<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Department;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    public function index()
    {
        $departments = Department::latest()->get();
        return view('backend.admin.departments.index',compact('departments'));
    }

    public function create()
    {
        return view('backend.admin.departments.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            ]);
        $department = new Department();
        $department->name = $request->name;
        $department->save();
        Toastr::success('Department Created Successfully');
        return redirect()->route('admin.departments.index');
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $department = Department::find($id);
        return view('backend.admin.departments.edit',compact('department'));
    }

    public function update(Request $request, $id)
    {
        $department = Department::find($id);
        $department->name = $request->name;
        $department->save();
        Toastr::success('Department Updated Successfully');
        return redirect()->route('admin.departments.index');
    }


    public function destroy($id)
    {
        //
    }
}
