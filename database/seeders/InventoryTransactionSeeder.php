<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InventoryTransactionSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        
        $transactions = [
            // Stock In transactions (from suppliers)
            [
                'Transaction_Type' => 'StockIn',
                'Product_ID' => 1,
                'Quantity' => 5,
                'Unit_Price_At_Transaction' => 85000.00,
                'Total_Value' => 425000.00,
                'Transaction_Date' => $now->subDays(5),
                'Reference_Number' => 'PO-2024-001',
                'Source_Location_ID' => null,
                'Destination_Location_ID' => 1,
                'Notes' => 'New shipment from MedEquip Philippines',
                'Performed_By' => 7,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Stock Out transactions (from sales)
            [
                'Transaction_Type' => 'StockOut',
                'Product_ID' => 1,
                'Quantity' => 3,
                'Unit_Price_At_Transaction' => 85000.00,
                'Total_Value' => 255000.00,
                'Transaction_Date' => $now->subMonths(1)->addDays(12),
                'Reference_Number' => 'SO-2023-150',
                'Source_Location_ID' => 1,
                'Destination_Location_ID' => null,
                'Notes' => 'Sale to St. Lukes Medical Center',
                'Performed_By' => 7,
                'created_at' => $now->subMonths(1),
                'updated_at' => $now->subMonths(1),
            ],
            // Inter-branch transfers
            [
                'Transaction_Type' => 'Transfer',
                'Product_ID' => 1,
                'Quantity' => 2,
                'Unit_Price_At_Transaction' => 85000.00,
                'Total_Value' => 170000.00,
                'Transaction_Date' => $now->subDays(15),
                'Reference_Number' => 'TR-2024-001',
                'Source_Location_ID' => 1,
                'Destination_Location_ID' => 2,
                'Notes' => 'Transfer to Cagayan branch',
                'Performed_By' => 7,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($transactions as $transaction) {
            DB::table('inventory_transactions')->insert($transaction);
        }
        $this->command->info('✅ Seeded ' . count($transactions) . ' inventory transactions');
    }
}