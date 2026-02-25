<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class QuotationLineItemSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        
        $lineItems = [
            [
                'Quotation_ID' => 1,
                'Product_ID' => 1,
                'Quantity' => 3,
                'Unit_Price' => 85000.00,
                'Line_Total' => 255000.00,
                'Discount_Percentage' => 5.00,
                'PHP_Conversion_Rate' => 57.00,
                'Currency' => 'PHP',
                'Notes' => 'Bulk order discount',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'Quotation_ID' => 2,
                'Product_ID' => 1,
                'Quantity' => 5,
                'Unit_Price' => 85000.00,
                'Line_Total' => 425000.00,
                'Discount_Percentage' => 8.00,
                'PHP_Conversion_Rate' => 56.80,
                'Currency' => 'PHP',
                'Notes' => 'ICU expansion',
                'created_at' => $now->subMonths(1),
                'updated_at' => $now,
            ],
        ];

        foreach ($lineItems as $item) {
            DB::table('quotation_line_items')->insert($item);
        }
        $this->command->info('✅ Seeded ' . count($lineItems) . ' quotation line items');
    }
}