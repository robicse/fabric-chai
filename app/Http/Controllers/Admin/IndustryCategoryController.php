<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\IndustryCategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IndustryCategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:industry-categories-list|industry-categories-create|industry-categories-edit', ['only' => ['index','store']]);
        $this->middleware('permission:industry-categories-create', ['only' => ['create','store']]);
        $this->middleware('permission:industry-categories-edit', ['only' => ['edit','update']]);
//        $this->middleware('permission:units-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $industryCategories = IndustryCategory::latest()->get();
        return view('backend.admin.industry_categories.index',compact('industryCategories'));
    }

    public function create()
    {
        return view('backend.admin.industry_categories.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=> 'required|unique:industry_categories,name',
        ]);

        $industryCategory = new IndustryCategory();
        $industryCategory->name = $request->name;
        $industryCategory->name_bn = $request->name_bn;
        $industryCategory->slug = Str::slug($request->name).'-'.Str::random(5);
        $industryCategory->save();

        Toastr::success('Industry Category Created Successfully');
        return redirect()->route('admin.industry-categories.index');

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $industryCategory = IndustryCategory::find($id);
        return view('backend.admin.industry_categories.edit',compact('industryCategory'));
    }

    public function update(Request $request, $id)
    {
        $industryCategory = IndustryCategory::find($id);
        $industryCategory->name = $request->name;
        $industryCategory->name_bn = $request->name_bn;
        $industryCategory->slug = Str::slug($request->name).'-'.Str::random(5);
        $industryCategory->save();
        Toastr::success('Industry Category Updated Successfully');
        return redirect()->route('admin.industry-categories.index');
    }

    public function destroy($id)
    {
        //
    }
}
