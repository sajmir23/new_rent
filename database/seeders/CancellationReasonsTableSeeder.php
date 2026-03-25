<?php

namespace Database\Seeders;

use App\Models\Admin\Cancellation_Reasons;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CancellationReasonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cancellation_reasons = [
            [
                'title_en' => 'Weather conditions',
                'title_it' => 'Condizioni meteorologiche',
                'title_al' => 'Kushte atmosferike',
                'title_es' => 'Condiciones meteorológicas',
                'title_de' => 'Wetterbedingungen',
                'title_fr' => 'Conditions météorologiques',
                'status' => true,

            ],
            [
                'title_en' => 'Difficult to use',
                'title_it' => 'Difficile da usare',
                'title_al' => 'Veshtire per t’u perdorur',
                'title_es' => 'Difícil de usar',
                'title_de' => 'Schwer zu benutzen',
                'title_fr' => 'Difficile à utiliser',
                'status' => true,
            ],
            [
                'title_en' => 'Address entered incorrectly',
                'title_it' => 'Indirizzo inserito errato',
                'title_al' => 'Adrese e futur gabim',
                'title_es' => 'Dirección ingresada incorrectamente',
                'title_de' => 'Falsche Adresse eingegeben',
                'title_fr' => 'Adresse saisie incorrectement',
                'status' => true,
            ],
            [
                'title_en' => 'Found a better price elsewhere',
                'title_it' => ' Trovato un prezzo migliore altrove',
                'title_al' => '  Gjeti çmim me te mire diku tjeter',
                'title_es' => ' Encontró un mejor precio en otro lugar',
                'title_de' => ' Anderenorts besseren Preis gefunden',
                'title_fr' => ' A trouvé un meilleur prix ailleurs',
                'status' => true,
            ],
            [
                'title_en' => 'Customer changed mind',
                'title_it' => ' Il cliente ha cambiato idea',
                'title_al' => '  Klienti ndryshoi mendje',
                'title_es' => ' El cliente cambió de opinión',
                'title_de' => '  Kunde hat seine Meinung geändert',
                'title_fr' => '  Le client a changé d’avis',
                'status' => true,
            ],
        ];
        foreach ($cancellation_reasons as $cancellation_reason) {
            Cancellation_Reasons::create($cancellation_reason);
        }
    }
}
