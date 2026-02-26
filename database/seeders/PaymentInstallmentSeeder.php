<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentInstallmentSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        
        $installments = [];
        
        // Payment Plan 1: St. Luke's (12 months, ₱54,166.67 per month)
        $plan1Start = $now->copy()->subMonths(1)->addDays(10);
        $monthlyPayment1 = 54166.67;
        
        for ($i = 1; $i <= 12; $i++) {
            $dueDate = $plan1Start->copy()->addMonths($i);
            $isPaid = $i <= 2; // First 2 installments paid
            
            $installments[] = [
                'Payment_Plan_ID' => 1,
                'Installment_Number' => $i,
                'Due_Date' => $dueDate,
                'Amount_Due' => $monthlyPayment1,
                'Amount_Paid' => $isPaid ? $monthlyPayment1 : 0.00,
                'Payment_Date' => $isPaid ? $dueDate->copy()->subDays(2) : null,
                'Payment_Method' => $isPaid ? 'BankTransfer' : null,
                'Payment_Status' => $isPaid ? 'Paid' : ($dueDate < $now ? 'Overdue' : 'Pending'),
                'Transaction_Reference' => $isPaid ? 'STLUKES-' . str_pad($i, 3, '0', STR_PAD_LEFT) : null,
                'Exchange_Rate_Used' => 56.80,
                'created_at' => $now->subMonths(1),
                'updated_at' => $now,
            ];
        }
        
        // Payment Plan 2: Asian Hospital (6 months, ₱20,000 per month)
        $plan2Start = $now->copy()->subMonths(2)->addDays(8);
        $monthlyPayment2 = 20000.00;
        
        for ($i = 1; $i <= 6; $i++) {
            $dueDate = $plan2Start->copy()->addMonths($i);
            $isPaid = $i <= 2; // First 2 installments paid
            
            $installments[] = [
                'Payment_Plan_ID' => 2,
                'Installment_Number' => $i,
                'Due_Date' => $dueDate,
                'Amount_Due' => $monthlyPayment2,
                'Amount_Paid' => $isPaid ? $monthlyPayment2 : 0.00,
                'Payment_Date' => $isPaid ? $dueDate->copy()->addDays(1) : null, // Paid 1 day late
                'Payment_Method' => $isPaid ? ($i == 1 ? 'GCash' : 'Check') : null,
                'Payment_Status' => $isPaid ? 'Paid' : ($dueDate < $now ? 'Overdue' : 'Pending'),
                'Transaction_Reference' => $isPaid ? 'ASIANHOSP-' . str_pad($i, 2, '0', STR_PAD_LEFT) : null,
                'Exchange_Rate_Used' => 56.80,
                'created_at' => $now->subMonths(2),
                'updated_at' => $now,
            ];
        }
        
        foreach ($installments as $installment) {
            DB::table('payment_installments')->insert($installment);
        }
        $this->command->info('✅ Seeded ' . count($installments) . ' payment installments');
    }
}