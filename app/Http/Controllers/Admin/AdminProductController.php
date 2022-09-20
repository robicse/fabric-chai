<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\AdminProduct;
use App\Model\HomeCategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:admin-products-list|admin-products-create|admin-products-edit', ['only' => ['index','store']]);
        $this->middleware('permission:admin-products-create', ['only' => ['create','store']]);
        $this->middleware('permission:admin-products-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:admin-products-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $adminProducts = AdminProduct::latest()->get();
        return view('backend.admin.admin_products.index',compact('adminProducts'));
    }

    public function create()
    {
        $homeCategories = HomeCategory::all();
        return view('backend.admin.admin_products.create',compact('homeCategories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=> 'required',
            'image'=> 'image',
            'long_description'=> 'required',
        ]);
        $adminProduct = new AdminProduct();
        $adminProduct->name = $request->name;
        $adminProduct->name_bn = $request->name_bn;
        $adminProduct->slug = Str::slug($request->name);
        $adminProduct->home_category_id = $request->home_category_id;
        if($request->hasFile('image')){
            $adminProduct->image = $request->image->store('uploads/products/admin-product');
        }
        $adminProduct->short_description = strip_tags($request->long_description);
        $adminProduct->short_description_bn = strip_tags($request->long_description_bn);
        $adminProduct->long_description = $request->long_description;
        $adminProduct->long_description_bn = $request->long_description_bn;
        $adminProduct->save();
        Toastr::success('Admin Product created successfully', 'Success');
        return redirect()->route('admin.admin-products.index');

    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $adminProduct = AdminProduct::find($id);
        $homeCategories = HomeCategory::all();
        return view('backend.admin.admin_products.edit',compact('homeCategories','adminProduct'));
    }


    public function update(Request $request, $id)
    {
        $adminProduct = AdminProduct::find($id);
        $adminProduct->name = $request->name;
        $adminProduct->name_bn = $request->name_bn;
        $adminProduct->home_category_id = $request->home_category_id;
        $adminProduct->image_alt = $request->image_alt;
        $adminProduct->meta_title = $request->meta_title;
        $adminProduct->meta_description = $request->meta_description;

        if($request->hasFile('image')){
            $adminProduct->image = $request->image->store('uploads/products/admin-product');
        }
        $adminProduct->short_description = strip_tags($request->long_description);
        $adminProduct->short_description_bn = strip_tags($request->long_description_bn);
        $adminProduct->long_description = $request->long_description;
        $adminProduct->long_description_bn = $request->long_description_bn;
        $adminProduct->save();
        Toastr::success('Admin Product updated successfully', 'Success');
        return redirect()->route('admin.admin-products.index');
    }

    public function destroy($id)
    {
        $adminProduct = AdminProduct::find($id);
        unlink($adminProduct->image);
        $adminProduct->delete();
        Toastr::success('Admin Product Deleted Successfully');
        return back();
    }
    public function slugChange(Request $request){
        $adminProduct = AdminProduct::find($request->id);
        $adminProduct->slug = $request->slug;
        $adminProduct->save();
        Toastr::success('SEO Slug Updated Successfully');
        return back();
    }
}
