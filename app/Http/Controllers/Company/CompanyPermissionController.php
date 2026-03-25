<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Admin\Permission;
use App\Support\FlashNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyPermissionController extends Controller
{
    public function index(Request $request){


        $permissions = Permission::query()->where('scope', 'company')->when($request->general_search_input , function ($query) use ($request){
            $query->whereAny(['name','description'],'LIKE','%'.$request['general_search_input'].'%');
        })->with(['roles'])->get();


        $groupedData = $permissions->groupBy(function ($item) {
            $slugParts = explode('.', $item['slug']);
            return $slugParts[0]; // Get the first word of the slug
        });


        return view('company.roles_permissions.all_permissions')->with([
            'groupedData' => $groupedData
        ]);
    }


    //this function will be used to check all the users with a specific permission
    public function checkUsers(Request $request,$permission_id){

        //roles that have this permission
        $rolesArray = DB::table('permission_role')->where('permission_id',$permission_id)->pluck('role_id');

        $roles = [];

        foreach ($rolesArray as $role_id){
            $role = DB::table('roles')->where('id',$role_id)->where('status',1)->first();
            $role->users = DB::table('users')->where('role_id',$role_id)->where('status',1)->get();
            array_push($roles,$role);
        }


        return view('company.roles_permissions.permission_users')->with([
            'roles' => $roles
        ]);
    }

    public function create(){
        return view('company.roles_permissions.add_permission');
    }
    public function store(Request $request){

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'slug' => 'required|string|max:255|unique:permissions,slug',
            'description' => 'nullable|string|max:255',
        ]);

        $permission = Permission::create([
            'name'        => $validatedData['name'],
            'slug'        => $validatedData['slug'],
            'description' => $validatedData['description'] ?: '',
            'scope'       => 'company'
        ]);

        FlashNotification::success(__('master.success'), __('master.created_successfully'));

        // Redirect instead of returning JSON
        return redirect()->route('company.permissions.index');

    }
}
