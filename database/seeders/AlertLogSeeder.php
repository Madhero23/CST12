<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AlertLogSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        
        $alerts = [
            // Low Stock Alerts
            [
                'Alert_Type' => 'Inventory',
                'Subject' => 'Low Stock Warning: Ultrasound Machine',
                'Message' => 'Portable Ultrasound Machine at Main Office is below reorder point. Current: 1, Min: 2.',
                'Severity' => 'High',
                'Related_Entity_Type' => 'Product',
                'Related_Entity_ID' => 3,
                'Is_Read' => false,
                'Resolution_Status' => 'Unresolved',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'Alert_Type' => 'Sales',
                'Subject' => 'Upcoming Payment: St. Lukes Medical Center',
                'Message' => 'Third installment of PHP 54,166.67 due in 7 days.',
                'Severity' => 'Medium',
                'Related_Entity_Type' => 'Sale',
                'Related_Entity_ID' => 3,
                'Is_Read' => false,
                'Resolution_Status' => 'Unresolved',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'Alert_Type' => 'System',
                'Subject' => 'Expiring Certificate: FDA - Patient Monitor',
                'Message' => 'FDA approval for Patient Monitor Model M5 expires in 30 days.',
                'Severity' => 'Low',
                'Related_Entity_Type' => 'Document',
                'Related_Entity_ID' => 2,
                'Is_Read' => true,
                'Read_By' => 7,
                'Read_Date' => $now->subDay(),
                'Resolution_Status' => 'InProgress',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($alerts as $alert) {
            DB::table('alert_logs')->insert($alert);
        }
        $this->command->info('✅ Seeded ' . count($alerts) . ' alert logs');
    }
}