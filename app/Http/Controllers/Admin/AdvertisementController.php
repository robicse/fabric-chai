<?php

namespace App\Http\Controllers\Admin;

use App\Model\Advertisement;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:advertisements-list|advertisements-create|advertisements-edit', ['only' => ['index','store']]);
        $this->middleware('permission:advertisements-create', ['only' => ['create','store']]);
        $this->middleware('permission:advertisements-edit', ['only' => ['edit','update']]);
    }
    public function index()
    {
        $advertisements = Advertisement::latest()->get();
        return view('backend.admin.advertisement.index',compact('advertisements'));
    }

    public function create($position)
    {
        return view('backend.admin.advertisement.create',compact('position'));
    }

    public function store(Request $request)
    {
        $advertisement = new Advertisement();
        $advertisement->title = $request->title;
        $advertisement->title_bn = $request->title_bn;
        $advertisement->position = $request->position;
        if($request->hasFile('image')){
            $advertisement->image = $request->image->store('uploads/advertisement/');
        }
        $advertisement->link = $request->link ? $request->link : '#';
        $advertisement->save();
        Toastr::success('Advertisement Created Successfully');
        return redirect()->route('admin.advertisements.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $advertisement = Advertisement::find($id);
        return view('backend.admin.advertisement.edit',compact('advertisement'));
    }

    public function update(Request $request, $id)
    {
        $advertisement =  Advertisement::find($id);
        $advertisement->title = $request->title;
        $advertisement->title_bn = $request->title_bn;
        if($request->hasFile('image')){
            $advertisement->image = $request->image->store('uploads/advertisement/');
        }
        $advertisement->link = $request->link;
        $advertisement->save();
        Toastr::success('Advertisement Updated Successfully');
        return redirect()->route('admin.advertisements.index');
    }

    public function destroy($id)
    {
        $advertisement = Advertisement::find($id);
        if(Storage::disk('public')->exists('uploads/advertisement/'.$advertisement->image))
        {
            Storage::disk('public')->delete('uploads/advertisement/'.$advertisement->image);
        }
        $advertisement->delete();
        Toastr::success('Advertisement Deleted Successfully');
        return back();
    }
}
