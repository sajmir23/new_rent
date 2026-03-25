<?php

namespace App\Http\Controllers\Company;

use App\Enums\UserTypesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\InsurancesStoreRequest;
use App\Http\Requests\Company\InsurancesUpdateRequest;
use App\Models\Admin\FuelTypes;
use App\Models\Company\Insurance;
use App\Models\User;
use App\Services\ActivityLogService;
use App\Services\ForbiddenLogService;
use App\Support\ActionJsonResponse;
use App\Support\EmptyDatatable;
use App\Support\FlashNotification;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;



class InsuranceController extends Controller
{
    protected $activityLogService;
    protected $forbiddenLogService;

    public function __construct(ActivityLogService $activityLogService,ForbiddenLogService $forbiddenLogService)
    {
        $this->activityLogService = $activityLogService;
        $this->forbiddenLogService = $forbiddenLogService;
    }

    /**
     * Display a listing of the company's insurances.
     *
     * Handles AJAX requests for datatable filtering and returns the view for non-AJAX requests.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */

    public function index(Request $request)
    {
        if (!auth()->user()->hasPermission('insurances.view_any'))
        {
        $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'insurances.view_any', 'Cannot view company info');
        return view('company.errors.unauthorized');
       }

        if ($request->ajax()) {
            try {

                $insurance = Insurance::query()->where('company_id',auth()->user()->company_id);

                if ($request->filled('title')) {
                    $insurance->where("title", 'like', '%' . $request->title . '%');
                }

                return DataTables::eloquent($insurance)
                    ->addIndexColumn()
                    ->editColumn('has_theft_protection', function (Insurance $insurance) {
                        return view('company.insurances.datatable.theft_protection', compact('insurance'));
                    })
                    ->editColumn('has_deposit', function (Insurance $insurance) {
                        return view('company.insurances.datatable.deposit', compact('insurance'));
                    })
                    ->addColumn('actions', 'company.insurances.datatable.actions')
                    ->rawColumns(['actions'])
                    ->make(true);

            } catch (Exception $e) {
                report($e);
                return EmptyDatatable::toJson();
            }
        }
            return view('company.insurances.index');
    }

    /**
     * Show the form for creating a new insurance.
     *
     * @return \Illuminate\View\View
     */

    public function create()
    {
        if (!auth()->user()->hasPermission('insurances.store'))
        {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'insurances.store', 'Cannot view insurance info');
            return view('company.errors.unauthorized');
        }

        return view('company.insurances.create');
    }

    /**
     * Store a newly created insurance in storage.
     *
     * @param \App\Http\Requests\InsurancesStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(InsurancesStoreRequest $request)
    {
        if (!auth()->user()->hasPermission('insurances.store')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'insurances.store', 'Cannot view insurance info');
            return view('company.errors.unauthorized');
        }

        $company_id = auth()->user()->company_id;

        $insurance = Insurance::create([
            'company_id'            => $company_id ?? "",
            'title_en'              => $request->title_en ?? "",
            'title_it'              => $request->title_it ?? "",
            'title_al'              => $request->title_al ?? "",
            'title_es'              => $request->title_es ?? "",
            'title_fr'              => $request->title_fr ?? "",
            'title_de'              => $request->title_de ?? "",
            'description_en'        => $request->description_en ?? "",
            'description_it'        => $request->description_it ?? "",
            'description_al'        => $request->description_al ?? "",
            'description_es'        => $request->description_es ?? "",
            'description_de'        => $request->description_de ?? "",
            'description_fr'        => $request->description_fr ?? "",
            'price_per_day'         => $request->price_per_day ?? 0,
            'deposit_price'         => $request->deposit_price ?? 0,
            'theft_protection_price'=> $request->theft_protection_price ?? 0,
            'has_deposit'           => $request->has_deposit ? true : false,
            'has_theft_protection'  => $request->has_theft_protection ? true : false,
        ]);

        $this->activityLogService->storeActivityLog('Created a new insurance. Insurance Id# | ' . $insurance->id, 3,
            'InsuranceController@store', 'store');

        FlashNotification::success(__('master.success'), __('master.created_successfully'));

        return ActionJsonResponse::make(true, route('company.insurances.index', ['id' => $insurance->id]))->response();
    }

    /**
     * Display the specified insurance details.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */

    public function show($id)
    {
        if (!auth()->user()->hasPermission('insurances.view_any'))
        {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'insurances.view_any', 'Cannot view insurance info');
            return view('company.errors.unauthorized');
        }

        $insurance=Insurance::findOrFail($id);

        return view('company.insurances.show.show')->with(['insurance'=>$insurance]);

    }

    /**
     * Show the form for editing the specified insurance.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */

    public function edit($id)
    {
        if (!auth()->user()->hasPermission('insurances.update'))
        {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'insurances.update', 'Cannot view insurance info');
            return view('company.errors.unauthorized');
        }

        $insurance=Insurance::findOrFail($id);
        return view('company.insurances.show.edit')->with(['insurance'=>$insurance]);
    }

    /**
     * Update the specified insurance in storage.
     *
     * @param \App\Http\Requests\InsurancesUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(InsurancesUpdateRequest $request, $id)
    {
        if (!auth()->user()->hasPermission('insurances.update'))
        {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'insurances.update', 'Cannot view insurance info');
            return view('company.errors.unauthorized');
        }

        $insurance = Insurance::findOrFail($id);

        $company_id =auth()->user()->company_id;

        $insurance->update([
            'company_id'             => $company_id ?? null,
            'title_en'               => $request->title_en ?? "",
            'title_it'               => $request->title_it ?? "",
            'title_al'               => $request->title_al ?? "",
            'title_es'               => $request->title_es ?? "",
            'title_fr'               => $request->title_fr ?? "",
            'title_de'               => $request->title_de ?? "",
            'description_en'         => $request->description_en ?? "",
            'description_it'         => $request->description_it ?? "",
            'description_al'         => $request->description_al ?? "",
            'description_es'         => $request->description_es ?? "",
            'description_de'         => $request->description_de ?? "",
            'description_fr'         => $request->description_fr ?? "",
            'price_per_day'          => $request->price_per_day ?? 0,
            'has_deposit'            => $request->has_deposit ? true : false,
            'deposit_price'          => $request->has_deposit ? ($request->deposit_price ?? 0) : 0,
            'has_theft_protection'   => $request->has_theft_protection ? true : false,
            'theft_protection_price' => $request->has_theft_protection ? ($request->theft_protection_price ?? 0) : 0,
        ]);


        $this->activityLogService->storeActivityLog('Updated Insurance. Insurance Id# | ' . $insurance->id, 3, 'InsuranceController@update',
            'update');
        FlashNotification::success(__('master.success'), __('master.updated_successfully'));
        return ActionJsonResponse::make(true, route('company.insurances.show', ['id' => $insurance->id]))->response();
    }

    /**
     * Delete the specified insurance.
     *
     * Handles permission checks and returns a JSON array with success or error message.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */

    public function delete(Request $request){

        if (! auth()->user()->hasPermission('insurances.delete')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'insurances.delete','Does not have permissions to delete Fuel Type');

            $data = [
                'status' => 2,
                'message' => 'You do not have access to delete Insurance'
            ];

            return $data;
        }

        try {
            DB::beginTransaction();

            Insurance::where('id',$request['data']['delete_id'])->delete();

            DB::commit();

            $data = [
                'status' => 1,
                'message' => 'Insurance Deleted With success'
            ];
            $this->activityLogService->storeActivityLog('Deleted Insurance . Insurance Id# | '.$request['data']['delete_id'],1,'InsuranceController@delete','delete');
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
     * Search for insurances by keyword or ID.
     *
     * Returns a JSON array of matching insurances with appended label accessor.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function search(Request $request){

        return response()->json(
            Insurance::search(
                $request->get('keyword'),
                $request->get('id'),
            )->get()->append(['label'])
        );
    }
}
