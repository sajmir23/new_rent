<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Admin\Permission;
use App\Models\Admin\Role;
use App\Services\ActivityLogService;
use App\Services\ForbiddenLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyRolesController extends Controller
{

    protected $activityLogService;
    protected $forbiddenLogService;


    public function __construct(ActivityLogService $service,ForbiddenLogService $forbiddenLogService)
    {
        $this->activityLogService = $service;
        $this->forbiddenLogService = $forbiddenLogService;
    }


    public function index(Request $request){


        if (! auth()->user()->hasPermission('roles.company.view_any')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'roles.company.view_any','Can not view All roles');
            return view('admin.errors.unauthorized');
        }

        $roles = Role::with('permissions')
            ->withCount('users')
            ->where(function ($query) {
                $query->where('company_id', auth()->user()->company_id)
                    ->orWhere(function ($q) {
                        $q->whereNull('company_id')
                            ->where('scope', 'company');
                    });
            })
            ->get();

        $permissions = Permission::where('scope', 'company')->get();

        $groupedPermissions = $permissions->groupBy(function ($item) {
            $slugParts = explode('.', $item['slug']);
            return $slugParts[0]; // Get the first word of the slug
        });

        return view('company.roles_permissions.roles')->with([
            'roles'              => $roles,
            'groupedPermissions' => $groupedPermissions,
        ]);

    }


    public function search(Request $request){

        return response()->json(
            Role::search(
                $request->get('keyword'),
                $request->get('id'),
            )->get()->append(['label'])
        );
    }

    //this method will be used to store a new role
    public function store(Request $request){

        if (! auth()->user()->hasPermission('roles.company.store')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'roles.company.store','Can not store new role');
            return view('admin.errors.unauthorized');
        }

        try {
            $role = Role::create([
                'title'            => $request->role_name ?? '--',
                'description'      => $request->role_description ?? null,
                'background_color' => $request->background_color ?? null,
                'text_color'       => $request->text_color ?? null,
                'scope'            => 'company',
                'company_id'       => auth()->user()->company_id,
                'status'           => 1,
            ]);

            if (isset($request->new_role_permissions) && count($request->new_role_permissions) > 0 ){

                foreach ($request->new_role_permissions as $permission){

                    DB::table('permission_role')->insert([
                        'role_id' => $role->id,
                        'permission_id' => $permission,
                    ]);
                }
            }

            $this->activityLogService->storeActivityLog('Created a new role . Role Id# | '.$role->id,1,'RolesController@store','store');

            return  redirect()->route('company.roles.index')->with('successMessage', __('general.stored_successfully'));

        }catch (\Exception $exception){

            return redirect()->back()->with('errorMessage' , __('general.sth_wrong'));
        }

    }

    // this method will be used to update role & role permissions
    public function managePermissions(Request $request,$id){

        if (! auth()->user()->hasPermission('roles.company.manage_permissions')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'roles.company.manage_permissions','Can not manage role permissions');
            return view('admin.errors.unauthorized');
        }

        $role             = Role::findOrFail($id);
        $role_permissions = DB::table('permission_role')->where('role_id',$id)->pluck('permission_id')->toArray();
        $permissions      = Permission::query()->where('scope', 'company')->get();


        $groupedPermissions = $permissions->groupBy(function ($item) {
            $slugParts = explode('.', $item['slug']);
            return $slugParts[0]; // Get the first word of the slug
        });

        return view('company.roles_permissions.manage_permissions')->with([
            'role'                => $role,
            'groupedPermissions'  => $groupedPermissions,
            'role_permissions'    => $role_permissions,
        ]);

    }


    //this method will be used to update role & permissions
    public function update(Request $request,$id){

        if (! auth()->user()->hasPermission('roles.company.update')) {
            $this->forbiddenLogService->storeForbiddenLog( request()->path() , 'roles.company.update','Can not update role');
            return view('admin.errors.unauthorized');
        }

        try {

            Role::findOrFail($id)->update(
                [
                    'title'            => $request->role_name  ? : "--",
                    'description'      => $request->role_description  ? : "--",
                    'background_color' => $request->background_color  ? : "--",
                    'text_color'       => $request->text_color  ? : "--",
                    'scope'            => 'company',
                    'company_id'       => auth()->user()->company_id,
                    'status'           => 1,
                ]
            );

            DB::table('permission_role')->where('role_id',$id)->delete();

            if (isset($request->new_role_permissions) && count($request->new_role_permissions) > 0 ){

                foreach ($request->new_role_permissions as $permission){

                    DB::table('permission_role')->insert([
                        'role_id' => $id,
                        'permission_id' => $permission,
                    ]);
                }
            }

            $this->activityLogService->storeActivityLog('Updated Role & Permissions . Role Id# | '.$id,1,'RolesController@update','update');

            return redirect()->back()->with('successMessage' , 'Update was successful');

        }catch (\Exception $exception){

            return redirect()->back()->with('errorMessage' , 'Something went wrong. Try Again Later');
        }

    }
}
