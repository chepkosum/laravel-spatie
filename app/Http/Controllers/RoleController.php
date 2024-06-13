<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller implements HasMiddleware
{


    public static function middleware(): array
{
    return [
        // 'role:Super Admin|Admin',
        new Middleware('permission:view role', only: ['index']),
        new Middleware('permission:create role', only: ['addPermissionToRole','givePermissionToRole']),
        new Middleware('permission:create role', only: ['create', 'store']),
        new Middleware('permission:update role', only: ['update', 'edit']),
        new Middleware('permission:delete role', only: ['destroy']),
    ];
}



    //For Laravel version 10 and below
    // public function __construct() {
    //     $this->middleware('permission: view role', ['only'=>['index']]);
    //     $this->middleware('permission: create role', ['only'=>['create', 'store','addPermissionToRole','givePermissionToRole']]);
    //     $this->middleware('permission: update role', ['only'=>['update', 'edit']]);
    //     $this->middleware('permission:delete role', ['only' => ['destroy']]);
    // }



    public function index(){

        $roles = Role::get();
        return view('role-permission.role.index',[
            'roles' => $roles
        ]);
    }

    public function create(){

        return view('role-permission.role.create');
    }


    public function store (Request $request){
        $request->validate([
             'name'=>[
                'required',
                'string',
                'unique:roles,name'
             ]
        ]);
        Role::create([
            'name'=> $request->name
        ]);

        return redirect('roles')->with('status', 'Role created successfully' );
    }

    public function edit(Role $role){

        return view('role-permission.role.edit',[
            'role' => $role
        ]);
    }

    public function update(Request $request, Role $role){

        $request->validate([
            'name'=>[
               'required',
               'string',
               'unique:roles,name,'.$role->id
            ]
       ]);
       $role->update([
           'name'=> $request->name
       ]);

       return redirect('roles')->with('status', 'Role Updated successfully' );
    }

    public function destroy($roleId){
        $role = Role::find($roleId);
        $role->delete();

       return redirect('roles')->with('status', 'Role Deleted successfully' );

    }



public function addPermissionToRole($roleId){

    $permissions = Permission::get();
    $role = Role::findOrFail($roleId);
    $rolePermissions = DB::table('role_has_permissions')
                            ->where('role_has_permissions.role_id', $role->id)
                            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                            ->all();

    return view('role-permission.role.add-permissions',[
        'role'=> $role,
        'permissions'=>$permissions,
        'rolePermissions'=> $rolePermissions
    ]);
}



public function givePermissionToRole(Request $request, $roleId){

    $request->validate([
        'permission' =>'required'
    ]);
    $role = Role::findOrFail($roleId);
    $role->syncPermissions($request->permission);

    return redirect()->back()->with('status','Permissions added to role');
}




}
