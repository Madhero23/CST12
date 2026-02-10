<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Run seeders in correct order
        $this->call([
            UserSeeder::class,
            SupplierSeeder::class,
            CustomerSeeder::class,
            LocationSeeder::class,
            ExchangeRateSeeder::class,
            ProductSeeder::class,
            InventorySeeder::class,
            QuotationTemplateSeeder::class,
            QuotationSeeder::class,
            QuotationLineItemSeeder::class,
            SaleSeeder::class,
            PaymentPlanSeeder::class,
            PaymentInstallmentSeeder::class,
            DocumentSeeder::class,
            CustomerInteractionSeeder::class,
            InventoryTransactionSeeder::class,
            AlertLogSeeder::class,
        ]);
    }
}