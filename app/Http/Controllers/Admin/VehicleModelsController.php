<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VehicleModelStoreRequest;
use App\Http\Requests\Admin\VehicleModelUpdateRequest;
use App\Models\Company\VehicleModel;
use App\Services\ActivityLogService;
use App\Services\ForbiddenLogService;
use App\Support\ActionJsonResponse;
use App\Support\EmptyDatatable;
use App\Support\FlashNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class VehicleModelsController extends Controller
{
    protected $activityLogService;
    protected $forbiddenLogService;


    public function __construct(ActivityLogService $service,ForbiddenLogService $forbiddenLogService)
    {
        $this->activityLogService = $service;
        $this->forbiddenLogService = $forbiddenLogService;
    }

    public function index(Request $request){

        if (! auth()->user()->hasPermission('models.view_any') && ! auth()->user()->hasPermission('models.company.view_any')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'models.view_any','Can not view all models');
            return view('admin.errors.unauthorized');
        }


        if ($request->ajax()) {

            try {
                $model = VehicleModel::query();

                if ($request->filled('title')) {
                    $model->where("title", 'like', '%' . $request->title . '%');
                }

                if ($request->filled('brand_id')) {
                    $model->where('brand_id', $request->brand_id);
                }

                return DataTables::eloquent($model)
                    ->addIndexColumn()
                    ->editColumn('status',function (VehicleModel $model){
                        return view('admin.models.datatable.active',compact('model'));
                    })
                    ->editColumn('brand',function (VehicleModel $model){
                        return view('admin.models.datatable.brand',compact('model'));
                    })
                    ->addColumn('actions', 'admin.models.datatable.actions')
                    ->rawColumns(['actions'])
                    ->make(true);

            }catch (Exception $e) {
                report($e);
                return EmptyDatatable::toJson();
            }
        }
        $route = auth()->user()->isSystemAdmin()
            ? route('admin.vehicle_model.index')
            : route('company.vehicle_model.index');

        $view = auth()->user()->isSystemAdmin()
            ? 'admin.models.index'
            : 'company.models.index';

        return view($view, compact('route'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('models.store')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'models.store', 'Can not create new model');
            return view('admin.errors.unauthorized');
        }

        return view('admin.models.create');
    }


    public function store(VehicleModelStoreRequest $request)
    {
        if (!auth()->user()->hasPermission('models.store')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'models.store', 'Can not create new model');
        }


        $model = VehicleModel::create([
            'title'               => $request->title ?: "",
            'brand_id'            => $request->brand_id ?: null,
            'status'              => $request->status ? true : true,
        ]);

        $this->activityLogService->storeActivityLog('Created a new model. model Id# | ' . $model->id, 3,
            'modelsController@store', 'store');
        FlashNotification::success(__('master.success'), __('master.created_successfully'));
        return ActionJsonResponse::make(true, route('admin.vehicle_model.index', ['id' => $model->id]))->response();
    }

    public function edit($id){

        if (! auth()->user()->hasPermission('models.update')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'models.update','Can not update model');
            return view('admin.errors.unauthorized');
        }

        $model = VehicleModel::findOrFail($id);

        return view('admin.models.show.edit')->with([
            'model' => $model,
        ]);
    }

    public function update(VehicleModelUpdateRequest $request, $id)
    {
        if (! auth()->user()->hasPermission('models.update')) {
            $this->forbiddenLogService->storeForbiddenLog(
                request()->path(),
                'models.update',
                'Can not update model'
            );
        }

        $model = VehicleModel::findOrFail($id);


        $model->update([
            'title'                     => $request->title ?: "",
            'brand_id'                  => $request->brand_id ?: null,
            'status'                    => $request->status ? true : false,

        ]);

        $this->activityLogService->storeActivityLog(
            'Updated model. model Id# | ' . $model->id,
            3,
            'modelsController@update',
            'update'
        );

        FlashNotification::success(__('master.success'), __('master.updated_successfully'));
        return ActionJsonResponse::make(true, route('admin.vehicle_model.show', ['id' => $model->id]))->response();
    }


    public function show($id){

        if (! auth()->user()->hasPermission('models.view_any')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'models.view_any','Can not view all models');
            return view('admin.errors.unauthorized');
        }

        $model = VehicleModel::findOrFail($id);

        return view('admin.models.show.show')->with([
            'model'  =>$model
        ]);
    }


    public function delete(Request $request){

        if (! auth()->user()->hasPermission('models.delete')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'models.delete','Does not have permissions to delete model');

            $data = [
                'status' => 2,
                'message' => 'You do not have access to delete model'
            ];

            return $data;
        }

        try {
            DB::beginTransaction();

            VehicleModel::where('id',$request['data']['delete_id'])->delete();

            DB::commit();

            $data = [
                'status' => 1,
                'message' => 'model Deleted With success'
            ];
            $this->activityLogService->storeActivityLog('Deleted model . model Id# | '.$request['data']['delete_id'],1,'modelsController@delete','delete');
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
            VehicleModel::search(
                $request->get('keyword'),
                $request->get('id'),
            )->get()->append(['label','vehicles_label'])
        );
    }
}