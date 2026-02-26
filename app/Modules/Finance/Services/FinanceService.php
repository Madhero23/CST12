<?php

namespace App\Modules\Finance\Services;

use App\Modules\Finance\Repositories\TransactionRepository;
use App\Modules\Shared\Services\LoggingService;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;

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

        $sale = \App\Models\Sale::create([
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

        $sale->Amount_Paid += $data['amount_paid'];
        $sale->Payment_Method = $method;
        $sale->Last_Payment_Date = $data['payment_date'];
        $sale->Payment_Reference = $data['payment_reference'] ?? null;

        if ($sale->Amount_Paid >= $sale->Total_Amount_PHP) {
            $sale->Status = 'Completed';
        }

        $sale->save();

        $this->logger->logActivity('Payment recorded', null, [
            'sale_id' => $sale->Sale_ID,
            'amount_paid' => $data['amount_paid'],
            'total_paid' => $sale->Amount_Paid,
            'status' => $sale->Status
        ]);

        return $sale;
    }
}
