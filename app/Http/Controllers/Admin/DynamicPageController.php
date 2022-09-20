<?php

namespace App\Http\Controllers\Admin;

use App\Model\DynamicPage;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DynamicPageController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:dynamic-pages-list|dynamic-pages-create|dynamic-pages-edit', ['only' => ['index','store']]);
        $this->middleware('permission:dynamic-pages-create', ['only' => ['create','store']]);
        $this->middleware('permission:dynamic-pages-edit', ['only' => ['edit','update']]);
//        $this->middleware('permission:units-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $dynamic_pages = DynamicPage::latest()->get();
        return view('backend.admin.dynamic_pages.index',compact('dynamic_pages'));
    }


    public function create()
    {
        return view('backend.admin.dynamic_pages.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=> 'required',
            'description'=> 'required',
        ]);
        $dynamic_page = new DynamicPage();
        $dynamic_page->name = $request->name;
        $dynamic_page->name_bn = $request->name_bn;
        $dynamic_page->slug = Str::slug($request->name);
        $dynamic_page->description = $request->	description;
        $dynamic_page->description_bn = $request->description_bn;
        $dynamic_page->meta_title = strip_tags($request->meta_title);
        $dynamic_page->meta_description = strip_tags($request->meta_description);
        $dynamic_page->save();
        Toastr::success('Dynamic Page Created Successfully', 'Success');
        return redirect()->route('admin.dynamic_pages.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $dynamic_page = DynamicPage::find($id);
        return view('backend.admin.dynamic_pages.edit',compact('dynamic_page'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'description'=> 'required',

        ]);
        $dynamic_page = DynamicPage::find($id);
        $dynamic_page->description = $request->	description;
        $dynamic_page->description_bn = $request->	description_bn;
        $dynamic_page->meta_title = strip_tags($request->meta_title);
        $dynamic_page->meta_description = strip_tags($request->meta_description);
        $dynamic_page->save();
        Toastr::success('Dynamic Page Updated Successfully', 'Success');
        return redirect()->route('admin.dynamic_pages.index');
    }

    public function destroy($id)
    {
        DynamicPage::destroy($id);
        Toastr::success('Dynamic Page Deleted Successfully');
        return redirect()->route('admin.dynamic_pages.index');

    }
}
