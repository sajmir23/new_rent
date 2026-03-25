<?php

namespace Database\Seeders;

use App\Models\Admin\PaymentStatus;
use App\Models\Admin\Vehicle_statuses;
use App\Models\Admin\VehicleStatus;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionsTableSeeder::class,
            CompanyPermissionTableSeeder::class,
            RolesTableSeeder::class,
            CitiesTableSeeder::class,
            CompaniesTableSeeder::class,
            UsersTableSeeder::class,
            BookingStatusesTableSeeder::class,
            VehiclesCategoriesTableSeeder::class,
            TransmissionTypesTableSeeder::class,
            FeaturesTableSeeder::class,
            FuelTypesTableSeeder::class,
            BrandsTableSeeder::class,
            VehicleModelTableSeeder::class,
            CancellationReasonsTableSeeder::class,
            VehicleStatusesTableSeeder::class,
            PaymentStatusesTableSeeder::class,
            InsurancesTableSeeder::class,
            AdditionalServiceTableSeeder::class,
            DeliveriesTableSeeder::class,
            VehicleTableSeeder::class,
            BookingsTableSeeder::class,
            TariffsTableSeeder::class,
            SeasonalPricesTableSeeder::class,
        ]);
    }
}