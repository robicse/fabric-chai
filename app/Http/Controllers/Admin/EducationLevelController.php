<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\EducationLevel;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class EducationLevelController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:education-levels-list|education-levels-create|education-levels-edit', ['only' => ['index','store']]);
        $this->middleware('permission:education-levels-create', ['only' => ['create','store']]);
        $this->middleware('permission:education-levels-edit', ['only' => ['edit','update']]);
    }

    public function index()
    {
        $educationLevels = EducationLevel::all();
        return view('backend.admin.education_levels.index',compact('educationLevels'));
    }

    public function create()
    {
        return view('backend.admin.education_levels.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required'
        ]);
        $educationLevel = new EducationLevel();
        $educationLevel->name = $request->name;
        $educationLevel->save();

        Toastr::success('Education Level Inserted Successfully');
        return redirect()->route('admin.education-levels.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $educationLevel = EducationLevel::find($id);
        return view('backend.admin.education_levels.edit',compact('educationLevel'));
    }


    public function update(Request $request, $id)
    {
        $educationLevel = EducationLevel::find($id);
        $educationLevel->name = $request->name;
        $educationLevel->save();

        Toastr::success('Education Level Updated Successfully');
        return redirect()->route('admin.education-levels.index');
    }

    public function destroy($id)
    {
        //
    }
}
