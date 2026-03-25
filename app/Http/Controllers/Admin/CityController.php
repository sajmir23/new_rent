<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\City;
use App\Services\ActivityLogService;
use App\Services\ForbiddenLogService;
use App\Support\EmptyDatatable;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CityController extends Controller
{
    protected $activityLogService;
    protected $forbiddenLogService;

    public function __construct(ActivityLogService $activityLogService,ForbiddenLogService $forbiddenLogService)
    {
        $this->activityLogService = $activityLogService;
        $this->forbiddenLogService = $forbiddenLogService;
    }
    public function index()
    {
        if (!auth()->user()->hasPermission('city.view_any')
        ) {$this->forbiddenLogService->storeForbiddenLog(request()->path(), 'city.view_any', 'Cannot view all cities');
            return view('admin.errors.unauthorized');
        }


        if(request()->ajax())
        {
            try
            {
                $city=City::query();

                return DataTables::eloquent($city)
                    ->addIndexColumn()
                    ->editColumn('name', function (City $city) {
                    return view('admin.city.datatable.name', compact('city'));
                })
                    ->make(true);
            }
            catch (\Exception $e)
            {
                report($e);
                return EmptyDatatable::toJson();

            }
        }
        return view ('admin.city.index');
    }

    public function search(Request $request){

        return response()->json(
            City::search(
                $request->get('keyword'),
                $request->get('id'),
            )->get()->append(['label'])
        );
    }
}
