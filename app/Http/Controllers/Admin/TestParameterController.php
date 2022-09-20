<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\TestParameter;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class TestParameterController extends Controller
{

    public function index()
    {
        $testParameters = TestParameter::latest()->get();
        return view('backend.admin.test_parameter.index',compact('testParameters'));
    }
    public function create()
    {
        return view('backend.admin.test_parameter.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'description'=>'required',
        ]);
        $testParameter = new TestParameter();
        $testParameter->name = $request->name;
        $testParameter->description = $request->description;
        $testParameter->save();

        Toastr::success('Test Parameter Inserted Successfully');
        return redirect()->route('admin.test-parameters.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $testParameter = TestParameter::find($id);
        return view('backend.admin.test_parameter.edit',compact('testParameter'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name'=>'required',
            'description'=>'required',
        ]);
        $testParameter = TestParameter::find($id);
        $testParameter->name = $request->name;
        $testParameter->description = $request->description;
        $testParameter->save();

        Toastr::success('Test Parameter Updated Successfully');
        return redirect()->route('admin.test-parameters.index');
    }

    public function destroy($id)
    {
        //
    }
    public function updateStatus(Request $request){

    }
}
