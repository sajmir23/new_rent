<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\AdditionalServiceStoreRequest;
use App\Http\Requests\Company\AdditionalServiceUpdateRequest;
use App\Models\Company\AdditionalService;
use App\Services\ActivityLogService;
use App\Services\ForbiddenLogService;
use App\Support\ActionJsonResponse;
use App\Support\EmptyDatatable;
use App\Support\FlashNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AdditionalServicesController extends Controller
{
    protected $activityLogService;
    protected $forbiddenLogService;


    public function __construct(ActivityLogService $service,ForbiddenLogService $forbiddenLogService)
    {
        $this->activityLogService = $service;
        $this->forbiddenLogService = $forbiddenLogService;
    }

    /**
     * Display a listing of the company's additional services.
     *
     * Handles AJAX requests for datatable filtering and returns the view for non-AJAX requests.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */

    public function index(Request $request){

        if (!auth()->user()->hasPermission('additional_services.view_any')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'additional_services.view_any', 'Can not view any Additional Service');
            return view('admin.errors.unauthorized');
        }

        if ($request->ajax()) {

            try {
                $additional_service = AdditionalService::query()->where('company_id',auth()->user()->company_id);

                if ($request->filled('title')) {
                    $additional_service->where("title_en", 'like', '%' . $request->title . '%');
                }

                return DataTables::eloquent($additional_service)
                    ->addIndexColumn()
                    ->editColumn('status',function (AdditionalService $additional_service){
                        return view('company.additional_services.datatable.active',compact('additional_service'));
                    })
                    ->editColumn('service_price',function (AdditionalService $additional_service){
                        return view('company.additional_services.datatable.price',compact('additional_service'));
                    })
                    ->addColumn('actions', 'company.additional_services.datatable.actions')
                    ->rawColumns(['actions'])
                    ->make(true);

            }catch (Exception $e) {
                report($e);
                return EmptyDatatable::toJson();
            }
        }

        return view('company.additional_services.index');


    }

    /**
     * Show the form for creating a new additional service.
     *
     * @return \Illuminate\View\View
     */

    public function create()
    {
        if (!auth()->user()->hasPermission('additional_services.store')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'additional_services.store', 'Can not create new Additional Service');
            return view('admin.errors.unauthorized');
        }

        return view('company.additional_services.create');
    }

    /**
     * Store a newly created additional service in storage.
     *
     * @param \App\Http\Requests\AdditionalServiceStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(AdditionalServiceStoreRequest $request)
    {
        if (!auth()->user()->hasPermission('additional_services.store')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'additional_services.store', 'Can not create new Additional Service');
        }
        $company_id = auth()->user()->company_id;

        $additional_service = AdditionalService::create([
            'company_id'                => $company_id ?? null,
            'title_en'                  => $request->title_en ?: "",
            'title_it'                  => $request->title_it ?: "",
            'title_al'                  => $request->title_al ?: "",
            'title_es'                  => $request->title_es ?: "",
            'title_fr'                  => $request->title_fr ?: "",
            'title_de'                  => $request->title_de ?: "",
            'description_en'            => $request->description_en ?: "",
            'description_it'            => $request->description_it ?: "",
            'description_al'            => $request->description_al ?: "",
            'description_es'            => $request->description_es ?: "",
            'description_fr'            => $request->description_fr ?: "",
            'description_de'            => $request->description_de ?: "",
            'service_price'             => $request->service_price ?: "",
            'status'                    => $request->status ? true : true,
        ]);

        $this->activityLogService->storeActivityLog('Created a new Additional Service. Additional Service Id# | ' . $additional_service->id, 3,
            'AdditionalServicesController@store', 'store');
        FlashNotification::success(__('master.success'), __('master.created_successfully'));
        return ActionJsonResponse::make(true, route('company.additional_services.index', ['id' => $additional_service->id]))->response();
    }

    /**
     * Show the form for editing the specified additional service.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */

    public function edit($id){

        if (! auth()->user()->hasPermission('additional_services.update')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'additional_services.update','Can not update Additional Service');
            return view('admin.errors.unauthorized');
        }

        $additional_service = AdditionalService::findOrFail($id);

        return view('company.additional_services.show.edit')->with([
            'additional_service' => $additional_service,
        ]);
    }

    /**
     * Update the specified additional service in storage.
     *
     * @param \App\Http\Requests\AdditionalServiceUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(AdditionalServiceUpdateRequest $request, $id)
    {
        if (! auth()->user()->hasPermission('additional_services.update')) {
            $this->forbiddenLogService->storeForbiddenLog(
                request()->path(),
                'additional_services.update',
                'Can not update Additional Service'
            );
        }

        $additional_service = AdditionalService::findOrFail($id);

        $company_id = auth()->user()->company_id;

        $additional_service->update([
            'company_id'                => $company_id ?? null,
            'title_en'                  => $request->title_en ?: "",
            'title_it'                  => $request->title_it ?: "",
            'title_al'                  => $request->title_al ?: "",
            'title_es'                  => $request->title_es ?: "",
            'title_fr'                  => $request->title_fr ?: "",
            'title_de'                  => $request->title_de ?: "",
            'description_en'            => $request->description_en ?: "",
            'description_it'            => $request->description_it ?: "",
            'description_al'            => $request->description_al ?: "",
            'description_es'            => $request->description_es ?: "",
            'description_fr'            => $request->description_fr ?: "",
            'description_de'            => $request->description_de ?: "",
            'service_quantity'          => $request->service_quantity ?: "",
            'service_price'             => $request->service_price ?: "",
            'status'                    => $request->status ? true : false,
        ]);

        $this->activityLogService->storeActivityLog(
            'Updated Additional Service. Additional Service Id# | ' . $additional_service->id,
            3,
            'AdditionalServicesController@update',
            'update'
        );

        FlashNotification::success(__('master.success'), __('master.updated_successfully'));
        return ActionJsonResponse::make(true, route('company.additional_services.show', ['id' => $additional_service->id]))->response();
    }

    /**
     * Display the specified additional service details.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */

    public function show($id){

        if (! auth()->user()->hasPermission('additional_services.view_any')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'additional_services.view_any','Can not view all Additional Services');
            return view('admin.errors.unauthorized');
        }

        $additional_service = AdditionalService::findOrFail($id);

        return view('company.additional_services.show.show')->with([
            'additional_service'  =>$additional_service
        ]);
    }

    /**
     * Delete the specified additional service.
     *
     * Handles permission checks and returns JSON data with success or error message.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */

    public function delete(Request $request){

        if (! auth()->user()->hasPermission('additional_services.delete')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'additional_services.delete','Does not have permissions to delete Additional Service');

            $data = [
                'status' => 2,
                'message' => 'You do not have access to delete Additional Service'
            ];

            return $data;
        }

        try {
            DB::beginTransaction();

            AdditionalService::where('id',$request['data']['delete_id'])->delete();

            DB::commit();

            $data = [
                'status' => 1,
                'message' => 'Additional Service Deleted With success'
            ];
            $this->activityLogService->storeActivityLog('Deleted Additional Service . Additional Service Id# | '.$request['data']['delete_id'],1,'AdditionalServicesController@delete','delete');
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
     * Search for additional services by keyword or ID.
     *
     * Returns a JSON array of matching services with id, label, and price.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function search(Request $request)
    {
        $results = AdditionalService::search(
            $request->get('keyword'),
            $request->get('id'),
        )->get();

        return response()->json(
            $results->map(function ($service) {
                return [
                    'id'    => $service->id,
                    'label' => $service->label, // from the appended accessor
                    'price' => $service->service_price ?? 0,
                ];
            })
        );
    }

}
