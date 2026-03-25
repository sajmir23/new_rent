<?php

namespace App\Http\Controllers\Company;

use App\Enums\UserTypesEnum;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FuelTypesStoreRequest;
use App\Models\Admin\Company;
use App\Models\Admin\FuelTypes;
use App\Models\User;
use App\Services\ActivityLogService;
use App\Services\ForbiddenLogService;
use App\Support\ActionJsonResponse;
use App\Support\EmptyDatatable;
use App\Support\FlashNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
{
    protected $activityLogService;
    protected $forbiddenLogService;


    public function __construct(ActivityLogService $service,ForbiddenLogService $forbiddenLogService)
    {
        $this->activityLogService = $service;
        $this->forbiddenLogService = $forbiddenLogService;
    }

    /**
     * Display the company information page for the authenticated user's company.
     *
     * @return \Illuminate\View\View
     */

    public function index()
    {
        if (!auth()->user()->hasPermission('company.data.view_any')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'company.data.view_any', 'Cannot view company info');
            return view('company.errors.unauthorized');
        }

        $company = Company::find(auth()->user()->company_id);

        if(!$company)
        {
            abort(404,"Company not found");
        }
        
        return view('company.company_data.index')->with(['company' => $company]);
    }

    /**
     * Show the form for editing the specified company.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */

    public function edit($id)
    {
        $authUser = auth()->user();

        if (!auth()->user()->hasPermission('company.data.update')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'company.data.update', 'Cannot update company info');
            return view('company.errors.unauthorized');
        }

        if ($authUser->company_id != $id) {
            abort(403, 'Unauthorized access to another company.');
        }

        $company = Company::findOrFail($id);

        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        $working_days = old('working_days', $company->working_days ?? []);

        return view('company.company_data.edit')->with([
            'company'       => $company,
            'days'          => $days,
            'working_days'  => $working_days,
        ]);
    }

    /**
     * Update the specified company in storage.
     *
     * Handles updating basic company info, logo upload/removal, and working days.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\View\View
     */

    public function update(Request $request,$id)
    {
        if (!auth()->user()->hasPermission('company.data.update')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'company.data.update', 'Cannot update company info');
            return view('company.errors.unauthorized');
        }

        $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city_id' => 'nullable|exists:cities,id',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $authUser = auth()->user();

        if ($authUser->company_id != $id) {
            abort(403, 'Unauthorized access to another company.');
        }
        $company = Company::findOrFail($id);

        $LogoPath = $company->logo;

        if($request->has('avatar_remove')&& $request->avatar_remove=="1")
        {
            if($LogoPath &&file_exists(storage_path('app/public/' . $LogoPath))) {
                unlink(storage_path('app/public/' . $LogoPath));
            }
            $LogoPath = null;
        }
        if ($request->hasFile('logo')) {
            if ($LogoPath && file_exists(storage_path('app/public/' . $LogoPath))) {
                unlink(storage_path('app/public/' . $LogoPath));
            }

            $LogoPath = $request->file('logo')->store('Images/Company', 'public');
        }
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        $workingDays = [];
        foreach ($days as $day) {
            if ($request->has($day)) {
                $workingDays[] = $day;
            }
        }

        $company->update([
            'name'          => $request->name,
            'phone'         =>$request->phone,
            'email'         =>$request->email,
            'address'       =>$request->address,
            'status'        => $request->status ? true : false,
            'logo'          => $LogoPath,
            'working_days'  => $workingDays,
            'city_id'       =>$request->city_id ?? null,

        ]);
        return view('company.company_data.index')->with([
            'company' => $company,
        ]);
    }

    /**
     * Display a list of staff members for the authenticated user's company.
     *
     * @return \Illuminate\View\View
     */

    public function staffList()
    {
        if (!auth()->user()->hasPermission('company.staff.view_any')) {
            $this->forbiddenLogService->storeForbiddenLog(request()->path(), 'company.staff.view_any', 'Cannot view staff members');
            return view('company.errors.unauthorized');
        }

        $company = Company::with(['staff'])->where('id',auth()->user()->company_id)->first();
        return view('company.company_data.staff')->with([
            'company' => $company,
        ]);
    }

}
