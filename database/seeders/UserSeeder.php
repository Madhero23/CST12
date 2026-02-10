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
        DB::table('users')->insert([
            [
                'Username' => 'admin.rozmed',
                'Password_Hash' => Hash::make('Admin123!'),
                'Role' => 'Admin',
                'Full_Name' => 'Maria Santos',
                'Email' => 'maria@rozmed.com',
                'Phone' => '+63 917 123 4567',
                'Department' => 'Administration',
                'Status' => 'Active',
                'Created_Date' => Carbon::now()->subYear(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'Username' => 'juan.dela',
                'Password_Hash' => Hash::make('Sales123!'),
                'Role' => 'Sales Staff',
                'Full_Name' => 'Juan Dela Cruz',
                'Email' => 'juan@rozmed.com',
                'Phone' => '+63 918 234 5678',
                'Department' => 'Sales',
                'Status' => 'Active',
                'Created_Date' => Carbon::now()->subYear(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Add more users based on your ERD
        ]);
    }
}