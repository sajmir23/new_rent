<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FuelTypesStoreRequest;
use App\Http\Requests\Admin\FuelTypesUpdateRequest;
use App\Models\Admin\FuelTypes;
use App\Models\Admin\VehicleCategory;
use App\Services\ActivityLogService;
use App\Services\ForbiddenLogService;
use App\Support\ActionJsonResponse;
use App\Support\EmptyDatatable;
use App\Support\FlashNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class FuelTypesController extends Controller
{
    protected $activityLogService;
    protected $forbiddenLogService;

    public function __construct(ActivityLogService $activityLogService,ForbiddenLogService $forbiddenLogService)
    {
        $this->activityLogService = $activityLogService;
        $this->forbiddenLogService = $forbiddenLogService;
    }

    public function index(Request $request){

        if (!auth()->user()->hasPermission('fuel_types.view_any') && !auth()->user()->hasPermission('fuel_types.company.view_any')
        ) {$this->forbiddenLogService->storeForbiddenLog(request()->path(), 'fuel_types.view_any', 'Cannot view all Fuel Types');
            return view('admin.errors.unauthorized');
        }

        if ($request->ajax())
        {
            try
            {

                $fuel_types = FuelTypes::select([
                    'id',
                    "title_en as title",
                    'status',
                ]);

                if ($request->filled('title')) {
                    $fuel_types->where("title_en", 'like', '%' . $request->title . '%');
                }

                return DataTables::eloquent($fuel_types)
                    ->addIndexColumn()
                    ->editColumn('status',function (FuelTypes $fuel_types){
                        return view('admin.fuel_types.datatable.active',compact('fuel_types'));
                    })

                    ->addColumn('actions', 'admin.fuel_types.datatable.actions')
                    ->rawColumns(['actions'])
                    ->make(true);

            }
            catch (Exception $e)
            {
                report($e);
                return EmptyDatatable::toJson();
            }
        }

        $route = auth()->user()->isSystemAdmin()
            ? route('admin.fuel_types.index')
            : route('company.fuel_types.index');

        $view = auth()->user()->isSystemAdmin()
            ? 'admin.fuel_types.index'
            : 'company.fuel_types.index';

        return view($view, compact('route'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('fuel_types.store')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'fuel_types.store', 'Can not create new Fuel Type');
            return view('admin.errors.unauthorized');
        }

        return view('admin.fuel_types.create');
    }

    public function store(FuelTypesStoreRequest $request)
    {
        if (!auth()->user()->hasPermission('fuel_types.store')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'fuel_types.store', 'Can not create new Fuel Type');
            return view('admin.errors.unauthorized');
        }

        $fuel_types = FuelTypes::create([
            'title_en'            => $request->title_en ?: "",
            'title_it'            => $request->title_it ?: "",
            'title_al'            => $request->title_al ?: "",
            'title_es'            => $request->title_es ?: "",
            'title_fr'            => $request->title_fr ?: "",
            'title_de'            => $request->title_de ?: "",
            'status'              => $request->status ? true : true,
        ]);

        $this->activityLogService->storeActivityLog('Created a New Fuel Type. Fuel Type Id# | ' . $fuel_types->id, 3,
            'FuelTypesController@store', 'store');
        FlashNotification::success(__('master.success'), __('master.created_successfully'));
        return ActionJsonResponse::make(true, route('admin.fuel_types.index', ['id' => $fuel_types->id]))->response();

    }
    public function edit($id){

        if (! auth()->user()->hasPermission('fuel_types.update')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'fuel_types.update','Can not update Fuel Type');
            return view('admin.errors.unauthorized');
        }

        $fuel_type = FuelTypes::findOrFail($id);

        return view('admin.fuel_types.show.edit')->with([
            'fuel_type' => $fuel_type,
        ]);
    }

    public function update(FuelTypesUpdateRequest $request, $id)
    {
        if (! auth()->user()->hasPermission('fuel_types.update')) {
            $this->forbiddenLogService->storeForbiddenLog(
                request()->path(),
                'fuel_types.update',
                'Can not update Fuel Type'
            );
        }

        $fuel_type=FuelTypes::findOrFail($id);

        $fuel_type->update([
           'title_en'                   => $request->title_en ?: "",
            'title_al'                  => $request->title_al ?: "",
            'title_it'                  => $request->title_it ?: "",
            'title_es'                  => $request->title_es ?: "",
            'title_fr'                  => $request->title_fr ?: "",
            'title_de'                  => $request->title_de ?: "",
            'status'                    => $request->status ? true : false,
        ]);

        $this->activityLogService->storeActivityLog(
            'Updated Fuel Type. Fuel Type Id# | ' . $fuel_type->id,
            3,
            'FuelTypesController@update',
            'update'
        );

        FlashNotification::success(__('master.success'), __('master.updated_successfully'));
        return ActionJsonResponse::make(true, route('admin.fuel_types.show', ['id' => $fuel_type->id]))->response();
    }

    public function show($id)
    {
        if (! auth()->user()->hasPermission('fuel_types.view_any')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'fuel_types.view_any','Can not view a Fuel Type');
            return view('admin.errors.unauthorized');
        }

        $fuel_type=FuelTypes::findOrFail($id);

        return view('admin.fuel_types.show.show')->with(['fuel_type'=>$fuel_type]);
    }

    public function delete(Request $request){

        if (! auth()->user()->hasPermission('fuel_types.delete')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'fuel_types.delete','Does not have permissions to delete Fuel Type');

            $data = [
                'status' => 2,
                'message' => 'You do not have access to delete Fuel Type'
            ];

            return $data;
        }

        try {
            DB::beginTransaction();

            FuelTypes::where('id',$request['data']['delete_id'])->delete();

            DB::commit();

            $data = [
                'status' => 1,
                'message' => 'Fuel Type Deleted With success'
            ];
            $this->activityLogService->storeActivityLog('Deleted Fuel Type . Fuel Type Id# | '.$request['data']['delete_id'],1,'FuelTypesController@delete','delete');
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
            FuelTypes::search(
                $request->get('keyword'),
                $request->get('id'),
            )->get()->append(['label'])
        );
    }
}
