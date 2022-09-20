<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\PopUp;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class PopUpController extends Controller
{
    public function index()
    {
        $popUps = PopUp::all();
        return view('backend.admin.pop_ups.index',compact('popUps'));
    }
    public function editorShow(Request $request){
        $popUp = PopUp::where('type',$request->type)->first();
        return $popUp;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $popUp = PopUp::find($id);
        return view('backend.admin.pop_ups.edit',compact('popUp'));
    }

    public function update(Request $request, $id)
    {
        $popUp = PopUp::find($id);
        $popUp->description = $request->description;
        $popUp->description_bn = $request->description_bn;
        $popUp->save();
        Toastr::success('Pop-up updated successfully');
        return redirect()->route('admin.pop-ups.index');
    }

    public function destroy($id)
    {
        //
    }
}
