<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FeatureStoreRequest;
use App\Http\Requests\Admin\FeatureUpdateRequest;
use App\Models\Admin\Feature;
use App\Services\ActivityLogService;
use App\Services\ForbiddenLogService;
use App\Support\ActionJsonResponse;
use App\Support\EmptyDatatable;
use App\Support\FlashNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class FeaturesController extends Controller
{
    protected $activityLogService;
    protected $forbiddenLogService;


    public function __construct(ActivityLogService $service,ForbiddenLogService $forbiddenLogService)
    {
        $this->activityLogService = $service;
        $this->forbiddenLogService = $forbiddenLogService;
    }

    public function index(Request $request){

        if (!auth()->user()->hasPermission('features.view_any') && !auth()->user()->hasPermission('features.company.view_any')
        ) {$this->forbiddenLogService->storeForbiddenLog(request()->path(), 'features.view_any', 'Cannot view all Features');
            return view('admin.errors.unauthorized');
        }

        if ($request->ajax()) {

            try {
                $feature = Feature::query();

                if ($request->filled('title')) {
                    $feature->where("title", 'like', '%' . $request->title . '%');
                }

                return DataTables::eloquent($feature)
                    ->addIndexColumn()
                    ->editColumn('status',function (Feature $feature){
                        return view('admin.features.datatable.active',compact('feature'));
                    })
                    ->addColumn('actions', 'admin.features.datatable.actions')
                    ->rawColumns(['actions'])
                    ->make(true);

            }catch (Exception $e) {
                report($e);
                return EmptyDatatable::toJson();
            }
        }

        $route = auth()->user()->isSystemAdmin()
            ? route('admin.features.index')
            : route('company.features.index');

        $view = auth()->user()->isSystemAdmin()
            ? 'admin.features.index'
            : 'company.features.index';

        return view($view, compact('route'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('features.store')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'features.store', 'Can not create new Feature');
            return view('admin.errors.unauthorized');
        }

        return view('admin.features.create');
    }


    public function store(FeatureStoreRequest $request)
    {
        if (!auth()->user()->hasPermission('features.store')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'features.store', 'Can not create new Feature');
        }


        $feature = Feature::create([
            'title'               => $request->title ?: "",
            'slug'                => $request->slug ?: "",
            'status'              => $request->status ? true : true,
        ]);

        $this->activityLogService->storeActivityLog('Created a new Feature. Feature Id# | ' . $feature->id, 3,
            'FeaturesController@store', 'store');
        FlashNotification::success(__('master.success'), __('master.created_successfully'));
        return ActionJsonResponse::make(true, route('admin.features.index', ['id' => $feature->id]))->response();
    }

    public function edit($id){

        if (! auth()->user()->hasPermission('features.update')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'features.update','Can not update Feature');
            return view('admin.errors.unauthorized');
        }

        $feature = Feature::findOrFail($id);

        return view('admin.features.show.edit')->with([
            'feature' => $feature,
        ]);
    }

    public function update(FeatureUpdateRequest $request, $id)
    {
        if (! auth()->user()->hasPermission('features.update')) {
            $this->forbiddenLogService->storeForbiddenLog(
                request()->path(),
                'features.update',
                'Can not update Feature'
            );
        }

        $feature = Feature::findOrFail($id);


        $feature->update([
            'title'                     => $request->title ?: "",
            'slug'                      => $request->slug ?: "",
            'status'                    => $request->status ? true : false,

        ]);

        $this->activityLogService->storeActivityLog(
            'Updated Feature. Feature Id# | ' . $feature->id,
            3,
            'FeaturesController@update',
            'update'
        );

        FlashNotification::success(__('master.success'), __('master.updated_successfully'));
        return ActionJsonResponse::make(true, route('admin.features.show', ['id' => $feature->id]))->response();
    }


    public function show($id){

        if (! auth()->user()->hasPermission('features.view_any')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'features.view_any','Can not view all Features');
            return view('admin.errors.unauthorized');
        }

        $feature = Feature::findOrFail($id);

        return view('admin.features.show.show')->with([
            'feature'  =>$feature
        ]);
    }


    public function delete(Request $request){

        if (! auth()->user()->hasPermission('features.delete')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'features.delete','Does not have permissions to delete Feature');

            $data = [
                'status' => 2,
                'message' => 'You do not have access to delete Feature'
            ];

            return $data;
        }

        try {
            DB::beginTransaction();

            Feature::where('id',$request['data']['delete_id'])->delete();

            DB::commit();

            $data = [
                'status' => 1,
                'message' => 'Feature Deleted With success'
            ];
            $this->activityLogService->storeActivityLog('Deleted Feature . Feature Id# | '.$request['data']['delete_id'],1,'FeaturesController@delete','delete');
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
            Feature::search(
                $request->get('keyword'),
                $request->get('id'),
            )->get()->append(['title'])
        );
    }
}