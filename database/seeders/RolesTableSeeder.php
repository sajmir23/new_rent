<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            'title'             => 'System Admin',
            'description'       => 'System Admin',
            'notes'             => 'System Admin Role',
            'scope'             => 'system',
            'status'            => 1,
            'text_color'        => '#ffffff',
            'background_color'  => '#eb3446',
            'created_at'        => Carbon::now()->toDateTimeString(),
            'updated_at'        => Carbon::now()->toDateTimeString(),
        ]);

        DB::table('roles')->insert([
            'title'             => 'Company Admin',
            'description'       => 'Company Admin',
            'notes'             => 'Company Admin Role',
            'scope'             => 'company',
            'status'            => 1,
            'text_color'        => '#ffffff',
            'background_color'  => '#eb3446',
            'created_at'        => Carbon::now()->toDateTimeString(),
            'updated_at'        => Carbon::now()->toDateTimeString(),
        ]);

        DB::table('roles')->insert([
            'title'             => 'Staff',
            'description'       => 'Staff',
            'notes'             => 'Staff Role',
            'scope'             => 'company',
            'status'            => 1,
            'text_color'        => '#ffffff',
            'background_color'  => '#eb3446',
            'created_at'        => Carbon::now()->toDateTimeString(),
            'updated_at'        => Carbon::now()->toDateTimeString(),
        ]);

        $permissions_system = DB::table('permissions')
            ->where('scope', 'system')
            ->get();

        $permissions_company = DB::table('permissions')
            ->where('scope', 'company')
            ->get();

        foreach ($permissions_system as $permission){

            DB::table('permission_role')->insert([
                'permission_id'    => $permission->id,
                'role_id'          => 1,
                'created_at'       => Carbon::now()->toDateTimeString(),
                'updated_at'       => Carbon::now()->toDateTimeString(),
            ]);

        }
        foreach ($permissions_company as $permission){

            DB::table('permission_role')->insert([
                'permission_id'    => $permission->id,
                'role_id'          => 2,
                'created_at'       => Carbon::now()->toDateTimeString(),
                'updated_at'       => Carbon::now()->toDateTimeString(),
            ]);

            DB::table('permission_role')->insert([
                'permission_id'    => $permission->id,
                'role_id'          => 3,
                'created_at'       => Carbon::now()->toDateTimeString(),
                'updated_at'       => Carbon::now()->toDateTimeString(),
            ]);


        }
    }
}
