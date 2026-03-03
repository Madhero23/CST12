<?php

namespace App\Modules\Finance\Services;

use App\Modules\Finance\Repositories\TransactionRepository;
use App\Modules\Shared\Services\LoggingService;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;
use Exception;

class FinanceService
{
    protected TransactionRepository $repository;
    protected LoggingService $logger;

    public function __construct(TransactionRepository $repository, LoggingService $logger)
    {
        $this->repository = $repository;
        $this->logger = $logger;
    }

    public function getAllSales(): Collection
    {
        return \App\Models\Sale::with('customer')->latest()->get();
    }

    public function createSale(array $data): \App\Models\Sale
    {
        $totalAmount = $data['amount'];
        $taxRate = 12.00;
        $subtotal = $totalAmount / (1 + ($taxRate / 100));
        $taxAmount = $totalAmount - $subtotal;

        // FR-FIN-02: Auto-generate Invoice Number (INV-YYYY-NNNN)
        $year = date('Y');
        $count = \App\Models\Sale::whereYear('Sale_Date', $year)->count() + 1;
        $invoiceNumber = 'INV-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

        $sale = \App\Models\Sale::create([
            'Invoice_Number' => $invoiceNumber,
            'Customer_ID' => $data['customer_id'],
            'Processed_By' => $data['processed_by'],
            'Sale_Date' => $data['sale_date'],
            'Subtotal_Amount_PHP' => $subtotal,
            'Subtotal_Amount_USD' => 0.00,
            'Tax_Rate' => $taxRate,
            'Tax_Amount_PHP' => $taxAmount,
            'Tax_Amount_USD' => 0.00,
            'Total_Amount_PHP' => $totalAmount,
            'Total_Amount_USD' => 0.00,
            'Is_Tax_Inclusive' => true,
            'Currency_Type' => 'PHP',
            'Exchange_Rate_At_Sale' => 1.0000,
            'Status' => 'Pending',
            'Notes' => $data['notes'] ?? null,
            'Due_Date' => $data['due_date'] ?? null,
            'Payment_Terms' => $data['payment_terms'] ?? null,
        ]);

        $this->logger->logActivity('Invoice generated', null, [
            'sale_id' => $sale->Sale_ID,
            'invoice_number' => $invoiceNumber,
            'total' => $totalAmount,
            'customer_id' => $data['customer_id']
        ]);

        return $sale;
    }

    public function recordPayment(\App\Models\Sale $sale, array $data): \App\Models\Sale
    {
        // Map UI labels to PascalCase DB enums
        $methodMapping = [
            'Bank Transfer' => 'BankTransfer',
            'Check'         => 'Check',
            'GCash'         => 'GCash',
            'Cash'          => 'Cash',
            'Credit Card'   => 'CreditCard'
        ];
        
        $method = $methodMapping[$data['payment_method']] ?? $data['payment_method'];

        // FR-FIN-07: Calculate outstanding balance
        $outstandingBalance = $sale->Total_Amount_PHP - ($sale->Amount_Paid ?? 0);

        // FR-FIN-06: Over-payment guard
        if ($data['amount_paid'] > $outstandingBalance) {
            throw new Exception("Over-payment rejected. Outstanding balance: ₱" . number_format($outstandingBalance, 2) . ". Amount attempted: ₱" . number_format($data['amount_paid'], 2));
        }

        $sale->Amount_Paid = ($sale->Amount_Paid ?? 0) + $data['amount_paid'];
        $sale->Payment_Method = $method;
        $sale->Last_Payment_Date = $data['payment_date'];
        $sale->Payment_Reference = $data['payment_reference'] ?? null;

        // FR-FIN-07: Auto-status update (Pending → Partial → Completed)
        $newOutstanding = $sale->Total_Amount_PHP - $sale->Amount_Paid;
        if ($newOutstanding <= 0) {
            $sale->Status = 'Completed';
        } elseif ($sale->Amount_Paid > 0) {
            $sale->Status = 'Partial';
        }

        $sale->save();

        $this->logger->logActivity('Payment recorded', null, [
            'sale_id' => $sale->Sale_ID,
            'amount_paid' => $data['amount_paid'],
            'total_paid' => $sale->Amount_Paid,
            'outstanding' => $newOutstanding,
            'status' => $sale->Status
        ]);

        return $sale;
    }
}

