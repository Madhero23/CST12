<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExchangeRateSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        
        $rates = [];
        
        // Generate rates for the last 30 days
        for ($i = 30; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i);
            // Simulate realistic PHP-USD fluctuations
            $baseRate = 56.50 + (rand(-50, 50) / 100); // Between 56.00 and 57.00
            
            $rates[] = [
                'Currency_Pair' => 'USD-PHP',
                'Rate_Value' => round($baseRate, 4),
                'Effective_Date' => $date->toDateString(),
                'Source' => 'BSP',
                'created_at' => $date,
                'updated_at' => $date,
            ];
        }
        
        // Add some specific rates for important dates
        $importantRates = [
            ['date' => '2024-01-01', 'rate' => 56.25, 'source' => 'BSP'],
            ['date' => '2024-01-15', 'rate' => 56.40, 'source' => 'BSP'],
            ['date' => '2024-02-01', 'rate' => 56.75, 'source' => 'BSP'],
            ['date' => $now->toDateString(), 'rate' => 57.00, 'source' => 'BSP'],
        ];
        
        foreach ($importantRates as $rate) {
            $rates[] = [
                'Currency_Pair' => 'USD-PHP',
                'Rate_Value' => $rate['rate'],
                'Effective_Date' => $rate['date'],
                'Source' => $rate['source'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        
        foreach ($rates as $rate) {
            DB::table('exchange_rates')->insert($rate);
        }
        $this->command->info('✅ Seeded ' . count($rates) . ' exchange rates');
    }
}