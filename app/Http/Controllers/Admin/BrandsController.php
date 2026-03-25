<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandsStoreRequest;
use App\Http\Requests\Admin\BrandsUpdateRequest;
use App\Models\Admin\Brand;
use App\Services\ActivityLogService;
use App\Services\ForbiddenLogService;
use App\Support\ActionJsonResponse;
use App\Support\EmptyDatatable;
use App\Support\FlashNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BrandsController extends Controller
{
    protected $activityLogService;
    protected $forbiddenLogService;


    public function __construct(ActivityLogService $service,ForbiddenLogService $forbiddenLogService)
    {
        $this->activityLogService = $service;
        $this->forbiddenLogService = $forbiddenLogService;
    }

    public function index(Request $request)
    {
        $user = auth()->user();

        // Permission check
        if (! $user->hasPermission('brands.view_any') && ! $user->hasPermission('brands.company.view_any')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'brands.view_any', 'Cannot view all Brands');
            return view('admin.errors.unauthorized');
        }

        // AJAX DataTables request
        if ($request->ajax()) {
            try {
                $brands = Brand::query();

                if ($request->filled('title')) {
                    $brands->where('title', 'like', '%' . $request->title . '%');
                }

                return DataTables::eloquent($brands)
                    ->addIndexColumn()
                    ->editColumn('status', function (Brand $brand) {
                        return view('admin.brands.datatable.active', compact('brand'));
                    })
                    ->editColumn('icon', function (Brand $brand) {
                        return view('admin.brands.datatable.icon', compact('brand'));
                    })
                    ->addColumn('actions', 'admin.brands.datatable.actions')
                    ->rawColumns(['actions'])
                    ->make(true);

            } catch (Exception $e) {
                report($e);
                return EmptyDatatable::toJson();
            }
        }

        // Non-AJAX request: return the view
        $route = $user->isSystemAdmin()
            ? route('admin.brands.index')
            : route('company.brands.index');

        $view = $user->isSystemAdmin()
            ? 'admin.brands.index'
            : 'company.brands.index';

        return view($view, compact('route'));
    }


    public function create()
    {
        if (!auth()->user()->hasPermission('brands.store')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'brands.store', 'Can not create new Brand');
            return view('admin.errors.unauthorized');
        }

        return view('admin.brands.create');
    }


    public function store(BrandsStoreRequest $request)
    {
        if (!auth()->user()->hasPermission('brands.store')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'brands.store', 'Can not create new Brand');
        }

        $iconPath = null;
        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('Images/Brand', 'public');
        }

        $brand = Brand::create([
            'title'               => $request->title ?: "",
            'status'              => $request->status ? true : true,
            'icon'                => $iconPath,
        ]);

        $this->activityLogService->storeActivityLog('Created a new Brand. Brand Id# | ' . $brand->id, 3,
            'BrandsController@store', 'store');
        FlashNotification::success(__('master.success'), __('master.created_successfully'));
        return ActionJsonResponse::make(true, route('admin.brands.index', ['id' => $brand->id]))->response();
    }

    public function edit($id){

        if (! auth()->user()->hasPermission('brands.update')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'brands.update','Can not update Brand');
            return view('admin.errors.unauthorized');
        }

        $brand = Brand::findOrFail($id);

        return view('admin.brands.show.edit')->with([
            'brand' => $brand,
        ]);
    }

    public function update(BrandsUpdateRequest $request, $id)
    {
        if (! auth()->user()->hasPermission('brands.update')) {
            $this->forbiddenLogService->storeForbiddenLog(
                request()->path(),
                'brands.update',
                'Can not update Brand'
            );
        }

        $brand = Brand::findOrFail($id);

        $iconPath = $brand->icon;

        if($request->has('avatar_remove') && $request->avatar_remove == "1")
        {
            if($iconPath &&file_exists(storage_path('app/public/' . $iconPath)))
            {
            unlink(storage_path('app/public/' . $iconPath));
            }
            $iconPath = null;
        }

        if ($request->hasFile('icon')) {
            if ($iconPath && file_exists(storage_path('app/public/' . $iconPath))) {
                unlink(storage_path('app/public/' . $iconPath));
            }

            $iconPath = $request->file('icon')->store('Images/Brand', 'public');
        }

        $brand->update([
            'title'                     => $request->title ?: "",
            'status'                    => $request->status ? true : false,
            'icon'                      => $iconPath,
        ]);

        $this->activityLogService->storeActivityLog(
            'Updated Brand. Brand Id# | ' . $brand->id,
            3,
            'BrandsController@update',
            'update'
        );

        FlashNotification::success(__('master.success'), __('master.updated_successfully'));
        return ActionJsonResponse::make(true, route('admin.brands.show', ['id' => $brand->id]))->response();
    }


    public function show($id){

        if (! auth()->user()->hasPermission('brands.view_any')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'brands.view_any','Can not view all Brands');
            return view('admin.errors.unauthorized');
        }

        $brand = Brand::findOrFail($id);

        return view('admin.brands.show.show')->with([
            'brand'  =>$brand
        ]);
    }


    public function delete(Request $request){

        if (! auth()->user()->hasPermission('brands.delete')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'brands.delete','Does not have permissions to delete Brand');

            $data = [
                'status' => 2,
                'message' => 'You do not have access to delete Brand'
            ];

            return $data;
        }

        try {
            DB::beginTransaction();

            Brand::where('id',$request['data']['delete_id'])->delete();

            DB::commit();

            $data = [
                'status' => 1,
                'message' => 'Brand Deleted With success'
            ];
            $this->activityLogService->storeActivityLog('Deleted Brand . Brand Id# | '.$request['data']['delete_id'],1,'BrandsController@delete','delete');
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
            Brand::search(
                $request->get('keyword'),
                $request->get('id'),
            )->get()->append(['label'])
        );
    }
}
