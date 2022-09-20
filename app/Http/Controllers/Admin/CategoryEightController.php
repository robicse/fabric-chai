<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\CategoryEight;
use App\Model\CategorySeven;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryEightController extends Controller
{
    function __construct(Request $request)
    {
        if ($request->segment(2) == 'category-eight'){
            $this->middleware('permission:category-eight-list|category-eight-create|category-eight-edit', ['only' => ['index','store']]);
            $this->middleware('permission:category-eight-create', ['only' => ['create','store']]);
            $this->middleware('permission:category-eight-edit', ['only' => ['edit','update']]);
        }else{
            $this->middleware('permission:work-order-category-eight-list|work-order-category-eight-create|work-order-category-eight-edit', ['only' => ['index','store']]);
            $this->middleware('permission:work-order-category-eight-create', ['only' => ['create','store']]);
            $this->middleware('permission:work-order-category-eight-edit', ['only' => ['edit','update']]);
        }
    }
    public function index(Request $request)
    {
        if ($request->segment(2) == 'category-eight'){
            $categoryEights = CategoryEight::where('type','product')->get();
        }else{
            $categoryEights = CategoryEight::where('type','work_order')->get();
        }
        return view('backend.admin.category_eight.index',compact('categoryEights'));
    }

    public function create(Request $request)
    {
        if ($request->segment(2) == 'category-eight'){
            $categorySevens = CategorySeven::where('type','product')->get();
        }else{
            $categorySevens = CategorySeven::where('type','work_order')->get();
        }
        return view('backend.admin.category_eight.create',compact('categorySevens'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=> 'required',
        ]);
        $check = CategoryEight::where('category_seven_id',$request->category_seven_id)->where('name',$request->name)->where('name_bn',$request->name_bn)->first();
        if (empty($check)){
            $categoryEight = new CategoryEight();
            $categoryEight->name = $request->name;
            $categoryEight->name_bn = $request->name_bn;
            $categoryEight->slug = Str::slug($request->name).'-'.Str::random(5);
            $categoryEight->category_seven_id = $request->category_seven_id;
            $categoryEight->meta_title = $request->meta_title;
            $categoryEight->meta_description = $request->meta_description;
            if ($request->segment(2) == 'category-eight'){
                $categoryEight->type = 'product';
            }else{
                $categoryEight->type = 'work_order';
            }
            $categoryEight->save();
            Toastr::success('Category Eight Created Successfully');
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
        $categoryEight = CategoryEight::find($id);
        if ($request->segment(2) == 'category-eight'){
            $categorySevens = CategorySeven::where('type','product')->get();
        }else{
            $categorySevens = CategorySeven::where('type','work_order')->get();
        }
        return view('backend.admin.category_eight.edit',compact('categoryEight','categorySevens'));
    }

    public function update(Request $request, $id)
    {
        $check = CategoryEight::where('category_seven_id',$request->category_seven_id)->where('name',$request->name)->where('name_bn',$request->name_bn)->first();
        if (empty($check)){
            $categoryEight = CategoryEight::find($id);
            $categoryEight->name = $request->name;
            $categoryEight->name_bn = $request->name_bn;
            $categoryEight->slug = Str::slug($request->name).'-'.Str::random(5);
            $categoryEight->category_seven_id = $request->category_seven_id;
            $categoryEight->meta_title = $request->meta_title;
            $categoryEight->meta_description = $request->meta_description;
            $categoryEight->save();
            Toastr::success('Category Eight Updated Successfully');
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
