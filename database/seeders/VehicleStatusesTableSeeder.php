<?php

namespace Database\Seeders;

use App\Models\Admin\VehicleStatus;
use Illuminate\Database\Seeder;

class VehicleStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicleStatuses = [
            [
                'id' => VehicleStatus::AVAILABLE,
                'title_en' => 'Available',
                'title_it' => 'Disponibile',
                'title_al' => 'Ne dispozicion',
                'title_es' => 'Disponible',
                'title_de' => 'Verfügbar',
                'title_fr' => 'Disponible',
                'text_color' => '#198754',
                'background_color' => '#D1E7DD',
                'status' => true,
            ],
            [
                'id' => VehicleStatus::BOOKED,
                'title_en' => 'Booked',
                'title_it' => 'Prenotato',
                'title_al' => 'I rezervuar',
                'title_es' => 'Reservado',
                'title_de' => 'Gebucht',
                'title_fr' => 'Réservé',
                'text_color' => '#0D6EFD',
                'background_color' => '#CFE2FF',
                'status' => true,
            ],
            [
                'id' => VehicleStatus::MAINTENANCE,
                'title_en' => 'Maintenance',
                'title_it' => 'Manutenzione',
                'title_al' => 'Mirembajtje',
                'title_es' => 'Mantenimiento',
                'title_de' => 'Wartung',
                'title_fr' => 'Maintenance',
                'text_color' => '#B02A37',
                'background_color' => '#F8D7DA',
                'status' => true,
            ],
            [
                'id' => VehicleStatus::INACTIVE,
                'title_en' => 'Inactive',
                'title_it' => 'Inattivo',
                'title_al' => 'Joaktiv',
                'title_es' => 'Inactivo',
                'title_de' => 'Inaktiv',
                'title_fr' => 'Inactif',
                'text_color' => '#6C757D',
                'background_color' => '#E2E3E5',
                'status' => true,
            ],
            [
                'id' => VehicleStatus::RENTED,
                'title_en' => 'Rented',
                'title_it' => 'Noleggiato',
                'title_al' => 'Me qira',
                'title_es' => 'Alquilado',
                'title_de' => 'Vermietet',
                'title_fr' => 'Loué',
                'text_color' => '#0D6EFD',
                'background_color' => '#CFE2FF',
                'status' => true,
            ]
        ];
        foreach ($vehicleStatuses as $vehicleStatus)
        {
            VehicleStatus::create($vehicleStatus);
        }
    }
}
