<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserTypesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UsersStoreRequest;
use App\Models\Admin\Role;
use App\Models\User;
use App\Services\ActivityLogService;
use App\Services\ForbiddenLogService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $activityLogService;
    protected $forbiddenLogService;


    public function __construct(ActivityLogService $service,ForbiddenLogService $forbiddenLogService)
    {
        $this->activityLogService = $service;
        $this->forbiddenLogService = $forbiddenLogService;
    }

    /**
     * Display a paginated list of system users with optional filters.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */

    public function index(Request $request){

        if (! auth()->user()->hasPermission('users.view_any')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'users.view_any','Can not view all users');
            return view('admin.errors.unauthorized');
        }

        $users = User::query()
            ->where('user_type',1)
            ->filterSearch($request->only(['general_search_input','first_name','last_name','role_id','email','status']))
            ->with(['role'])
            ->orderBy('id','desc')
            ->paginate($request->show_number ? : 20)
            ->withQueryString();

        $role = $request->role_id ? Role::findOrFail($request->role_id) : null;


        return view('admin.users.index')->with([
            'users' => $users,
            'role' => $role,
        ]);
    }

    /**
     * Show the form for creating a new system user.
     *
     * @return \Illuminate\View\View
     */

    public function create(){

        if (! auth()->user()->hasPermission('users.store')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'users.store','Can not create new system user');
            return view('admin.errors.unauthorized');
        }

        $roles = Role::query()->withCount('users')->get();

        return view('admin.users.create')->with([
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created system user.
     *
     * @param UsersStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function store(UsersStoreRequest $request){

        if (! auth()->user()->hasPermission('users.view_any')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'users.view_any','Can not create new system user');
            return view('admin.errors.unauthorized');
        }

        $user = User::create([
            'first_name'              => $request->input('name'),
            'last_name'               => $request->input('last_name'),
            'role_id'                 => $request->input('role_id'),
            'email'                   => $request->input('email'),
            'phone_number'            => $request->input('phone') ? : "",
            'address'                 => $request->input('address') ? : "",
            'notes'                   => $request->input('notes') ? : "",
            'status'                  => $request->status == 1 ? true : false,
            'approved_google_login'   => $request->approved_google_login,
            'password'                => Hash::make($request->input('password')),
            'email_verified_at'       => Carbon::now()->toDateTimeString(),
        ]);

        $this->activityLogService->storeActivityLog('Created a new user . User Id# | '.$user->id,1,'UsersController@store','store');


        return redirect()->back()->with('successMessage' , __('general.stored_successfully'));
    }

    /**
     * Show the form for editing a system user.
     *
     * @param Request $request
     * @param int $user_id
     * @return \Illuminate\View\View
     */

    public function edit(Request $request,$user_id){

        if (! auth()->user()->hasPermission('users.update')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'users.update','Does not have permissions to update users');
            return view('admin.errors.unauthorized');
        }

        $user = User::findOrFail($user_id);
        $roles = Role::query()->withCount('users')->get();

        return view('admin.users.edit')->with([
            'user'  => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Update an existing system user.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(Request $request,$id){

        if (! auth()->user()->hasPermission('users.update')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'users.update','Does not have permissions to update users');
            return view('admin.errors.unauthorized');
        }

        User::findOrFail($id)->update([
            'first_name'         => $request->input('name'),
            'last_name'          => $request->input('last_name'),
            'role_id'            => $request->input('role_id'),
            'email'              => $request->input('email'),
            'phone_number'       => $request->input('phone') ? : "",
            'address'            => $request->input('address') ? : "",
            'notes'              => $request->input('notes') ? : "",
            'status'             => $request->status == 1 ? true : false,
            'approved_google_login'   => $request->approved_google_login,
            'email_verified_at'  => Carbon::now()->toDateTimeString(),
        ]);

        if ($request->input('password')){
            User::findOrFail($id)->update([
                'password'           => Hash::make($request->input('password')),
            ]);
        }

        $this->activityLogService->storeActivityLog('Updated user . User Id# | '.$id,1,'UsersController@update','update');


        return redirect()->back()->with('successMessage' , __('general.update_successful'));

    }

    /**
     * Delete a system user.
     *
     * @param Request $request
     * @return array
     */

    public function destroy(Request $request){

        if (! auth()->user()->hasPermission('users.delete')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'users.delete','Does not have permissions to delete users');

            $data = [
                'status' => 2,
                'message' => 'You do not have access to delete users'
            ];

            return $data;
        }

        if ($request['data']['delete_id'] == 1){
            $data = [
                'status' => 2,
                'message' => 'You can not delete the crm master'
            ];
            return $data;
        }
        try {
            User::where('user_type',UserTypesEnum::SYSTEM_ADMIN)->where('id',$request['data']['delete_id'])->delete();
            $data = [
                'status' => 1,
                'message' => 'User Deleted With success'
            ];
            $this->activityLogService->storeActivityLog('Deleted user . User Id# | '.$request['data']['delete_id'],1,'UsersController@delete','delete');
            return $data;
        } catch (\Exception $e) {
            report($e);
            $data = [
                'status' => 2,
                'message' => 'Something went wrong. Please try again later'
            ];

            return $data;
        }
    }

    /**
     * Search system users via keyword.
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

    /**
     * Impersonate a user.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */

    public function impersonate(User $user)
    {
        if (! auth()->user()->hasPermission('impersonation.can_impersonate')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'impersonation.can_impersonate','Does not have permissions to impersonate users');
            return view('admin.errors.unauthorized');
        }

        auth()->user()->impersonate($user);


        if ($user->user_type == UserTypesEnum::COMPANY_ADMIN || $user->user_type == UserTypesEnum::STAFF){
            return redirect()->intended(route('company.dashboard', absolute: false));
        }else{
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }
    }

    /**
     * Leave impersonation session.
     *
     * @return \Illuminate\Http\RedirectResponse
     */

    public function leaveImpersonate()
    {
        auth()->user()->leaveImpersonation();

        return redirect()->intended(route('admin.dashboard', absolute: false));
    }

}
