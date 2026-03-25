<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Company\Vehicle;
use Illuminate\Http\Request;

class VehiclesController extends Controller
{

    /**
     * Retrieve the 10 most recently created vehicles with base data.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function allVehicles(Request $request)
    {
        return Vehicle::baseData()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * Retrieve the 10 most recently created vehicles associated with the airport city (city_id = 53).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function airportVehicles(Request $request)
    {
        return Vehicle::baseData()
            ->whereHas('company.city', fn($q) => $q->where('id', 53))
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * Retrieve the 10 most recently created electric vehicles.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function electricVehicles(Request $request)
    {
        return Vehicle::baseData()
            ->where('fuel_type_id', 3)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * Retrieve the 10 most recently created vehicles that have delivery options.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function deliveryVehicles(Request $request)
    {
        return Vehicle::baseData()
            ->whereHas('company.deliveries')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * Retrieve a paginated list of vehicles based on provided filters.
     *
     * Supported filters:
     * - seats (int)
     * - price_min, price_max (float)
     * - year_min, year_max (int)
     * - vehicleCategories (array|int)
     * - electric_only (bool)
     * - delivery (bool)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */

    public function filtersPage(Request $request)
    {
        $filters = $request->all();

        // Cast numeric values
        $filters['seats'] = isset($filters['seats']) ? (int)$filters['seats'] : null;
        $filters['price_min'] = isset($filters['price_min']) ? (float)$filters['price_min'] : null;
        $filters['price_max'] = isset($filters['price_max']) ? (float)$filters['price_max'] : null;
        $filters['year_min'] = isset($filters['year_min']) ? (int)$filters['year_min'] : null;
        $filters['year_max'] = isset($filters['year_max']) ? (int)$filters['year_max'] : null;

        // Convert single category string to array
        if (isset($filters['vehicleCategories']) && !is_array($filters['vehicleCategories'])) {
            $filters['vehicleCategories'] = [(int)$filters['vehicleCategories']];
        }

        // Convert boolean strings
        $filters['electric_only'] = filter_var($filters['electric_only'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $filters['delivery'] = filter_var($filters['delivery'] ?? false, FILTER_VALIDATE_BOOLEAN);

        return Vehicle::baseData()
            ->filter($filters)
            ->latest()
            ->paginate(16);
    }

    /**
     * Show a specific vehicle by ID and verify the slug.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function vehicleShow($id)
    {
        $vehicle = Vehicle::baseData()->findOrFail($id);

        if ($vehicle->id !== $id) {
            return response()->json([
                'success' => false,
                'message' => 'Vehicle not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $vehicle
        ]);
    }
}