<?php

namespace Database\Seeders;

use App\Models\Company\AdditionalService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdditionalServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'company_id' => 1,
                'title_en' => 'Child Safety Seat',
                'title_it' => 'Seggiolino per Bambini',
                'title_al' => 'Ulëse për Fëmijë',
                'title_es' => 'Asiento de Seguridad Infantil',
                'title_de' => 'Kindersitz',
                'title_fr' => 'Siège Auto pour Enfant',
                'description_en' => 'A secure car seat for children aged 1–6. Mandatory in most countries.',
                'description_it' => 'Un seggiolino auto sicuro per bambini da 1 a 6 anni. Obbligatorio in molti paesi.',
                'description_al' => 'Ulëse e sigurtë për fëmijë nga mosha 1 deri në 6 vjeç. E detyrueshme në shumicën e vendeve.',
                'description_es' => 'Asiento seguro para niños de 1 a 6 años. Obligatorio en la mayoría de los países.',
                'description_de' => 'Ein sicherer Kindersitz für Kinder im Alter von 1–6 Jahren. In vielen Ländern vorgeschrieben.',
                'description_fr' => 'Siège auto sécurisé pour enfants de 1 à 6 ans. Obligatoire dans de nombreux pays.',
                'service_price' => 5.00,
                'status' => true,
            ],
            [
                'company_id' => 2,
                'title_en' => 'Second Driver',
                'title_it' => 'Secondo Conducente',
                'title_al' => 'Shofer i Dytë',
                'title_es' => 'Segundo Conductor',
                'title_de' => 'Zweiter Fahrer',
                'title_fr' => 'Deuxième Conducteur',
                'description_en' => 'Add a second authorized driver to the rental agreement.',
                'description_it' => 'Aggiungi un secondo conducente autorizzato al contratto di noleggio.',
                'description_al' => 'Shto një shofer të dytë të autorizuar në marrëveshjen e qirasë.',
                'description_es' => 'Agrega un segundo conductor autorizado al contrato de alquiler.',
                'description_de' => 'Fügen Sie dem Mietvertrag einen zweiten autorisierten Fahrer hinzu.',
                'description_fr' => 'Ajoutez un deuxième conducteur autorisé au contrat de location.',
                'service_price' => 7.50,
                'status' => true,
            ],
            [
                'company_id' => 1,
                'title_en' => 'GPS Navigation',
                'title_it' => 'Navigatore GPS',
                'title_al' => 'GPS Navigimi',
                'title_es' => 'Navegación GPS',
                'title_de' => 'GPS-Navigation',
                'title_fr' => 'Navigation GPS',
                'description_en' => 'Pre-installed GPS unit with offline maps for stress-free driving.',
                'description_it' => 'Unità GPS preinstallata con mappe offline per una guida senza stress.',
                'description_al' => 'Njësi GPS e instaluar me harta offline për një udhëtim të qetë.',
                'description_es' => 'Unidad GPS preinstalada con mapas offline para conducir sin estrés.',
                'description_de' => 'Vorinstallierte GPS-Einheit mit Offline-Karten für stressfreies Fahren.',
                'description_fr' => 'GPS préinstallé avec cartes hors ligne pour une conduite sans stress.',
                'service_price' => 6.00,
                'status' => true,
            ],
            [
                'company_id' => 2,
                'title_en' => 'Wi-Fi Router',
                'title_it' => 'Router Wi-Fi',
                'title_al' => 'Router Wi-Fi',
                'title_es' => 'Router Wi-Fi',
                'title_de' => 'WLAN-Router',
                'title_fr' => 'Routeur Wi-Fi',
                'description_en' => 'Portable 4G router with unlimited data within the country.',
                'description_it' => 'Router 4G portatile con dati illimitati nel paese.',
                'description_al' => 'Router portativ 4G me internet të pakufizuar brenda vendit.',
                'description_es' => 'Router 4G portátil con datos ilimitados dentro del país.',
                'description_de' => 'Mobiler 4G-Router mit unbegrenztem Datenvolumen im Land.',
                'description_fr' => 'Routeur 4G portable avec données illimitées dans le pays.',
                'service_price' => 8.00,
                'status' => true,
            ],
            [
                'company_id' => 1,
                'title_en' => 'Snow Chains',
                'title_it' => 'Catene da Neve',
                'title_al' => 'Zinxhirë Bore',
                'title_es' => 'Cadenas para Nieve',
                'title_de' => 'Schneeketten',
                'title_fr' => 'Chaînes à Neige',
                'description_en' => 'Essential for mountain roads during winter season.',
                'description_it' => 'Essenziali per le strade di montagna durante l’inverno.',
                'description_al' => 'Thelbësore për rrugët malore në sezonin e dimrit.',
                'description_es' => 'Esenciales para carreteras de montaña en invierno.',
                'description_de' => 'Unverzichtbar für Bergstraßen im Winter.',
                'description_fr' => 'Indispensables pour les routes de montagne en hiver.',
                'service_price' => 4.00,
                'status' => true,
            ],
            [
                'company_id' => 2,
                'title_en' => 'Fuel Prepayment',
                'title_it' => 'Prepagamento Carburante',
                'title_al' => 'Parapagim i Karburantit',
                'title_es' => 'Prepago de Combustible',
                'title_de' => 'Kraftstoff-Vorauszahlung',
                'title_fr' => 'Prépaiement du Carburant',
                'description_en' => 'Pay in advance and return the car with any fuel level.',
                'description_it' => 'Paga in anticipo e restituisci l’auto con qualsiasi livello di carburante.',
                'description_al' => 'Paguaj paraprakisht dhe kthe makinën me çdo nivel karburanti.',
                'description_es' => 'Paga por adelantado y devuelve el coche con cualquier nivel de combustible.',
                'description_de' => 'Zahlen Sie im Voraus und geben Sie das Auto mit beliebigem Tankstand zurück.',
                'description_fr' => 'Payez d’avance et retournez la voiture avec le niveau de carburant de votre choix.',
                'service_price' => 30.00,
                'status' => true,
            ],
        ];

        foreach ($services as $service) {
            AdditionalService::create($service);
        }
    }
}
