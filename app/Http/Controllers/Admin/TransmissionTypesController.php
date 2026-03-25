<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TransmissionTypesStoreRequest;
use App\Http\Requests\Admin\TransmissionTypesUpdateRequest;
use App\Models\Admin\TransmissionType;
use App\Services\ActivityLogService;
use App\Services\ForbiddenLogService;
use App\Support\ActionJsonResponse;
use App\Support\EmptyDatatable;
use App\Support\FlashNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TransmissionTypesController extends Controller
{
    protected $activityLogService;
    protected $forbiddenLogService;


    public function __construct(ActivityLogService $service,ForbiddenLogService $forbiddenLogService)
    {
        $this->activityLogService = $service;
        $this->forbiddenLogService = $forbiddenLogService;
    }

    public function index(Request $request){

        if (!auth()->user()->hasPermission('transmission_types.view_any') && !auth()->user()->hasPermission('transmission_types.company.view_any')
        ) {$this->forbiddenLogService->storeForbiddenLog(request()->path(), 'transmission_types.view_any', 'Cannot view all Transmission Types');
            return view('admin.errors.unauthorized');
        }

        if ($request->ajax()) {

            try {

                $transmission_type = TransmissionType::select([
                    'id',
                    "title_en as title",
                    'status',
                ]);

                if ($request->filled('title')) {
                    $transmission_type->where("title_en", 'like', '%' . $request->title . '%');
                }

                return DataTables::eloquent($transmission_type)
                    ->addIndexColumn()
                    ->editColumn('status',function (TransmissionType $transmission_type){
                        return view('admin.transmission_types.datatable.active',compact('transmission_type'));
                    })
                    ->addColumn('actions', 'admin.transmission_types.datatable.actions')
                    ->rawColumns(['actions'])
                    ->make(true);

            }catch (Exception $e) {
                report($e);
                return EmptyDatatable::toJson();
            }
        }

        $route = auth()->user()->isSystemAdmin()
            ? route('admin.transmission_types.index')
            : route('company.transmission_types.index');

        $view = auth()->user()->isSystemAdmin()
            ? 'admin.transmission_types.index'
            : 'company.transmission_types.index';

        return view($view, compact('route'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('transmission_types.store')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'transmission_types.store', 'Can not create new Transmission Type');
            return view('admin.errors.unauthorized');
        }

        return view('admin.transmission_types.create');
    }


    public function store(TransmissionTypesStoreRequest $request)
    {
        if (!auth()->user()->hasPermission('transmission_types.store')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'transmission_types.store', 'Can not create new Transmission Type');
        }

        $transmission_type = TransmissionType::create([
            'title_en'            => $request->title_en ?: "",
            'title_it'            => $request->title_it ?: "",
            'title_al'            => $request->title_al ?: "",
            'title_es'            => $request->title_es ?: "",
            'title_fr'            => $request->title_fr ?: "",
            'title_de'            => $request->title_de ?: "",
            'status'              => $request->status ? true : true,
        ]);

        $this->activityLogService->storeActivityLog('Created a new Transmission Type. Transmission Type Id# | ' . $transmission_type->id, 3,
            'TransmissionTypesController@store', 'store');
        FlashNotification::success(__('master.success'), __('master.created_successfully'));
        return ActionJsonResponse::make(true, route('admin.transmission_types.index', ['id' => $transmission_type->id]))->response();
    }

    public function edit($id){

        if (! auth()->user()->hasPermission('transmission_types.update')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'transmission_types.update','Can not update Transmission Type');
            return view('admin.errors.unauthorized');
        }

        $transmission_type = TransmissionType::findOrFail($id);

        return view('admin.transmission_types.show.edit')->with([
            'transmission_type' => $transmission_type,
        ]);
    }

    public function update(TransmissionTypesUpdateRequest $request, $id)
    {
        if (! auth()->user()->hasPermission('transmission_types.update')) {
            $this->forbiddenLogService->storeForbiddenLog(
                request()->path(),
                'transmission_types.update',
                'Can not update Transmission Type'
            );
        }

        $transmission_type = TransmissionType::findOrFail($id);
        

        $transmission_type->update([
            'title_en'                  => $request->title_en ?: "",
            'title_al'                  => $request->title_al ?: "",
            'title_it'                  => $request->title_it ?: "",
            'title_es'                  => $request->title_es ?: "",
            'title_fr'                  => $request->title_fr ?: "",
            'title_de'                  => $request->title_de ?: "",
            'status'                    => $request->status ? true : false,
        ]);

        $this->activityLogService->storeActivityLog(
            'Updated Transmission Type. Transmission Type Id# | ' . $transmission_type->id,
            3,
            'TransmissionTypesController@update',
            'update'
        );

        FlashNotification::success(__('master.success'), __('master.updated_successfully'));
        return ActionJsonResponse::make(true, route('admin.transmission_types.show', ['id' => $transmission_type->id]))->response();
    }


    public function show($id){

        if (! auth()->user()->hasPermission('transmission_types.view_any')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'transmission_types.view_any','Can not view all Transmission Types');
            return view('admin.errors.unauthorized');
        }

        $transmission_type = TransmissionType::findOrFail($id);

        return view('admin.transmission_types.show.show')->with([
            'transmission_type'  =>$transmission_type
        ]);
    }


    public function delete(Request $request){

        if (! auth()->user()->hasPermission('transmission_types.delete')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'transmission_types.delete','Does not have permissions to delete Transmission Type');

            $data = [
                'status' => 2,
                'message' => 'You do not have access to delete Transmission Type'
            ];

            return $data;
        }

        try {
            DB::beginTransaction();

            TransmissionType::where('id',$request['data']['delete_id'])->delete();

            DB::commit();

            $data = [
                'status' => 1,
                'message' => 'Transmission Type Deleted With success'
            ];
            $this->activityLogService->storeActivityLog('Deleted Transmission Type . Transmission Type Id# | '.$request['data']['delete_id'],1,'TransmissionTypesController@delete','delete');
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
            TransmissionType::search(
                $request->get('keyword'),
                $request->get('id'),
            )->get()->append(['label'])
        );
    }
}
