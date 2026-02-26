<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        
        $suppliers = [
            [
                'Supplier_Name' => 'MedEquip Philippines Inc.',
                'Contact_Person' => 'Michael Chen',
                'Email' => 'sales@medequip.ph',
                'Phone' => '+63 2 8123 5555',
                'Address' => '789 Supplier Blvd, Makati City, Metro Manila',
                'Country' => 'Philippines',
                'Specialization' => 'Hospital Equipment & Surgical Instruments',
                'Years_In_Service' => 15,
                'Status' => 'Active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'Supplier_Name' => 'Global Medical Supplies Corp.',
                'Contact_Person' => 'Sarah Johnson',
                'Email' => 'info@globalmed.com',
                'Phone' => '+63 2 8123 6666',
                'Address' => '456 Import Ave, Pasig City, Metro Manila',
                'Country' => 'USA',
                'Specialization' => 'Medical Supplies & Consumables',
                'Years_In_Service' => 10,
                'Status' => 'Active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'Supplier_Name' => 'PhilHealth Distributors LLC',
                'Contact_Person' => 'David Wong',
                'Email' => 'sales@philhealthdist.com',
                'Phone' => '+63 2 8123 7777',
                'Address' => '123 Distribution St, Mandaluyong City',
                'Country' => 'Philippines',
                'Specialization' => 'Pharmacy Items & Laboratory Supplies',
                'Years_In_Service' => 8,
                'Status' => 'Active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'Supplier_Name' => 'Asian Medical Technologies',
                'Contact_Person' => 'James Lee',
                'Email' => 'james@asianmedtech.com',
                'Phone' => '+63 2 8123 8888',
                'Address' => '890 Tech Park, Taguig City, Metro Manila',
                'Country' => 'Singapore',
                'Specialization' => 'Advanced Medical Equipment & Diagnostic Machines',
                'Years_In_Service' => 12,
                'Status' => 'Active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'Supplier_Name' => 'Pacific Healthcare Imports',
                'Contact_Person' => 'Lisa Martinez',
                'Email' => 'lisa@pacifichealth.com',
                'Phone' => '+63 2 8123 9999',
                'Address' => '345 Port Area, Manila',
                'Country' => 'Philippines',
                'Specialization' => 'Imported Medical Devices',
                'Years_In_Service' => 7,
                'Status' => 'Active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('suppliers')->insert($suppliers);
        $this->command->info('✅ Seeded 5 suppliers');
    }
}