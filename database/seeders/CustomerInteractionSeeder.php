<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CustomerInteractionSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        
        $interactions = [
            [
                'Customer_ID' => 1,
                'User_ID' => 2,
                'Interaction_Type' => 'Meeting',
                'Interaction_Date' => $now->subDays(5),
                'Subject' => 'ICU upgrade consultation',
                'Details' => 'Discussed patient monitors and infusion pumps.',
                'Related_Quotation_ID' => 1,
                'Status' => 'Completed',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'Customer_ID' => 2,
                'User_ID' => 3,
                'Interaction_Type' => 'Call',
                'Interaction_Date' => $now->subDays(3),
                'Subject' => 'Follow-up on QT-2023-150',
                'Details' => 'Confirmed order details.',
                'Related_Quotation_ID' => 2,
                'Status' => 'Completed',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($interactions as $interaction) {
            DB::table('customer_interactions')->insert($interaction);
        }
        $this->command->info('✅ Seeded ' . count($interactions) . ' interactions');
    }
}