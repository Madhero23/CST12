<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Temporarily disable foreign key checks for SQLite
        DB::statement('PRAGMA foreign_keys = OFF;');

        // Clear all data in correct order (reverse of creation)
        $this->truncateTables();

        // Enable foreign key checks
        DB::statement('PRAGMA foreign_keys = ON;');

        // Run seeders in correct dependency order
        $this->call([
            UserSeeder::class,
            SupplierSeeder::class,
            LocationSeeder::class,
            CustomerSeeder::class,
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

    private function truncateTables(): void
    {
        $tables = [
            'alert_logs',
            'inventory_transactions',
            'customer_interactions',
            'documents',
            'payment_installments',
            'payment_plans',
            'sales',
            'quotation_line_items',
            'quotations',
            'quotation_templates',
            'inventories',
            'products',
            'exchange_rates',
            'customers',
            'locations',
            'suppliers',
            'users',
        ];

        foreach ($tables as $table) {
            DB::table($table)->delete();
        }
    }
}