<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        DB::table('inventories')->truncate();
        
        $inventories = [
            // Main Office (Location ID 1)
            [
                'Product_ID' => 1, 'Location_ID' => 1,
                'Quantity_On_Hand' => 10, 'Quantity_Reserved' => 2, 'Quantity_Available' => 8,
                'Value_PHP' => 850000.00, 'Value_USD' => 14912.28,
                'Manufacturing_Date' => '2023-01-15', 'Received_Date' => '2023-03-20', // AGING
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'Product_ID' => 2, 'Location_ID' => 1,
                'Quantity_On_Hand' => 5, 'Quantity_Reserved' => 0, 'Quantity_Available' => 5,
                'Value_PHP' => 225000.00, 'Value_USD' => 3947.37,
                'Manufacturing_Date' => '2023-06-10', 'Received_Date' => '2023-08-01', // AGING
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'Product_ID' => 3, 'Location_ID' => 1,
                'Quantity_On_Hand' => 2, 'Quantity_Reserved' => 1, 'Quantity_Available' => 1,
                'Value_PHP' => 700000.00, 'Value_USD' => 12280.70,
                'Manufacturing_Date' => now()->format('Y-m-d'), 'Received_Date' => now()->format('Y-m-d'), // FRESH
                'created_at' => $now, 'updated_at' => $now,
            ],
            // CDO Branch (Location ID 2)
            [
                'Product_ID' => 1, 'Location_ID' => 2,
                'Quantity_On_Hand' => 3, 'Quantity_Reserved' => 0, 'Quantity_Available' => 3,
                'Value_PHP' => 255000.00, 'Value_USD' => 4473.68,
                'Manufacturing_Date' => '2023-05-20', 'Received_Date' => '2023-06-15', // AGING
                'created_at' => $now, 'updated_at' => $now,
            ],
        ];

        foreach ($inventories as $inventory) {
            DB::table('inventories')->insert($inventory);
        }
        $this->command->info('✅ Seeded ' . count($inventories) . ' inventory records');
    }
}