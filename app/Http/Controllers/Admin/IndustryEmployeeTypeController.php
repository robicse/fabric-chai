<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\IndustryCategory;
use App\Model\IndustryEmployeeType;
use App\Model\IndustrySubCategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IndustryEmployeeTypeController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:industry-employee-types-list|industry-employee-types-create|industry-employee-types-edit', ['only' => ['index','store']]);
        $this->middleware('permission:industry-employee-types-create', ['only' => ['create','store']]);
        $this->middleware('permission:industry-employee-types-edit', ['only' => ['edit','update']]);
//        $this->middleware('permission:units-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $industryEmployeeTypes = IndustryEmployeeType::latest()->get();
        return view('backend.admin.industry_employee_types.index',compact('industryEmployeeTypes'));
    }

    public function create()
    {
        $industryCategories = IndustryCategory::all();
        $industrySubCategories = IndustrySubCategory::all();
        return view('backend.admin.industry_employee_types.create',compact('industryCategories','industrySubCategories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'industry_category_id'=> 'required',
            'industry_sub_category_id'=> 'required',
            //'name'=> 'required|unique:industry_categories,name',
        ]);

        $check_exists = IndustryEmployeeType::where('name',$request->name)
            ->where('industry_category_id',$request->industry_category_id)
            ->where('industry_sub_category_id',$request->industry_category_id)
            ->pluck('id')
            ->first();
        if(!empty($check_exists)){
            Toastr::warning('Industry Employee Type Name Already Exists Under This Industry Category And Industry Sub Category, Please Try Another Name');
            return back();
        }

        $industryEmployeeType = new IndustryEmployeeType();
        $industryEmployeeType->name = $request->name;
        $industryEmployeeType->name_bn = $request->name_bn;
        $industryEmployeeType->slug = Str::slug($request->name).'-'.Str::random(5);
        $industryEmployeeType->industry_category_id = $request->industry_category_id;
        $industryEmployeeType->industry_sub_category_id = $request->industry_sub_category_id;
        $industryEmployeeType->save();

        Toastr::success('Industry Employee Type Created Successfully');
        return redirect()->route('admin.industry-employee-types.index');

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $industryEmployeeType = IndustryEmployeeType::find($id);
        $industryCategories = IndustryCategory::all();
        $industrySubCategories = IndustrySubCategory::all();
        return view('backend.admin.industry_employee_types.edit',compact('industryEmployeeType','industryCategories','industrySubCategories'));
    }

    public function update(Request $request, $id)
    {
        $industryEmployeeType = IndustryEmployeeType::find($id);
        $industryEmployeeType->name = $request->name;
        $industryEmployeeType->name_bn = $request->name_bn;
        $industryEmployeeType->slug = Str::slug($request->name).'-'.Str::random(5);
        $industryEmployeeType->industry_category_id = $request->industry_category_id;
        $industryEmployeeType->industry_sub_category_id = $request->industry_sub_category_id;
        $industryEmployeeType->save();
        Toastr::success('Industry Employee Type Updated Successfully');
        return redirect()->route('admin.industry-employee-types.index');
    }

    public function destroy($id)
    {
        //
    }
}
