<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserTypesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CompaniesStoreRequest;
use App\Http\Requests\Admin\CompaniesUpdateRequest;
use App\Models\Admin\Company;
use App\Models\User;
use App\Notifications\CompanyCreatedNotification;
use App\Services\ActivityLogService;
use App\Services\ForbiddenLogService;
use App\Support\ActionJsonResponse;
use App\Support\EmptyDatatable;
use App\Support\FlashNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Yajra\DataTables\Facades\DataTables;

class CompaniesController extends Controller
{
    protected $activityLogService;
    protected $forbiddenLogService;


    public function __construct(ActivityLogService $service,ForbiddenLogService $forbiddenLogService)
    {
        $this->activityLogService = $service;
        $this->forbiddenLogService = $forbiddenLogService;
    }

    /**
     * Display a listing of companies.
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */

    public function index(Request $request){

        if (! auth()->user()->hasPermission('companies.view_any')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'companies.view_any','Can not view allCompanies');
            return view('admin.errors.unauthorized');
        }


        if ($request->ajax()) {

            try {
                $company = Company::query();

                if ($request->filled('email')) {
                    $company->where("email", 'like', '%' . $request->email . '%');
                }
                if ($request->filled('phone')) {
                    $company->where("phone", 'like', '%' . $request->phone . '%');
                }

                return DataTables::eloquent($company)
                    ->addIndexColumn()
                    ->editColumn('status',function (Company $company){
                        return view('admin.companies.datatable.active',compact('company'));
                    })
                    ->editColumn('logo',function (Company $company){
                        return view('admin.companies.datatable.logo',compact('company'));
                    })
                    ->editColumn('name',function (Company $company){
                        return view('admin.companies.datatable.name',compact('company'));
                    })
                    ->addColumn('company_admin',function (Company $company){
                        return view('admin.companies.datatable.company_admin',['admin' => $company->admin]);
                    })
                    ->editColumn('booking_fee_percentage',function (Company $company){
                        return view('admin.companies.datatable.booking_fee_percentage',compact('company'));
                    })
                    ->addColumn('actions', 'admin.companies.datatable.actions')
                    ->rawColumns(['actions'])
                    ->make(true);

            }catch (Exception $e) {
                report($e);
                return EmptyDatatable::toJson();
            }
        }

        return view('admin.companies.index');
    }

    /**
     * Show the form for creating a new company.
     *
     * @return \Illuminate\View\View
     */

    public function create()
    {
        if (!auth()->user()->hasPermission('companies.store')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'companies.store', 'Can not create new Company');
            return view('admin.errors.unauthorized');
        }

        return view('admin.companies.create');
    }

    /**
     * Store a newly created company and its admin user.
     *
     * @param CompaniesStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(CompaniesStoreRequest $request)
    {
        if (!auth()->user()->hasPermission('companies.store')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'companies.store', 'Can not create new Company');
        }

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('Images/Companies', 'public');
        }

        $admin = User::create([
            'first_name'                  => $request->first_name ?? null,
            'last_name'                   => $request->last_name ?? null,
            'phone_number'                => $request->phone_number ?? null,
            'email'                       => $request->email_admin ?? null,
            'notes'                       => $request->notes ?? null,
            'address'                     => $request->address_admin ?? null,
            'password'                    => Hash::make($request->input('password')),
            'role_id'                     => 2,
            'user_type'                   => UserTypesEnum::COMPANY_ADMIN,
            'status'                      => true,
        ]);

        $company = Company::create([
            'name'        => $request->name ?? null,
            'email'       => $request->email ?? null,
            'phone'       => $request->phone ?? null,
            'address'     => $request->address ?? null,
            'notes'       => $request->notes ?? null,
            'status'      => $request->status ? true : true,
            'city_id'     => $request->city_id ?? null,
            'logo'        => $logoPath,
            'booking_fee_percentage'      => $request->booking_fee_percentage ?? 0,
        ]);

        $admin->update([
            'company_id' => $company->id,
        ]);

        $systemUser = User::where('user_type', UserTypesEnum::SYSTEM_ADMIN)->where('id',auth()->user()->id)->get();

        if ($systemUser->isNotEmpty()) {
            Notification::send($systemUser, new CompanyCreatedNotification($company));
        }

        $this->activityLogService->storeActivityLog(
            'Created a new Company with the admin user. Company Id#' . $company->id . ' | User Id#' . $admin->id,
            3,
            'CompaniesController@store',
            'store'
        );

        FlashNotification::success(__('master.success'), __('master.created_successfully'));
        return ActionJsonResponse::make(true, route('admin.companies.index', ['id' => $company->id]))->response();
    }

    /**
     * Show the form for editing a company and its admin.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */

    public function edit($id){

        if (! auth()->user()->hasPermission('companies.update')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'companies.update','Can not update Company');
            return view('admin.errors.unauthorized');
        }

        $company =Company::findOrFail($id);
        $admin = User::where('company_id', $company->id)
            ->where('user_type', UserTypesEnum::COMPANY_ADMIN)
            ->first();

        return view('admin.companies.show.edit')->with([
            'company' => $company,
            'admin'   => $admin,
        ]);
    }

    /**
     * Update a company and its admin.
     *
     * @param CompaniesUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(CompaniesUpdateRequest $request, $id)
    {
        if (! auth()->user()->hasPermission('companies.update')) {
            $this->forbiddenLogService->storeForbiddenLog(
                request()->path(),
                'companies.update',
                'Can not update Company'
            );
        }

        $company = Company::findOrFail($id);

        // Handle logo update
        $logoPath = $company->logo;
        if ($request->hasFile('logo')) {
            if ($logoPath && file_exists(storage_path('app/public/' . $logoPath))) {
                unlink(storage_path('app/public/' . $logoPath));
            }
            $logoPath = $request->file('logo')->store('Images/Companies', 'public');
        }

        // Update company
        $company->update([
            'name'                        => $request->name ?: '',
            'email'                       => $request->email ?: '',
            'phone'                       => $request->phone ?: '',
            'address'                     => $request->address ?: '',
            'notes'                       => $request->notes ?: '',
            'status'                      => $request->status ? true : false,
            'booking_fee_percentage'      => $request->booking_fee_percentage ?? 0,
            'city_id'                     => $request->city_id ?? null,
            'logo'                        => $logoPath,
        ]);

        $admin = User::where('company_id', $company->id)
            ->where('user_type', UserTypesEnum::COMPANY_ADMIN)
            ->first();

        if ($admin) {
            $admin->update([
                'first_name'   => $request->first_name ?: '',
                'last_name'    => $request->last_name ?: '',
                'phone_number' => $request->phone_number ?: '',
                'email'        => $request->email_admin ?: '',
                'address'      => $request->address_admin ?: '',
                'notes'        => $request->notes ?: '',
                'status'       => $request->status_admin ? true : false,
                'password'     => $request->filled('password') ? Hash::make($request->password) : $admin->password,
            ]);
        }

        $this->activityLogService->storeActivityLog(
            'Updated Company. Company Id# | ' . $company->id,
            3,
            'CompaniesController@update',
            'update'
        );

        FlashNotification::success(__('master.success'), __('master.updated_successfully'));

        return ActionJsonResponse::make(true, route('admin.companies.show', ['id' => $company->id]))->response();
    }

    /**
     * Display a company.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */

    public function show($id)
    {
        if (! auth()->user()->hasPermission('companies.view_any')) {$this->forbiddenLogService->storeForbiddenLog(request()->path(), 'companies.view_any', 'Can not view all Companies');

            return view('admin.errors.unauthorized');
        }

        $company = Company::with(['admin'])->findOrFail($id);

        return view('admin.companies.show.show', [
            'company' => $company,
            'admin'   => $company->admin,
        ]);
    }

    /**
     * Delete a company and its admin user.
     *
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */

    public function delete(Request $request){

        if (! auth()->user()->hasPermission('companies.delete')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'companies.delete','Does not have permissions to delete Company');

            $data = [
                'status' => 2,
                'message' => 'You do not have access to delete Company'
            ];

            return $data;
        }

        try {
            DB::beginTransaction();

            $company = Company::findOrFail($request['data']['delete_id']);

            // Delete related admin (if any)
            User::where('company_id', $company->id)
                /*->where('user_type', )*/
                ->delete();

            if ($company->status == true) {
                return response()->json([
                    'status' => 2,
                    'message' => 'The company is active and cannot be deleted!'
                ]);
            }
            // Delete the company itself
            $company->delete();

            DB::commit();

            $data = [
                'status' => 1,
                'message' => 'Company and its admin user deleted successfully.'
            ];

            $this->activityLogService->storeActivityLog(
                'Deleted Company. Company Id# | ' . $company->id,
                1,
                'CompaniesController@delete',
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
     * Search companies for autocomplete.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function search(Request $request){

        return response()->json(
            Company::search(
                $request->get('keyword'),
                $request->get('id'),
            )->get()->append(['label'])
        );
    }

}
