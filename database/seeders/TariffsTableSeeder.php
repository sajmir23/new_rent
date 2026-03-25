<?php

namespace Database\Seeders;

use App\Models\Company\Tariff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TariffsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tariff::insert([
            [
                'company_id'      => 1,
                'min_days'        => 1,
                'max_days'        => 7,
                'rate_multiplier' => 1.00,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'company_id'      => 1,
                'min_days'        => 8,
                'max_days'        => 14,
                'rate_multiplier' => 0.95,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'company_id'      => 1,
                'min_days'        => 15,
                'max_days'        => null, // open-ended
                'rate_multiplier' => 0.90,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
        ]);
    }
}
