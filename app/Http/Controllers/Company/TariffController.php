<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\SeasonalPricesStoreRequest;
use App\Http\Requests\Company\SeasonalPricesUpdateRequest;
use App\Http\Requests\Company\TariffStoreRequest;
use App\Http\Requests\Company\TariffUpdateRequest;
use App\Models\Company\SeasonalPrice;
use App\Models\Company\Tariff;
use App\Services\ActivityLogService;
use App\Services\ForbiddenLogService;
use App\Support\ActionJsonResponse;
use App\Support\EmptyDatatable;
use App\Support\FlashNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TariffController extends Controller
{
    protected $activityLogService;
    protected $forbiddenLogService;

    public function __construct(ActivityLogService $activityLogService, ForbiddenLogService $forbiddenLogService)
    {
        $this->activityLogService = $activityLogService;
        $this->forbiddenLogService = $forbiddenLogService;
    }

    /**
     * Display a list of tariffs for the company.
     * Supports AJAX for DataTables.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */

    public function index(Request $request){

        if (! auth()->user()->hasPermission('tariffs.view_any')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'tariffs.view_any','Can not view all tariffs');
            return view('company.errors.unauthorized');
        }


        if ($request->ajax()) {
            try {
                $tariff = Tariff::where('company_id', auth()->user()->company_id);

                return DataTables::eloquent($tariff)
                    ->addIndexColumn()
                    ->addColumn('actions', 'company.tariff.datatable.actions')
                    ->rawColumns(['actions'])
                    ->make(true);

            } catch (Exception $e) {
                report($e);
                return EmptyDatatable::toJson();
            }
        }


        return view('company.tariff.index');
    }

    /**
     * Show form to create a new tariff.
     *
     * @return \Illuminate\View\View
     */

    public function create()
    {
        if (!auth()->user()->hasPermission('tariffs.store')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'tariffs.store', 'Can not create new tariffs');
            return view('company.errors.unauthorized');
        }
        return view('company.tariff.create');
    }

    /**
     * Store a new tariff.
     *
     * @param \App\Http\Requests\TariffStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(TariffStoreRequest $request)
    {
        if (!auth()->user()->hasPermission('tariffs.store'))
        {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'tariffs.store', 'Can not create new tariffs');
            return view('company.errors.unauthorized');
        }

        $tariffs = Tariff::create([
            'company_id'            => auth()->user()->company_id,
            'min_days'            => $request->min_days ? : null,
            'max_days'              => $request->max_days ? : null,
            'rate_multiplier'       => $request->rate_multiplier ?? null,
        ]);

        $this->activityLogService->storeActivityLog('Created a new Tariffs. Tariff Id# | ' . $tariffs->id, 3,
            'TariffController@store', 'store');
        FlashNotification::success(__('master.success'), __('master.created_successfully'));
        return ActionJsonResponse::make(true, route('company.tariff.index', ['id' => $tariffs->id]))->response();
    }

    /**
     * Show form to edit an existing tariff.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */

    public function edit($id)
    {

        if (! auth()->user()->hasPermission('tariffs.update')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'tariffs.update','Can not update Tariff');
            return view('company.errors.unauthorized');
        }

        $tariff = Tariff::where('id', $id)
            ->where('company_id',auth()->user()->company_id)->firstOrFail();

        return view('company.tariff.show.edit')->with([
            'tariff' => $tariff,
        ]);
    }

    /**
     * Update an existing tariff.
     *
     * @param \App\Http\Requests\TariffUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(TariffUpdateRequest $request,$id)
    {
        if (! auth()->user()->hasPermission('tariffs.update')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path(),'tariffs.update', 'Can not update tariffs');
            return view('company.errors.unauthorized');
        }
        $tariff= Tariff::where('id',$id)
            ->where('company_id',auth()->user()->company_id)->firstOrFail();

        $tariff->update([
            'company_id'      => auth()->user()->company_id,
            'min_days'      => $request->min_days ??  null,
            'max_days'        => $request->max_days ?? null,
            'rate_multiplier' => $request->rate_multiplier ?: null,
        ]);

        $this->activityLogService->storeActivityLog(
            'Updated Tariffs. Tariff Id# | ' . $tariff->id,
            3,
            'TariffController@update',
            'update'
        );

        FlashNotification::success(__('master.success'), __('master.updated_successfully'));
        return ActionJsonResponse::make(true, route('company.tariff.index'))->response();
    }

    /**
     * Delete a tariff.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */

    public function delete(Request $request){

        if (! auth()->user()->hasPermission('tariffs.delete')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'tariffs.delete','Does not have permissions to delete Tariff');

            $data = [
                'status' => 2,
                'message' => 'You do not have access to delete Tariff'
            ];

            return $data;
        }

        try {
            DB::beginTransaction();

            Tariff::where('id',$request['data']['delete_id'])->delete();

            DB::commit();

            $data = [
                'status' => 1,
                'message' => 'Tariff Deleted With success'
            ];
            $this->activityLogService->storeActivityLog('Deleted Tariff . Tariff Id# | '.$request['data']['delete_id'],1,'TariffController@delete','delete');
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
     * Search tariffs by keyword or ID.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function search(Request $request){

        return response()->json(
            Tariff::search(
                $request->get('keyword'),
                $request->get('id'),
            )->get()->append(['label'])
        );
    }
}
