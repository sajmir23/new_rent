<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\VehiclesStoreRequest;
use App\Http\Requests\Company\VehiclesUpdateRequest;
use App\Models\Admin\Feature;
use App\Models\Company\Vehicle;
use App\Models\Company\VehicleModel;
use App\Services\ActivityLogService;
use App\Services\ForbiddenLogService;
use App\Support\ActionJsonResponse;
use App\Support\EmptyDatatable;
use App\Support\FlashNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class VehiclesController extends Controller
{
    protected $activityLogService;
    protected $forbiddenLogService;


    public function __construct(ActivityLogService $service,ForbiddenLogService $forbiddenLogService)
    {
        $this->activityLogService = $service;
        $this->forbiddenLogService = $forbiddenLogService;
    }

    /**
     * Display a datatable of all vehicles for the logged-in user's company.
     * Applies optional filters. Returns JSON for AJAX requests,
     * otherwise renders the vehicles index view.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request){

        if (! auth()->user()->hasPermission('vehicles.view_any')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'vehicles.view_any','Can not view all vehicles');
            return view('admin.errors.unauthorized');
        }


        if ($request->ajax()) {

            try {
                $vehicles = Vehicle::with('company', 'vehicleModel', 'vehicleCategory', 'fuelType', 'transmissionType', 'vehicleStatus', 'creator', 'updater')
                    ->where('company_id', auth()->user()->company_id)
                    ->orderByDesc('id');

                $filterDates = [
                    'registration_expiry' => 'registration_expiry',
                    'insurance_expiry'    => 'insurance_expiry',
                ];

                foreach ($filterDates as $inputName => $dbField) {
                    if ($request->has($inputName) && !empty($request->$inputName)) {
                        $dates = explode(' - ', $request->$inputName);
                        if (count($dates) === 2) { // Ensure we have both start and end dates
                            $startDate = Carbon::parse($dates[0])->toDateString();
                            $endDate = Carbon::parse($dates[1])->toDateString();

                            $vehicles->whereBetween($dbField, [$startDate, $endDate]);
                        }
                    }
                }

                if ($request->filled('title')) {
                    $vehicles->where("title", 'like', '%' . $request->title . '%');
                }
                if ($request->filled('plate')) {
                    $vehicles->where("plate", 'like', '%' . $request->plate . '%');
                }
                if ($request->filled('vin')) {
                    $vehicles->where("vin", 'like', '%' . $request->vin . '%');
                }
                if ($request->has('vehicle_category_id') && $request->vehicle_category_id != null) {
                    $filter = $request->get('vehicle_category_id');
                    $vehicles->where('vehicle_category_id', $filter);
                }
                if ($request->has('fuel_type_id') && $request->fuel_type_id != null) {
                    $filter = $request->get('fuel_type_id');
                    $vehicles->where('fuel_type_id', $filter);
                }

                if ($request->has('transmission_type_id') && $request->transmission_type_id != null) {
                    $filter = $request->get('transmission_type_id');
                    $vehicles->where('transmission_type_id', $filter);
                }

                if ($request->has('vehicle_status_id') && $request->vehicle_status_id != null) {
                    $filter = $request->get('vehicle_status_id');
                    $vehicles->where('vehicle_status_id', $filter);
                }

                if ($request->has('vehicle_model_id') && $request->vehicle_model_id != null) {
                    $filter = $request->get('vehicle_model_id');
                    $vehicles->where('vehicle_model_id', $filter);
                }

                return DataTables::eloquent($vehicles)
                    ->addIndexColumn()
                    ->addColumn('vehicle',function (Vehicle $vehicle){
                        return view('company.vehicles.datatable.vehicle',compact('vehicle'));
                    })
                    ->addColumn('identifiers',function (Vehicle $vehicle){
                        return view('company.vehicles.datatable.identifiers',compact('vehicle'));
                    })
                    ->addColumn('specifications',function (Vehicle $vehicle){
                        return view('company.vehicles.datatable.specifications',compact('vehicle'));
                    })
                    ->addColumn('mechanics',function (Vehicle $vehicle){
                        return view('company.vehicles.datatable.mechanics',compact('vehicle'));
                    })
                    ->addColumn('requirements',function (Vehicle $vehicle){
                        return view('company.vehicles.datatable.requirements',compact('vehicle'));
                    })
                    ->addColumn('vehicle_status',function (Vehicle $vehicle){
                        return view('company.vehicles.datatable.status',compact('vehicle'));
                    })
                    ->addColumn('expiry_dates',function (Vehicle $vehicle){
                        return view('company.vehicles.datatable.expiry_dates',compact('vehicle'));
                    })
                    ->addColumn('daily_rate',function (Vehicle $vehicle){
                        return view('company.vehicles.datatable.daily_rate',compact('vehicle'));
                    })
                    ->addColumn('actions', 'company.vehicles.datatable.actions')
                    ->rawColumns(['actions'])
                    ->make(true);

            }catch (Exception $e) {
                report($e);
                return EmptyDatatable::toJson();
            }
        }

        return view('company.vehicles.index');
    }

    /**
     * Show the form for creating a new vehicle.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if (!auth()->user()->hasPermission('vehicles.store')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'vehicles.store', 'Can not create new vehicles');
            return view('admin.errors.unauthorized');
        }
        $features=Feature::all();

        return view('company.vehicles.create')->with([
            'features' => $features
        ]);
    }

    /**
     * Store a newly created vehicle in storage.
     * @param \App\Http\Requests\Company\VehiclesStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(VehiclesStoreRequest $request)
    {
        if (!auth()->user()->hasPermission('vehicles.store')) {
            $this->forbiddenLogService->storeForbiddenLog(
                request()->path(),
                'vehicles.store',
                'Can not create new vehicles'
            );
        }

        $vehicleModel = VehicleModel::with('brands')->find($request->vehicle_model_id);

        $brandTitle = $vehicleModel?->brands->title ?? '--';
        $modelTitle = $vehicleModel?->title ?? '--';
        $year = $request->year ?? '--';
        $finalTitle = trim("$brandTitle $modelTitle $year");

        DB::transaction(function () use ($request, $finalTitle) {
            $vehicle = Vehicle::create([
                'title'                             => $finalTitle,
                'slug'                              => 'temp', // temporary slug
                'base_daily_rate'                   => $request->base_daily_rate,
                'plate'                             => $request->plate  ?? "",
                'vin'                               => $request->vin ?? "",
                'registration_expiry'               => $request->registration_expiry ?? null,
                'insurance_expiry'                  => $request->insurance_expiry ?? null,
                'year'                              => $request->year ?? null,
                'mileage'                           => $request->mileage ?? null,
                'color'                             => $request->color ?? "",
                'notes'                             => $request->notes ?? "",
                'engine_size'                       => $request->engine_size ?? null,
                'company_id'                        => auth()->user()->company_id,
                'vehicle_model_id'                  => $request->vehicle_model_id  ?? null,
                'vehicle_category_id'               => $request->vehicle_category_id ?? null,
                'fuel_type_id'                      => $request->fuel_type_id ?? null,
                'transmission_type_id'              => $request->transmission_type_id ?? null,
                'vehicle_status_id'                 => $request->vehicle_status_id ?? null,
                'seats'                             => $request->seats ?? null,
                'min_drive_age'                     => $request->min_drive_age ?? null,
                'max_drive_age'                     => $request->max_drive_age ?? null,
                'international_licence_required'    => $request->international_licence_required ? true : false,
                'created_by'                        => auth()->id(),
            ]);

            $baseSlug = Str::slug($finalTitle);
            $slug     = "{$baseSlug}-{$vehicle->id}";

            $vehicle->update(['slug' => $slug]);

            if ($request->has('features')) {
                $vehicle->features()->sync($request->features);
            }

            if ($request->images) {
                $tempIds = explode(',', $request->images);
                $companyName = auth()->user()->company->name ?? 'company';
                $companyFolder = Str::slug($companyName);

                foreach ($tempIds as $imgId) {

                    $finalPath = "vehicles/{$companyFolder}/{$imgId}";
                    $fullPath = storage_path("app/public/{$finalPath}");

                    if (!File::exists($fullPath)) {
                        Log::error("Vehicle image missing: {$fullPath}");
                        continue;
                    }

                    $vehicle->images()->create([
                        'name'       => $imgId,
                        'path'       => $finalPath,
                        'mime'       => File::mimeType($fullPath),
                        'size'       => round(File::size($fullPath) / 1024, 2),
                        'created_by' => auth()->id()
                    ]);
                }
            }
            $this->activityLogService->storeActivityLog('Created a new vehicle. Vehicle Id# | ' . $vehicle->id, 3, 'vehiclesController@store', 'store');
        });

        FlashNotification::success(__('master.success'), __('master.created_successfully'));

        return ActionJsonResponse::make(
            true,
            route('company.vehicles.index')
        )->response();
    }

    /**
     * Show the data of a specified vehicle.
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        if (! auth()->user()->hasPermission('vehicles.view_any')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'vehicles.view_any', 'Can not view all Vehicles');
            return view('admin.errors.unauthorized');
        }

        $vehicle = Vehicle::where('id', $id)
            ->where('company_id', auth()->user()->company_id)->with('features')
            ->firstOrFail();


        return view('company.vehicles.show.show')->with([
            'vehicle' => $vehicle,
        ]);
    }

    /**
     * Show the form for editing the specified vehicle.
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        if (!auth()->user()->hasPermission('vehicles.update')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'vehicles.update', 'Can not edit vehicles');
            return view('admin.errors.unauthorized');
        }

        $vehicle = Vehicle::where('id', $id)
            ->where('company_id', auth()->user()->company_id)->with('features')
            ->firstOrFail();

        $features=Feature::all();

        return view('company.vehicles.show.edit')->with([
            'vehicle' => $vehicle,
            'features' => $features
        ]);
    }

    /**
     * Update the specified vehicle in storage.
     * @param \App\Http\Requests\Company\VehiclesUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(VehiclesUpdateRequest $request, $id)
    {
        if (!auth()->user()->hasPermission('vehicles.update')) {
            $this->forbiddenLogService->storeForbiddenLog(
                request()->path(),
                'vehicles.update',
                'Can not update vehicles'
            );
        }

        $vehicle = Vehicle::findOrFail($id);

        $vehicleModel = VehicleModel::with('brands')->find($request->vehicle_model_id);
        $brandTitle = $vehicleModel?->brands?->title ?? '--';
        $modelTitle = $vehicleModel?->title ?? '--';
        $year = $request->year ?? '--';
        $finalTitle = trim("$brandTitle $modelTitle $year");

        $oldTitle = $vehicle->title;

        $vehicle->update([
            'title'                              => $finalTitle,
            'plate'                              => $request->plate ?? "",
            'vin'                                => $request->vin ?? "",
            'registration_expiry'                => $request->registration_expiry ?? null,
            'insurance_expiry'                   => $request->insurance_expiry ?? null,
            'year'                               => $request->year ?? null,
            'mileage'                            => $request->mileage ?? null,
            'color'                              => $request->color ?? "",
            'notes'                              => $request->notes ?? "",
            'engine_size'                        => $request->engine_size ?? null,
            'company_id'                         => auth()->user()->company_id,
            'vehicle_model_id'                   => $request->vehicle_model_id,
            'vehicle_category_id'                => $request->vehicle_category_id,
            'fuel_type_id'                       => $request->fuel_type_id,
            'transmission_type_id'               => $request->transmission_type_id,
            'vehicle_status_id'                  => $request->vehicle_status_id,
            'seats'                              => $request->seats ?? null,
            'min_drive_age'                      => $request->min_drive_age ?? null,
            'max_drive_age'                      => $request->max_drive_age ?? null,
            'international_licence_required'     => $request->international_licence_required ? true : false,
            'updated_by'                         => auth()->id(),
        ]);

        if ($oldTitle !== $finalTitle) {
            $baseSlug = Str::slug($finalTitle);
            $newSlug = "{$baseSlug}-{$vehicle->id}";
            $vehicle->update(['slug' => $newSlug]);
        }


        $vehicle->features()->sync($request->features ?? []);

        if ($request->deleted_images) {
            $deletedIds = explode(',', $request->deleted_images);

            foreach ($deletedIds as $imgId) {
                $image = $vehicle->images()->find($imgId);

                if ($image) {
                    Storage::disk('public')->delete($image->path);
                    $image->delete();
                }
            }
        }

        if ($request->images) {

            $imgIds = explode(',', $request->images);

            $companyName = auth()->user()->company->name ?? 'company';
            $companyFolder = Str::slug($companyName);
            $finalFolder = "vehicles/{$companyFolder}";

            foreach ($imgIds as $imgId) {

                $finalPath = "{$finalFolder}/{$imgId}";
                $fullPath = storage_path("app/public/{$finalPath}");

                if (!File::exists($fullPath)) {
                    // If upload failed somehow, skip
                    Log::warning("Missing uploaded image on update: {$fullPath}");
                    continue;
                }

                $vehicle->images()->create([
                    'name'       => $imgId,
                    'path'       => $finalPath,
                    'mime'       => File::mimeType($fullPath),
                    'size'       => round(File::size($fullPath) / 1024, 2),
                    'created_by' => auth()->id()
                ]);
            }
        }

        $this->activityLogService->storeActivityLog('Updated Vehicle. Vehicle Id# | ' . $vehicle->id, 3, 'VehiclesController@update', 'update');

        FlashNotification::success(__('master.success'), __('master.updated_successfully'));

        return ActionJsonResponse::make(
            true,
            route('company.vehicles.index')
        )->response();
    }

    /**
     * Delete a vehicle if it has the correct status.
     * @param \Illuminate\Http\Request $request
     * @return array Status and message indicating the result of the operation
     */
    public function delete(Request $request)
    {

        if (!auth()->user()->hasPermission('vehicles.delete')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'vehicles.delete', 'Does not have permissions to delete Vehicle');

            return [
                'status' => 2,
                'message' => 'You do not have access to delete Vehicle'
            ];
        }

        $request->validate([
            'data.delete_id' => 'required|integer|exists:vehicles,id'
        ]);

        $deleteId = $request->input('data.delete_id');

        try {
            DB::beginTransaction();

            $deleted = Vehicle::where('id', $deleteId)
                ->where('vehicle_status_id', 4)
                ->delete();

            DB::commit();

            if ($deleted) {
                $this->activityLogService->storeActivityLog(
                    'Deleted Vehicle. Vehicle ID: ' . $deleteId,
                    1,
                    'VehiclesController@delete',
                    'delete'
                );

                return [
                    'status' => 1,
                    'message' => 'Vehicle deleted successfully.'
                ];
            } else {
                return [
                    'status' => 2,
                    'message' => 'Vehicle could not be deleted. It may not have the correct status.'
                ];
            }

        } catch (\Exception $e) {
            report($e);
            DB::rollBack();

            return [
                'status' => 0,
                'message' => 'Something went wrong. Please try again later.'
            ];
        }
    }

    /**
     * Search vehicles based on a keyword and optional ID.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        return response()->json(
            Vehicle::search(
                $request->get('keyword'),
                $request->get('id'),
            )->get()->append(['label'])
        );
    }

}