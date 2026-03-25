<?php

namespace Database\Seeders;

use App\Enums\UserTypesEnum;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('companies')->insert([
            'name'       => 'Local Rent Company',
            'email'      => 'localrent@test.com',
            'phone'      => '0121212222',
            'address'    => 'test address',
            'booking_fee_percentage'=>20,
            'city_id'    => 1,
            'status'     => true,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);

        DB::table('companies')->insert([
            'name'       => 'Rent Now',
            'email'      => 'rentnow@test.com',
            'phone'      => '01212122265',
            'address'    => 'test address',
            'city_id'    => 2,
            'status'     => true,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);
    }
}
