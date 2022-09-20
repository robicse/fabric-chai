<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\SubCategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class SubCategoryController extends Controller
{
    function __construct(Request $request)
    {
        if ($request->segment(2) == 'sub-categories'){
            $this->middleware('permission:sub-categories-list|sub-categories-create|sub-categories-edit', ['only' => ['index','store']]);
            $this->middleware('permission:sub-categories-create', ['only' => ['create','store']]);
            $this->middleware('permission:sub-categories-edit', ['only' => ['edit','update']]);
        }else{
            $this->middleware('permission:work-order-sub-categories-list|work-order-sub-categories-create|work-order-sub-categories-edit', ['only' => ['index','store']]);
            $this->middleware('permission:work-order-sub-categories-create', ['only' => ['create','store']]);
            $this->middleware('permission:work-order-sub-categories-edit', ['only' => ['edit','update']]);
        }
    }
    public function index(Request $request)
    {
        if ($request->segment(2) == 'sub-categories'){
            $subCategories = SubCategory::where('type','product')->get();
        }else{
            $subCategories = SubCategory::where('type','work_order')->get();
        }
        return view('backend.admin.sub_categories.index', compact('subCategories'));
    }

    public function create(Request $request)
    {
        if ($request->segment(2) == 'sub-categories'){
            $categories = Category::where('type','product')->get();
        }else{
            $categories = Category::where('type','work_order')->get();
        }
        return view('backend.admin.sub_categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=> 'required',
        ]);
        $check = SubCategory::where('category_id',$request->category_id)->where('name',$request->name)->first();
        if (empty($check)){
            $subCategory = new SubCategory();
            $subCategory->name = $request->name;
            $subCategory->name_bn = $request->name_bn;
            $subCategory->category_id = $request->category_id;
            $subCategory->slug = Str::slug($request->name).'-'.Str::random(5);
            $subCategory->meta_title = $request->meta_title;
            $subCategory->meta_description = $request->meta_description;
            if ($request->segment(2) == 'sub-categories'){
                $subCategory->type = 'product';
            }else{
                $subCategory->type = 'work_order';
            }
            $subCategory->save();
            Toastr::success('SubCategories Created Successfully');
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
        if ($request->segment(2) == 'sub-categories'){
            $categories = Category::where('type','product')->get();
        }else{
            $categories = Category::where('type','work_order')->get();
        }
        $subCategory = SubCategory::find($id);
        return view('backend.admin.sub_categories.edit',compact('categories','subCategory'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            //'name'=> 'required'.$id,
        ]);
        $check = SubCategory::where('category_id',$request->category_id)->where('name',$request->name)->where('name_bn',$request->name_bn)->first();
        if (empty($check)){
            $subCategory = SubCategory::find($id);
            $subCategory->name = $request->name;
            $subCategory->name_bn = $request->name_bn;
            $subCategory->category_id = $request->category_id;
            $subCategory->slug = Str::slug($request->name).'-'.Str::random(5);
            $subCategory->meta_title = $request->meta_title;
            $subCategory->meta_description = $request->meta_description;
            $subCategory->save();
            Toastr::success('Sub Categories Updated Successfully');
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
