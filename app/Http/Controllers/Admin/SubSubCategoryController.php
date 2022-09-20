<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\SubCategory;
use App\Model\SubSubCategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubSubCategoryController extends Controller
{
    function __construct(Request $request)
    {
        if ($request->segment(2) == 'sub-sub-categories'){
            $this->middleware('permission:sub-sub-categories-list|sub-sub-categories-create|sub-sub-categories-edit', ['only' => ['index','store']]);
            $this->middleware('permission:sub-sub-categories-create', ['only' => ['create','store']]);
            $this->middleware('permission:sub-sub-categories-edit', ['only' => ['edit','update']]);
        }else{
            $this->middleware('permission:work-order-sub-sub-categories-list|work-order-sub-sub-categories-create|work-order-sub-sub-categories-edit', ['only' => ['index','store']]);
            $this->middleware('permission:work-order-sub-sub-categories-create', ['only' => ['create','store']]);
            $this->middleware('permission:work-order-sub-sub-categories-edit', ['only' => ['edit','update']]);
        }
    }
    public function index(Request $request)
    {
        if ($request->segment(2) == 'sub-sub-categories'){
            $subsubcategories = SubSubCategory::where('type','product')->get();
        }else{
            $subsubcategories = SubSubCategory::where('type','work_order')->get();
        }
        return view('backend.admin.sub_sub_categories.index', compact('subsubcategories'));
    }

    public function create(Request $request)
    {
        if ($request->segment(2) == 'sub-sub-categories'){
            $subcategories = SubCategory::where('type','product')->get();
        }else{
            $subcategories = SubCategory::where('type','work_order')->get();
        }
        return view('backend.admin.sub_sub_categories.create',compact('subcategories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=> 'required',
        ]);
        $check = SubSubCategory::where('sub_category_id',$request->sub_category_id)->where('name',$request->name)->first();
        if (empty($check)){
            $subcategory = new SubSubCategory();
            $subcategory->name = $request->name;
            $subcategory->name_bn = $request->name_bn;
            $subcategory->sub_category_id = $request->sub_category_id;
            $subcategory->slug = Str::slug($request->name).'-'.Str::random(5);
            $subcategory->meta_title = $request->meta_title;
            $subcategory->meta_description = $request->meta_description;
            if ($request->segment(2) == 'sub-sub-categories'){
                $subcategory->type = 'product';
            }else{
                $subcategory->type = 'work_order';
            }
            $subcategory->save();
            Toastr::success('Sub Sub Categories Created Successfully');
            return back();
        }else{
            Toastr::error('Already exists');
            return back();
        }

    }

    public function show($id)
    {
        //
    }

    public function edit(Request $request,$id)
    {
        if ($request->segment(2) == 'sub-sub-categories'){
            $subcategories = SubCategory::where('type','product')->get();
        }else{
            $subcategories = SubCategory::where('type','work_order')->get();
        }
        $subsubcategory = SubSubCategory::find($id);
        return view('backend.admin.sub_sub_categories.edit',compact('subcategories','subsubcategory'));
    }

    public function update(Request $request, $id)
    {
        $check = SubSubCategory::where('sub_category_id',$request->sub_category_id)->where('name',$request->name)->where('name_bn',$request->name_bn)->first();
        if (empty($check)){
            $subcategory = SubSubCategory::find($id);
            $subcategory->name = $request->name;
            $subcategory->name_bn = $request->name_bn;
            $subcategory->sub_category_id = $request->sub_category_id;
            $subcategory->slug = Str::slug($request->name).'-'.Str::random(5);
            $subcategory->meta_title = $request->meta_title;
            $subcategory->meta_description = $request->meta_description;
            $subcategory->save();
            Toastr::success('Sub SubCategories Updated Successfully');
            return back();
        }else{
            Toastr::error('Already exists');
            return back();
        }

    }

    public function destroy($id)
    {
    }
}
