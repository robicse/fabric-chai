<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Unit;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class UnitController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:units-list|units-create|units-edit', ['only' => ['index','store']]);
        $this->middleware('permission:units-create', ['only' => ['create','store']]);
        $this->middleware('permission:units-edit', ['only' => ['edit','update']]);
//        $this->middleware('permission:units-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $units = Unit::all();
        return view('backend.admin.units.index', compact('units'));
    }

    public function create()
    {
        return view('backend.admin.units.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=> 'required|unique:units,name',
        ]);

        $unit = new Unit;
        $unit->name = $request->name;
        $unit->name_bn = $request->name_bn;
        $unit->slug = Str::slug($request->name);
        $unit->save();
        Toastr::success('Unit Created Successfully');
        return back();


    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $unit = Unit::find($id);
        return view('backend.admin.units.edit',compact('unit'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=> 'required|unique:units,name,'.$id,
        ]);

        $unit = Unit::find($id);
        $unit->name = $request->name;
        $unit->name_bn = $request->name_bn;
        $unit->slug = Str::slug($request->name);
        $unit->save();
        Toastr::success('Unit updated successfully','Success');
        return back();
    }

    public function destroy($id)
    {
        $unit = Unit::find($id);
        $unit->delete();
        Toastr::success('Unit deleted successfully','Success');
        return back();
    }
}
