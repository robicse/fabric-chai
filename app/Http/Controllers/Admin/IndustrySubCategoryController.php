<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\IndustryCategory;
use App\Model\IndustrySubCategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IndustrySubCategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:industry-sub-categories-list|industry-sub-categories-create|industry-sub-categories-edit', ['only' => ['index','store']]);
        $this->middleware('permission:industry-sub-categories-create', ['only' => ['create','store']]);
        $this->middleware('permission:industry-sub-categories-edit', ['only' => ['edit','update']]);
//        $this->middleware('permission:units-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $industrySubCategories = IndustrySubCategory::latest()->get();
        return view('backend.admin.industry_sub_categories.index',compact('industrySubCategories'));
    }

    public function create()
    {
        $industryCategories = IndustryCategory::all();
        return view('backend.admin.industry_sub_categories.create',compact('industryCategories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'industry_category_id'=> 'required',
            //'name'=> 'required|unique:industry_categories,name',
        ]);

        $check_exists = IndustrySubCategory::where('name',$request->name)
            ->where('industry_category_id',$request->industry_category_id)
            ->pluck('id')
            ->first();
        if(!empty($check_exists)){
            Toastr::warning('Industry Sub Category Name Already Exists Under This Industry Category, Please Try Another Name');
            return back();
        }

        $industrySubCategory = new IndustrySubCategory();
        $industrySubCategory->name = $request->name;
        $industrySubCategory->name_bn = $request->name_bn;
        $industrySubCategory->slug = Str::slug($request->name).'-'.Str::random(5);
        $industrySubCategory->industry_category_id = $request->industry_category_id;
        $industrySubCategory->save();

        Toastr::success('Industry Sub Category Created Successfully');
        return redirect()->route('admin.industry-sub-categories.index');

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $industrySubCategory = IndustrySubCategory::find($id);
        $industryCategories = IndustryCategory::all();
        return view('backend.admin.industry_sub_categories.edit',compact('industrySubCategory','industryCategories'));
    }

    public function update(Request $request, $id)
    {
        $industrySubCategory = IndustrySubCategory::find($id);
        $industrySubCategory->name = $request->name;
        $industrySubCategory->name_bn = $request->name_bn;
        $industrySubCategory->slug = Str::slug($request->name).'-'.Str::random(5);
        $industrySubCategory->industry_category_id = $request->industry_category_id;
        $industrySubCategory->save();
        Toastr::success('Industry Category Eight Updated Successfully');
        return redirect()->route('admin.industry-sub-categories.index');
    }

    public function destroy($id)
    {
        //
    }
}
