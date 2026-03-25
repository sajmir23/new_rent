<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions_array = [

            //roles
            ['name'=>'View Roles','slug'   => 'roles.view_any','description' => 'Check if this user can view roles list','scope' => 'system'],
            ['name'=>'Create Roles','slug' => 'roles.store','description' => 'Check if this user can store a new role','scope' => 'system'],
            ['name'=>'Update Roles','slug' => 'roles.update','description' => 'Check if this user can update a role','scope' => 'system'],
            ['name'=>'Delete Roles','slug' => 'roles.delete','description' => 'Check if this user can update roles','scope' => 'system'] ,
            ['name'=>'Manage Role Permissions','slug' => 'roles.manage_permissions','description' => 'Check if this user manage permissions for a role','scope' => 'system'] ,

            //permissions
            ['name'=>'View Permissions','slug'     => 'permissions.view_any','description' => 'Check if this user can view permissions list','scope' => 'system'],
            ['name'=>'Create Permissions','slug'   => 'permissions.store','description'    => 'Check if this user can create new permission','scope' => 'system'],

            //impersonation
            ['name'=>'Can Impersonate','slug'     => 'impersonation.can_impersonate','description' => 'Check if this user can impersonate users','scope' => 'system'],
            ['name'=>'Can Be Impersonated ','slug'   => 'impersonation.can_be_impersonated','description'    => 'Check if this user can be impersonated','scope' => 'system'],

            //general
            ['name'=>'View Login History','slug'   => 'general.view_login_history','description' => 'Check if this user can view login history list','scope' => 'system'],
            ['name'=>'View Activity Log','slug'    => 'general.view_activity_log','description' => 'Check if this user can view activity log list','scope' => 'system'],
            ['name'=>'View Forbidden Log','slug'   => 'general.view_forbidden_log','description' => 'Check if this user can view forbidden log list','scope' => 'system'],
            ['name'=>'View Dashboard','slug'       => 'general.dashboard','description' => 'Check if this user can view dashboard','scope' => 'system'],

            //users
            ['name'=>'View Users','slug'   => 'users.view_any','description' => 'Check if this user can view users list','scope' => 'system'],
            ['name'=>'Create Users','slug' => 'users.store','description' => 'Check if this user can store a new user','scope' => 'system'],
            ['name'=>'Update Users','slug' => 'users.update','description' => 'Check if this user can update a user','scope' => 'system'],
            ['name'=>'Delete Users','slug' => 'users.delete','description' => 'Check if this user can update users','scope' => 'system'] ,

            //vehicles_categories
            ['name'=>'View Vehicle Categories','slug'   => 'vehicle_categories.view_any','description' => 'Check if this user can view vehicle categories list','scope' => 'system'],
            ['name'=>'Create Vehicle Category','slug' => 'vehicle_categories.store','description' => 'Check if this user can store a new vehicle category','scope' => 'system'],
            ['name'=>'Update Vehicle Category','slug' => 'vehicle_categories.update','description' => 'Check if this user can update a vehicle category','scope' => 'system'],
            ['name'=>'Delete Vehicle Category','slug' => 'vehicle_categories.delete','description' => 'Check if this user can update vehicle category','scope' => 'system'] ,

            //transmission_types
            ['name'=>'View Transmission Types','slug'   => 'transmission_types.view_any','description' => 'Check if this user can view transmission types list','scope' => 'system'],
            ['name'=>'Create Transmission Type','slug' => 'transmission_types.store','description' => 'Check if this user can store a new transmission type','scope' => 'system'],
            ['name'=>'Update Transmission Type','slug' => 'transmission_types.update','description' => 'Check if this user can update a transmission type','scope' => 'system'],
            ['name'=>'Delete Transmission Type','slug' => 'transmission_types.delete','description' => 'Check if this user can update transmission type','scope' => 'system'] ,

            //features
            ['name'=>'View Features','slug'   => 'features.view_any','description' => 'Check if this user can view features list','scope' => 'system'],
            ['name'=>'Create Feature','slug' => 'features.store','description' => 'Check if this user can store a new feature','scope' => 'system'],
            ['name'=>'Update Feature','slug' => 'features.update','description' => 'Check if this user can update a feature','scope' => 'system'],
            ['name'=>'Delete Feature','slug' => 'features.delete','description' => 'Check if this user can update feature','scope' => 'system'] ,

            //fuel_types
            ['name'=>'View FuelTypes','slug'   => 'fuel_types.view_any','description' => 'Check if this user can view fuel types list','scope' => 'system'],
            ['name'=>'Create FuelTypes','slug' => 'fuel_types.store','description' => 'Check if this user can store a fuel type','scope' => 'system'],
            ['name'=>'Update FuelTypes','slug' => 'fuel_types.update','description' => 'Check if this user can update a fuel type','scope' => 'system'],
            ['name'=>'Delete FuelTypes','slug' => 'fuel_types.delete','description' => 'Check if this user can update fuel type','scope' => 'system'] ,

            //brands
            ['name'=>'View Brands','slug'   => 'brands.view_any','description' => 'Check if this user can view brands list','scope' => 'system'],
            ['name'=>'Create Brand','slug' => 'brands.store','description' => 'Check if this user can store a new brands','scope' => 'system'],
            ['name'=>'Update Brand','slug' => 'brands.update','description' => 'Check if this user can update a brand','scope' => 'system'],
            ['name'=>'Delete Brand','slug' => 'brands.delete','description' => 'Check if this user can update brand','scope' => 'system'] ,

            //models
            ['name'=>'View Models','slug'   => 'models.view_any','description' => 'Check if this user can view models list','scope' => 'system'],
            ['name'=>'Create Model','slug' => 'models.store','description' => 'Check if this user can store a new model','scope' => 'system'],
            ['name'=>'Update Model','slug' => 'models.update','description' => 'Check if this user can update a model','scope' => 'system'],
            ['name'=>'Delete Model','slug' => 'models.delete','description' => 'Check if this user can update model','scope' => 'system'] ,


            //companies
            ['name'=>'View Companies','slug'   => 'companies.view_any','description' => 'Check if this user can view companies list','scope' => 'system'],
            ['name'=>'Create Company','slug' => 'companies.store','description' => 'Check if this user can store a new company','scope' => 'system'],
            ['name'=>'Update Company','slug' => 'companies.update','description' => 'Check if this user can update a company','scope' => 'system'],
            ['name'=>'Delete Company','slug' => 'companies.delete','description' => 'Check if this user can update company','scope' => 'system'] ,

            //staff
            ['name'=>'View Staff','slug'   => 'staff.view_any','description' => 'Check if this user can view staff list','scope' => 'system'],
            ['name'=>'Create Staff','slug' => 'staff.store','description' => 'Check if this user can store a new staff','scope' => 'system'],
            ['name'=>'Update Staff','slug' => 'staff.update','description' => 'Check if this user can update a staff','scope' => 'system'],
            ['name'=>'Delete Staff','slug' => 'staff.delete','description' => 'Check if this user can update staff','scope' => 'system'] ,

            //company_admin
            ['name'=>'View CompanyAdmin','slug'   => 'company_admin.view_any','description' => 'Check if this user can view company admin list','scope' => 'system'],
            ['name'=>'Create CompanyAdmin','slug' => 'company_admin.store','description' => 'Check if this user can store a new company admin','scope' => 'system'],
            ['name'=>'Update CompanyAdmin','slug' => 'company_admin.update','description' => 'Check if this user can update a company admin','scope' => 'system'],
            ['name'=>'Delete CompanyAdmin','slug' => 'company_admin.delete','description' => 'Check if this user can update company admin','scope' => 'system'] ,

            //cancellation_reasons
            ['name'=>'View CancellationReasons','slug'   => 'cancellation_reasons.view_any','description' => 'Check if this user can view cancellation reasons list','scope' => 'system'],
            ['name'=>'Create CancellationReasons','slug' => 'cancellation_reasons.store','description' => 'Check if this user can store a new cancellation reason','scope' => 'system'],
            ['name'=>'Update CancellationReasons','slug' => 'cancellation_reasons.update','description' => 'Check if this user can update a cancellation reason','scope' => 'system'],
            ['name'=>'Delete CancellationReasons','slug' => 'cancellation_reasons.delete','description' => 'Check if this user can update cancellation reason','scope' => 'system'] ,

            //city

            ['name'=>'View all cities','slug'   => 'city.view_any','description' => 'Check if this user can view cities list','scope' => 'system'],


        ];


        foreach ($permissions_array as $permission){
            DB::table('permissions')->insert([
                'name'        => $permission['name'],
                'slug'        => $permission['slug'],
                'description' => $permission['description'],
                'scope'       => $permission['scope'],
                'created_at'  => Carbon::now()->toDateTimeString(),
                'updated_at'  => Carbon::now()->toDateTimeString(),
            ]);
        }
    }
}
