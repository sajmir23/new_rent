<?php

namespace Database\Seeders;

use App\Models\Company\SeasonalPrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeasonalPricesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SeasonalPrice::insert([
            [
                'company_id'      => 1,
                'start_date'      => '2025-06-01',
                'end_date'        => '2025-08-31', // summer high season
                'rate_multiplier' => 1.25,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'company_id'      => 1,
                'start_date'      => '2025-12-15',
                'end_date'        => '2026-01-10', // Christmas/New Year peak
                'rate_multiplier' => 1.50,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
        ]);
    }
}
