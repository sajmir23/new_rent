<?php

namespace Database\Seeders;

use App\Models\Company\Insurance;
use Illuminate\Database\Seeder;

class InsurancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $insurances = [
            [
                'company_id' => 1,
                'title_en' => 'Basic Insurance',
                'title_it' => 'Assicurazione Base',
                'title_al' => 'Sigurimi Bazë',
                'title_es' => 'Seguro Básico',
                'title_de' => 'Grundversicherung',
                'title_fr' => 'Assurance de base',
                'description_en' => 'Covers damage caused by accidents. Theft and deposit are not included.',
                'description_it' => 'Copre i danni causati da incidenti. Furto e deposito non inclusi.',
                'description_al' => 'Mbulojnë dëmet nga aksidentet. Vjedhja dhe depozita nuk përfshihen.',
                'description_es' => 'Cubre daños por accidentes. No incluye robo ni depósito.',
                'description_de' => 'Deckt Unfallschäden ab. Diebstahl und Kaution nicht enthalten.',
                'description_fr' => 'Couvre les dommages dus aux accidents. Vol et dépôt non inclus.',
                'price_per_day' => 5.00,
                'has_theft_protection' => false,
                'has_deposit' => true,
                'deposit_price' => 300.00,
                'theft_protection_price' => null,
            ],
            [
                'company_id' => 2,
                'title_en' => 'Standard Insurance',
                'title_it' => 'Assicurazione Standard',
                'title_al' => 'Sigurimi Standard',
                'title_es' => 'Seguro Estándar',
                'title_de' => 'Standardversicherung',
                'title_fr' => 'Assurance Standard',
                'description_en' => 'Includes accident coverage and theft protection. Deposit required.',
                'description_it' => 'Include copertura incidenti e protezione contro il furto. Deposito richiesto.',
                'description_al' => 'Përfshin mbulim aksidentesh dhe mbrojtje nga vjedhja. Kërkohet depozitë.',
                'description_es' => 'Incluye cobertura de accidentes y protección contra robo. Se requiere depósito.',
                'description_de' => 'Beinhaltet Unfall- und Diebstahlschutz. Kaution erforderlich.',
                'description_fr' => 'Inclut la couverture des accidents et la protection contre le vol. Dépôt requis.',
                'price_per_day' => 10.00,
                'has_theft_protection' => true,
                'has_deposit' => true,
                'deposit_price' => 200.00,
                'theft_protection_price' => 3.00,
            ],
            [
                'company_id' => 1,
                'title_en' => 'Premium Insurance',
                'title_it' => 'Assicurazione Premium',
                'title_al' => 'Sigurimi Premium',
                'title_es' => 'Seguro Premium',
                'title_de' => 'Premium-Versicherung',
                'title_fr' => 'Assurance Premium',
                'description_en' => 'Full coverage with no deposit required. Theft protection included.',
                'description_it' => 'Copertura completa senza deposito richiesto. Protezione furto inclusa.',
                'description_al' => 'Mbulim i plotë pa kërkesë për depozitë. Mbrojtje nga vjedhja e përfshirë.',
                'description_es' => 'Cobertura completa sin depósito requerido. Protección contra robo incluida.',
                'description_de' => 'Vollständiger Schutz ohne Kaution. Diebstahlschutz inklusive.',
                'description_fr' => 'Couverture complète sans dépôt requis. Protection contre le vol incluse.',
                'price_per_day' => 18.50,
                'has_theft_protection' => true,
                'has_deposit' => false,
                'deposit_price' => null,
                'theft_protection_price' => 0.00,
            ],
            [
                'company_id' => 2,
                'title_en' => 'Young Driver Insurance',
                'title_it' => 'Assicurazione Giovani Conducenti',
                'title_al' => 'Sigurimi për Shoferët e Rinj',
                'title_es' => 'Seguro para Conductores Jóvenes',
                'title_de' => 'Versicherung für junge Fahrer',
                'title_fr' => 'Assurance Jeune Conducteur',
                'description_en' => 'Provides insurance for drivers under 25. Includes accident and limited theft coverage.',
                'description_it' => 'Fornisce assicurazione per conducenti sotto i 25 anni. Include incidenti e copertura limitata contro il furto.',
                'description_al' => 'Siguron shoferët nën moshën 25 vjeç. Përfshin aksidentet dhe mbrojtje të kufizuar nga vjedhja.',
                'description_es' => 'Proporciona seguro para conductores menores de 25 años. Incluye accidentes y cobertura limitada contra robo.',
                'description_de' => 'Versicherung für Fahrer unter 25 Jahren. Beinhaltet Unfallschutz und eingeschränkten Diebstahlschutz.',
                'description_fr' => 'Couvre les conducteurs de moins de 25 ans. Inclut les accidents et une protection contre le vol limitée.',
                'price_per_day' => 8.00,
                'has_theft_protection' => true,
                'has_deposit' => true,
                'deposit_price' => 400.00,
                'theft_protection_price' => 2.00,
            ],
            [
                'company_id' => 1,
                'title_en' => 'Weekend Protection Plan',
                'title_it' => 'Piano di Protezione Weekend',
                'title_al' => 'Plani i Mbrojtjes për Fundjavë',
                'title_es' => 'Plan de Protección de Fin de Semana',
                'title_de' => 'Wochenendschutzplan',
                'title_fr' => 'Plan de Protection Weekend',
                'description_en' => 'Short-term plan ideal for weekend trips. Includes basic damage and theft protection.',
                'description_it' => 'Piano a breve termine ideale per i viaggi del weekend. Include danni e protezione furto di base.',
                'description_al' => 'Plan afatshkurtër për udhëtime në fundjavë. Përfshin dëme dhe mbrojtje bazë nga vjedhja.',
                'description_es' => 'Plan a corto plazo ideal para viajes de fin de semana. Incluye daños y protección contra robo básica.',
                'description_de' => 'Kurzzeitplan für Wochenendausflüge. Beinhaltet Basis-Unfallschutz und Diebstahlschutz.',
                'description_fr' => 'Plan court terme idéal pour les escapades du week-end. Inclut les dommages de base et la protection contre le vol.',
                'price_per_day' => 6.50,
                'has_theft_protection' => true,
                'has_deposit' => false,
                'deposit_price' => null,
                'theft_protection_price' => 1.50,
            ],

        ];

        foreach ($insurances as $insurance) {
            Insurance::create($insurance);
        }
    }
}
