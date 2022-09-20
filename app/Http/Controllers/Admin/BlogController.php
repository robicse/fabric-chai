<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Blog;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BlogController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:blogs-list|blogs-create|blogs-edit', ['only' => ['index','store']]);
        $this->middleware('permission:blogs-create', ['only' => ['create','store']]);
        $this->middleware('permission:blogs-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:blogs-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $blogs = Blog::all();
        return view('backend.admin.blog.index',compact('blogs'));
    }

    public function create()
    {
        return view('backend.admin.blog.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title'=> 'required',
            'description'=> 'required',
            'image'=> 'required',
        ]);
        $blog = new Blog();
        $blog->title = $request->title;
        $blog->title_bn = $request->title_bn;
        //$blog->slug = Str::slug($request->title);
        $blog->slug = Str::slug($request->title).'-'.Str::random(5);

        $blog->user_id = Auth::id();
        $blog->author = $request->author;
        $blog->author_bn = $request->author_bn;
        $blog->description = $request->description;
        $blog->description_bn = $request->description_bn;
        $blog->short_description = strip_tags($request->description);
        $blog->short_description_bn = strip_tags($request->description_bn);
        $blog->status = 1;
        $image = $request->file('image');
        if (isset($image)) {
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imagename = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
//            resize image for hospital and upload
            $proImage = Image::make($image)->resize(370, 250)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('uploads/blogs/' . $imagename, $proImage);
        }else {
            $imagename = "default.png";
        }

        $blog->image = $imagename;
        $blog->save();
        Toastr::success('Blog Created Successfully', 'Success');
        return redirect()->route('admin.blogs.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $blog = Blog::find($id);
        return view('backend.admin.blog.edit',compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'=> 'required',
            'description'=> 'required',

        ]);
        $blog = Blog::find($id);
        $blog->title = $request->title;
        $blog->title_bn = $request->title_bn;
        $blog->author = $request->author;
        $blog->author_bn = $request->author_bn;
        $blog->image_alt = $request->image_alt;
        $blog->description = $request->description;
        $blog->description_bn = $request->description_bn;
        $blog->short_description = strip_tags($request->description);
        $blog->short_description_bn = strip_tags($request->description_bn);
        $blog->meta_title = $request->meta_title;
        $blog->meta_description = $request->meta_description;
        $image = $request->file('image');
        if (isset($image)) {
            $currentDate = Carbon::now()->toDateString();
            $image_name = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            if (Storage::disk('public')->exists('uploads/blogs/'. $blog->image)) {
                Storage::disk('public')->delete('uploads/blogs/'. $blog->image);
            }
            $proImage = Image::make($image)->resize(370, 250)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('uploads/blogs/' . $image_name, $proImage);
        }
        else {
            $image_name =$blog->image;
        }
        $blog->image = $image_name;
        $blog->save();
        Toastr::success('Blog Updated Successfully', 'Success');
        return redirect()->route('admin.blogs.index');
    }

    public function destroy($id)
    {
        $blog = Blog::find($id);
        Storage::disk('public')->delete('uploads/blogs/' . $blog->image);
        $blog->delete();
        Toastr::success('Blog Deleted Successfully!');
        return redirect()->route('admin.blogs.index');
    }
    public function updateStatus(Request $request){
        $blog = Blog::findOrFail($request->id);
        $blog->status = $request->status;
        if($blog->save()){
            return 1;
        }
        return 0;
    }
    public function slugChange(Request $request){
        $blog = Blog::find($request->id);
        $blog->slug = $request->slug;
        $blog->save();
        Toastr::success('SEO Slug Updated Successfully');
        return back();
    }
}
