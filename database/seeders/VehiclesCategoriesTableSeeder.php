<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehiclesCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vehicle_categories')->insert([
            [
                'title_en' => 'City',
                'title_it' => 'Città',
                'title_al' => 'Qytet',
                'title_es' => 'Ciudad',
                'title_de' => 'Stadt',
                'title_fr' => 'Ville',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title_en' => 'Sedan',
                'title_it' => 'Berlina',
                'title_al' => 'Sedan',
                'title_es' => 'Sedán',
                'title_de' => 'Limousine',
                'title_fr' => 'Berline',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title_en' => 'Family',
                'title_it' => 'Familiare',
                'title_al' => 'Familje',
                'title_es' => 'Familiar',
                'title_de' => 'Familienauto',
                'title_fr' => 'Familiale',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title_en' => 'Minibus',
                'title_it' => 'Minibus',
                'title_al' => 'Minibus',
                'title_es' => 'Minibús',
                'title_de' => 'Minibus',
                'title_fr' => 'Minibus',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title_en' => '4x4',
                'title_it' => '4x4',
                'title_al' => '4x4',
                'title_es' => '4x4',
                'title_de' => '4x4',
                'title_fr' => '4x4',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title_en' => 'Convertible',
                'title_it' => 'Cabriolet',
                'title_al' => 'Kabriolet',
                'title_es' => 'Convertible',
                'title_de' => 'Cabrio',
                'title_fr' => 'Décapotable',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title_en' => 'Coupe',
                'title_it' => 'Coupé',
                'title_al' => 'Kupë',
                'title_es' => 'Coupé',
                'title_de' => 'Coupé',
                'title_fr' => 'Coupé',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title_en' => 'Antique',
                'title_it' => 'Antico',
                'title_al' => 'Antik',
                'title_es' => 'Antiguo',
                'title_de' => 'Antik',
                'title_fr' => 'Ancien',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title_en' => 'Campervan',
                'title_it' => 'Camper',
                'title_al' => 'Kamper',
                'title_es' => 'Autocaravana',
                'title_de' => 'Wohnmobil',
                'title_fr' => 'Camping-car',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title_en' => 'SUV',
                'title_it' => 'SUV',
                'title_al' => 'SUV',
                'title_es' => 'SUV',
                'title_de' => 'SUV',
                'title_fr' => 'SUV',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title_en' => 'Commercial',
                'title_it' => 'Commerciale',
                'title_al' => 'Komerci',
                'title_es' => 'Comercial',
                'title_de' => 'Gewerblich',
                'title_fr' => 'Commercial',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
