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

            [
                'company_id'                    => 1,
                'vehicle_model_id'              => 15,
                'vehicle_category_id'           => 10, // SUV
                'fuel_type_id'                  => 2,  // Petrol
                'transmission_type_id'          => 1,  // Automatic
                'vehicle_status_id'             => 1,  // Available
                'created_by'                    => 1,
                'updated_by'                    => 1,
                'title'                         => 'Audi Q5 2021',
                'slug'                          => 'audi-q5-2021',
                'base_daily_rate'               => 55.00,
                'plate'                         => 'AA-001-ZZ',
                'vin'                           => 'WAUZZZ8R9BA123456',
                'registration_expiry'           => Carbon::now()->addMonths(6),
                'insurance_expiry'              => Carbon::now()->addMonths(8),
                'year'                          => 2021,
                'mileage'                       => 45000,
                'color'                         => 'Grey',
                'notes'                         => 'Premium SUV, great for long trips.',
                'seats'                         => 5,
                'engine_size'                   => 2.0,
            ],
            [
                'company_id'                    => 1,
                'vehicle_model_id'              => 82,
                'vehicle_category_id'           => 2,  // Sedan
                'fuel_type_id'                  => 1,  // Diesel
                'transmission_type_id'          => 2,  // Manual
                'vehicle_status_id'             => 1,
                'created_by'                    => 1,
                'updated_by'                    => 1,
                'title'                         => 'Mercedes-Benz C-Class 2018',
                'slug'                          => 'mercedes-c-class-2018',
                'base_daily_rate'               => 40.00,
                'plate'                         => 'AB-123-CD',
                'vin'                           => 'WDD2050081F123456',
                'registration_expiry'           => Carbon::now()->addMonths(11),
                'insurance_expiry'              => Carbon::now()->addMonths(12),
                'year'                          => 2018,
                'mileage'                       => 85000,
                'color'                         => 'Silver',
                'notes'                         => 'Elegant and comfortable for business meetings.',
                'seats'                         => 5,
                'engine_size'                   => 2.2,
            ],
            [
                'company_id'                    => 1,
                'vehicle_model_id'              => 110,
                'vehicle_category_id'           => 1,  // City
                'fuel_type_id'                  => 3,  // Electricity
                'transmission_type_id'          => 1,  // Automatic
                'vehicle_status_id'             => 1,
                'created_by'                    => 1,
                'updated_by'                    => 1,
                'title'                         => 'Renault Zoe 2020',
                'slug'                          => 'renault-zoe-2020',
                'base_daily_rate'               => 30.00,
                'plate'                         => 'EL-444-ZO',
                'vin'                           => 'VF1AG000657123456',
                'registration_expiry'           => Carbon::now()->addMonths(5),
                'insurance_expiry'              => Carbon::now()->addMonths(7),
                'year'                          => 2020,
                'mileage'                       => 25000,
                'color'                         => 'Blue',
                'notes'                         => 'Full electric, perfect for Tirana city traffic.',
                'seats'                         => 4,
                'engine_size'                   => 0.0,
            ],
            [
                'company_id'                    => 1,
                'vehicle_model_id'              => 145,
                'vehicle_category_id'           => 5,  // 4x4
                'fuel_type_id'                  => 1,  // Diesel
                'transmission_type_id'          => 2,  // Manual
                'vehicle_status_id'             => 1,
                'created_by'                    => 1,
                'updated_by'                    => 1,
                'title'                         => 'Dacia Duster 2022',
                'slug'                          => 'dacia-duster-2022',
                'base_daily_rate'               => 35.00,
                'plate'                         => 'BC-999-EF',
                'vin'                           => 'UU1HSD785L1234567',
                'registration_expiry'           => Carbon::now()->addMonths(14),
                'insurance_expiry'              => Carbon::now()->addMonths(16),
                'year'                          => 2022,
                'mileage'                       => 15000,
                'color'                         => 'Orange',
                'notes'                         => 'Robust 4x4 for exploring the Albanian mountains.',
                'seats'                         => 5,
                'engine_size'                   => 1.5,
            ],
            [
                'company_id'                    => 1,
                'vehicle_model_id'              => 201,
                'vehicle_category_id'           => 4,  // Minibus
                'fuel_type_id'                  => 1,  // Diesel
                'transmission_type_id'          => 2,  // Manual
                'vehicle_status_id'             => 1,
                'created_by'                    => 1,
                'updated_by'                    => 1,
                'title'                         => 'Ford Transit 2019',
                'slug'                          => 'ford-transit-2019',
                'base_daily_rate'               => 70.00,
                'plate'                         => 'TR-8821-B',
                'vin'                           => 'WF0XXXTTGXK123456',
                'registration_expiry'           => Carbon::now()->addMonths(3),
                'insurance_expiry'              => Carbon::now()->addMonths(5),
                'year'                          => 2019,
                'mileage'                       => 120000,
                'color'                         => 'White',
                'notes'                         => 'Ideal for large groups or tours.',
                'seats'                         => 9,
                'engine_size'                   => 2.2,
            ],
            [
                'company_id'                    => 1,
                'vehicle_model_id'              => 55,
                'vehicle_category_id'           => 6,  // Convertible
                'fuel_type_id'                  => 2,  // Petrol
                'transmission_type_id'          => 1,  // Automatic
                'vehicle_status_id'             => 1,
                'created_by'                    => 1,
                'updated_by'                    => 1,
                'title'                         => 'Mazda MX-5 2021',
                'slug'                          => 'mazda-mx5-2021',
                'base_daily_rate'               => 50.00,
                'plate'                         => 'AA-777-MX',
                'vin'                           => 'JM1ND123456789012',
                'registration_expiry'           => Carbon::now()->addMonths(10),
                'insurance_expiry'              => Carbon::now()->addMonths(11),
                'year'                          => 2021,
                'mileage'                       => 12000,
                'color'                         => 'Red',
                'notes'                         => 'Enjoy the coastal sun with this cabrio.',
                'seats'                         => 2,
                'engine_size'                   => 2.0,
            ],
            [
                'company_id'                    => 1,
                'vehicle_model_id'              => 12,
                'vehicle_category_id'           => 10, // SUV
                'fuel_type_id'                  => 4,  // Hybrid
                'transmission_type_id'          => 3,  // CVT
                'vehicle_status_id'             => 1,
                'created_by'                    => 1,
                'updated_by'                    => 1,
                'title'                         => 'Lexus RX 450h 2020',
                'slug'                          => 'lexus-rx450h-2020',
                'base_daily_rate'               => 90.00,
                'plate'                         => 'TR-001-LX',
                'vin'                           => 'JTJBJ11A123456789',
                'registration_expiry'           => Carbon::now()->addMonths(12),
                'insurance_expiry'              => Carbon::now()->addMonths(13),
                'year'                          => 2020,
                'mileage'                       => 38000,
                'color'                         => 'Deep Blue',
                'notes'                         => 'Luxury hybrid SUV with extreme comfort.',
                'seats'                         => 5,
                'engine_size'                   => 3.5,
            ],
            [
                'company_id'                    => 1,
                'vehicle_model_id'              => 180,
                'vehicle_category_id'           => 3,  // Family
                'fuel_type_id'                  => 2,  // Petrol
                'transmission_type_id'          => 1,  // Automatic
                'vehicle_status_id'             => 2,  // Booked
                'created_by'                    => 1,
                'updated_by'                    => 1,
                'title'                         => 'Skoda Octavia 2022',
                'slug'                          => 'skoda-octavia-2022',
                'base_daily_rate'               => 45.00,
                'plate'                         => 'AA-556-SK',
                'vin'                           => 'TMBJJ7NX1NY123456',
                'registration_expiry'           => Carbon::now()->addMonths(18),
                'insurance_expiry'              => Carbon::now()->addMonths(20),
                'year'                          => 2022,
                'mileage'                       => 22000,
                'color'                         => 'Black',
                'notes'                         => 'Very spacious family car with modern tech.',
                'seats'                         => 5,
                'engine_size'                   => 1.5,
            ],
            [
                'company_id'                    => 1,
                'vehicle_model_id'              => 220,
                'vehicle_category_id'           => 7,  // Coupe
                'fuel_type_id'                  => 2,  // Petrol
                'transmission_type_id'          => 4,  // DCT
                'vehicle_status_id'             => 1,
                'created_by'                    => 1,
                'updated_by'                    => 1,
                'title'                         => 'Porsche 718 Cayman',
                'slug'                          => 'porsche-cayman-718',
                'base_daily_rate'               => 150.00,
                'plate'                         => 'TR-718-P',
                'vin'                           => 'WP0ZZZ98ZLS123456',
                'registration_expiry'           => Carbon::now()->addMonths(7),
                'insurance_expiry'              => Carbon::now()->addMonths(9),
                'year'                          => 2021,
                'mileage'                       => 8000,
                'color'                         => 'Yellow',
                'notes'                         => 'High performance sports coupe.',
                'seats'                         => 2,
                'engine_size'                   => 2.5,
            ],
            [
                'company_id'                    => 1,
                'vehicle_model_id'              => 42,
                'vehicle_category_id'           => 1,  // City
                'fuel_type_id'                  => 2,  // Petrol
                'transmission_type_id'          => 2,  // Manual
                'vehicle_status_id'             => 1,
                'created_by'                    => 1,
                'updated_by'                    => 1,
                'title'                         => 'Fiat 500 2019',
                'slug'                          => 'fiat-500-2019',
                'base_daily_rate'               => 18.00,
                'plate'                         => 'AA-111-FF',
                'vin'                           => 'ZFA31200001234567',
                'registration_expiry'           => Carbon::now()->addMonths(4),
                'insurance_expiry'              => Carbon::now()->addMonths(6),
                'year'                          => 2019,
                'mileage'                       => 55000,
                'color'                         => 'Mint Green',
                'notes'                         => 'Small, stylish and easy to park.',
                'seats'                         => 4,
                'engine_size'                   => 1.2,
            ],
            [
                'company_id'                    => 1,
                'vehicle_model_id'              => 68,
                'vehicle_category_id'           => 10, // SUV
                'fuel_type_id'                  => 1,  // Diesel
                'transmission_type_id'          => 1,  // Automatic
                'vehicle_status_id'             => 3,  // Maintenance
                'created_by'                    => 1,
                'updated_by'                    => 1,
                'title'                         => 'Volvo XC90 2020',
                'slug'                          => 'volvo-xc90-2020',
                'base_daily_rate'               => 110.00,
                'plate'                         => 'TR-990-V',
                'vin'                           => 'YV1LF2225L1234567',
                'registration_expiry'           => Carbon::now()->addMonths(2),
                'insurance_expiry'              => Carbon::now()->addMonths(4),
                'year'                          => 2020,
                'mileage'                       => 65000,
                'color'                         => 'White',
                'notes'                         => 'The safest SUV in the world, 7 seats.',
                'seats'                         => 7,
                'engine_size'                   => 2.0,
            ],
            [
                'company_id'                    => 1,
                'vehicle_model_id'              => 99,
                'vehicle_category_id'           => 5,  // 4x4
                'fuel_type_id'                  => 1,  // Diesel
                'transmission_type_id'          => 1,  // Automatic
                'vehicle_status_id'             => 1,
                'created_by'                    => 1,
                'updated_by'                    => 1,
                'title'                         => 'Jeep Wrangler 2021',
                'slug'                          => 'jeep-wrangler-2021',
                'base_daily_rate'               => 85.00,
                'plate'                         => 'AA-444-JW',
                'vin'                           => '1C4HJXDG1MW123456',
                'registration_expiry'           => Carbon::now()->addMonths(12),
                'insurance_expiry'              => Carbon::now()->addMonths(14),
                'year'                          => 2021,
                'mileage'                       => 28000,
                'color'                         => 'Military Green',
                'notes'                         => 'Iconic off-roader for extreme adventures.',
                'seats'                         => 5,
                'engine_size'                   => 2.2,
            ],
            [
                'company_id'                    => 1,
                'vehicle_model_id'              => 150,
                'vehicle_category_id'           => 11, // Antique
                'fuel_type_id'                  => 2,  // Petrol
                'transmission_type_id'          => 2,  // Manual
                'vehicle_status_id'             => 4,  // Inactive
                'created_by'                    => 1,
                'updated_by'                    => 1,
                'title'                         => 'Volkswagen Beetle 1974',
                'slug'                          => 'volkswagen-beetle-1974',
                'base_daily_rate'               => 100.00,
                'plate'                         => 'HIST-01',
                'vin'                           => '1142123456',
                'registration_expiry'           => Carbon::now()->addMonths(24),
                'insurance_expiry'              => Carbon::now()->addMonths(24),
                'year'                          => 1974,
                'mileage'                       => 150000,
                'color'                         => 'Yellow',
                'notes'                         => 'Classic vintage car for photoshoots and weddings.',
                'seats'                         => 4,
                'engine_size'                   => 1.6,
            ],
            [
                'company_id'                    => 1,
                'vehicle_model_id'              => 210,
                'vehicle_category_id'           => 1,  // City
                'fuel_type_id'                  => 6,  // Bi-Fuel
                'transmission_type_id'          => 2,  // Manual
                'vehicle_status_id'             => 1,
                'created_by'                    => 1,
                'updated_by'                    => 1,
                'title'                         => 'Dacia Sandero 2021',
                'slug'                          => 'dacia-sandero-2021',
                'base_daily_rate'               => 22.00,
                'plate'                         => 'AA-223-DS',
                'vin'                           => 'UU1DJF12345678901',
                'registration_expiry'           => Carbon::now()->addMonths(10),
                'insurance_expiry'              => Carbon::now()->addMonths(12),
                'year'                          => 2021,
                'mileage'                       => 40000,
                'color'                         => 'Blue',
                'notes'                         => 'LPG/Petrol mix for super low travel costs.',
                'seats'                         => 5,
                'engine_size'                   => 1.0,
            ],
            [
                'company_id'                    => 1,
                'vehicle_model_id'              => 35,
                'vehicle_category_id'           => 2,  // Sedan
                'fuel_type_id'                  => 2,  // Petrol
                'transmission_type_id'          => 1,  // Automatic
                'vehicle_status_id'             => 1,
                'created_by'                    => 1,
                'updated_by'                    => 1,
                'title'                         => 'Honda Accord 2020',
                'slug'                          => 'honda-accord-2020',
                'base_daily_rate'               => 45.00,
                'plate'                         => 'TR-124-HA',
                'vin'                           => '1HGCR2F58LA123456',
                'registration_expiry'           => Carbon::now()->addMonths(13),
                'insurance_expiry'              => Carbon::now()->addMonths(15),
                'year'                          => 2020,
                'mileage'                       => 30000,
                'color'                         => 'Black',
                'notes'                         => 'Smooth ride and very reliable.',
                'seats'                         => 5,
                'engine_size'                   => 2.0,
            ],
            [
                'company_id'                    => 1,
                'vehicle_model_id'              => 190,
                'vehicle_category_id'           => 9,  // Campervan
                'fuel_type_id'                  => 1,  // Diesel
                'transmission_type_id'          => 2,  // Manual
                'vehicle_status_id'             => 1,
                'created_by'                    => 1,
                'updated_by'                    => 1,
                'title'                         => 'Volkswagen California 2021',
                'slug'                          => 'volkswagen-california-2021',
                'base_daily_rate'               => 130.00,
                'plate'                         => 'CAMP-21',
                'vin'                           => 'WV1ZZZ7HZMH123456',
                'registration_expiry'           => Carbon::now()->addMonths(6),
                'insurance_expiry'              => Carbon::now()->addMonths(8),
                'year'                          => 2021,
                'mileage'                       => 20000,
                'color'                         => 'Two-tone Blue/White',
                'notes'                         => 'Fully equipped for camping around Albania.',
                'seats'                         => 4,
                'engine_size'                   => 2.0,
            ],
        ];

        foreach ($vehicles as $data) {
           Vehicle::create($data);

        }
    }
}
