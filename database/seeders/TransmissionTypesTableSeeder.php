<?php

namespace Database\Seeders;

use App\Models\Admin\TransmissionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransmissionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transmissions = [
            [
                'title_en' => 'Automatic',
                'title_it' => 'Automatico',
                'title_al' => 'Automatik',
                'title_es' => 'Automático',
                'title_fr' => 'Automatique',
                'title_de' => 'Automatik',
            ],
            [
                'title_en' => 'Manual',
                'title_it' => 'Manuale',
                'title_al' => 'Manual',
                'title_es' => 'Manual',
                'title_fr' => 'Manuelle',
                'title_de' => 'Manuell',
            ],
            [
                'title_en' => 'CVT',
                'title_it' => 'CVT',
                'title_al' => 'CVT',
                'title_es' => 'CVT',
                'title_fr' => 'CVT',
                'title_de' => 'CVT',
            ],
            [
                'title_en' => 'DCT',
                'title_it' => 'DCT',
                'title_al' => 'DCT',
                'title_es' => 'DCT',
                'title_fr' => 'DCT',
                'title_de' => 'DCT',
            ],
        ];
        foreach ($transmissions as $transmission) {
            TransmissionType::create($transmission);
        }
    }
}
