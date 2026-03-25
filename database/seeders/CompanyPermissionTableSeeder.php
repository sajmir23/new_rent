<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions_array = [

            //roles
            ['name'=>'View Company Roles','slug'   => 'roles.company.view_any','description' => 'Check if this user can view roles list','scope' => 'company'],
            ['name'=>'Create Company Roles','slug' => 'roles.company.store','description' => 'Check if this user can store a new role','scope' => 'company'],
            ['name'=>'Update Company Roles','slug' => 'roles.company.update','description' => 'Check if this user can update a role','scope' => 'company'],
            ['name'=>'Delete Company Roles','slug' => 'roles.company.delete','description' => 'Check if this user can update roles','scope' => 'company'] ,
            ['name'=>'Manage Company Role Permissions','slug' => 'roles.company.manage_permissions','description' => 'Check if this user manage permissions for a role','scope' => 'company'] ,

            //permissions
            ['name'=>'View Company Permissions','slug'     => 'permissions.company.view_any','description' => 'Check if this user can view permissions list','scope' => 'company'],
            ['name'=>'Create Company Permissions','slug'   => 'permissions.company.store','description'    => 'Check if this user can create new permission','scope' => 'company'],

            ['name'=>'View Company Vehicle Categories','slug'   => 'vehicle_categories.company.view_any','description' => 'Check if this user can view vehicle categories list','scope' => 'company'],

            ['name'=>'View Company Transmission Types','slug'   => 'transmission_types.company.view_any','description' => 'Check if this user can view transmission types list','scope' => 'company'],

            ['name'=>'View Company Features','slug'   => 'features.company.view_any','description' => 'Check if this user can view features list','scope' => 'company'],

            ['name'=>'View Company Fuel Types','slug'   => 'fuel_types.company.view_any','description' => 'Check if this user can view fuel types','scope' => 'company'],

            ['name'=>'View Company Brands','slug'   => 'brands.company.view_any','description' => 'Check if this user can view brands','scope' => 'company'],

            ['name'=>'View Company Models','slug'   => 'models.company.view_any','description' => 'Check if this user can view models','scope' => 'company'],

            ['name'=>'View Company Promo Codes','slug'   => 'promo_codes.company.view_any','description' => 'Check if this user can view promo codes','scope' => 'company'],

            ['name'=>'View Company Cancellation Reasons','slug'   => 'cancellation_reasons.company.view_any','description' => 'Check if this user can view cancellation reasons','scope' => 'company'],

            //company_details
            ['name'=>'View Company Details','slug'   => 'company_details.view_any','description' => 'Check if this user can view Company Details','scope' => 'company'],
            ['name'=>'Update Company Details','slug' => 'company_details.update','description' => 'Check if this user can update Company Details','scope' => 'company'],

            //vehicles
            ['name'=>'View Vehicles','slug'   => 'vehicles.view_any','description' => 'Check if this user can view vehicles list','scope' => 'company'],
            ['name'=>'Create Vehicles','slug' => 'vehicles.store','description' => 'Check if this user can store a new vehicles','scope' => 'company'],
            ['name'=>'Update Vehicles','slug' => 'vehicles.update','description' => 'Check if this user can update a vehicles','scope' => 'company'],
            ['name'=>'Delete Vehicles','slug' => 'vehicles.delete','description' => 'Check if this user can delete vehicles','scope' => 'company'] ,
            ['name'=>'Add Vehicle Requirements','slug' => 'vehicles.add_requirements','description' => 'Check if this user can add vehicle requirements','scope' => 'company'] ,
            ['name'=>'Add Vehicle Insurances','slug' => 'vehicles.add_insurances','description' => 'Check if this user can add vehicle insurances','scope' => 'company'] ,
            ['name'=>'Add Vehicle Additional Services','slug' => 'vehicles.add_additional_services','description' => 'Check if this user can add vehicle additional services','scope' => 'company'] ,
            ['name'=>'Save Vehicle Feature','slug' => 'vehicles.save_vehicle_feature','description' => 'Check if this user can change vehicle feature','scope' => 'company'] ,

            //staff
            ['name'=>'View Company Staff','slug'   => 'company.staff.view_any','description' => 'Check if this user can view staff list','scope' => 'company'],
            ['name'=>'Create Company Staff','slug' => 'company.staff.store','description' => 'Check if this user can store a new staff','scope' => 'company'],
            ['name'=>'Update Company Staff','slug' => 'company.staff.update','description' => 'Check if this user can update staff','scope' => 'company'],
            ['name'=>'Delete Company Staff','slug' => 'company.staff.delete','description' => 'Check if this user can delete staff','scope' => 'company'] ,

            ['name'=>'Update Company Data','slug' => 'company.data.update','description' => 'Check if this user can update company data','scope' => 'company'],
            ['name'=>'View Company Data','slug' => 'company.data.view_any','description' => 'Check if this user can view any company data','scope' => 'company'],

            ['name'=>'Import Images','slug' => 'images.import','description' => 'Check if this user can import images','scope' => 'company'] ,
            ['name'=>'Delete Images','slug' => 'images.delete','description' => 'Check if this user can delete images','scope' => 'company'] ,

            //insurances
            ['name'=>'View Insurance','slug'   => 'insurances.view_any','description' => 'Check if this user can view insurances','scope' => 'company'],
            ['name'=>'Create Insurance','slug' => 'insurances.store','description' => 'Check if this user can store a new insurance','scope' => 'company'],
            ['name'=>'Update Insurance','slug' => 'insurances.update','description' => 'Check if this user can update insurance','scope' => 'company'],
            ['name'=>'Delete Insurance','slug' => 'insurances.delete','description' => 'Check if this user can delete insurance','scope' => 'company'] ,

            //additional_services
            ['name'=>'View Additional Services','slug'   => 'additional_services.view_any','description' => 'Check if this user can view additional services','scope' => 'company'],
            ['name'=>'Create Additional Service','slug' => 'additional_services.store','description' => 'Check if this user can store a new additional service','scope' => 'company'],
            ['name'=>'Update Additional Service','slug' => 'additional_services.update','description' => 'Check if this user can update additional service','scope' => 'company'],
            ['name'=>'Delete Additional Service','slug' => 'additional_services.delete','description' => 'Check if this user can delete additional service','scope' => 'company'] ,


            //seasonal_prices
            ['name'=>'View Seasonal Prices','slug'   => 'seasonal_prices.view_any','description' => 'Check if this user can view seasonal prices list','scope' => 'company'],
            ['name'=>'Create Seasonal Prices','slug' => 'seasonal_prices.store','description' => 'Check if this user can store a new seasonal prices','scope' => 'company'],
            ['name'=>'Update Seasonal Prices','slug' => 'seasonal_prices.update','description' => 'Check if this user can update a seasonal prices','scope' => 'company'],
            ['name'=>'Delete Seasonal Prices','slug' => 'seasonal_prices.delete','description' => 'Check if this user can delete seasonal prices','scope' => 'company'] ,

            //tariffs
            ['name'=>'View Tariffs','slug'   => 'tariffs.view_any','description' => 'Check if this user can view tariffs list','scope' => 'company'],
            ['name'=>'Create Tariffs','slug' => 'tariffs.store','description' => 'Check if this user can store a new tariffs','scope' => 'company'],
            ['name'=>'Update Tariffs','slug' => 'tariffs.update','description' => 'Check if this user can update a tariff','scope' => 'company'],
            ['name'=>'Delete Tariff','slug' => 'tariffs.delete','description' => 'Check if this user can delete tariffs','scope' => 'company'] ,

            //deliveries
            ['name'=>'View Deliveries','slug'   => 'deliveries.view_any','description' => 'Check if this user can view deliveries list','scope' => 'company'],
            ['name'=>'Create Deliveries','slug' => 'deliveries.store','description' => 'Check if this user can store a new deliveries','scope' => 'company'],
            ['name'=>'Update Deliveries','slug' => 'deliveries.update','description' => 'Check if this user can update a deliveries','scope' => 'company'],
            ['name'=>'Delete Deliveries','slug' => 'deliveries.delete','description' => 'Check if this user can delete deliveries','scope' => 'company'] ,

            //bookings
            ['name'=>'View Bookings','slug'   => 'bookings.view_any','description' => 'Check if this user can view bookings list','scope' => 'company'],
            ['name'=>'Create Bookings','slug' => 'bookings.store','description' => 'Check if this user can store a new bookings','scope' => 'company'],
            ['name'=>'Cancel Booking','slug' => 'bookings.cancel','description' => 'Check if this user can cancel a booking','scope' => 'company'],

        ];


        foreach ($permissions_array as $permission){
            DB::table('permissions')->updateOrInsert([
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
