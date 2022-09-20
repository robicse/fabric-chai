<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\CityCorporation;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class CityCorporationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:city-corporations-list|city-corporations-create|city-corporations-edit', ['only' => ['index','store']]);
        $this->middleware('permission:city-corporations-create', ['only' => ['create','store']]);
        $this->middleware('permission:city-corporations-edit', ['only' => ['edit','update']]);
//        $this->middleware('permission:units-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $cityCorporations = CityCorporation::latest()->get();
        return view('backend.admin.city_corporations.index',compact('cityCorporations'));
    }

    public function create()
    {
        return view('backend.admin.city_corporations.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
        ]);
        $cityCorporation = new CityCorporation();
        $cityCorporation->name = $request->name;
        $cityCorporation->save();

        Toastr::success('City Corporation Inserted Successfully');
        return redirect()->route('admin.city-corporations.index');
    }

    public function show($id)
    {
       //
    }

    public function edit($id)
    {
        $cityCorporation = CityCorporation::find($id);
        return view('backend.admin.city_corporations.edit',compact('cityCorporation'));
    }

    public function update(Request $request, $id)
    {
        $cityCorporation = CityCorporation::find($id);
        $cityCorporation->name = $request->name;
        $cityCorporation->save();

        Toastr::success('City Corporation Updated Successfully');
        return redirect()->route('admin.city-corporations.index');
    }

    public function destroy($id)
    {
        $cityCorporation = CityCorporation::find($id);
        $cityCorporation->delete();

        Toastr::success('City Corporation Deleted Successfully');
        return back();
    }
}
