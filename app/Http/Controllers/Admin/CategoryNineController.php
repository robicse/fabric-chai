<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\CategoryEight;
use App\Model\CategoryNine;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryNineController extends Controller
{
    function __construct(Request $request)
    {
        if ($request->segment(2) == 'category-nine'){
            $this->middleware('permission:category-nine-list|category-nine-create|category-nine-edit', ['only' => ['index','store']]);
            $this->middleware('permission:category-nine-create', ['only' => ['create','store']]);
            $this->middleware('permission:category-nine-edit', ['only' => ['edit','update']]);
        }else{
            $this->middleware('permission:work-order-category-nine-list|work-order-category-nine-create|work-order-category-nine-edit', ['only' => ['index','store']]);
            $this->middleware('permission:work-order-category-nine-create', ['only' => ['create','store']]);
            $this->middleware('permission:work-order-category-nine-edit', ['only' => ['edit','update']]);
        }
    }
    public function index(Request $request)
    {
        if ($request->segment(2) == 'category-nine'){
            $categoryNines = CategoryNine::where('type','product')->get();
        }else{
            $categoryNines = CategoryNine::where('type','work_order')->get();
        }
        return view('backend.admin.category_nine.index',compact('categoryNines'));
    }

    public function create(Request $request)
    {
        if ($request->segment(2) == 'category-nine'){
            $categoryEights = CategoryEight::where('type','product')->get();
        }else{
            $categoryEights = CategoryEight::where('type','work_order')->get();
        }
        return view('backend.admin.category_nine.create',compact('categoryEights'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=> 'required',
        ]);
        $check = CategoryNine::where('category_eight_id',$request->category_eight_id)->where('name',$request->name)->first();
        if (empty($check)){
            $categoryNine = new CategoryNine();
            $categoryNine->name = $request->name;
            $categoryNine->name_bn = $request->name_bn;
            $categoryNine->slug = Str::slug($request->name).'-'.Str::random(5);
            $categoryNine->category_eight_id = $request->category_eight_id;
            $categoryNine->meta_title = $request->meta_title;
            $categoryNine->meta_description = $request->meta_description;
            if ($request->segment(2) == 'category-nine'){
                $categoryNine->type = 'product';
            }else{
                $categoryNine->type = 'work_order';
            }
            $categoryNine->save();
            Toastr::success('Category Nine Created Successfully');
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
        $categoryNine = CategoryNine::find($id);
        if ($request->segment(2) == 'category-nine'){
            $categoryEights = CategoryEight::where('type','product')->get();
        }else{
            $categoryEights = CategoryEight::where('type','work_order')->get();
        }
        return view('backend.admin.category_nine.edit',compact('categoryNine','categoryEights'));
    }

    public function update(Request $request, $id)
    {
        $check = CategoryNine::where('category_eight_id',$request->category_eight_id)->where('name',$request->name)->where('name_bn',$request->name_bn)->first();
        if (empty($check)){
            $categoryNine = CategoryNine::find($id);
            $categoryNine->name = $request->name;
            $categoryNine->name_bn = $request->name_bn;
            $categoryNine->slug = Str::slug($request->name).'-'.Str::random(5);
            $categoryNine->category_eight_id = $request->category_eight_id;
            $categoryNine->meta_title = $request->meta_title;
            $categoryNine->meta_description = $request->meta_description;
            $categoryNine->save();
            Toastr::success('Category Nine Updated Successfully');
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
