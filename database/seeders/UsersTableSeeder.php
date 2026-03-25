<?php

namespace Database\Seeders;

use App\Enums\UserTypesEnum;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //system users
        DB::table('users')->insert([
            'first_name' => 'Developer',
            'last_name'  => 'Developer',
            'email'      => 'developer@developer.com',
            'role_id'    => 1, //1->system admin
            'user_type'    => UserTypesEnum::SYSTEM_ADMIN,
            'password'   => Hash::make('password'),
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);

        DB::table('users')->insert([
            'first_name'    => 'First',
            'last_name'     => 'Company',
            'email'         => 'firstcompany@localrent.com',
            'company_id'    => 1,
            'role_id'       => 2, //1->company_admin
            'user_type'     => UserTypesEnum::COMPANY_ADMIN,
            'password'      => Hash::make('password'),
            'created_at'    => Carbon::now()->toDateTimeString(),
            'updated_at'    => Carbon::now()->toDateTimeString(),
        ]);

        DB::table('users')->insert([
            'first_name'    => 'second',
            'last_name'     => 'Company',
            'email'         => 'secondcompany@rentnow.com',
            'company_id'    => 2,
            'role_id'       => 2, //1->company_admin
            'user_type'     => UserTypesEnum::COMPANY_ADMIN,
            'password'      => Hash::make('password'),
            'created_at'    => Carbon::now()->toDateTimeString(),
            'updated_at'    => Carbon::now()->toDateTimeString(),
        ]);

        DB::table('users')->insert([
            'first_name'    => 'Staff',
            'last_name'     => 'company1',
            'email'         => 'staffcompany1@localrent.com',
            'company_id'    => 1,
            'role_id'       => 3, //1->staff
            'user_type'     => UserTypesEnum::STAFF,
            'phone_number' => '+1 (394) 684-4596',
            'password'      => Hash::make('password'),
            'created_at'    => Carbon::now()->toDateTimeString(),
            'updated_at'    => Carbon::now()->toDateTimeString(),
        ]);

        DB::table('users')->insert([
            'first_name'    => 'Staff',
            'last_name'     => 'company2',
            'email'         => 'staffcompany2@rentnow.com',
            'company_id'    => 2,
            'role_id'       => 3, //1->staff
            'user_type'     => UserTypesEnum::STAFF,
            'phone_number'  => '+1 (128) 341-4192',
            'password'      => Hash::make('password'),
            'created_at'    => Carbon::now()->toDateTimeString(),
            'updated_at'    => Carbon::now()->toDateTimeString(),
        ]);

        DB::table('users')->insert([
            'first_name'    => 'Staff2',
            'last_name'     => 'Company1',
            'email'         => 'staff2company1@localrent.com',
            'company_id'    => 1,
            'role_id'       => 3, //1->staff
            'user_type'     => UserTypesEnum::STAFF,
            'phone_number'  => '+1 (128) 341-4192',
            'password'      => Hash::make('password'),
            'created_at'    => Carbon::now()->toDateTimeString(),
            'updated_at'    => Carbon::now()->toDateTimeString(),
        ]);
    }
}
