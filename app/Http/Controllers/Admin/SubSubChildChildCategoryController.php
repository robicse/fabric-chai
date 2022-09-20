<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\SubSubChildCategory;
use App\Model\SubSubChildChildCategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubSubChildChildCategoryController extends Controller
{
    function __construct(Request $request)
    {
        if ($request->segment(2) == 'sub-sub-child-child-categories'){
            $this->middleware('permission:sub-sub-child-child-categories-list|sub-sub-child-child-categories-create|sub-sub-child-child-categories-edit', ['only' => ['index','store']]);
            $this->middleware('permission:sub-sub-child-child-categories-create', ['only' => ['create','store']]);
            $this->middleware('permission:sub-sub-child-child-categories-edit', ['only' => ['edit','update']]);
        }else{
            $this->middleware('permission:work-order-sub-sub-child-child-categories-list|work-order-sub-sub-child-child-categories-create|work-order-sub-sub-child-child-categories-edit', ['only' => ['index','store']]);
            $this->middleware('permission:work-order-sub-sub-child-child-categories-create', ['only' => ['create','store']]);
            $this->middleware('permission:work-order-sub-sub-child-child-categories-edit', ['only' => ['edit','update']]);
        }
    }
    public function index(Request $request)
    {
        if ($request->segment(2) == 'sub-sub-child-child-categories'){
            $subSubChildChildCategories = SubSubChildChildCategory::where('type','product')->get();
        }else{
            $subSubChildChildCategories = SubSubChildChildCategory::where('type','work_order')->get();
        }
        return view('backend.admin.sub_sub_child_child_categories.index', compact('subSubChildChildCategories'));
    }

    public function create(Request $request)
    {
        if ($request->segment(2) == 'sub-sub-child-child-categories'){
            $subSubChildCategories = SubSubChildCategory::where('type','product')->get();
        }else{
            $subSubChildCategories = SubSubChildCategory::where('type','work_order')->get();
        }
        return view('backend.admin.sub_sub_child_child_categories.create',compact('subSubChildCategories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=> 'required',
        ]);
        $check = SubSubChildChildCategory::where('sub_Sub_child_cat_id',$request->sub_Sub_child_cat_id)->where('name',$request->name)->first();
        if (empty($check)){
            $subSubChildChildCategory = new SubSubChildChildCategory();
            $subSubChildChildCategory->name = $request->name;
            $subSubChildChildCategory->name_bn = $request->name_bn;
            $subSubChildChildCategory->sub_Sub_child_cat_id = $request->sub_sub_child_category_id;
            $subSubChildChildCategory->slug = Str::slug($request->name).'-'.Str::random(5);
            $subSubChildChildCategory->meta_title = $request->meta_title;
            $subSubChildChildCategory->meta_description = $request->meta_description;
            if ($request->segment(2) == 'sub-sub-child-child-categories'){
                $subSubChildChildCategory->type = 'product';
            }else{
                $subSubChildChildCategory->type = 'work_order';
            }
            $subSubChildChildCategory->save();
            Toastr::success('Sub Sub Child Child Categories Created Successfully');
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
        if ($request->segment(2) == 'sub-sub-child-child-categories'){
            $subSubChildCategories = SubSubChildCategory::where('type','product')->get();
        }else{
            $subSubChildCategories = SubSubChildCategory::where('type','work_order')->get();
        }
        $subSubChildChildCategory = SubSubChildChildCategory::find($id);
        return view('backend.admin.sub_sub_child_child_categories.edit',compact('subSubChildCategories','subSubChildChildCategory'));
    }

    public function update(Request $request, $id)
    {
        $check = SubSubChildChildCategory::where('sub_Sub_child_cat_id',$request->sub_Sub_child_cat_id)->where('name',$request->name)->where('name_bn',$request->name_bn)->first();
        if (empty($check)){
            $subSubChildChildCategory = SubSubChildChildCategory::find($id);
            $subSubChildChildCategory->name = $request->name;
            $subSubChildChildCategory->name_bn = $request->name_bn;
            $subSubChildChildCategory->sub_Sub_child_cat_id = $request->sub_sub_child_category_id;
            $subSubChildChildCategory->slug = Str::slug($request->name).'-'.Str::random(5);
            $subSubChildChildCategory->meta_title = $request->meta_title;
            $subSubChildChildCategory->meta_description = $request->meta_description;
            $subSubChildChildCategory->save();
            Toastr::success('Sub Sub Child Child Categories Updated Successfully');
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
