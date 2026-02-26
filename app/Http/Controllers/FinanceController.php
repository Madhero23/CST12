<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\PaymentPlan;
use App\Modules\Finance\Services\FinanceService;
use App\Modules\Shared\Services\LoggingService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Throwable;

class FinanceController extends Controller
{
    protected FinanceService $financeService;
    protected LoggingService $logger;

    public function __construct(FinanceService $financeService, LoggingService $logger)
    {
        $this->financeService = $financeService;
        $this->logger = $logger;
    }

    public function index(): View
    {
        try {
            $sales = $this->financeService->getAllSales();
            $paymentPlans = \App\Models\PaymentPlan::with(['sale.customer', 'installments'])->latest()->get();
            $overdueSales = \App\Models\Sale::where('Status', 'Pending')
                ->where('Sale_Date', '<', now()->subDays(30))
                ->get();
            $customers = \App\Models\Customer::orderBy('Institution_Name')->get();

            return view('finance.finance', [
                'sales' => $sales,
                'paymentPlans' => $paymentPlans,
                'overdueSales' => $overdueSales,
                'customers' => $customers
            ]);
        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to load finance page');
            return view('finance.finance', [
                'sales' => collect([]),
                'paymentPlans' => collect([]),
                'overdueSales' => collect([]),
                'customers' => collect([]),
                'error' => 'Unable to load finance data.',
            ]);
        }
    }

    public function createSale(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'customer_id' => 'required|exists:customers,Customer_ID',
                'amount' => 'required|numeric|min:0',
                'sale_date' => 'required|date',
                'due_date' => 'nullable|date',
                'notes' => 'nullable|string',
                'payment_terms' => 'nullable|string',
            ]);

            $validated['processed_by'] = Auth::id() ?? 1;
            
            $sale = $this->financeService->createSale($validated);

            return response()->json(['success' => true, 'sale' => $sale], 201);
        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to create sale');
            return response()->json(['success' => false, 'message' => 'Failed to create sale: ' . $e->getMessage()], 500);
        }
    }

    public function createPaymentPlan(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'customer_id' => 'required|exists:customers,Customer_ID',
                'sale_id' => 'nullable|exists:sales,Sale_ID',
                'total_amount' => 'required|numeric|min:1',
                'installments' => 'required|integer|min:2',
                'first_due_date' => 'required|date|after_or_equal:today',
                'frequency' => 'required|in:monthly,bi-weekly,weekly',
            ]);

            // If no Sale_ID provided, create a placeholder sale for this plan
            if (!isset($validated['sale_id']) || !$validated['sale_id']) {
                $totalAmount = $validated['total_amount'];
                $subtotal = $totalAmount / 1.12;
                $taxAmount = $totalAmount - $subtotal;

                $sale = \App\Models\Sale::create([
                    'Customer_ID' => $validated['customer_id'],
                    'Processed_By' => Auth::id() ?? 1,
                    'Sale_Date' => now(),
                    'Subtotal_Amount_PHP' => $subtotal,
                    'Subtotal_Amount_USD' => 0.00, // Placeholder
                    'Tax_Rate' => 12.00,
                    'Tax_Amount_PHP' => $taxAmount,
                    'Tax_Amount_USD' => 0.00, // Placeholder
                    'Total_Amount_PHP' => $totalAmount,
                    'Total_Amount_USD' => 0.00, // Placeholder
                    'Is_Tax_Inclusive' => true,
                    'Currency_Type' => 'PHP',
                    'Exchange_Rate_At_Sale' => 1.0000,
                    'Status' => 'Pending',
                    'Payment_Term_Months' => $validated['installments'],
                ]);
                $validated['sale_id'] = $sale->Sale_ID;
            }

            // Calculate End Date based on frequency and installments
            $startDate = \Carbon\Carbon::parse($validated['first_due_date']);
            $endDate = clone $startDate;
            $numInstallments = (int)$validated['installments'];
            
            if ($validated['frequency'] === 'monthly') {
                $endDate->addMonths($numInstallments - 1);
            } elseif ($validated['frequency'] === 'bi-weekly') {
                $endDate->addWeeks(($numInstallments - 1) * 2);
            } else {
                $endDate->addWeeks($numInstallments - 1);
            }

            $plan = \App\Models\PaymentPlan::create([
                'Sale_ID' => $validated['sale_id'],
                'Total_Amount' => $validated['total_amount'],
                'Payment_Term_Months' => $numInstallments,
                'Status' => 'Active',
                'Start_Date' => now(),
                'End_Date' => $endDate,
                'Currency' => 'PHP'
            ]);

            // Generate Installments
            $installmentAmount = round($validated['total_amount'] / $numInstallments, 2);
            $totalDistributed = 0;

            for ($i = 0; $i < $numInstallments; $i++) {
                $dueDate = clone $startDate;
                if ($validated['frequency'] === 'monthly') {
                    $dueDate->addMonths($i);
                } elseif ($validated['frequency'] === 'bi-weekly') {
                    $dueDate->addWeeks($i * 2);
                } else {
                    $dueDate->addWeeks($i);
                }

                // Adjust last installment for rounding differences
                $currentAmount = $installmentAmount;
                if ($i === $numInstallments - 1) {
                    $currentAmount = $validated['total_amount'] - $totalDistributed;
                }
                $totalDistributed += $currentAmount;

                \App\Models\PaymentInstallment::create([
                    'Payment_Plan_ID' => $plan->Payment_Plan_ID,
                    'Installment_Number' => $i + 1,
                    'Due_Date' => $dueDate,
                    'Amount_Due' => $currentAmount,
                    'Total_Due' => $currentAmount,
                    'Payment_Status' => 'Pending'
                ]);
            }

            $plan->load(['sale.customer', 'installments']);

            return response()->json(['success' => true, 'plan' => $plan], 201);
        } catch (Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function recordPayment(Request $request, int $id): JsonResponse
    {
        try {
            $validated = $request->validate([
                'amount_paid' => 'required|numeric|min:0.01',
                'payment_method' => 'required|string',
                'payment_date' => 'required|date',
                'payment_reference' => 'nullable|string',
            ]);

            $sale = Sale::findOrFail($id);
            
            $sale = $this->financeService->recordPayment($sale, $validated);

            return response()->json(['success' => true, 'sale' => $sale]);
        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to record payment', ['sale_id' => $id]);
            return response()->json(['success' => false, 'message' => 'Failed to record payment: ' . $e->getMessage()], 500);
        }
    }

    public function getPaymentPlan(int $id): JsonResponse
    {
        try {
            $plan = PaymentPlan::with(['sale.customer', 'installments' => function($q) {
                $q->orderBy('Installment_Number', 'asc');
            }])->findOrFail($id);
            return response()->json(['success' => true, 'plan' => $plan]);
        } catch (Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Plan not found'], 404);
        }
    }

    public function payInstallment(Request $request, int $id): JsonResponse
    {
        try {
            $validated = $request->validate([
                'amount_paid' => 'required|numeric|min:0.01',
                'payment_method' => 'required|string',
                'payment_date' => 'required|date',
                'payment_reference' => 'nullable|string',
            ]);

            $installment = \App\Models\PaymentInstallment::findOrFail($id);
            $plan = $installment->paymentPlan;
            $sale = $plan->sale;

            // Update Installment
            $installment->Amount_Paid += $validated['amount_paid'];
            $installment->Payment_Date = $validated['payment_date'];
            $installment->Payment_Method = str_replace(' ', '', $validated['payment_method']); // Map e.g. "Bank Transfer" to "BankTransfer"
            $installment->Transaction_Reference = $validated['payment_reference'];
            
            if ($installment->Amount_Paid >= $installment->Total_Due) {
                $installment->Payment_Status = 'Paid';
            } else {
                $installment->Payment_Status = 'Partial';
            }
            $installment->save();

            // Update Sale (Cumulative)
            $sale->Amount_Paid += $validated['amount_paid'];
            $sale->Last_Payment_Date = $validated['payment_date'];
            $sale->Payment_Method = $validated['payment_method'];
            $sale->Payment_Reference = $validated['payment_reference'];

            if ($sale->Amount_Paid >= $sale->Total_Amount_PHP) {
                $sale->Status = 'Completed';
            }
            $sale->save();

            // Check if all installments in plan are paid
            $pendingCount = $plan->installments()->where('Payment_Status', '!=', 'Paid')->count();
            if ($pendingCount === 0) {
                $plan->Status = 'Completed';
                $plan->save();
            }

            $this->logger->logActivity('Installment paid', null, [
                'installment_id' => $installment->Installment_ID,
                'plan_id' => $plan->Payment_Plan_ID,
                'amount' => $validated['amount_paid']
            ]);

            return response()->json([
                'success' => true, 
                'message' => 'Payment recorded!',
                'installment' => $installment,
                'plan_status' => $plan->Status,
                'sale_status' => $sale->Status
            ]);
        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to pay installment', ['id' => $id]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
