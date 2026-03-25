<?php

namespace Database\Seeders;

use App\Models\Admin\BookingStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'id' => BookingStatus::PENDING,
                'title_en' => 'Pending',
                'title_it' => 'In attesa',
                'title_al' => 'Në pritje',
                'title_es' => 'Pendiente',
                'title_fr' => 'En attente',
                'title_de' => 'Ausstehend',
                'text_color' => '#FFA500',
                'background_color' => '#FFF5E5',
                'status' => true,
            ],
            [
                'id' => BookingStatus::CONFIRMED,
                'title_en' => 'Confirmed',
                'title_it' => 'Confermato',
                'title_al' => 'Konfirmuar',
                'title_es' => 'Confirmado',
                'title_fr' => 'Confirmé',
                'title_de' => 'Bestätigt',
                'text_color' => '#007BFF',
                'background_color' => '#E6F0FF',
                'status' => true,
            ],
            [
                'id' => BookingStatus::ACTIVE,
                'title_en' => 'Active',
                'title_it' => 'Attivo',
                'title_al' => 'Aktiv',
                'title_es' => 'Activo',
                'title_fr' => 'Actif',
                'title_de' => 'Aktiv',
                'text_color' => '#28A745',
                'background_color' => '#E6F9E6',
                'status' => true,
            ],
            [
                'id' => BookingStatus::COMPLETED,
                'title_en' => 'Completed',
                'title_it' => 'Completato',
                'title_al' => 'Përfunduar',
                'title_es' => 'Completado',
                'title_fr' => 'Terminé',
                'title_de' => 'Abgeschlossen',
                'text_color' => '#6C757D',
                'background_color' => '#F2F2F2',
                'status' => true,
            ],
            [
                'id' => BookingStatus::CANCELLED,
                'title_en' => 'Cancelled',
                'title_it' => 'Annullato',
                'title_al' => 'Anuluar',
                'title_es' => 'Cancelado',
                'title_fr' => 'Annulé',
                'title_de' => 'Storniert',
                'text_color' => '#DC3545',
                'background_color' => '#FDECEA',
                'status' => true,
            ],
        ];

        foreach ($statuses as $status) {
            BookingStatus::create($status);
        }
    }
}
