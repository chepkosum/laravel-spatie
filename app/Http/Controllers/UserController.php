<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            // 'role:Super Admin|Admin',
            new Middleware('role:Super Admin|Admin', only: ['index']),
            new Middleware('role:Super Admin|Admin', only: ['create', 'store']),
            new Middleware('role:Super Admin', only: ['update', 'edit']),
            new Middleware('role:Super Admin', only: ['destroy']),
        ];
    }



        //For laravel version 10 and below
        // public function __construct() {
        //     $this->middleware('permission: view permission', ['only'=>['index']]);
        //     $this->middleware('permission: create permission', ['only'=>['create', 'store']]);
        //     $this->middleware('permission: update permission', ['only'=>['update', 'edit']]);
        //     $this->middleware('permission:delete permission', ['only' => ['destroy']]);
        // }







    public function index(){

        $users = User::get();
        return view('role-permission.user.index',[
            'users'=>$users
        ]);
    }


    public function create(){

        $roles= Role::pluck('name','name')->all();
        return view('role-permission.user.create',[
            'roles'=>$roles
        ]);
    }


    public function store(Request $request){
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|max:255|unique:users,email',
            'password'=> 'required|string|min:8|max:20',
            'roles'=>'required'
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);

        $user->syncRoles($request->roles);

        return redirect('/users')->with('status', 'User created successfully with roles');
    }







    public function edit(User $user){

        $roles= Role::pluck('name','name')->all();
        $userRoles = $user->roles->pluck('name','name')->all();
        return view('role-permission.user.edit',[
            'user'=>$user,
            'roles'=>$roles,
            'userRoles'=>$userRoles

        ]);
    }



    public function update(Request $request, User $user){
        $request->validate([
            'name'=>'required|string|max:255',
            'password'=> 'nullable|string|min:8|max:20',
            'roles'=>'required'
        ]);

        $data=[
            'name'=>$request->name,
            'email'=>$request->email,
        ];

        if(!empty($request->password)){
            $data +=[
                'password'=>Hash::make($request->password),
            ];
        }

        $user->update($data);

        $user->syncRoles($request->roles);

        return redirect('/users')->with('status', 'User updated successfully with roles');


    }




    public function destroy($userId){
        $user = User::findOrFail($userId);

        // Remove all roles associated with the user
        $user->roles()->detach();

        // Delete the user
        $user->delete();

        return redirect('/users')->with('status', 'User deleted successfully with roles');
    }











}
