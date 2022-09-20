<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\SubSubChildCategory;
use App\Model\SubSubCategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubSubChildCategoryController extends Controller
{
    function __construct(Request $request)
    {
        if ($request->segment(2) == 'sub-sub-child-categories'){
            $this->middleware('permission:sub-sub-child-categories-list|sub-sub-child-categories-create|sub-sub-child-categories-edit', ['only' => ['index','store']]);
            $this->middleware('permission:sub-sub-child-categories-create', ['only' => ['create','store']]);
            $this->middleware('permission:sub-sub-child-categories-edit', ['only' => ['edit','update']]);
        }else{
            $this->middleware('permission:work-order-sub-sub-child-categories-list|work-order-sub-sub-child-categories-create|work-order-sub-sub-child-categories-edit', ['only' => ['index','store']]);
            $this->middleware('permission:work-order-sub-sub-child-categories-create', ['only' => ['create','store']]);
            $this->middleware('permission:work-order-sub-sub-child-categories-edit', ['only' => ['edit','update']]);
        }
    }
    public function index(Request $request)
    {
        if ($request->segment(2) == 'sub-sub-child-categories'){
            $subSubChildCategories = SubSubChildCategory::where('type','product')->get();
        }else{
            $subSubChildCategories = SubSubChildCategory::where('type','work_order')->get();
        }
        return view('backend.admin.sub_sub_child_categories.index', compact('subSubChildCategories'));
    }

    public function create(Request $request)
    {
        if ($request->segment(2) == 'sub-sub-child-categories'){
            $subSubCategories = SubSubCategory::where('type','product')->get();
        }else{
            $subSubCategories = SubSubCategory::where('type','work_order')->get();
        }
        return view('backend.admin.sub_sub_child_categories.create',compact('subSubCategories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=> 'required',
        ]);

        $check = SubSubChildCategory::where('sub_sub_category_id',$request->sub_sub_category_id)->where('name',$request->name)->first();
        if (empty($check)){
            $subSubChildCategory = new SubSubChildCategory();
            $subSubChildCategory->name = $request->name;
            $subSubChildCategory->name_bn = $request->name_bn;
            $subSubChildCategory->sub_sub_category_id = $request->sub_sub_category_id;
            $subSubChildCategory->slug = Str::slug($request->name).'-'.Str::random(5);
            $subSubChildCategory->meta_title = $request->meta_title;
            $subSubChildCategory->meta_description = $request->meta_description;
            if ($request->segment(2) == 'sub-sub-child-categories'){
                $subSubChildCategory->type = 'product';
            }else{
                $subSubChildCategory->type = 'work_order';
            }
            $subSubChildCategory->save();
            Toastr::success('Sub Sub Child Categories Created Successfully');
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
        if ($request->segment(2) == 'sub-sub-child-categories'){
            $subSubCategories = SubSubCategory::where('type','product')->get();
        }else{
            $subSubCategories = SubSubCategory::where('type','work_order')->get();
        }
        $subSubChildCategory = SubSubChildCategory::find($id);
        return view('backend.admin.sub_sub_child_categories.edit',compact('subSubCategories','subSubChildCategory'));
    }

    public function update(Request $request, $id)
    {
        $check = SubSubChildCategory::where('sub_sub_category_id',$request->sub_sub_category_id)->where('name',$request->name)->where('name_bn',$request->name_bn)->first();
        if (empty($check)){
            $subSubChildCategory = SubSubChildCategory::find($id);
            $subSubChildCategory->name = $request->name;
            $subSubChildCategory->name_bn = $request->name_bn;
            $subSubChildCategory->sub_sub_category_id = $request->sub_sub_category_id;
            $subSubChildCategory->slug = Str::slug($request->name).'-'.Str::random(5);
            $subSubChildCategory->meta_title = $request->meta_title;
            $subSubChildCategory->meta_description = $request->meta_description;
            $subSubChildCategory->save();
            Toastr::success('Sub Sub Child Categories Updated Successfully');
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
