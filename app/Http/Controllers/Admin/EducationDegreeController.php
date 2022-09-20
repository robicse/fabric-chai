<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\EducationDegree;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class EducationDegreeController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:education-degrees-list|education-degrees-create|education-degrees-edit', ['only' => ['index','store']]);
        $this->middleware('permission:education-degrees-create', ['only' => ['create','store']]);
        $this->middleware('permission:education-degrees-edit', ['only' => ['edit','update']]);
//        $this->middleware('permission:units-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $educationDegrees = EducationDegree::all();
        return view('backend.admin.education_degrees.index',compact('educationDegrees'));
    }

    public function create()
    {
        return view('backend.admin.education_degrees.create');
    }

    public function store(Request $request)
    {
        $educationDegree = new EducationDegree();
        $educationDegree->education_level_id = $request->education_level_id;
        $educationDegree->name = $request->name;
        $educationDegree->save();

        Toastr::success('Education Degree Inserted Successfully');
        return redirect()->route('admin.education-degrees.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $educationDegree = EducationDegree::find($id);
        return view('backend.admin.education_degrees.edit',compact('educationDegree'));
    }

    public function update(Request $request, $id)
    {
        $educationDegree = EducationDegree::find($id);
        $educationDegree->education_level_id = $request->education_level_id;
        $educationDegree->name = $request->name;
        $educationDegree->save();

        Toastr::success('Education Degree Updated Successfully');
        return redirect()->route('admin.education-degrees.index');
    }

    public function destroy($id)
    {
        //
    }
}
