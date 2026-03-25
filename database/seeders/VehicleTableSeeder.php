<?php

namespace Database\Seeders;

use App\Models\Company\Vehicle;
use App\Models\Company\VehicleAdditionalService;
use App\Models\Company\VehicleRequirement;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Psy\Util\Str;

class VehicleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicles = [
            [
                'company_id'                    => 1,
                'vehicle_model_id'              => 39,
                'vehicle_category_id'           => 1,
                'fuel_type_id'                  => 1,
                'transmission_type_id'          => 1,
                'vehicle_status_id'             => 5,
                'created_by'                    => 1,
                'updated_by'                    => 1,
                'title'                         => 'Volkswagen Golf 2019',
                'slug'                          => 'volkswagen-golf-2019',
                'base_daily_rate'               => 20.00,
                'plate'                         => 'GOLF-2025',
                'vin'                           => 'WVWZZZ1KZKW123456',
                'registration_expiry'           => Carbon::now()->addMonths(8),
                'insurance_expiry'              => Carbon::now()->addMonths(10),
                'year'                          => 2019,
                'mileage'                       => 60000,
                'color'                         => 'Blue',
                'notes'                         => 'Compact hatchback, perfect for city and highway.',
                'seats'                         => 5,
                'engine_size'                   => 2.0,
            ],

            [
                'company_id'                    => 1,
                'vehicle_model_id'              => 30,
                'vehicle_category_id'           => 2,
                'fuel_type_id'                  => 2,
                'transmission_type_id'          => 2,
                'vehicle_status_id'             => 1,
                'created_by'                    => 1,
                'updated_by'                    => 1,
                'title'                         => 'Toyota Corolla 2021',
                'slug'                          => 'toyota-corolla-2021',
                'base_daily_rate'               => 25.00,
                'plate'                         => 'COR-2021',
                'vin'                           => 'JTDBL40E799123457',
                'registration_expiry'           => Carbon::now()->addMonths(12),
                'insurance_expiry'              => Carbon::now()->addMonths(14),
                'year'                          => 2021,
                'mileage'                       => 35000,
                'color'                         => 'White',
                'notes'                         => 'Reliable sedan with excellent fuel efficiency.',
                'seats'                         => 5,
                'engine_size'                   => 2.5,
            ],

            [
                'company_id'                    => 1,
                'vehicle_model_id'              => 7,
                'vehicle_category_id'           => 3,
                'fuel_type_id'                  => 3,
                'transmission_type_id'          => 1,
                'vehicle_status_id'             => 1,
                'created_by'                    => 1,
                'updated_by'                    => 1,
                'title'                         => 'BMW X5 2022',
                'slug'                          => 'bmw-X5-2022',
                'base_daily_rate'               => 65.00,
                'plate'                         => 'BMWX5-22',
                'vin'                           => 'WP0ZZZ99ZTS392124',
                'registration_expiry'           => Carbon::now()->addMonths(9),
                'insurance_expiry'              => Carbon::now()->addMonths(11),
                'year'                          => 2022,
                'mileage'                       => 20000,
                'color'                         => 'Black',
                'notes'                         => 'Luxury SUV with premium comfort and features.',
                'seats'                         => 7,
            ],

            [
                'company_id'                    => 1,
                'vehicle_model_id'              => 61,
                'vehicle_category_id'           => 4,
                'fuel_type_id'                  => 4,
                'transmission_type_id'          => 2,
                'vehicle_status_id'             => 1,
                'created_by'                    => 1,
                'updated_by'                    => 1,
                'title'                         => 'Hyundai Santa Fe',
                'slug'                          => 'hyundai-santa-fe',
                'base_daily_rate'               => 80.00,
                'plate'                         => 'Hyundai-23',
                'vin'                           => '1HGCM82633A004352',
                'registration_expiry'           => Carbon::now()->addMonths(15),
                'insurance_expiry'              => Carbon::now()->addMonths(16),
                'year'                          => 2023,
                'mileage'                       => 10000,
                'color'                         => 'Red',
                'notes'                         => 'Fully electric sedan with autopilot and zero emissions.',
            ],
        ];

        foreach ($vehicles as $data) {
           Vehicle::create($data);

        }
    }
}
