<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VehicleCategoryStoreRequest;
use App\Http\Requests\Admin\VehicleCategoryUpdateRequest;
use App\Http\Requests\Admin\VehiclesCategoriesStoreRequest;
use App\Http\Requests\Admin\VehiclesCategoriesUpdateRequest;
use App\Models\Admin\VehicleCategory;
use App\Services\ActivityLogService;
use App\Services\ForbiddenLogService;
use App\Support\ActionJsonResponse;
use App\Support\EmptyDatatable;
use App\Support\FlashNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class VehicleCategoriesController extends Controller
{
    protected $activityLogService;
    protected $forbiddenLogService;


    public function __construct(ActivityLogService $service,ForbiddenLogService $forbiddenLogService)
    {
        $this->activityLogService = $service;
        $this->forbiddenLogService = $forbiddenLogService;
    }

    public function index(Request $request){

        if (!auth()->user()->hasPermission('vehicle_categories.view_any') && !auth()->user()->hasPermission('vehicle_categories.company.view_any')
        ) {$this->forbiddenLogService->storeForbiddenLog(request()->path(), 'vehicle_categories.view_any', 'Cannot view all Vehicle Categories');
            return view('admin.errors.unauthorized');
        }


        if ($request->ajax()) {

            try {
                $vehicle_category = VehicleCategory::select([
                    'id',
                    "title_en as title",
                    'icon',
                    'status',
                ]);

                if ($request->filled('title')) {
                    $vehicle_category->where("title_en", 'like', '%' . $request->title . '%');
                }

                return DataTables::eloquent($vehicle_category)
                    ->addIndexColumn()
                    ->editColumn('status',function (VehicleCategory $vehicle_category){
                        return view('admin.vehicle_categories.datatable.active',compact('vehicle_category'));
                    })
                    ->editColumn('icon',function (VehicleCategory $vehicle_category){
                        return view('admin.vehicle_categories.datatable.icon',compact('vehicle_category'));
                    })
                    ->addColumn('actions', 'admin.vehicle_categories.datatable.actions')
                    ->rawColumns(['actions'])
                    ->make(true);

             }catch (Exception $e) {
                report($e);
                return EmptyDatatable::toJson();
             }
        }

        $route = auth()->user()->isSystemAdmin()
            ? route('admin.vehicle_categories.index')
            : route('company.vehicle_categories.index');

        $view = auth()->user()->isSystemAdmin()
            ? 'admin.vehicle_categories.index'
            : 'company.vehicle_categories.index';

        return view($view, compact('route'));


    }

    public function create()
    {
        if (!auth()->user()->hasPermission('vehicle_categories.store')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'vehicle_categories.store', 'Can not create new Vehicle Category');
            return view('admin.errors.unauthorized');
        }

        return view('admin.vehicle_categories.create');
    }


    public function store(VehiclesCategoriesStoreRequest $request)
    {
        if (!auth()->user()->hasPermission('vehicle_categories.store')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'vehicle_categories.store', 'Can not create new Vehicle Category');
        }

        $iconPath = null;
        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('Images/VehicleCategory', 'public');
        }

        $vehicle_category = VehicleCategory::create([
            'title_en'            => $request->title_en ?: "",
            'title_it'            => $request->title_it ?: "",
            'title_al'            => $request->title_al ?: "",
            'title_es'            => $request->title_es ?: "",
            'title_fr'            => $request->title_fr ?: "",
            'title_de'            => $request->title_de ?: "",
            'status'              => $request->status ? true : true,
            'icon'                => $iconPath,
        ]);

        $this->activityLogService->storeActivityLog('Created a new Vehicle Category. Vehicle Category Id# | ' . $vehicle_category->id, 3,
            'VehicleCategorysController@store', 'store');
        FlashNotification::success(__('master.success'), __('master.created_successfully'));
        return ActionJsonResponse::make(true, route('admin.vehicle_categories.index', ['id' => $vehicle_category->id]))->response();
    }

    public function edit(Request $request,$id){

        if (! auth()->user()->hasPermission('vehicle_categories.update')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'vehicle_categories.update','Can not update Vehicle Category');
            return view('admin.errors.unauthorized');
        }

        $vehicle_category = VehicleCategory::findOrFail($id);

        return view('admin.vehicle_categories.show.edit')->with([
            'vehicle_category' => $vehicle_category,
        ]);
    }

    public function update(VehiclesCategoriesUpdateRequest $request, $id)
    {
        if (! auth()->user()->hasPermission('vehicle_categories.update')) {
            $this->forbiddenLogService->storeForbiddenLog(
                request()->path(),
                'vehicle_categories.update',
                'Can not update Vehicle Category'
            );
        }

        $vehicle_category = VehicleCategory::findOrFail($id);

        $iconPath = $vehicle_category->icon;

        if ($request->has('avatar_remove') && $request->avatar_remove == "1") {
            if ($iconPath && file_exists(storage_path('app/public/' . $iconPath))) {
                unlink(storage_path('app/public/' . $iconPath));
            }
            $iconPath = null;
        }

        if ($request->hasFile('icon')) {
            if ($iconPath && file_exists(storage_path('app/public/' . $iconPath))) {
                unlink(storage_path('app/public/' . $iconPath));
            }

            $iconPath = $request->file('icon')->store('Images/VehicleCategory', 'public');
        }

        $vehicle_category->update([
            'title_en'                  => $request->title_en ?: "",
            'title_al'                  => $request->title_al ?: "",
            'title_it'                  => $request->title_it ?: "",
            'title_es'                  => $request->title_es ?: "",
            'title_fr'                  => $request->title_fr ?: "",
            'title_de'                  => $request->title_de ?: "",
            'status'                    => $request->status ? true : false,
            'icon'                      => $iconPath,
        ]);

        $this->activityLogService->storeActivityLog(
            'Updated Vehicle Category. Vehicle Category Id# | ' . $vehicle_category->id,
            3,
            'VehicleCategorysController@update',
            'update'
        );

        FlashNotification::success(__('master.success'), __('master.updated_successfully'));
        return ActionJsonResponse::make(true, route('admin.vehicle_categories.show', ['id' => $vehicle_category->id]))->response();
    }


    public function show($id){

        if (! auth()->user()->hasPermission('vehicle_categories.view_any')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'vehicle_categories.view_any','Can not view all Vehicle Categorys');
            return view('admin.errors.unauthorized');
        }

        $vehicle_category = VehicleCategory::findOrFail($id);

        return view('admin.vehicle_categories.show.show')->with([
            'vehicle_category'  =>$vehicle_category
        ]);
    }


    public function delete(Request $request){

        if (! auth()->user()->hasPermission('vehicle_categories.delete')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'vehicle_categories.delete','Does not have permissions to delete Vehicle Category');

            $data = [
                'status' => 2,
                'message' => 'You do not have access to delete Vehicle Category'
            ];

            return $data;
        }

        try {
            DB::beginTransaction();

            VehicleCategory::where('id',$request['data']['delete_id'])->delete();

            DB::commit();

            $data = [
                'status' => 1,
                'message' => 'Vehicle Category Deleted With success'
            ];
            $this->activityLogService->storeActivityLog('Deleted Vehicle Category . Vehicle Category Id# | '.$request['data']['delete_id'],1,'VehicleCategorysController@delete','delete');
        } catch (\Exception $e) {
            report($e);
            DB::rollBack();

            $data = [
                'status' => 0,
                'message' => 'Something went wrong. Please try again later'
            ];

        }
        return $data;
    }

    public function search(Request $request){

        return response()->json(
            VehicleCategory::search(
                $request->get('keyword'),
                $request->get('id'),
            )->get()->append(['label'])
        );
    }
}
