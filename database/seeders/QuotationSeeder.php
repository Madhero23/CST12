<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class QuotationSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        
        $quotations = [
            [
                'Quotation_Number' => 'QT-2024-001',
                'Customer_ID' => 1,
                'Created_By' => 2,
                'Expiration_Date' => $now->addDays(25),
                'Status' => 'Sent',
                'Template_ID' => 2,
                'Subtotal_Amount_PHP' => 480000.00,
                'Subtotal_Amount_USD' => 8421.05,
                'Tax_Rate' => 12.00,
                'Tax_Amount_PHP' => 57600.00,
                'Tax_Amount_USD' => 1010.53,
                'Total_Amount_PHP' => 537600.00,
                'Total_Amount_USD' => 9431.58,
                'Is_Tax_Inclusive' => false,
                'created_at' => $now->subDays(5),
                'updated_at' => $now,
            ],
            [
                'Quotation_Number' => 'QT-2023-150',
                'Customer_ID' => 2,
                'Created_By' => 2,
                'Expiration_Date' => $now->subMonths(1)->addDays(25),
                'Status' => 'Won',
                'Template_ID' => 2,
                'Subtotal_Amount_PHP' => 580357.14,
                'Subtotal_Amount_USD' => 10181.70,
                'Tax_Rate' => 12.00,
                'Tax_Amount_PHP' => 69642.86,
                'Tax_Amount_USD' => 1221.80,
                'Total_Amount_PHP' => 650000.00,
                'Total_Amount_USD' => 11403.51,
                'Is_Tax_Inclusive' => true,
                'created_at' => $now->subMonths(1)->subDays(5),
                'updated_at' => $now->subMonths(1),
            ],
        ];

        foreach ($quotations as $quotation) {
            DB::table('quotations')->insert($quotation);
        }
        $this->command->info('✅ Seeded ' . count($quotations) . ' quotations');
    }
}