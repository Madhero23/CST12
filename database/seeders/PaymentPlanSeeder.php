<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentPlanSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        
        $paymentPlans = [
            [
                'Sale_ID' => 1,
                'Total_Amount' => 650000.00,
                'Currency' => 'PHP',
                'Payment_Term_Months' => 12,
                'Start_Date' => $now->copy()->subMonths(1)->addDays(10),
                'End_Date' => $now->copy()->addMonths(11)->addDays(10),
                'Status' => 'Active',
                'created_at' => $now->subMonths(1),
                'updated_at' => $now,
            ],
            [
                'Sale_ID' => 1, // Just using the same sale for mock purposes if only 1 sale exists
                'Total_Amount' => 120000.00,
                'Currency' => 'PHP',
                'Payment_Term_Months' => 6,
                'Start_Date' => $now->copy()->subMonths(2)->addDays(8),
                'End_Date' => $now->copy()->addMonths(4)->addDays(8),
                'Status' => 'Active',
                'created_at' => $now->subMonths(2),
                'updated_at' => $now,
            ],
        ];

        foreach ($paymentPlans as $plan) {
            DB::table('payment_plans')->insert($plan);
        }
        $this->command->info('✅ Seeded ' . count($paymentPlans) . ' payment plans');
    }
}