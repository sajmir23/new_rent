<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleModelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vehicle_models')->insert([

            ['title' => '1 Series', 'brand_id' => 2, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => '3 Series', 'brand_id' => 2, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => '5 Series', 'brand_id' => 2, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => '7 Series', 'brand_id' => 2, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'X1', 'brand_id' => 2, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'X3', 'brand_id' => 2, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'X5', 'brand_id' => 2, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'X6', 'brand_id' => 2, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'M3', 'brand_id' => 2, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'M5', 'brand_id' => 2, 'status' => true, 'created_at' => now(), 'updated_at' => now()],


            ['title' => 'A-Class', 'brand_id' => 3, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'C-Class', 'brand_id' => 3, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'E-Class', 'brand_id' => 3, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'S-Class', 'brand_id' => 3, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'GLA', 'brand_id' => 3, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'GLC', 'brand_id' => 3, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'GLE', 'brand_id' => 3, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'GLS', 'brand_id' => 3, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'AMG GT', 'brand_id' => 3, 'status' => true, 'created_at' => now(), 'updated_at' => now()],


            ['title' => 'A1', 'brand_id' => 4, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'A3', 'brand_id' => 4, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'A4', 'brand_id' => 4, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'A6', 'brand_id' => 4, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'A8', 'brand_id' => 4, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Q2', 'brand_id' => 4, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Q3', 'brand_id' => 4, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Q5', 'brand_id' => 4, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Q7', 'brand_id' => 4, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'RS6', 'brand_id' => 4, 'status' => true, 'created_at' => now(), 'updated_at' => now()],


            ['title' => 'Corolla', 'brand_id' => 5, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Camry', 'brand_id' => 5, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Yaris', 'brand_id' => 5, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'RAV4', 'brand_id' => 5, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Land Cruiser', 'brand_id' => 5, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Hilux', 'brand_id' => 5, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Prius', 'brand_id' => 5, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'C-HR', 'brand_id' => 5, 'status' => true, 'created_at' => now(), 'updated_at' => now()],


            ['title' => 'Polo', 'brand_id' => 1, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Golf', 'brand_id' => 1, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Passat', 'brand_id' => 1, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Tiguan', 'brand_id' => 1, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Touareg', 'brand_id' => 1, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Arteon', 'brand_id' => 1, 'status' => true, 'created_at' => now(), 'updated_at' => now()],


            ['title' => 'Civic', 'brand_id' => 6, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Accord', 'brand_id' => 6, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'CR-V', 'brand_id' => 6, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'HR-V', 'brand_id' => 6, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Jazz', 'brand_id' => 6, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Pilot', 'brand_id' => 6, 'status' => true, 'created_at' => now(), 'updated_at' => now()],


            ['title' => 'Fiesta', 'brand_id' => 7, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Focus', 'brand_id' => 7, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Mondeo', 'brand_id' => 7, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Mustang', 'brand_id' => 7, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Explorer', 'brand_id' => 7, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Ranger', 'brand_id' => 7, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'F-150', 'brand_id' => 7, 'status' => true, 'created_at' => now(), 'updated_at' => now()],


            ['title' => 'i10', 'brand_id' => 8, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'i20', 'brand_id' => 8, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'i30', 'brand_id' => 8, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Tucson', 'brand_id' => 8, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Santa Fe', 'brand_id' => 8, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Kona', 'brand_id' => 8, 'status' => true, 'created_at' => now(), 'updated_at' => now()],


            ['title' => 'Rio', 'brand_id' => 9, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Ceed', 'brand_id' => 9, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Optima', 'brand_id' => 9, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Sportage', 'brand_id' => 9, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Sorento', 'brand_id' => 9, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Stinger', 'brand_id' => 9, 'status' => true, 'created_at' => now(), 'updated_at' => now()],


            ['title' => 'Micra', 'brand_id' => 10, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Juke', 'brand_id' => 10, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Qashqai', 'brand_id' => 10, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'X-Trail', 'brand_id' => 10, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Leaf', 'brand_id' => 10, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Navara', 'brand_id' => 10, 'status' => true, 'created_at' => now(), 'updated_at' => now()],


            ['title' => 'IS', 'brand_id' => 11, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'ES', 'brand_id' => 11, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'GS', 'brand_id' => 11, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'LS', 'brand_id' => 11, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'NX', 'brand_id' => 11, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'RX', 'brand_id' => 11, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'GX', 'brand_id' => 11, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'LX', 'brand_id' => 11, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'RC', 'brand_id' => 11, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'LC', 'brand_id' => 11, 'status' => true, 'created_at' => now(), 'updated_at' => now()],


            ['title' => 'Mazda2', 'brand_id' => 12, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Mazda3', 'brand_id' => 12, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Mazda6', 'brand_id' => 12, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'CX-3', 'brand_id' => 12, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'CX-30', 'brand_id' => 12, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'CX-5', 'brand_id' => 12, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'CX-50', 'brand_id' => 12, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'CX-9', 'brand_id' => 12, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'MX-5 Miata', 'brand_id' => 12, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'RX-8', 'brand_id' => 12, 'status' => true, 'created_at' => now(), 'updated_at' => now()],

            ['title' => 'Impreza', 'brand_id' => 13, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Legacy', 'brand_id' => 13, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Outback', 'brand_id' => 13, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Forester', 'brand_id' => 13, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Ascent', 'brand_id' => 13, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Crosstrek', 'brand_id' => 13, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'BRZ', 'brand_id' => 13, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'WRX', 'brand_id' => 13, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'WRX STI', 'brand_id' => 13, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Tribeca', 'brand_id' => 13, 'status' => true, 'created_at' => now(), 'updated_at' => now()],

            ['title' => 'Camaro', 'brand_id' => 14, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Corvette', 'brand_id' => 14, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Malibu', 'brand_id' => 14, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Impala', 'brand_id' => 14, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Cruze', 'brand_id' => 14, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Spark', 'brand_id' => 14, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Equinox', 'brand_id' => 14, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Tahoe', 'brand_id' => 14, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Suburban', 'brand_id' => 14, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Silverado', 'brand_id' => 14, 'status' => true, 'created_at' => now(), 'updated_at' => now()],

            ['title' => 'Wrangler', 'brand_id' => 15, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Grand Cherokee', 'brand_id' => 15, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Cherokee', 'brand_id' => 15, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Compass', 'brand_id' => 15, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Renegade', 'brand_id' => 15, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Gladiator', 'brand_id' => 15, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Wagoneer', 'brand_id' => 15, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Grand Wagoneer', 'brand_id' => 15, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Liberty', 'brand_id' => 15, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Patriot', 'brand_id' => 15, 'status' => true, 'created_at' => now(), 'updated_at' => now()],

            ['title' => 'Charger', 'brand_id' => 16, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Challenger', 'brand_id' => 16, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Durango', 'brand_id' => 16, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Dart', 'brand_id' => 16, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Avenger', 'brand_id' => 16, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Viper', 'brand_id' => 16, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Journey', 'brand_id' => 16, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Magnum', 'brand_id' => 16, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Neon', 'brand_id' => 16, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Ram Van', 'brand_id' => 16, 'status' => true, 'created_at' => now(), 'updated_at' => now()],

            ['title' => '300', 'brand_id' => 17, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Pacifica', 'brand_id' => 17, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Voyager', 'brand_id' => 17, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Sebring', 'brand_id' => 17, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Aspen', 'brand_id' => 17, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'PT Cruiser', 'brand_id' => 17, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Crossfire', 'brand_id' => 17, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Concorde', 'brand_id' => 17, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'LHS', 'brand_id' => 17, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Town & Country', 'brand_id' => 17, 'status' => true, 'created_at' => now(), 'updated_at' => now()],

            ['title' => '1500', 'brand_id' => 18, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => '2500', 'brand_id' => 18, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => '3500', 'brand_id' => 18, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'ProMaster', 'brand_id' => 18, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'ProMaster City', 'brand_id' => 18, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Dakota', 'brand_id' => 18, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'TRX', 'brand_id' => 18, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Power Wagon', 'brand_id' => 18, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Rebel', 'brand_id' => 18, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Warlock', 'brand_id' => 18, 'status' => true, 'created_at' => now(), 'updated_at' => now()],

            ['title' => 'Enclave', 'brand_id' => 19, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Encore', 'brand_id' => 19, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Regal', 'brand_id' => 19, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'LaCrosse', 'brand_id' => 19, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Verano', 'brand_id' => 19, 'status' => true, 'updated_at' => now(), 'created_at' => now()],
            ['title' => 'Envision', 'brand_id' => 19, 'status' => true, 'updated_at' => now(), 'created_at' => now()],
            ['title' => 'Lucerne', 'brand_id' => 19, 'status' => true, 'updated_at' => now(), 'created_at' => now()],
            ['title' => 'Park Avenue', 'brand_id' => 19, 'status' => true, 'updated_at' => now(), 'created_at' => now()],
            ['title' => 'Rendezvous', 'brand_id' => 19, 'status' => true, 'updated_at' => now(), 'created_at' => now()],
            ['title' => 'Century', 'brand_id' => 19, 'status' => true, 'updated_at' => now(), 'created_at' => now()],

            ['title' => 'Escalade', 'brand_id' => 20, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'XT5', 'brand_id' => 20, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'XT6', 'brand_id' => 20, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'CT5', 'brand_id' => 20, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'CT4', 'brand_id' => 20, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'ATS', 'brand_id' => 20, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'CTS', 'brand_id' => 20, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'SRX', 'brand_id' => 20, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'DTS', 'brand_id' => 20, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'XLR', 'brand_id' => 20, 'status' => true, 'created_at' => now(), 'updated_at' => now()],


            ['title' => 'XC90', 'brand_id' => 21, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'XC60', 'brand_id' => 21, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'XC40', 'brand_id' => 21, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'S90', 'brand_id' => 21, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'S60', 'brand_id' => 21, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'V90', 'brand_id' => 21, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'V60', 'brand_id' => 21, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'C30', 'brand_id' => 21, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'C70', 'brand_id' => 21, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => '850', 'brand_id' => 21, 'status' => true, 'created_at' => now(), 'updated_at' => now()],

            ['title' => 'Range Rover', 'brand_id' => 22, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Range Rover Sport', 'brand_id' => 22, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Range Rover Evoque', 'brand_id' => 22, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Defender', 'brand_id' => 22, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Discovery', 'brand_id' => 22, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Discovery Sport', 'brand_id' => 22, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Freelander', 'brand_id' => 22, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'LR2', 'brand_id' => 22, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'LR3', 'brand_id' => 22, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'LR4', 'brand_id' => 22, 'status' => true, 'created_at' => now(), 'updated_at' => now()],

            ['title' => 'F-PACE', 'brand_id' => 23, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'E-PACE', 'brand_id' => 23, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'I-PACE', 'brand_id' => 23, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'XF', 'brand_id' => 23, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'XE', 'brand_id' => 23, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'XJ', 'brand_id' => 23, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'F-TYPE', 'brand_id' => 23, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'S-TYPE', 'brand_id' => 23, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'XK', 'brand_id' => 23, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'XJR', 'brand_id' => 23, 'status' => true, 'created_at' => now(), 'updated_at' => now()],

            ['title' => '911', 'brand_id' => 24, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Cayenne', 'brand_id' => 24, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Macan', 'brand_id' => 24, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Panamera', 'brand_id' => 24, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Taycan', 'brand_id' => 24, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => '718 Cayman', 'brand_id' => 24, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => '718 Boxster', 'brand_id' => 24, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => '918 Spyder', 'brand_id' => 24, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Carrera GT', 'brand_id' => 24, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => '935', 'brand_id' => 24, 'status' => true, 'created_at' => now(), 'updated_at' => now()],


            ['title' => '488 GTB', 'brand_id' => 25, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => '812 Superfast', 'brand_id' => 25, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Roma', 'brand_id' => 25, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Portofino', 'brand_id' => 25, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'F8 Tributo', 'brand_id' => 25, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'SF90 Stradale', 'brand_id' => 25, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'LaFerrari', 'brand_id' => 25, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Enzo', 'brand_id' => 25, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'F50', 'brand_id' => 25, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'California', 'brand_id' => 25, 'status' => true, 'created_at' => now(), 'updated_at' => now()],

        ]);
    }
}
