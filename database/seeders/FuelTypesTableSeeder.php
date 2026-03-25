<?php

namespace Database\Seeders;

use App\Models\Admin\FuelTypes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FuelTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $fueltypes = [
              [
                  'title_en' => 'Diesel',
                  'title_it' => 'Diesel',
                  'title_al' => 'Naftë',
                  'title_es' => 'Diésel',
                  'title_de' => 'Diesel',
                  'title_fr' => 'Diesel',
                  'status' => true,
              ],
              [
                  'title_en' => 'Petrol',
                  'title_it' => 'Benzina',
                  'title_al' => 'Benzinë',
                  'title_es' => 'Gasolina',
                  'title_de' => 'Benzin',
                  'title_fr' => 'Essence',
                  'status' => true,
              ],
              [
                  'title_en' => 'Electricity',
                  'title_it' => 'Elettricità',
                  'title_al' => 'Energji elektrike',
                  'title_es' => 'Electricidad',
                  'title_de' => 'Elektrizität',
                  'title_fr' => 'Électricité',
                  'status' => true,
              ],
              [
                  'title_en' => 'Hybrid',
                  'title_it' => 'Ibrido',
                  'title_al' => 'Hibrid',
                  'title_es' => 'Híbrido',
                  'title_de' => 'Hybrid',
                  'title_fr' => 'Hybride',
                  'status' => true,
              ],
              [
                      'title_en' => 'Hydrogen',
                      'title_it' => 'Idrogeno',
                      'title_al' => 'Hidrogjen',
                      'title_es' => 'Hidrógeno',
                      'title_de' => 'Wasserstoff',
                      'title_fr' => 'Hydrogène',
                      'status' => true,
              ],
              [
                  'title_en' => 'Bi-Fuel',
                  'title_it' => 'BiFuel',
                  'title_al' => 'Bi-karburant',
                  'title_es' => 'Bicombustible',
                  'title_de' => 'Bivalenter Antrieb',
                  'title_fr' => 'Bicarburation',
                  'status' => true,
              ]
          ];

          foreach ($fueltypes as $fueltype) {
              FuelTypes::create($fueltype);
          }
    }
}
