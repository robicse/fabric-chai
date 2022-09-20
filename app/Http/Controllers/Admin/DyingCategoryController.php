<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\DyingCategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DyingCategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:dying-categories-list|dying-categories-create|dying-categories-edit', ['only' => ['index','store']]);
        $this->middleware('permission:dying-categories-create', ['only' => ['create','store']]);
        $this->middleware('permission:dying-categories-edit', ['only' => ['edit','update']]);
    }
    public function index()
    {
        $dyingCategories = DyingCategory::all();
        return view('backend.admin.dying_categories.index',compact('dyingCategories'));
    }

    public function create()
    {
        return view('backend.admin.dying_categories.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|unique:dying_categories,name',
        ]);

        $dyingCategory = new DyingCategory();
        $dyingCategory->name =$request->name;
        $dyingCategory->name_bn =$request->name_bn;
        $dyingCategory->slug =Str::slug($request->name).'-'.Str::random(5);
        $dyingCategory->save();

        Toastr::success('Dying Category inserted successfully');
        return redirect()->route('admin.dying-categories.index');

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $dyingCategory = DyingCategory::find($id);
        return view('backend.admin.dying_categories.edit',compact('dyingCategory'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name'=> 'required|unique:dying_categories,name,'.$id,
        ]);

        $dyingCategory = DyingCategory::find($id);
        $dyingCategory->name =$request->name;
        $dyingCategory->name_bn =$request->name_bn;
        $dyingCategory->slug =Str::slug($request->name).'-'.Str::random(5);
        $dyingCategory->save();

        Toastr::success('Dying Category updated successfully');
        return redirect()->route('admin.dying-categories.index');
    }

    public function destroy($id)
    {
        //
    }
}
