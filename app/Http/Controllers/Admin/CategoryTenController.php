<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\CategoryNine;
use App\Model\CategoryTen;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryTenController extends Controller
{
    function __construct(Request $request)
    {
        if ($request->segment(2) == 'category-ten'){
            $this->middleware('permission:category-ten-list|category-ten-create|category-ten-edit', ['only' => ['index','store']]);
            $this->middleware('permission:category-ten-create', ['only' => ['create','store']]);
            $this->middleware('permission:category-ten-edit', ['only' => ['edit','update']]);
        }else{
            $this->middleware('permission:work-order-category-ten-list|work-order-category-ten-create|work-order-category-ten-edit', ['only' => ['index','store']]);
            $this->middleware('permission:work-order-category-ten-create', ['only' => ['create','store']]);
            $this->middleware('permission:work-order-category-ten-edit', ['only' => ['edit','update']]);
        }
    }
    public function index(Request $request)
    {
        if ($request->segment(2) == 'category-ten'){
            $categoryTens = CategoryTen::where('type','product')->get();
        }else{
            $categoryTens = CategoryTen::where('type','work_order')->get();
        }
        return view('backend.admin.category_ten.index',compact('categoryTens'));
    }

    public function create(Request $request)
    {
        if ($request->segment(2) == 'category-ten'){
            $categoryNines = CategoryNine::where('type','product')->get();
        }else{
            $categoryNines = CategoryNine::where('type','work_order')->get();
        }
        return view('backend.admin.category_ten.create',compact('categoryNines'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=> 'required',
        ]);
        $check = CategoryTen::where('category_nine_id',$request->category_nine_id)->where('name',$request->name)->first();
        if (empty($check)){
            $categoryTen = new CategoryTen();
            $categoryTen->name = $request->name;
            $categoryTen->name_bn = $request->name_bn;
            $categoryTen->slug = Str::slug($request->name).'-'.Str::random(5);
            $categoryTen->category_nine_id = $request->category_nine_id;
            $categoryTen->meta_title = $request->meta_title;
            $categoryTen->meta_description = $request->meta_description;

            if ($request->segment(2) == 'category-ten'){
                $categoryTen->type = 'product';
            }else{
                $categoryTen->type = 'work_order';
            }

            $categoryTen->save();
            Toastr::success('Category Ten Created Successfully');
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
        $categoryTen = CategoryTen::find($id);
        if ($request->segment(2) == 'category-ten'){
            $categoryNines = CategoryNine::where('type','product')->get();
        }else{
            $categoryNines = CategoryNine::where('type','work_order')->get();
        }
        return view('backend.admin.category_ten.edit',compact('categoryTen','categoryNines'));
    }

    public function update(Request $request, $id)
    {
        $check = CategoryTen::where('category_nine_id',$request->category_nine_id)->where('name',$request->name)->where('name_bn',$request->name_bn)->first();
        if (empty($check)){
            $categoryTen = CategoryTen::find($id);
            $categoryTen->name = $request->name;
            $categoryTen->name_bn = $request->name_bn;
            $categoryTen->slug = Str::slug($request->name).'-'.Str::random(5);
            $categoryTen->category_nine_id = $request->category_nine_id;
            $categoryTen->meta_title = $request->meta_title;
            $categoryTen->meta_description = $request->meta_description;
            $categoryTen->save();
            Toastr::success('Category Ten Updated Successfully');
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
