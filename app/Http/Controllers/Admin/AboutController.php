<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\About;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:about-us-list|about-us-edit', ['only' => ['index','store']]);
        $this->middleware('permission:about-us-edit', ['only' => ['edit','update']]);
    }
    public function index()
    {
        $about_us = About::first();
        return view('backend.admin.about_us.index',compact('about_us'));
    }

    public function create()
    {
        return view('backend.admin.about_us.create');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'image'=> 'required',
        ]);
        $check = About::first();
        if (empty($check)){
            $about_us = new About();
            if($request->hasFile('image')){
                $about_us->image = $request->image->store('uploads/about_us');
            }
            $about_us->description = $request->description;
            $about_us->description_bn = $request->description_bn;
            $about_us->save();
            Toastr::success('About Us created successfully', 'Success');
            return redirect()->route('admin.about-us.index');
        }else{
            Toastr::error('Already Exists', 'Error');
            return redirect()->route('admin.about-us.index');
        }


    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $about_us =  About::find($id);
        return view('backend.admin.about_us.edit',compact('about_us'));
    }

    public function update(Request $request, $id)
    {
            $about_us =  About::find($id);
            if($request->hasFile('image')){
                $about_us->image = $request->image->store('uploads/about_us');
            }
            $about_us->description = $request->description;
            $about_us->description_bn = $request->description_bn;
            $about_us->save();
            Toastr::success('About Us Updated successfully', 'Success');
            return redirect()->route('admin.about-us.index');
    }

    public function destroy($id)
    {
        $about_us =  About::find($id);
        $about_us->delete();
        Toastr::success('About Us Deleted successfully', 'Success');
        return redirect()->route('admin.about-us.index');

    }
}
