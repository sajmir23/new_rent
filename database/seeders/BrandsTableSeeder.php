<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('brands')->insert([
            [
                'title' => 'Volkswagen',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'BMW',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Mercedes-Benz',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Audi',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Toyota',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Honda',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Ford',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Hyundai',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Kia',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Nissan',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Lexus',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Mazda',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Subaru',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Chevrolet',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Jeep',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Dodge',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Chrysler',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Ram',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Buick',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Cadillac',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Volvo',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Land Rover',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Jaguar',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Porsche',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Ferrari',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Lamborghini',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Maserati',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Renault',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Peugeot',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Skoda',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
            ]
        );
    }
}
