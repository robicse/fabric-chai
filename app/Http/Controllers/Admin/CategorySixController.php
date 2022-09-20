<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\CategorySix;
use App\Model\SubSubChildChildCategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategorySixController extends Controller
{
    function __construct(Request $request)
    {
        if ($request->segment(2) == 'category-six'){
            $this->middleware('permission:category-six-list|category-six-create|category-six-edit', ['only' => ['index','store']]);
            $this->middleware('permission:category-six-create', ['only' => ['create','store']]);
            $this->middleware('permission:category-six-edit', ['only' => ['edit','update']]);
        }else{
            $this->middleware('permission:work-order-category-six-list|work-order-category-six-create|work-order-category-six-edit', ['only' => ['index','store']]);
            $this->middleware('permission:work-order-category-six-create', ['only' => ['create','store']]);
            $this->middleware('permission:work-order-category-six-edit', ['only' => ['edit','update']]);
        }
    }
    public function index(Request $request)
    {
        if ($request->segment(2) == 'category-six'){
            $categorySixes = CategorySix::where('type','product')->get();
        }else{
            $categorySixes = CategorySix::where('type','work_order')->get();
        }
        return view('backend.admin.category_six.index',compact('categorySixes'));
    }

    public function create(Request $request)
    {
        if ($request->segment(2) == 'category-six'){
            $categoryFives = SubSubChildChildCategory::where('type','product')->get();
        }else{
            $categoryFives = SubSubChildChildCategory::where('type','work_order')->get();
        }
        return view('backend.admin.category_six.create',compact('categoryFives'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=> 'required',
            'sub_sub_child_child_cat_id'=> 'required',
        ]);
        $check = CategorySix::where('sub_sub_child_child_cat_id',$request->sub_sub_child_child_cat_id)->where('name',$request->name)->first();
        if (empty($check)){
            $categorySix = new CategorySix();
            $categorySix->name = $request->name;
            $categorySix->name_bn = $request->name_bn;
            $categorySix->slug = Str::slug($request->name).'-'.Str::random(5);
            $categorySix->sub_sub_child_child_cat_id = $request->sub_sub_child_child_cat_id;
            $categorySix->meta_title = $request->meta_title;
            $categorySix->meta_description = $request->meta_description;
            if ($request->segment(2) == 'category-six'){
                $categorySix->type = 'product';
            }else{
                $categorySix->type = 'work_order';
            }
            $categorySix->save();
            Toastr::success('Category Six Created Successfully');
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
        $categorySix = CategorySix::find($id);
        if ($request->segment(2) == 'category-six'){
            $categoryFives = SubSubChildChildCategory::where('type','product')->get();
        }else{
            $categoryFives = SubSubChildChildCategory::where('type','work_order')->get();
        }
        return view('backend.admin.category_six.edit',compact('categorySix','categoryFives'));
    }

    public function update(Request $request, $id)
    {
        $check = CategorySix::where('sub_sub_child_child_cat_id',$request->sub_sub_child_child_cat_id)->where('name',$request->name)->where('name_bn',$request->name_bn)->first();
        if (empty($check)){
            $categorySix = CategorySix::find($id);
            $categorySix->name = $request->name;
            $categorySix->name_bn = $request->name_bn;
            $categorySix->slug = Str::slug($request->name).'-'.Str::random(5);
            $categorySix->sub_sub_child_child_cat_id = $request->sub_sub_child_child_cat_id;
            $categorySix->meta_title = $request->meta_title;
            $categorySix->meta_description = $request->meta_description;
            $categorySix->save();
            Toastr::success('Category Six Updated Successfully');
            return back();
        }else{
            Toastr::error('Already exists');
            return back();
        }

    }

    public function destroy($id)
    {
        //
    }
}
