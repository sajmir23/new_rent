<?php

namespace Database\Seeders;

use App\Models\Admin\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\table;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities=[
            ['name' => 'Tirana'],
            ['name' => 'Kamez'],
            ['name' => 'Kavaje'],

            ['name' => 'Durres'],
            ['name' => 'Shijak'],

            ['name' => 'Shkoder'],
            ['name' => 'Vau i Dejes'],
            ['name' => 'Fushe-Arrez'],
            ['name' => 'Puke'],

            ['name' => 'Vlore'],
            ['name' => 'Sarande'],
            ['name' => 'Himare'],
            ['name' => 'Delvine'],
            ['name' => 'Selenice'],

            ['name' => 'Elbasan'],
            ['name' => 'Gramsh',],
            ['name' => 'Librazhd'],
            ['name' => 'Peqin'],
            ['name' => 'Belsh'],
            ['name' => 'Cerrik'],

            ['name' => 'Fier'],
            ['name' => 'Lushnje'],
            ['name' => 'Patos'],
            ['name' => 'Roskovec'],
            ['name' => 'Divjake'],
            ['name' => 'Ballsh'],

            ['name' => 'Korçe',],
            ['name' => 'Pogradec'],
            ['name' => 'Maliq'],
            ['name' => 'Erseke'],
            ['name' => 'Bilisht'],

            ['name' => 'Berat'],
            ['name' => 'Kuçove'],
            ['name' => 'Çorovode'],
            ['name' => 'Poliçan'],
            ['name' => 'Ura Vajgurore'],

            ['name' => 'Lezhe'],
            ['name' => 'Laç'],
            ['name' => 'Rreshen'],

            ['name' => 'Kukes'],
            ['name' => 'Krume'],
            ['name' => 'Bajram Curri'],

            ['name' => 'Peshkopi'],
            ['name' => 'Bulqize'],
            ['name' => 'Burrel'],
            ['name' => 'Klos'],

            ['name' => 'Gjirokaster'],
            ['name' => 'Tepelene'],
            ['name' => 'Permet'],
            ['name' => 'Kelcyre'],
            ['name' => 'Memaliaj'],
            ['name' => 'Jorgucat'],

            ['name' => 'Tirana International Airport'],
        ];

        DB::table('cities')->insert($cities);
    }
}
