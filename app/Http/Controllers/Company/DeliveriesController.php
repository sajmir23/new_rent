<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\DeliveriesStoreRequest;
use App\Http\Requests\Company\DeliveriesUpdateRequest;
use App\Models\Company\Delivery;
use App\Services\ActivityLogService;
use App\Services\ForbiddenLogService;
use App\Support\ActionJsonResponse;
use App\Support\EmptyDatatable;
use App\Support\FlashNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class DeliveriesController extends Controller
{
    protected $activityLogService;
    protected $forbiddenLogService;


    public function __construct(ActivityLogService $service,ForbiddenLogService $forbiddenLogService)
    {
        $this->activityLogService = $service;
        $this->forbiddenLogService = $forbiddenLogService;
    }

    /**
     * Display a listing of the company's deliveries.
     *
     * Handles AJAX requests for DataTables filtering and returns the index view for non-AJAX requests.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */

    public function index(Request $request){

        if (! auth()->user()->hasPermission('deliveries.view_any')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'deliveries.view_any','Can not view all deliveries');
            return view('admin.errors.unauthorized');
        }


        if ($request->ajax()) {

            try {
                $deliveries = Delivery::where('company_id', auth()->user()->company_id);


                return DataTables::eloquent($deliveries)
                    ->addIndexColumn()
                    ->editColumn('city_id',function (Delivery $delivery){
                        return view('company.deliveries.datatable.city',compact('delivery'));
                    })
                    ->editColumn('price',function (Delivery $delivery){
                        return view('company.deliveries.datatable.price',compact('delivery'));
                    })
                    ->editColumn('city_id',function (Delivery $delivery){
                        return view('company.deliveries.datatable.city',compact('delivery'));
                    })
                    ->addColumn('actions', 'company.deliveries.datatable.actions')
                    ->rawColumns(['actions'])
                    ->make(true);

            }catch (Exception $e) {
                report($e);
                return EmptyDatatable::toJson();
            }
        }

        return view('company.deliveries.index');
    }

    /**
     * Show the form for creating a new delivery.
     *
     * @return \Illuminate\View\View
     */

    public function create()
    {
        if (!auth()->user()->hasPermission('deliveries.store')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'deliveries.store', 'Can not create new deliveries');
            return view('admin.errors.unauthorized');
        }
        return view('company.deliveries.create');
    }

    /**
     * Store a newly created delivery in storage.
     *
     * @param \App\Http\Requests\DeliveriesStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(DeliveriesStoreRequest $request)
    {
        if (!auth()->user()->hasPermission('deliveries.store'))
        {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'deliveries.store', 'Can not create new Delivery');
            return view('admin.errors.unauthorized');
        }

        $delivery = Delivery::create([
            'company_id'              =>auth()->user()->company_id,
            'city_id'                 => $request->city_id ?: null,
            'place'                   => $request->place ?: "",
            'price'                   => $request->price ?: 0,
            'delivery_time'           => $request->delivery_time ?: null,
        ]);

        $this->activityLogService->storeActivityLog('Created a new Delivery. Delivery Id# | ' . $delivery->id, 3,
            'deliveriesController@store', 'store');
        FlashNotification::success(__('master.success'), __('master.created_successfully'));
        return ActionJsonResponse::make(true, route('company.deliveries.index', ['id' => $delivery->id]))->response();
    }

    /**
     * Show the form for editing the specified delivery.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */

    public function edit($id)
    {

        if (! auth()->user()->hasPermission('deliveries.update')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'deliveries.update','Can not update Delivery');
            return view('admin.errors.unauthorized');
        }

        $delivery = Delivery::where('id', $id)
            ->where('company_id',auth()->user()->company_id)->firstOrFail();

        return view('company.deliveries.show.edit')->with([
            'delivery' => $delivery,
        ]);
    }

    /**
     * Update the specified delivery in storage.
     *
     * @param \App\Http\Requests\DeliveriesUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(DeliveriesUpdateRequest $request,$id)
    {
        if (! auth()->user()->hasPermission('deliveries.update')) {
            $this->forbiddenLogService->storeForbiddenLog(
                request()->path(),
                'deliveries.update',
                'Can not update Delivery'
            );
        }
        $delivery = Delivery::where('id',$id)
            ->where('company_id',auth()->user()->company_id)->firstOrFail();

        $delivery->update([
            'company_id'              =>auth()->user()->company_id,
            'city_id'                 => $request->city_id ?: null,
            'place'                   => $request->place ?: "",
            'price'                   => $request->price ?: 0,
            'delivery_time'           => $request->delivery_time ?: null,
        ]);

        $this->activityLogService->storeActivityLog(
            'Updated Delivery. Delivery Id# | ' . $delivery->id,
            3,
            'DeliveriesController@update',
            'update'
        );

        FlashNotification::success(__('master.success'), __('master.updated_successfully'));
        return ActionJsonResponse::make(true, route('company.deliveries.show', ['id' => $delivery->id]))->response();
    }

    /**
     * Display the specified delivery details.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */

    public function show($id){

        if (! auth()->user()->hasPermission('deliveries.view_any')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'deliveries.view_any','Can not view all deliveries');
            return view('admin.errors.unauthorized');
        }

        $delivery = Delivery::where('id',$id)
            ->where('company_id',auth()->user()->company_id)->firstOrFail();

        return view('company.deliveries.show.show')->with([
            'delivery'  =>$delivery,
        ]);
    }

    /**
     * Delete the specified delivery.
     *
     * Handles permission checks and returns a JSON array with success or error messages.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */

    public function delete(Request $request){

        if (! auth()->user()->hasPermission('deliveries.delete')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'deliveries.delete','Does not have permissions to delete delivery');

            $data = [
                'status' => 2,
                'message' => 'You do not have access to delete Delivery',
            ];

            return $data;
        }

        try {
            DB::beginTransaction();

            Delivery::where('id',$request['data']['delete_id'])->delete();

            DB::commit();

            $data = [
                'status' => 1,
                'message' => 'Delivery Deleted With success'
            ];
            $this->activityLogService->storeActivityLog('Deleted Delivery . Delivery Id# | '.$request['data']['delete_id'],1,'DeliveriesController@delete','delete');
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

    /**
     * Search for deliveries by keyword or ID.
     *
     * Returns a JSON array of matching deliveries with appended label accessor.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function search(Request $request){

        return response()->json(
            Delivery::search(
                $request->get('keyword'),
                $request->get('id'),
            )->get()->append(['label'])
        );
    }
}
