<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\HomeCategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class HomeCategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:home-categories-list|home-categories-create', ['only' => ['index','store']]);
        $this->middleware('permission:home-categories-create', ['only' => ['create','store']]);
    }
    public function index()
    {
        $homeCategories = HomeCategory::all();
        return view('backend.admin.home_categories.index',compact('homeCategories'));
    }

    public function create()
    {
        $categories = Category::where('type','product')->get();
        return view('backend.admin.home_categories.create',compact('categories'));
    }

    public function store(Request $request)
    {
        $category_check = HomeCategory::where('category_id',$request->category_id)->first();
        if (empty($category_check)) {
            $home_category = new HomeCategory();
            $home_category->category_id = $request->category_id;
            $home_category->save();
            Toastr::success('Home Page Category has been inserted successfully', 'Success');
            return redirect()->route('admin.home-categories.index');
        } else{
            Toastr::error('This category already added to your home category', 'Error');
            return redirect()->route('admin.home-categories.index');
        }

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $homeCategory = HomeCategory::findOrFail($id);
        $categories = Category::where('type','product')->get();
        return view('backend.admin.home_categories.edit', compact('homeCategory','categories'));
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {
        $home_category = HomeCategory::find($id);
        $home_category->delete();
        Toastr::success('Home Category Deleted Successfully');
        return back();
    }
}
