<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\MachineType;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class MachineTypeController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:machine-type-list|machine-type-create|machine-type-edit', ['only' => ['index','store']]);
        $this->middleware('permission:machine-type-create', ['only' => ['create','store']]);
        $this->middleware('permission:machine-type-edit', ['only' => ['edit','update']]);
    }
    public function index()
    {
        $machine_types = MachineType::all();
        return view('backend.admin.machine_type.index',compact('machine_types'));
    }

    public function create()
    {
        return view('backend.admin.machine_type.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=> 'required|unique:machine_types,name',
        ]);
        $machine_type = new MachineType();
        $machine_type->name = $request->name;
        $machine_type->name_bn = $request->name_bn;
        $machine_type->save();
        Toastr::success('Machine Type created successfully');
        return redirect()->route('admin.machine-type.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $machine_type = MachineType::find($id);
        return view('backend.admin.machine_type.edit',compact('machine_type'));
    }

    public function update(Request $request, $id)
    {
        $machine_type = MachineType::find($id);
        $machine_type->name = $request->name;
        $machine_type->name_bn = $request->name_bn;
        $machine_type->save();
        Toastr::success('Machine Type updated successfully');
        return redirect()->route('admin.machine-type.index');
    }

    public function destroy($id)
    {
        //
    }
}
