<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        
        $locations = [
            [
                'Location_Name' => 'Main Office & Warehouse - Manila',
                'Address' => '123 Medical Equipment Street, Quezon City, Metro Manila 1100',
                'Contact_Number' => '+63 2 8123 4567',
                'Status' => 'Active',
                'Manager_ID' => 7, // Robert Garcia
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'Location_Name' => 'Cagayan de Oro Branch',
                'Address' => '456 Healthcare Avenue, Cagayan de Oro City, Misamis Oriental 9000',
                'Contact_Number' => '+63 88 8445 6789',
                'Status' => 'Active',
                'Manager_ID' => 8, // Susan Li
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'Location_Name' => 'Showroom - Makati',
                'Address' => '789 Ayala Avenue, Makati City, Metro Manila 1200',
                'Contact_Number' => '+63 2 8123 9876',
                'Status' => 'Active',
                'Manager_ID' => 2, // Juan Dela Cruz
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('locations')->insert($locations);
        $this->command->info('✅ Seeded 3 locations');
    }
}