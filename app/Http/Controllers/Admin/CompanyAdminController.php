<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserTypesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CompanyAdminStoreRequest;
use App\Http\Requests\Admin\CompanyAdminUpdateRequest;
use App\Http\Requests\Admin\StaffStoreRequest;
use App\Http\Requests\Admin\StaffUpdateRequest;
use App\Models\Admin\Company;
use App\Models\User;
use App\Services\ActivityLogService;
use App\Services\ForbiddenLogService;
use App\Support\ActionJsonResponse;
use App\Support\EmptyDatatable;
use App\Support\FlashNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class CompanyAdminController extends Controller
{
    public function __construct(ActivityLogService $service,ForbiddenLogService $forbiddenLogService)
    {
        $this->activityLogService = $service;
        $this->forbiddenLogService = $forbiddenLogService;
    }

    /**
     * Display a listing of company admins.
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */

    public function index(Request $request){

        if (! auth()->user()->hasPermission('company_admin.view_any')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'company_admin.view_any','Can not view all company admin list');
            return view('admin.errors.unauthorized');
        }


        if ($request->ajax()) {

            try {
                $company_admin = User::with('company')
                    ->where('user_type', UserTypesEnum::COMPANY_ADMIN);

                if ($request->filled('first_name')) {
                    $company_admin->where("first_name", 'like', '%' . $request->first_name . '%');
                }
                if ($request->filled('last_name')) {
                    $company_admin->where("last_name", 'like', '%' . $request->last_name . '%');
                }
                if ($request->filled('email')) {
                    $company_admin->where("email", 'like', '%' . $request->email . '%');
                }
                if ($request->filled('phone')) {
                    $company_admin->where("phone_number", 'like', '%' . $request->phone . '%');
                }
                if ($request->filled('company')) {
                    $company_admin->whereHas('company', function ($query) use ($request) {
                        $query->where("name", "like", "%" . $request->company . "%");
                    });
                }

                return DataTables::eloquent($company_admin)
                    ->addIndexColumn()
                    ->editColumn('status',function (User $company_admin){
                        return view('admin.company_admin.datatable.active',compact('company_admin'));
                    })
                    ->addColumn('full_name',function (User $company_admin){
                        return view('admin.company_admin.datatable.name',compact('company_admin'));
                    })
                    ->editColumn('company_id',function (User $company_admin){
                        return view('admin.company_admin.datatable.company',compact('company_admin'));
                    })
                    ->addColumn('user_data',function (User $company_admin){
                        return view('admin.company_admin.datatable.user_data',compact('company_admin'));
                    })
                    ->editColumn('created_at', function ($row) {
                        return $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : '';
                    })

                    ->addColumn('actions', 'admin.company_admin.datatable.action')
                    ->rawColumns(['actions'])
                    ->make(true);

            }catch (Exception $e) {
                report($e);
                return EmptyDatatable::toJson();
            }
        }

        return view('admin.company_admin.index');
    }

    /**
     * Show the form for editing a company admin.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */

    public function edit($id){

        if (! auth()->user()->hasPermission('company_admin.update')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'company_admin.update','Can not update Company Admin');
            return view('admin.errors.unauthorized');
        }

        $company_admin = User::findOrFail($id);

        return view('admin.company_admin.show.edit')->with([
            'company_admin' => $company_admin,
        ]);
    }

    /**
     * Update the specified company admin.
     *
     * @param CompanyAdminUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(CompanyAdminUpdateRequest $request, $id)
    {
        if (! auth()->user()->hasPermission('company_admin.update')) {$this->forbiddenLogService->storeForbiddenLog(
            request()->path(), 'company_admin.update', 'Can not update Company Admin');
        }

        $company_admin = User::findOrFail($id);

        $company_admin->update([
            'first_name'   => $request->first_name ?: '',
            'last_name'    => $request->last_name ?: '',
            'phone_number' => $request->phone_number ?: '',
            'email'        => $request->email ?: '',
            'address'      => $request->address ?: '',
            'notes'        => $request->notes ?: '',
            'company_id'   => $request->company_id ?: null,
            'status'       => $request->status ? true : false,
            'password'     => $request->filled('password') ? Hash::make($request->password) : $company_admin->password,
        ]);

        $this->activityLogService->storeActivityLog(
            'Updated Company Admin. Company Admin Id# | ' . $company_admin->id,
            3,
            'CompanyAdminController@update',
            'update'
        );

        FlashNotification::success(__('master.success'), __('master.updated_successfully'));

        return ActionJsonResponse::make(true, route('admin.company_admin.show', ['id' => $company_admin->id]))->response();
    }

    /**
     * Display a specific company admin.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */

    public function show($id)
    {
        if (! auth()->user()->hasPermission('company_admin.view_any')) {$this->forbiddenLogService->storeForbiddenLog(request()->path(), 'company_admin.view_any', 'Can not view all company Admin');

            return view('admin.errors.unauthorized');
        }

        $company_admin = User::with(['company'])->findOrFail($id);

        return view('admin.company_admin.show.show', [
            'company_admin' => $company_admin,
        ]);
    }

    /**
     * Delete a company admin.
     *
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */

    public function delete(Request $request){

        if (! auth()->user()->hasPermission('company_admin.delete')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'company_admin.delete','Does not have permissions to delete Company Admin');

            $data = [
                'status' => 2,
                'message' => 'You do not have access to delete Staff'
            ];

            return $data;
        }

        try {
            DB::beginTransaction();

            $company_admin = User::findOrFail($request['data']['delete_id']);

            if ($company_admin->status == true) {
                return response()->json([
                    'status' => 2,
                    'message' => 'The user is active and cannot be deleted!'
                ]);
            }


            $company_admin->delete();

            DB::commit();

            $data = [
                'status' => 1,
                'message' => 'Company Admin deleted successfully.'
            ];

            $this->activityLogService->storeActivityLog(
                'Deleted Company Admin. Company Admin Id# | ' . $company_admin->id,
                1,
                'CompanyAdminController@delete',
                'delete'
            );
        } catch (\Exception $e) {
            report($e);
            DB::rollBack();

            $data = [
                'status' => 0,
                'message' => 'Something went wrong. Please try again later.'
            ];
        }

        return $data;
    }

    /**
     * Search company admins for autocomplete.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function search(Request $request){

        return response()->json(
            User::search(
                $request->get('keyword'),
                $request->get('id'),
            )->get()->append(['label'])
        );
    }


}
