<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        
        $users = [
            // System Admin
            [
                'Username' => 'admin.rozmed',
                'Password_Hash' => Hash::make('Admin123!'),
                'Role' => 'Admin',
                'Full_Name' => 'Maria Santos',
                'Email' => 'maria@rozmed.com',
                'Phone' => '+63 917 123 4567',
                'Department' => 'Administration',
                'Last_Login' => $now->subDay(),
                'Status' => 'Active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Sales Staff
            [
                'Username' => 'juan.dela',
                'Password_Hash' => Hash::make('Sales123!'),
                'Role' => 'SalesStaff',
                'Full_Name' => 'Juan Dela Cruz',
                'Email' => 'juan@rozmed.com',
                'Phone' => '+63 918 234 5678',
                'Department' => 'Sales',
                'Last_Login' => $now->subDays(2),
                'Status' => 'Active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'Username' => 'ana.reyes',
                'Password_Hash' => Hash::make('Sales456!'),
                'Role' => 'SalesStaff',
                'Full_Name' => 'Ana Reyes',
                'Email' => 'ana@rozmed.com',
                'Phone' => '+63 919 345 6789',
                'Department' => 'Sales',
                'Last_Login' => $now->subDays(3),
                'Status' => 'Active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'Username' => 'carlos.lim',
                'Password_Hash' => Hash::make('Sales789!'),
                'Role' => 'SalesStaff',
                'Full_Name' => 'Carlos Lim',
                'Email' => 'carlos@rozmed.com',
                'Phone' => '+63 920 456 7890',
                'Department' => 'Sales',
                'Last_Login' => $now->subWeek(),
                'Status' => 'Active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Finance Staff
            [
                'Username' => 'liza.tan',
                'Password_Hash' => Hash::make('Finance123!'),
                'Role' => 'FinanceStaff',
                'Full_Name' => 'Liza Tan',
                'Email' => 'liza@rozmed.com',
                'Phone' => '+63 921 567 8901',
                'Department' => 'Finance',
                'Last_Login' => $now->subDays(4),
                'Status' => 'Active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'Username' => 'mark.ong',
                'Password_Hash' => Hash::make('Finance456!'),
                'Role' => 'FinanceStaff',
                'Full_Name' => 'Mark Ong',
                'Email' => 'mark@rozmed.com',
                'Phone' => '+63 922 678 9012',
                'Department' => 'Finance',
                'Last_Login' => $now->subDays(5),
                'Status' => 'Active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Inventory Managers
            [
                'Username' => 'robert.garcia',
                'Password_Hash' => Hash::make('Inventory123!'),
                'Role' => 'InventoryManager',
                'Full_Name' => 'Robert Garcia',
                'Email' => 'robert@rozmed.com',
                'Phone' => '+63 923 789 0123',
                'Department' => 'Warehouse',
                'Last_Login' => $now->subDays(6),
                'Status' => 'Active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'Username' => 'susan.li',
                'Password_Hash' => Hash::make('Inventory456!'),
                'Role' => 'InventoryManager',
                'Full_Name' => 'Susan Li',
                'Email' => 'susan@rozmed.com',
                'Phone' => '+63 924 890 1234',
                'Department' => 'Warehouse',
                'Last_Login' => $now->subDays(7),
                'Status' => 'Active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('users')->insert($users);
        $this->command->info('✅ Seeded 8 users');
    }
}