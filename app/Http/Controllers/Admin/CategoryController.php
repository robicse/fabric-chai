<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Brand;
use App\Model\Category;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
//use Request;

class CategoryController extends Controller
{
    function __construct(Request $request)
    {
        if ($request->segment(2) == 'work-order-categories'){
            $this->middleware('permission:work-order-categories-list|work-order-categories-create|work-order-categories-edit', ['only' => ['index','store']]);
            $this->middleware('permission:work-order-categories-create', ['only' => ['create','store']]);
            $this->middleware('permission:work-order-categories-edit', ['only' => ['edit','update']]);
        }else{
            $this->middleware('permission:categories-list|categories-create|categories-edit', ['only' => ['index','store']]);
            $this->middleware('permission:categories-create', ['only' => ['create','store']]);
            $this->middleware('permission:categories-edit', ['only' => ['edit','update']]);
        }
    }

    public function index(Request $request)
    {

        if ($request->segment(2) == 'work-order-categories'){
            $categories = Category::where('type','work_order')->get();
        }else{
            $categories = Category::where('type','product')->get();
        }
//        $categories = Category::where('type','type')->get();
        return view('backend.admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('backend.admin.categories.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=> 'required|unique:categories,name',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->name_bn = $request->name_bn;
        $category->slug = Str::slug($request->name).'-'.Str::random(5);
        $category->image_alt = $request->image_alt;
        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->featured = 0;
        $category->top = 0;
        $category->is_home = 0;
        if ($request->segment(2) == 'work-order-categories'){
            $category->type = 'work_order';
        }else{
            $category->type = 'product';
        }
        $image = $request->file('icon');
        if (isset($image)) {
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imagename = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
//            resize image for hospital and upload
            $proImage = Image::make($image)->resize(300, 300)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('uploads/categories/' . $imagename, $proImage);

        }else {
            $imagename = "default.png";
        }
        $category->icon = $imagename;

        $banner_image = $request->file('banner_image');
        if (isset($banner_image)) {
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $banner_image_name = $currentDate . '-' . uniqid() . '.' . $banner_image->getClientOriginalExtension();
//            resize image for hospital and upload
            $proImage = Image::make($banner_image)->resize(930, 180)->save($banner_image->getClientOriginalExtension());
            Storage::disk('public')->put('uploads/categories/banner/' . $banner_image_name, $proImage);

        }else {
            $banner_image_name = "default.png";
        }

        $category->banner_image = $banner_image_name;
        $category->save();
        Toastr::success('Categories Created Successfully');
        return back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $category = Category::find($id);
        if ($category->id == 4 || $category->id == 7 || $category->id == 9){
            Toastr::warning('You can not edit this category!');
            return back();
        }
        return view('backend.admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=> 'required|unique:categories,name,'.$id,
        ]);
        if ($id == 4 || $id == 7 || $id == 9){
            Toastr::warning('You can not edit this category!');
            return back();
        }
        $category =  Category::find($id);
        $category->name = $request->name;
        $category->name_bn = $request->name_bn;
        $category->image_alt = $request->image_alt;
        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->featured = 0;
        $category->top = 0;
        $category->is_home = 0;
        $image = $request->file('icon');
        if (isset($image)) {
            if(Storage::disk('public')->exists('uploads/categories/'.$category->icon))
            {
                Storage::disk('public')->delete('uploads/categories/'.$category->icon);
            }
            $currentDate = Carbon::now()->toDateString();
            $imagename = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $proImage = Image::make($image)->resize(300, 300)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('uploads/categories/' . $imagename, $proImage);

        }else {
            $imagename = $category->icon;
        }
        $category->icon = $imagename;

        $banner_image = $request->file('banner_image');
        if (isset($banner_image)) {
            if(Storage::disk('public')->exists('uploads/categories/banner/'.$category->banner_image))
            {
                Storage::disk('public')->delete('uploads/categories/banner/'.$category->banner_image);
            }
            $currentDate = Carbon::now()->toDateString();
            $banner_image_name = $currentDate . '-' . uniqid() . '.' . $banner_image->getClientOriginalExtension();
            $proImage = Image::make($banner_image)->resize(930, 180)->save($banner_image->getClientOriginalExtension());
            Storage::disk('public')->put('uploads/categories/banner/' . $banner_image_name, $proImage);

        }else {
            $banner_image_name = "default.png";
        }

        $category->banner_image = $banner_image_name;

        $category->save();
        Toastr::success('Categories Updated Successfully');
        return back();
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if(Storage::disk('public')->exists('uploads/categories/'.$category->icon))
        {
            Storage::disk('public')->delete('uploads/categories/'.$category->icon);
        }
        if(Storage::disk('public')->exists('uploads/categories/banner/'.$category->banner_image))
        {
            Storage::disk('public')->delete('uploads/categories/banner/'.$category->banner_image);
        }
        $category->delete();
        Toastr::success('Categories Deleted Successfully');
        return back();

    }
    public function updateIsHome(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->is_home = $request->status;
        if($category->save()){
            return 1;
        }
        return 0;
    }
    public function slugChange(Request $request){
        $category = Category::find($request->id);
        $category->slug = $request->slug;
        $category->save();
        Toastr::success('SEO Slug Updated Successfully');
        return back();
    }
}
