<?php

/**
 * AdminUserSeeder — Seeds a default Admin user for initial login.
 *
 * Run with: php artisan db:seed --class=AdminUserSeeder
 */

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed the default admin user.
     */
    public function run(): void
    {
        // Only create if the admin user doesn't already exist
        if (!User::where('Username', 'admin')->exists()) {
            User::create([
                'Username'      => 'admin',
                'Email'         => 'admin@rozmed.com',
                'Password_Hash' => Hash::make('Admin1234!'),
                'Role'          => 'Admin',
                'Full_Name'     => 'System Administrator',
                'Phone'         => '09170000000',
                'Department'    => 'IT',
                'Status'        => 'Active',
            ]);

            $this->command->info('Admin user created: admin / Admin1234!');
        } else {
            $this->command->info('Admin user already exists, skipping.');
        }

        // Create sample role-specific users for testing
        $testUsers = [
            [
                'Username'   => 'salesstaff01',
                'Email'      => 'sales@rozmed.com',
                'Password'   => 'Pass1234!',
                'Role'       => 'SalesStaff',
                'Full_Name'  => 'Sales Staff',
                'Phone'      => '09170000001',
                'Department' => 'Sales',
            ],
            [
                'Username'   => 'financestaff01',
                'Email'      => 'finance@rozmed.com',
                'Password'   => 'Pass1234!',
                'Role'       => 'FinanceStaff',
                'Full_Name'  => 'Finance Staff',
                'Phone'      => '09170000002',
                'Department' => 'Finance',
            ],
            [
                'Username'   => 'inventorymgr01',
                'Email'      => 'inventory@rozmed.com',
                'Password'   => 'Pass1234!',
                'Role'       => 'InventoryManager',
                'Full_Name'  => 'Inventory Manager',
                'Phone'      => '09170000003',
                'Department' => 'Warehouse',
            ],
        ];

        foreach ($testUsers as $userData) {
            if (!User::where('Username', $userData['Username'])->exists()) {
                User::create([
                    'Username'      => $userData['Username'],
                    'Email'         => $userData['Email'],
                    'Password_Hash' => Hash::make($userData['Password']),
                    'Role'          => $userData['Role'],
                    'Full_Name'     => $userData['Full_Name'],
                    'Phone'         => $userData['Phone'],
                    'Department'    => $userData['Department'],
                    'Status'        => 'Active',
                ]);
                $this->command->info("Created user: {$userData['Username']} / {$userData['Password']}");
            }
        }
    }
}
