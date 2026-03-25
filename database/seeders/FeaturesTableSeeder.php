<?php

namespace Database\Seeders;

use App\Models\Admin\BookingStatus;
use App\Models\Admin\Feature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeaturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            ['title'  => 'Child Seat', 'slug'   => 'child_seat', 'status' => true,],
            ['title'  => 'GPS', 'slug'   => 'gps', 'status' => true,],
            ['title'  => 'Air Conditioning', 'slug'   => 'air_conditioning', 'status' => true,],
            ['title'  => 'Bike Rack', 'slug'   => 'bike_rack', 'status' => true,],
            ['title'  => 'Roof Box', 'slug'   => 'roof_box', 'status' => true,],
            ['title'  => 'Snow Tires', 'slug'   => 'snow_tires', 'status' => true,],
            ['title'  => 'Snow Chains', 'slug'   => 'snow_chains', 'status' => true,],
            ['title'  => 'Four Wheels Drive', 'slug'   => 'four_wheels_drive', 'status' => true,],
            ['title'  => 'Apple CarPlay', 'slug'   => 'apple_carplay', 'status' => true,],
            ['title'  => 'Android Auto', 'slug'   => 'android_auto', 'status' => true,],
            ['title'  => 'Aux Input', 'slug'   => 'aux_input', 'status' => true,],
            ['title'  => 'Backup Camera', 'slug'   => 'backup_camera', 'status' => true,],
            ['title'  => 'Blind Spot Warning', 'slug'   => 'blind_spot_warning', 'status' => true,],
            ['title'  => 'Bluetooth', 'slug'   => 'bluetooth', 'status' => true,],
            ['title'  => 'Heated Seats', 'slug'   => 'heated_seats', 'status' => true,],
            ['title'  => 'Pet Friendly', 'slug'   => 'pet_friendly', 'status' => true,],
            ['title'  => 'Keyless Entry', 'slug'   => 'keyless_entry', 'status' => true,],
            ['title'  => 'USB Charger', 'slug'   => 'usb_charger', 'status' => true,],

        ];

        foreach ($features as $feature) {
            Feature::create($feature);
        }
    }
}
