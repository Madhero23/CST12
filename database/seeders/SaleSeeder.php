<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        
        $sales = [
            [
                'Quotation_ID' => 2, // Matches QT-2023-150
                'Customer_ID' => 2,
                'Processed_By' => 5,
                'Sale_Date' => $now->subMonths(1)->addDays(10),
                'Subtotal_Amount_PHP' => 580357.14,
                'Subtotal_Amount_USD' => 10181.70,
                'Tax_Rate' => 12.00,
                'Tax_Amount_PHP' => 69642.86,
                'Tax_Amount_USD' => 1221.80,
                'Total_Amount_PHP' => 650000.00,
                'Total_Amount_USD' => 11403.51,
                'Is_Tax_Inclusive' => true,
                'Currency_Type' => 'PHP',
                'Exchange_Rate_At_Sale' => 56.80,
                'Status' => 'Completed',
                'Payment_Term_Months' => 12,
                'created_at' => $now->subMonths(1),
                'updated_at' => $now,
            ],
        ];

        foreach ($sales as $sale) {
            DB::table('sales')->insert($sale);
        }
        $this->command->info('✅ Seeded ' . count($sales) . ' sales');
    }
}