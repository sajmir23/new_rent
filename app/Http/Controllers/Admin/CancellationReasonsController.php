<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CancellationReasonsStoreRequest;
use App\Http\Requests\Admin\CancellationReasonsUpdateRequest;
use App\Http\Requests\Admin\FuelTypesStoreRequest;
use App\Http\Requests\Admin\FuelTypesUpdateRequest;
use App\Models\Admin\Cancellation_Reasons;
use App\Models\Admin\FuelTypes;
use App\Services\ActivityLogService;
use App\Services\ForbiddenLogService;
use App\Support\ActionJsonResponse;
use App\Support\EmptyDatatable;
use App\Support\FlashNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CancellationReasonsController extends Controller
{
    protected $activityLogService;
    protected $forbiddenLogService;

    public function __construct(ActivityLogService $activityLogService,ForbiddenLogService $forbiddenLogService)
    {
        $this->activityLogService = $activityLogService;
        $this->forbiddenLogService = $forbiddenLogService;
    }

    public function index(Request $request){


        if (!auth()->user()->hasPermission('cancellation_reasons.view_any') && !auth()->user()->hasPermission('cancellation_reasons.company.view_any')
        ) {$this->forbiddenLogService->storeForbiddenLog(request()->path(), 'cancellation_reasons.view_any', 'Cannot view all Cancellation Reasons');
            return view('admin.errors.unauthorized');
        }

        if ($request->ajax())
        {
            try
            {

                $cancellation_reasons = Cancellation_Reasons::select([
                    'id',
                    "title_en as title",
                    'status',
                ]);

                if ($request->filled('title')) {
                    $cancellation_reasons->where("title_en", 'like', '%' . $request->title . '%');
                }
                return DataTables::eloquent($cancellation_reasons)
                    ->addIndexColumn()
                    ->editColumn('status',function (Cancellation_Reasons $cancellation_reasons){
                        return view('admin.cancellation_reasons.datatable.active',compact('cancellation_reasons'));
                    })
                    ->addColumn('actions', 'admin.cancellation_reasons.datatable.actions')
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
            ? route('admin.cancellation_reasons.index')
            : route('company.cancellation_reasons.index');

        $view = auth()->user()->isSystemAdmin()
            ? 'admin.cancellation_reasons.index'
            : 'company.cancellation_reasons.index';

        return view($view, compact('route'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('cancellation_reasons.store')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'cancellation_reasons.store', 'Can not create new Cancellation Reason');
            return view('admin.errors.unauthorized');
        }
        return view('admin.cancellation_reasons.create');
    }

    public function store(CancellationReasonsStoreRequest $request)
    {
        if (!auth()->user()->hasPermission('cancellation_reasons.store')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'cancellation_reasons.store', 'Can not create new Cancellation Reason');
            return view('admin.errors.unauthorized');
        }

        $cancellation_reasons = Cancellation_Reasons::create([
            'title_en'            => $request->title_en ?: "",
            'title_it'            => $request->title_it ?: "",
            'title_al'            => $request->title_al ?: "",
            'title_es'            => $request->title_es ?: "",
            'title_fr'            => $request->title_fr ?: "",
            'title_de'            => $request->title_de ?: "",
            'status'              => $request->status ? true : true,
        ]);

        $this->activityLogService->storeActivityLog('Created a New Cancellation Reason. Cancellation Reason Id# | ' . $cancellation_reasons->id, 3,
            'CancellationReasonsController@store', 'store');
        FlashNotification::success(__('master.success'), __('master.created_successfully'));
        return ActionJsonResponse::make(true, route('admin.cancellation_reasons.index', ['id' => $cancellation_reasons->id]))->response();

    }
    public function edit($id){

        if (! auth()->user()->hasPermission('cancellation_reasons.update')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'cancellation_reasons.update','Can not update Cancellation Reason');
            return view('admin.errors.unauthorized');
        }

        $cancellation_reason = Cancellation_Reasons::findOrFail($id);

        return view('admin.cancellation_reasons.show.edit')->with([
            'cancellation_reason' => $cancellation_reason,
        ]);
    }

    public function update(CancellationReasonsUpdateRequest $request, $id)
    {
        if (! auth()->user()->hasPermission('cancellation_reasons.update')) {
            $this->forbiddenLogService->storeForbiddenLog(
                request()->path(),
                'cancellation_reasons.update',
                'Can not update Cancellation Reason'
            );
        }

        $cancellation_reason = Cancellation_Reasons::findOrFail($id);

        $cancellation_reason->update([
            'title_en'                   => $request->title_en ?: "",
            'title_al'                  => $request->title_al ?: "",
            'title_it'                  => $request->title_it ?: "",
            'title_es'                  => $request->title_es ?: "",
            'title_fr'                  => $request->title_fr ?: "",
            'title_de'                  => $request->title_de ?: "",
            'status'                    => $request->status ? true : false,
        ]);

        $this->activityLogService->storeActivityLog(
            'Updated Cancellation Reason. Cancellation Reason Id# | ' . $cancellation_reason->id,
            3,
            'CancellationReasonsController@update',
            'update'
        );

        FlashNotification::success(__('master.success'), __('master.updated_successfully'));
        return ActionJsonResponse::make(true, route('admin.cancellation_reasons.show', ['id' => $cancellation_reason->id]))->response();
    }

    public function show($id)
    {
        if (! auth()->user()->hasPermission('cancellation_reasons.view_any')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'cancellation_reasons.view_any','Can not view a Cancellation Reason');
            return view('admin.errors.unauthorized');
        }

        $cancellation_reason=Cancellation_Reasons::findOrFail($id);

        return view('admin.cancellation_reasons.show.show')->with(['cancellation_reason'=>$cancellation_reason]);
    }

    public function delete(Request $request){

        if (! auth()->user()->hasPermission('cancellation_reasons.delete')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'cancellation_reasons.delete','Does not have permissions to delete Cancellation Reason');

            $data = [
                'status' => 2,
                'message' => 'You do not have access to delete Cancellation Reason'
            ];

            return $data;
        }

        try {
            DB::beginTransaction();

            Cancellation_reasons::where('id',$request['data']['delete_id'])->delete();

            DB::commit();

            $data = [
                'status' => 1,
                'message' => 'Cancellation Reason Deleted With success'
            ];
            $this->activityLogService->storeActivityLog('Deleted Cancellation Reason . Cancellation Reason Id# | '.$request['data']['delete_id'],1,'CancellationReasonsController@delete','delete');
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
            Cancellation_reasons::search(
                $request->get('keyword'),
                $request->get('id'),
            )->get()->append(['label'])
        );
    }
}
