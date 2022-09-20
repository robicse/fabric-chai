<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\ColorFastness;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class ColorFastnessController extends Controller
{
    public function index()
    {
        $colorFastnesses = ColorFastness::latest()->get();
        return view('backend.admin.color_fastness.index',compact('colorFastnesses'));
    }

    public function create()
    {
        return view('backend.admin.color_fastness.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|unique:color_fastnesses,name',

        ]);
        $colorFastness = new ColorFastness();
        $colorFastness->name = $request->name;
        $colorFastness->save();

        Toastr::success('Color Fastness Inserted Successfully');
        return redirect()->route('admin.color-fastness.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $colorFastness = ColorFastness::find($id);
        return view('backend.admin.color_fastness.edit',compact('colorFastness'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name'=>'required|unique:color_fastnesses,name,'.$id,

        ]);
        $colorFastness = ColorFastness::find($id);
        $colorFastness->name = $request->name;
        $colorFastness->save();

        Toastr::success('Color Fastness Updated Successfully');
        return redirect()->route('admin.color-fastness.index');
    }

    public function destroy($id)
    {
        //
    }
}
