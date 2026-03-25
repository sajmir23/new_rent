<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Admin\Brand;
use App\Models\Admin\City;
use App\Models\Admin\VehicleCategory;
use App\Models\Company\VehicleModel;

class ReferenceDataController extends Controller
{
    public function index()
    {
        return response()->json([
            'cities' => City::select('id','name')
                ->orderBy('id')
                ->get(),

            'brands' => Brand::select('id', 'title', 'icon')
                ->where('status', true)
                ->orderBy('title')
                ->get(),

            'vehicle_models' => VehicleModel::select('id', 'title', 'brand_id')
                ->with('brands:id,title')
                ->where('status', true)
                ->orderBy('title')
                ->get(),

            'categories' => VehicleCategory::select(
                'id',
                'title_en', 'title_it', 'title_al', 'title_es', 'title_fr', 'title_de'
            )
                ->where('status', true)
                ->orderBy('id')
                ->get(),
        ]);
    }
}
