<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\PriorityBuyer;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class PriorityBuyerController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:priority-buyers-list|priority-buyers-create|priority-buyers-edit', ['only' => ['index','store']]);
        $this->middleware('permission:priority-buyers-create', ['only' => ['create','store']]);
        $this->middleware('permission:priority-buyers-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:priority-buyers-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $priorityBuyers = PriorityBuyer::latest()->get();
        return view('backend.admin.priority_buyers.index',compact('priorityBuyers'));
    }

    public function create()
    {
        return view('backend.admin.priority_buyers.create');
    }

    public function store(Request $request)
    {
        $priorityBuyer = new PriorityBuyer();
        $priorityBuyer->title = $request->title;
        if ($request->hasFile('image')){
            $priorityBuyer->image = $request->image->store('uploads/priority_buyers');
        }
        $priorityBuyer->save();
        Toastr::success('Priority Buyer inserted successfully');
        return redirect()->route('admin.priority-buyers.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $priorityBuyer = PriorityBuyer::find($id);
        return view('backend.admin.priority_buyers.edit',compact('priorityBuyer'));
    }

    public function update(Request $request, $id)
    {
        $priorityBuyer = PriorityBuyer::find($id);
        $priorityBuyer->title = $request->title;

        if ($request->hasFile('image')){
            if ($priorityBuyer->image != $request->image){
                unlink($priorityBuyer->image);
                $priorityBuyer->image = $request->image->store('uploads/priority_buyers');
            }
        }
        $priorityBuyer->save();
        Toastr::success('Priority Buyer updated successfully');
        return redirect()->route('admin.priority-buyers.index');
    }

    public function destroy($id)
    {
        $priorityBuyer = PriorityBuyer::find($id);
        unlink($priorityBuyer->image);
        $priorityBuyer->delete();
        Toastr::success('Priority Buyer deleted successfully');
        return redirect()->route('admin.priority-buyers.index');
    }
}
