<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\SeasonalPricesStoreRequest;
use App\Http\Requests\Company\SeasonalPricesUpdateRequest;
use App\Models\Company\SeasonalPrice;
use App\Services\ActivityLogService;
use App\Services\ForbiddenLogService;
use App\Support\ActionJsonResponse;
use App\Support\EmptyDatatable;
use App\Support\FlashNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SeasonalPricesController extends Controller
{
    protected $activityLogService;
    protected $forbiddenLogService;


    public function __construct(ActivityLogService $service,ForbiddenLogService $forbiddenLogService)
    {
        $this->activityLogService = $service;
        $this->forbiddenLogService = $forbiddenLogService;
    }

    /**
     * Display a list of seasonal prices for the company.
     * Supports AJAX for DataTables.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */

    public function index(Request $request){

        if (! auth()->user()->hasPermission('seasonal_prices.view_any')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'seasonal_prices.view_any','Can not view all seasonal prices');
            return view('admin.errors.unauthorized');
        }


        if ($request->ajax()) {
            try {
                $seasonal_price = SeasonalPrice::where('company_id', auth()->user()->company_id);

                return DataTables::eloquent($seasonal_price)
                    ->addIndexColumn()
                    ->addColumn('start_date', function ($row) {
                        return $row->start_date
                            ? \Carbon\Carbon::parse($row->start_date)->format('d-m-Y')
                            : '';
                    })
                    ->addColumn('end_date', function ($row) {
                        return $row->end_date
                            ? \Carbon\Carbon::parse($row->end_date)->format('d-m-Y')
                            : '';
                    })
                    ->addColumn('actions', 'company.seasonal_prices.datatable.actions')
                    ->rawColumns(['actions'])
                    ->make(true);

            } catch (Exception $e) {
                report($e);
                return EmptyDatatable::toJson();
            }
        }


        return view('company.seasonal_prices.index');
    }

    /**
     * Redirect to seasonal prices index with the selected seasonal price.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function show($id)
    {
        $seasonal_price=SeasonalPrice::where('id',$id)->where('company_id',auth()->user()->company_id)->firstOrFail();
        return redirect()->route('company.seasonal_prices.index')->with([
            'seasonal_price' => $seasonal_price
        ]);
    }

    /**
     * Show form to create a new seasonal price.
     *
     * @return \Illuminate\View\View
     */

    public function create()
    {
        if (!auth()->user()->hasPermission('seasonal_prices.store')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'seasonal_prices.store', 'Can not create new seasonal price');
            return view('admin.errors.unauthorized');
        }
        return view('company.seasonal_prices.create');
    }

    /**
     * Store a new seasonal price.
     *
     * @param \App\Http\Requests\SeasonalPricesStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(SeasonalPricesStoreRequest $request)
    {
        if (!auth()->user()->hasPermission('seasonal_prices.store'))
        {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'seasonal_prices.store', 'Can not create new seasonal prices');
            return view('admin.errors.unauthorized');
        }

        $seasonal_price = SeasonalPrice::create([
            'company_id'            => auth()->user()->company_id,
            'start_date'            => $request->start_date ? \Carbon\Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d') : null,
            'end_date'              => $request->end_date ? \Carbon\Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d') : null,
            'rate_multiplier'       => $request->rate_multiplier ?? null,
        ]);

        $this->activityLogService->storeActivityLog('Created a new Seasonal Price. Seasonal Price Id# | ' . $seasonal_price->id, 3,
            'SeasonalPricesController@store', 'store');
        FlashNotification::success(__('master.success'), __('master.created_successfully'));
        return ActionJsonResponse::make(true, route('company.seasonal_prices.index', ['id' => $seasonal_price->id]))->response();
    }

    /**
     * Show form to edit an existing seasonal price.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */

    public function edit($id)
    {

        if (! auth()->user()->hasPermission('seasonal_prices.update')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'seasonal_prices.update','Can not update Seasonal Price');
            return view('admin.errors.unauthorized');
        }

        $seasonal_price = SeasonalPrice::where('id', $id)
            ->where('company_id',auth()->user()->company_id)->firstOrFail();

        return view('company.seasonal_prices.show.edit')->with([
            'seasonal_price' => $seasonal_price,
        ]);
    }

    /**
     * Update a seasonal price.
     *
     * @param \App\Http\Requests\SeasonalPricesUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(SeasonalPricesUpdateRequest $request,$id)
    {
        if (! auth()->user()->hasPermission('seasonal_prices.update')) {
            $this->forbiddenLogService->storeForbiddenLog(
                request()->path(),
                'seasonal_prices.update',
                'Can not update Seasonal Price'
            );
        }
        $seasonal_price= SeasonalPrice::where('id',$id)
            ->where('company_id',auth()->user()->company_id)->firstOrFail();

        $seasonal_price->update([
            'company_id'      => auth()->user()->company_id,
            'start_date'      => $request->start_date ? \Carbon\Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d') : null,
            'end_date'        => $request->end_date ? \Carbon\Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d') : null,
            'rate_multiplier' => $request->rate_multiplier ?: null,
        ]);

        $this->activityLogService->storeActivityLog(
            'Updated Seasonal Price. Seasonal Price Id# | ' . $seasonal_price->id,
            3,
            'SeasonalPricesController@update',
            'update'
        );

        FlashNotification::success(__('master.success'), __('master.updated_successfully'));
        return ActionJsonResponse::make(true, route('company.seasonal_prices.index'))->response();
    }

    /**
     * Delete a seasonal price.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */

    public function delete(Request $request){

        if (! auth()->user()->hasPermission('seasonal_prices.delete')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'seasonal_prices.delete','Does not have permissions to delete Seasonal Price');

            $data = [
                'status' => 2,
                'message' => 'You do not have access to delete Seasonal Price'
            ];

            return $data;
        }

        try {
            DB::beginTransaction();

            SeasonalPrice::where('id',$request['data']['delete_id'])->delete();

            DB::commit();

            $data = [
                'status' => 1,
                'message' => 'Seasonal Price Deleted With success'
            ];
            $this->activityLogService->storeActivityLog('Deleted Seasonal Price . Seasonal Price Id# | '.$request['data']['delete_id'],1,'SeasonalPricesController@delete','delete');
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
     * Search seasonal prices by keyword or ID.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function search(Request $request){

        return response()->json(
            SeasonalPrice::search(
                $request->get('keyword'),
                $request->get('id'),
            )->get()->append(['label'])
        );
    }
}
