<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\CategorySeven;
use App\Model\CategorySix;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategorySevenController extends Controller
{
    function __construct(Request $request)
    {
        if ($request->segment(2) == 'category-seven'){
            $this->middleware('permission:category-seven-list|category-seven-create|category-seven-edit', ['only' => ['index','store']]);
            $this->middleware('permission:category-seven-create', ['only' => ['create','store']]);
            $this->middleware('permission:category-seven-edit', ['only' => ['edit','update']]);
        }else{
            $this->middleware('permission:work-order-category-seven-list|work-order-category-seven-create|work-order-category-seven-edit', ['only' => ['index','store']]);
            $this->middleware('permission:work-order-category-seven-create', ['only' => ['create','store']]);
            $this->middleware('permission:work-order-category-seven-edit', ['only' => ['edit','update']]);
        }
    }
    public function index(Request $request)
    {
        if ($request->segment(2) == 'category-seven'){
            $categorySevens = CategorySeven::where('type','product')->get();
        }else{
            $categorySevens = CategorySeven::where('type','work_order')->get();
        }
        return view('backend.admin.category_seven.index',compact('categorySevens'));
    }

    public function create(Request $request)
    {
        if ($request->segment(2) == 'category-seven'){
            $categorySixes = CategorySix::where('type','product')->get();
        }else{
            $categorySixes = CategorySix::where('type','work_order')->get();
        }
        return view('backend.admin.category_seven.create',compact('categorySixes'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=> 'required',
        ]);
        $check = CategorySeven::where('category_six_id',$request->category_six_id)->where('name',$request->name)->first();
        if (empty($check)){
            $categorySeven = new CategorySeven();
            $categorySeven->name = $request->name;
            $categorySeven->name_bn = $request->name_bn;
            $categorySeven->slug = Str::slug($request->name).'-'.Str::random(5);
            $categorySeven->category_six_id = $request->category_six_id;
            $categorySeven->meta_title = $request->meta_title;
            $categorySeven->meta_description = $request->meta_description;
            if ($request->segment(2) == 'category-seven'){
                $categorySeven->type = 'product';
            }else{
                $categorySeven->type = 'work_order';
            }
            $categorySeven->save();
            Toastr::success('Category Seven Created Successfully');
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
        $categorySeven = CategorySeven::find($id);
        if ($request->segment(2) == 'category-seven'){
            $categorySixes = CategorySix::where('type','product')->get();
        }else{
            $categorySixes = CategorySix::where('type','work_order')->get();
        }
        return view('backend.admin.category_seven.edit',compact('categorySeven','categorySixes'));
    }

    public function update(Request $request, $id)
    {
        $check = CategorySeven::where('category_six_id',$request->category_six_id)->where('name',$request->name)->where('name_bn',$request->name_bn)->first();
        if (empty($check)){
            $categorySeven = CategorySeven::find($id);
            $categorySeven->name = $request->name;
            $categorySeven->name_bn = $request->name_bn;
            $categorySeven->slug = Str::slug($request->name).'-'.Str::random(5);
            $categorySeven->category_six_id = $request->category_six_id;
            $categorySeven->meta_title = $request->meta_title;
            $categorySeven->meta_description = $request->meta_description;
            $categorySeven->save();
            Toastr::success('Category Seven Updated Successfully');
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
