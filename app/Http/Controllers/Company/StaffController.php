<?php

namespace App\Http\Controllers\Company;

use App\Enums\UserTypesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StaffStoreRequest;
use App\Http\Requests\Admin\StaffUpdateRequest;
use App\Models\User;
use App\Services\ActivityLogService;
use App\Services\ForbiddenLogService;
use App\Support\ActionJsonResponse;
use App\Support\EmptyDatatable;
use App\Support\FlashNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class StaffController extends Controller
{
    protected $activityLogService;
    protected $forbiddenLogService;


    public function __construct(ActivityLogService $service,ForbiddenLogService $forbiddenLogService)
    {
        $this->activityLogService = $service;
        $this->forbiddenLogService = $forbiddenLogService;
    }

    /**
     * Display a paginated list of staff for the authenticated company.
     * Supports AJAX search and DataTables integration.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */

    public function index(Request $request)
    {
        if (! auth()->user()->hasPermission('company.staff.view_any')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'company.staff.view_any','Can not view all staff');
            return view('company.errors.unauthorized');
        }
        if ($request->ajax()) {

            try {
                $staff = User::with('company')
                    ->where('user_type', UserTypesEnum::STAFF)
                    ->where('company_id',auth()->user()->company_id);

                if ($request->filled('first_name')) {
                    $staff->where("first_name", 'like', '%' . $request->first_name . '%');
                }
                if ($request->filled('last_name')) {
                    $staff->where("last_name", 'like', '%' . $request->last_name . '%');
                }
                if ($request->filled('email')) {
                    $staff->where("email", 'like', '%' . $request->email . '%');
                }
                if ($request->filled('phone')) {
                    $staff->where("phone_number", 'like', '%' . $request->phone . '%');
                }

                return DataTables::eloquent($staff)
                    ->addIndexColumn()
                    ->editColumn('status',function (User $staff){
                        return view('company.staff.datatable.active',compact('staff'));
                    })
                    ->editColumn('full_name',function (User $staff){
                        return view('company.staff.datatable.name',compact('staff'));
                    })
                    ->editColumn('company_id',function (User $staff){
                        return view('company.staff.datatable.company',compact('staff'));
                    })
                    ->addColumn('user_data',function (User $staff){
                        return view('company.staff.datatable.user_data',compact('staff'));
                    })
                    ->editColumn('created_at', function ($row) {
                        return $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : '';
                    })

                    ->addColumn('actions', 'company.staff.datatable.actions')
                    ->rawColumns(['actions'])
                    ->make(true);

            }catch (Exception $e) {
                report($e);
                return EmptyDatatable::toJson();
            }
        }

        return view('company.staff.index');
    }

    /**
     * Show the form for creating a new staff member.
     *
     * @return \Illuminate\View\View
     */

    public function create()
    {
        if (!auth()->user()->hasPermission('company.staff.store')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'company.staff.store', 'Can not create new Staff');
            return view('company.errors.unauthorized');
        }

        return view('company.staff.create');
    }

    /**
     * Store a newly created staff member.
     *
     * @param StaffStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(StaffStoreRequest $request)
    {
        if (!auth()->user()->hasPermission('company.staff.store')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'company.staff.store', 'Can not create new Staff');
        }

        $staff = User::create([
            'first_name'   => $request->first_name ?: "",
            'last_name'    => $request->last_name ?: "",
            'phone_number' => $request->phone_number ?: "",
            'email'        => $request->email ?: "",
            'notes'        => $request->notes ?: "",
            'address'      => $request->address ?: "",
            'company_id'   => auth()->user()->company_id,
            'password'     => Hash::make($request->input('password')),
            'role_id'      => 3,
            'user_type'    => UserTypesEnum::STAFF,
            'status'       => true
        ]);

        $this->activityLogService->storeActivityLog(
            'Created a new Staff. Staff Id# | ' . $staff->id,
            3,
            'StaffController@store',
            'store'
        );

        FlashNotification::success(__('master.success'), __('master.created_successfully'));
        return ActionJsonResponse::make(true, route('company.staff.index', ['id' => $staff->id]))->response();
    }

    /**
     * Show the form for editing a staff member.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */

    public function edit($id){

        if (! auth()->user()->hasPermission('company.staff.update')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'company.staff.update','Can not update Staff');
            return view('company.errors.unauthorized');
        }

        $staff = User::where('id', $id)
            ->where('company_id', auth()->user()->company_id)
            ->firstOrFail();

        return view('company.staff.show.edit')->with([
            'staff' => $staff,
        ]);
    }

    /**
     * Update a staff member.
     *
     * @param StaffUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(StaffUpdateRequest $request, $id)
    {
        if (! auth()->user()->hasPermission('company.staff.update')) {$this->forbiddenLogService->storeForbiddenLog(
            request()->path(), 'company.staff.update', 'Can not update Staff');
        }

        $staff = User::where('id', $id)
            ->where('company_id', auth()->user()->company_id)
            ->firstOrFail();

        $staff->update([
            'first_name'   => $request->first_name ?: '',
            'last_name'    => $request->last_name ?: '',
            'phone_number' => $request->phone_number ?: '',
            'email'        => $request->email ?: '',
            'address'      => $request->address ?: '',
            'notes'        => $request->notes ?: '',
            'company_id'   => $request->company_id ?: null,
            'status'       => $request->status ? true : false,
            'password'     => $request->filled('password') ? Hash::make($request->password) : $staff->password,
        ]);

        $this->activityLogService->storeActivityLog(
            'Updated Staff. Staff Id# | ' . $staff->id,
            3,
            'staffController@update',
            'update'
        );

        FlashNotification::success(__('master.success'), __('master.updated_successfully'));

        return ActionJsonResponse::make(true, route('company.staff.show', ['id' => $staff->id]))->response();
    }

    /**
     * Display a staff member details.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */

    public function show($id)
    {
        if (! auth()->user()->hasPermission('company.staff.view_any')) {$this->forbiddenLogService->storeForbiddenLog(request()->path(), 'company.staff.view_any', 'Can not view all staff');

            return view('company.errors.unauthorized');
        }

        $staff = User::with(['company'])
            ->where('id', $id)
            ->where('company_id', auth()->user()->company_id)
            ->firstOrFail();

        return view('company.staff.show.show', [
            'staff' => $staff,
        ]);
    }

    /**
     * Delete a staff member if inactive.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */

    public function delete(Request $request){

        if (! auth()->user()->hasPermission('company.staff.delete')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'company.staff.delete','Does not have permissions to delete Staff');

            $data = [
                'status' => 2,
                'message' => 'You do not have access to delete Staff'
            ];

            return $data;
        }

        try {
            DB::beginTransaction();

            $staff = User::findOrFail($request['data']['delete_id']);

            if ($staff->status == true) {
                return response()->json([
                    'status' => 2,
                    'message' => 'The user is active and cannot be deleted!'
                ]);
            }


            $staff->delete();

            DB::commit();

            $data = [
                'status' => 1,
                'message' => 'Staff deleted successfully.'
            ];

            $this->activityLogService->storeActivityLog(
                'Deleted Staff. Staff Id# | ' . $staff->id,
                1,
                'StaffController@delete',
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
     * Search staff by keyword or ID for autocomplete.
     *
     * @param \Illuminate\Http\Request $request
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
