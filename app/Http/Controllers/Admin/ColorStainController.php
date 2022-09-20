<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\ColorStain;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class ColorStainController extends Controller
{

    public function index()
    {
        $colorStains = ColorStain::latest()->get();
        return view('backend.admin.color_staining.index',compact('colorStains'));
    }

    public function create()
    {
        return view('backend.admin.color_staining.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|unique:color_stains,name',

        ]);
        $colorStain = new ColorStain();
        $colorStain->name = $request->name;
        $colorStain->save();

        Toastr::success('Color Staining Inserted Successfully');
        return redirect()->route('admin.color-staining.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $colorStain = ColorStain::find($id);
        return view('backend.admin.color_staining.edit',compact('colorStain'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name'=>'required|unique:color_stains,name,'.$id,

        ]);
        $colorStain = ColorStain::find($id);
        $colorStain->name = $request->name;
        $colorStain->save();

        Toastr::success('Color Staining Updated Successfully');
        return redirect()->route('admin.color-staining.index');
    }

    public function destroy($id)
    {
        //
    }
}
