<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $roles = Role::latest()->get();
        return view('backend.admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permission = Permission::orderBy('name','ASC')->get();
        return view('backend.admin.roles.create', compact('permission'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'department_id' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::create(['name' => $request->input('name'),'department_id' => $request->input('department_id')]);
        $role->syncPermissions($request->input('permission'));

        Toastr::success('Role Created Successfully','Success');
        return redirect()->back();
    }

    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();
        return view('backend.admin.roles.show', compact('role','rolePermissions'));

    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::orderBy('name','ASC')->get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        return view('backend.admin.roles.edit', compact('role','permission','rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'department_id' => 'required',
            'permission' => 'required',
        ]);


        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->department_id = $request->input('department_id');
        $role->save();


        $role->syncPermissions($request->input('permission'));


        Toastr::success('Role Permission Updated Successfully','Success');
        return redirect()->back();
    }

    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        Toastr::success('Role Permission Deleted Successfully','Success');
        return redirect()->back();
    }

    public function create_permission(Request $request)
    {
        /*$this->validate($request, [
        'name' => 'required|unique:permissions,name',
        ]);

        Permission::create(['name' => $request->input('name')]);*/

        $this->validate($request, [
            'name' => 'required|unique:permissions,name',
            //'controller_name' => 'required',
        ]);

        Permission::create(['name' => $request->input('name')]);

        Toastr::success('Role List Created Successfully');
        return redirect()->back();
    }
}
