<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('deliveries')->insert([
            [
                'company_id'    => 1, // adjust based on existing company IDs
                'city_id'       => 1, // adjust based on existing city IDs
                'place'         => 'Downtown',
                'price'         => 15.50,
                'delivery_time' => '00:30:00', // 30 minutes
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'company_id'    => 1,
                'city_id'       => 1,
                'place'         => 'Airport',
                'price'         => 25.00,
                'delivery_time' => '01:00:00', // 1 hour
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'company_id'    => 1,
                'city_id'       => 1,
                'place'         => 'Train Station',
                'price'         => 12.75,
                'delivery_time' => '00:45:00',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'company_id'    => 2, // adjust based on existing company IDs
                'city_id'       => 1, // adjust based on existing city IDs
                'place'         => 'Downtown',
                'price'         => 15.50,
                'delivery_time' => '00:30:00', // 30 minutes
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'company_id'    => 2,
                'city_id'       => 1,
                'place'         => 'Airport',
                'price'         => 25.00,
                'delivery_time' => '01:00:00', // 1 hour
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'company_id'    => 2,
                'city_id'       => 1,
                'place'         => 'Train Station',
                'price'         => 12.75,
                'delivery_time' => '00:45:00',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
        ]);
    }
}
