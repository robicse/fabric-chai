<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\DyingSubcategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DyingSubcategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:dying-sub-categories-list|dying-sub-categories-create|dying-sub-categories-edit', ['only' => ['index','store']]);
        $this->middleware('permission:dying-sub-categories-create', ['only' => ['create','store']]);
        $this->middleware('permission:dying-sub-categories-edit', ['only' => ['edit','update']]);
    }
    public function index()
    {
        $dyingSubcategories = DyingSubcategory::latest()->get();
        return view('backend.admin.dying_subcategories.index',compact('dyingSubcategories'));
    }

    public function create()
    {
        return view('backend.admin.dying_subcategories.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
        ]);
        $dyingSubcategory = new DyingSubcategory();
        $dyingSubcategory->dying_category_id = $request->dying_category_id;
        $dyingSubcategory->name = $request->name;
        $dyingSubcategory->name_bn = $request->name_bn;
        $dyingSubcategory->slug =Str::slug($request->name).'-'.Str::random(5);
        $dyingSubcategory->save();

        Toastr::success('Dying Subcategory inserted successfully');
        return redirect()->route('admin.dying-sub-categories.index');

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $dyingSubcategory = DyingSubcategory::find($id);
        return view('backend.admin.dying_subcategories.edit',compact('dyingSubcategory'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name'=> 'required',
        ]);
        $dyingSubcategory = DyingSubcategory::find($id);
        $dyingSubcategory->dying_category_id = $request->dying_category_id;
        $dyingSubcategory->name = $request->name;
        $dyingSubcategory->name_bn = $request->name_bn;
        $dyingSubcategory->slug =Str::slug($request->name).'-'.Str::random(5);
        $dyingSubcategory->save();

        Toastr::success('Dying Subcategory updated successfully');
        return redirect()->route('admin.dying-sub-categories.index');
    }

    public function destroy($id)
    {
        //
    }
}
