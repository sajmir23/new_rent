<?php

namespace Database\Seeders;

use App\Models\Admin\PaymentStatus;
use Illuminate\Database\Seeder;

class PaymentStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payments=[
            [
                'title_en' => 'Pending',
                'title_it' => 'In attesa',
                'title_al' => 'Ne pritje',
                'title_es' => 'Pendiente',
                'title_de' => 'Ausstehend',
                'title_fr' => 'En attente',
                'text_color' => '#856404',
                'background_color' => '#fff3cd',
                'status' => true,
            ],
            [
                'title_en' => 'Paid',
                'title_it' => 'Pagato',
                'title_al' => 'E paguar',
                'title_es' => 'Pagado',
                'title_de' => 'Bezahlt',
                'title_fr' => 'Payé',
                'text_color' => '#155724',
                'background_color' => '#d4edda',
                'status' => true,
            ],
            [
                'title_en' => 'Refunded',
                'title_it' => 'Rimborsato',
                'title_al' => 'Rikthyer',
                'title_es' => 'Reembolsado',
                'title_de' => 'Rückerstattet',
                'title_fr' => 'Remboursé',
                'text_color' => '#0c5460',
                'background_color' => '#d1ecf1',
                'status' => true,
            ],
            [
                'title_en' => 'Disputed',
                'title_it' => 'Controverso',
                'title_al' => 'I kundershtuar',
                'title_es' => 'En disputa',
                'title_de' => 'Angezweifelt',
                'title_fr' => 'Contesté',
                'text_color' => '#721c24',
                'background_color' => '#f8d7da',
                'status' => true,
            ]
        ];
        foreach($payments as $payment)
        {
            PaymentStatus::create($payment);
        }
    }
}
