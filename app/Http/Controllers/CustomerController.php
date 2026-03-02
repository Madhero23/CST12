<?php

namespace App\Http\Controllers;

use App\Modules\Customer\Services\CustomerService;
use App\Modules\Customer\Requests\StoreCustomerRequest;
use App\Modules\Customer\Requests\UpdateCustomerRequest;
use App\Modules\Shared\Services\LoggingService;
use App\Modules\Shared\Exceptions\NotFoundException;
use App\Modules\Shared\Exceptions\DatabaseException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

/**
 * Customer Controller
 * 
 * Handles customer management operations
 */
class CustomerController extends Controller
{
    protected CustomerService $customerService;
    protected LoggingService $logger;

    public function __construct(CustomerService $customerService, LoggingService $logger)
    {
        $this->customerService = $customerService;
        $this->logger = $logger;
    }

    /**
     * Display a listing of customers
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        try {
            $filters = [
                'type' => $request->input('type'),
                'segment' => $request->input('segment'),
                'status' => $request->input('status'),
                'search' => $request->input('search'),
            ];

            $filters = array_filter($filters);
            $customers = $this->customerService->getAllCustomers($filters);

            $pipelineStats = [
                'draft' => \App\Models\Quotation::where('status', 'draft')->count(),
                'pending' => \App\Models\Quotation::where('status', 'pending')->count(),
                'sent' => \App\Models\Quotation::where('status', 'sent')->count(),
                'follow_up' => \App\Models\Quotation::where('status', 'follow-up')->count(),
                'won' => \App\Models\Quotation::where('status', 'won')->orWhere('status', 'approved')->count(),
            ];

            // Fetch products for the Create Quote modal
            $products = \App\Models\Product::where('Status', 'Active')
                ->select('Product_ID', 'Product_Code', 'Product_Name', 'Unit_Price_USD', 'Unit_Price_PHP')
                ->orderBy('Product_Name')
                ->get();

            return view('customer.customer', compact('customers', 'filters', 'pipelineStats', 'products'));

        } catch (DatabaseException $e) {
            $this->logger->logError($e, 'Failed to load customers page');
            
            return view('customer.customer', [
                'customers' => collect([]),
                'filters' => [],
                'pipelineStats' => ['draft' => 0, 'pending' => 0, 'sent' => 0, 'follow_up' => 0, 'won' => 0],
                'error' => 'Unable to load customers. Please try again later.',
            ]);
        }
    }

    /**
     * Store a newly created customer (AJAX endpoint)
     *
     * @param Request $request
     * @return JsonResponse
     */

    /**
     * Store a newly created customer
     *
     * @param StoreCustomerRequest $request
     * @return RedirectResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'Institution_Name' => 'required|string|max:255',
                'Customer_Type' => 'required|in:Hospital,School,Government,PrivateClinic,OtherInstitution',
                'Segment_Type' => 'nullable|in:HighValue,MediumValue,LowValue,Prospect',
                'Contact_Person' => 'nullable|string|max:255',
                'Email' => 'required|email|unique:customers,Email',
                'Phone' => ['nullable', 'string', 'regex:/^[0-9]{10,11}$/'],  // FR-CRM-03
                'Address' => 'nullable|string',
                'Status' => 'nullable|in:Active,Inactive,OnHold',
                'Payment_Terms_Preference' => 'nullable|string',
            ]);

            $customer = $this->customerService->createCustomer($validated);

            return response()->json(['success' => true, 'customer' => $customer], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Validation failed: ' . $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to create customer');
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create customer. Please try again.',
            ], 500);
        }
    }

    /**
     * Update the specified customer (AJAX endpoint)
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $validated = $request->validate([
                'Institution_Name' => 'sometimes|required|string|max:255',
                'Customer_Type' => 'sometimes|required|in:Hospital,School,Government,PrivateClinic,OtherInstitution',
                'Segment_Type' => 'nullable|in:HighValue,MediumValue,LowValue,Prospect',
                'Contact_Person' => 'nullable|string|max:255',
                'Email' => 'sometimes|required|email|unique:customers,Email,' . $id . ',Customer_ID',
                'Phone' => ['nullable', 'string', 'regex:/^[0-9]{10,11}$/'],  // FR-CRM-03
                'Address' => 'nullable|string',
                'Status' => 'nullable|in:Active,Inactive,OnHold',
                'Payment_Terms_Preference' => 'nullable|string',
            ]);

            // FR-CRM-04: isDirty guard — return "No changes" if nothing was modified
            $customer = \App\Models\Customer::findOrFail($id);
            $hasChanges = false;
            foreach ($validated as $key => $value) {
                if ($customer->$key != $value) {
                    $hasChanges = true;
                    break;
                }
            }
            if (!$hasChanges) {
                return response()->json(['success' => true, 'message' => 'No changes detected.', 'customer' => $customer]);
            }

            $customer = $this->customerService->updateCustomer($id, $validated);

            return response()->json(['success' => true, 'customer' => $customer]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Validation failed: ' . $e->getMessage(),
                'errors' => $e->errors()
            ], 422);

        } catch (NotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Customer not found.'], 404);

        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to update customer', ['customer_id' => $id]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update customer. Please try again.',
            ], 500);
        }
    }

    /**
     * Remove the specified customer
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->customerService->deleteCustomer($id);

            return response()->json(['success' => true, 'message' => 'Customer deleted successfully!']);

        } catch (NotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Customer not found.'], 404);

        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to delete customer', ['customer_id' => $id]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete customer. Please try again.',
            ], 500);
        }
    }

    /**
     * Search customers (AJAX endpoint)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $searchTerm = $request->input('q', '');

            if (empty(trim($searchTerm))) {
                return response()->json([
                    'success' => true,
                    'customers' => [],
                ]);
            }

            $customers = $this->customerService->searchCustomers($searchTerm);

            return response()->json([
                'success' => true,
                'customers' => $customers,
            ]);

        } catch (Throwable $e) {
            $this->logger->logError($e, 'Customer search failed', [
                'search_term' => $request->input('q'),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Search failed. Please try again.',
            ], 500);
        }
    }

    public function createQuotation(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'customer_id' => 'required|exists:customers,Customer_ID',
                'title' => 'required|string|max:255',
                'template_id' => 'nullable|exists:quotation_templates,Template_ID',
                'items' => 'required|array|min:1',
                'items.*.product_id' => 'required|exists:products,Product_ID',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.price' => 'required|numeric|min:0',
                'total_amount' => 'required|numeric',
                'valid_until' => 'required|date',
                'status' => 'required|in:Draft,Sent,Pending,Approved,Won,Lost',
                'additional_notes' => 'nullable|string',
            ]);

            return \Illuminate\Support\Facades\DB::transaction(function () use ($validated) {
                // FR-CRM-07: Generate Quotation Number (QUO-YYYY-NNNN)
                $year = date('Y');
                $count = \App\Models\Quotation::whereYear('created_at', $year)->count() + 1;
                $quoteNumber = 'QUO-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

                // Consistent with Finance module: VAT Inclusive (12%)
                // Total = Subtotal * 1.12 => Subtotal = Total / 1.12
                $rate = 56.00; // 1 USD = 56 PHP
                $totalUSD = $validated['total_amount'];
                $totalPHP = $totalUSD * $rate;
                
                $taxRate = 12.00; // 12% VAT
                $subtotalUSD = $totalUSD / (1 + ($taxRate / 100));
                $subtotalPHP = $totalPHP / (1 + ($taxRate / 100));
                
                $taxAmountUSD = $totalUSD - $subtotalUSD;
                $taxAmountPHP = $totalPHP - $subtotalPHP;

                $quotation = \App\Models\Quotation::create([
                    'Title'               => $validated['title'],
                    'Quotation_Number'    => $quoteNumber,
                    'Customer_ID'         => $validated['customer_id'],
                    'Created_By'          => \Illuminate\Support\Facades\Auth::id() ?? 1,
                    'Expiration_Date'     => $validated['valid_until'],
                    'Status'              => $validated['status'],
                    'Template_ID'         => $validated['template_id'] ?? null,
                    'Subtotal_Amount_USD' => $subtotalUSD,
                    'Subtotal_Amount_PHP' => $subtotalPHP,
                    'Tax_Rate'            => $taxRate,
                    'Tax_Amount_USD'      => $taxAmountUSD,
                    'Tax_Amount_PHP'      => $taxAmountPHP,
                    'Total_Amount_USD'    => $totalUSD,
                    'Total_Amount_PHP'    => $totalPHP,
                    'Is_Tax_Inclusive'    => true,
                    'Additional_Notes'    => $validated['additional_notes'] ?? null,
                ]);

                foreach ($validated['items'] as $item) {
                    \App\Models\QuotationLineItem::create([
                        'Quotation_ID' => $quotation->Quotation_ID,
                        'Product_ID' => $item['product_id'],
                        'Quantity' => $item['quantity'],
                        'Unit_Price' => $item['price'],
                        'Line_Total' => $item['price'] * $item['quantity'],
                        'Currency' => 'USD',
                        'PHP_Conversion_Rate' => $rate,
                    ]);
                }

                // Log activity
                $this->logger->logActivity('Quotation created', null, [
                    'quotation_id' => $quotation->Quotation_ID,
                    'quotation_number' => $quoteNumber,
                    'customer_id' => $validated['customer_id']
                ]);

                return response()->json(['success' => true, 'quotation' => $quotation], 201);
            });
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to create quotation');
            return response()->json(['success' => false, 'message' => 'Failed to create quotation: ' . $e->getMessage()], 500);
        }
    }

    public function addInteractionLog(\Illuminate\Http\Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validated = $request->validate([
                'customer_id' => 'required|exists:customers,Customer_ID',
                'Interaction_Type' => 'required|string',
                'Subject' => 'required|string',
                'Details' => 'required|string',  // FR-CRM-10: Notes required
                'Follow_Up_Date' => 'nullable|date|after:today',  // FR-CRM-11: Must be future date
            ]);
            
            $log = \App\Models\CustomerInteractionLog::create([
                'Customer_ID' => $validated['customer_id'],
                'User_ID' => \Illuminate\Support\Facades\Auth::id() ?? 1,
                'Interaction_Type' => $validated['Interaction_Type'],
                'Subject' => $validated['Subject'],
                'Details' => $validated['Details'],
                'Follow_Up_Date' => $validated['Follow_Up_Date'] ?? null,
                'Interaction_Date' => now(),
            ]);
            
            
            return response()->json(['success' => true, 'log' => $log], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Validation failed: ' . $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Failed to add log: ' . $e->getMessage()], 500);
        }
    }

    public function getInteractionLogs($customerId): \Illuminate\Http\JsonResponse
    {
        try {
            $logs = \App\Models\CustomerInteractionLog::where('Customer_ID', $customerId)
                ->with('user:id,name') // Assuming User model has 'name'
                ->orderBy('Interaction_Date', 'desc')
                ->get();
            
            return response()->json(['success' => true, 'logs' => $logs]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Failed to fetch logs'], 500);
        }
    }

    public function reminders(): JsonResponse
    {
        try {
            // In a real scenario, this would query customer_interactions with follow_up_date >= today
            // For now, fetching some upcoming follow-ups or mocking based on documentation
            // Using a raw query or Eloquent if available
            $reminders = \Illuminate\Support\Facades\DB::table('customer_interactions')
                ->join('customers', 'customer_interactions.Customer_ID', '=', 'customers.Customer_ID')
                ->whereNotNull('Follow_Up_Date')
                ->where('Follow_Up_Date', '>=', now()->toDateString())
                ->orderBy('Follow_Up_Date', 'asc')
                ->select(
                    'customers.Institution_Name as customer_name',
                    'customer_interactions.Subject as subject',
                    'customer_interactions.Follow_Up_Date as due_date',
                    'customers.Segment_Type as priority'
                )
                ->limit(5)
                ->get();

            if ($reminders->isEmpty()) {
                // Mock data matching the user's mockup for demonstration
                $reminders = collect([
                    [
                        'customer_name' => 'Dr. Sarah Johnson',
                        'subject' => 'Follow up on ultrasound quote',
                        'due_date' => now()->toDateString(),
                        'priority' => 'HighValue'
                    ],
                    [
                        'customer_name' => 'Michael Chen',
                        'subject' => 'Send updated pricing',
                        'due_date' => now()->addDay()->toDateString(),
                        'priority' => 'MediumValue'
                    ],
                    [
                        'customer_name' => 'Emily Rodriguez',
                        'subject' => 'Schedule demo call',
                        'due_date' => now()->addDays(3)->toDateString(),
                        'priority' => 'LowValue'
                    ]
                ]);
            }

            return response()->json([
                'success' => true,
                'reminders' => $reminders
            ]);
        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to fetch reminders');
            return response()->json(['success' => false, 'message' => 'Failed to fetch reminders'], 500);
        }
    }

    /**
     * FR-CRM-08: Update quotation status with transition guard
     *
     * Allowed transitions:
     *   Draft   → Sent, Pending
     *   Sent    → Pending, Won, Lost
     *   Pending → Approved, Won, Lost
     */
    private static array $allowedTransitions = [
        'Draft'   => ['Sent', 'Pending'],
        'Sent'    => ['Pending', 'Won', 'Lost'],
        'Pending' => ['Approved', 'Won', 'Lost'],
    ];

    public function updateQuotationStatus(Request $request, int $id): JsonResponse
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:Draft,Sent,Pending,Approved,Won,Lost',
                'notes'  => 'nullable|string|max:500',
            ]);

            $quotation = \App\Models\Quotation::findOrFail($id);
            $currentStatus = $quotation->Status;
            $newStatus = $validated['status'];

            // Guard: check if the transition is allowed
            $allowed = self::$allowedTransitions[$currentStatus] ?? [];
            if (!in_array($newStatus, $allowed)) {
                return response()->json([
                    'success' => false,
                    'message' => "Invalid status transition: {$currentStatus} → {$newStatus}. Allowed: " . implode(', ', $allowed),
                ], 422);
            }

            $quotation->update([
                'Status' => $newStatus,
                'Status_Notes' => $validated['notes'] ?? null,
                'Conversion_Date' => in_array($newStatus, ['Won', 'Approved']) ? now() : $quotation->Conversion_Date,
                'Reason_For_Loss' => $newStatus === 'Lost' ? ($validated['notes'] ?? null) : $quotation->Reason_For_Loss,
            ]);

            $this->logger->logActivity('Quotation status updated', null, [
                'quotation_id' => $id,
                'from' => $currentStatus,
                'to' => $newStatus,
            ]);

            return response()->json(['success' => true, 'quotation' => $quotation->fresh()]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Quotation not found.'], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (Throwable $e) {
            $this->logger->logError($e, 'Failed to update quotation status', ['quotation_id' => $id]);
            return response()->json(['success' => false, 'message' => 'Failed to update status.'], 500);
        }
    }
}
