<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Method;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class MethodController extends Controller
{

    public function index()
    {
        $methods = Method::latest()->get();
        return view('backend.admin.methods.index',compact('methods'));
    }

    public function create()
    {
        return view('backend.admin.methods.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|unique:methods,name',

        ]);
        $method = new Method();
        $method->name = $request->name;
        $method->save();

        Toastr::success('Method Name Inserted Successfully');
        return redirect()->route('admin.methods.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $method = Method::find($id);
        return view('backend.admin.methods.edit',compact('method'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name'=>'required|unique:methods,name,'.$id,

        ]);
        $method = Method::find($id);
        $method->name = $request->name;
        $method->save();

        Toastr::success('Method Name Updated Successfully');
        return redirect()->route('admin.methods.index');
    }

    public function destroy($id)
    {
        //
    }
}
