<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Role;
use App\Models\User;
use App\Services\ActivityLogService;
use App\Services\ForbiddenLogService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{

    protected $activityLogService;
    protected $forbiddenLogService;


    public function __construct(ActivityLogService $service,ForbiddenLogService $forbiddenLogService)
    {
        $this->activityLogService = $service;
        $this->forbiddenLogService = $forbiddenLogService;
    }

    public function myAccount(Request $request){

        if (! auth()->user()->hasPermission('users.update')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'users.update','Does not have permissions to update users');
            return view('admin.errors.unauthorized');
        }

        $user = Auth::user();
        $roles = Role::query()->withCount('users')->get();

        return view('admin.account.my_profile')->with([
            'user'  => $user,
            'roles' => $roles
        ]);
    }


    public function update(Request $request,$id){

        if (auth()->id() !=$id ) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'my_account.update','Does not have permissions to update account info');
            return view('admin.errors.unauthorized');
        }

        User::findOrFail($id)->update([
            'first_name'         => $request->input('name'),
            'last_name'          => $request->input('last_name'),
            'email'              => $request->input('email'),
            'phone_number'       => $request->input('phone') ? : "",
            'address'            => $request->input('address') ? : "",
            'notes'              => $request->input('notes') ? : "",
            'email_verified_at'  => Carbon::now()->toDateTimeString(),
        ]);

        if ($request->input('password')){
            User::findOrFail($id)->update([
                'password'           => Hash::make($request->input('password')),
            ]);
        }

        $this->activityLogService->storeActivityLog('Updated Account Info . User Id# | '.$id,1,'AccountController@update','update');

        return redirect()->back()->with('successMessage' , __('master.update_successful'));
    }}
