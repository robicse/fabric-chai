<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class StaffController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:staff-list|staff-create|staff-edit|staff-delete', ['only' => ['index','store']]);
        $this->middleware('permission:staff-create', ['only' => ['create','store']]);
        $this->middleware('permission:staff-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:staff-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $users = User::where('user_type','staff')->orWhere('user_type','admin')->latest()->get();
        return view('backend.admin.staffs.index', compact('users'));
    }
    public function getRole(Request $request){
        $roles =Role::where('department_id',$request->department_id)->get();
        return $roles;
    }

    public function create()
    {
        $roles = Role::all();
        return view('backend.admin.staffs.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|regex:/(01)[0-9]{9}/|unique:users,phone',
            'password' => 'required|min:6',
            'roles' => 'required'
        ]);


        $input = $request->all();
        $input['user_type'] = 'staff';
        $input['password'] = Hash::make($input['password']);


        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        Toastr::success('User Role Created Successfully ');
        return back();

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $staff = User::find($id);
        $roles = $roles = Role::all();
        $userRole = $staff->roles->first();
        //dd($userRole);
        return view('backend.admin.staffs.edit', compact('roles','staff','userRole'));

    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => '',
            'phone' => 'required|regex:/(01)[0-9]{9}/|unique:users,phone,'.$id,
            'roles' => 'required'
        ]);


        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }


        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));

        Toastr::success('User Role Updated Successfully ');
        return back();

    }

    public function destroy($id)
    {
       $user = User::find($id);
        if ($user->user_type != 'admin') {
            $user->delete();
            Toastr::success('User Role Deleted Successfully ');
        }else{
            Toastr::warning('You can not delete Super admin');
        }

        return back();
    }
}
