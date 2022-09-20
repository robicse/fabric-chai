<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\MessageCharge;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class MessageChargeController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:message-charge-list|message-charge-create|message-charge-edit', ['only' => ['index','store']]);
        $this->middleware('permission:message-charge-create', ['only' => ['create','store']]);
        $this->middleware('permission:message-charge-edit', ['only' => ['edit','update']]);
    }
    public function index()
    {
        $message_charges = MessageCharge::all();
        return view('backend.admin.message_charge.index',compact('message_charges'));
    }

    public function create()
    {
        return view('backend.admin.message_charge.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'cost_per_sms' => 'required',
            'end_date' => 'required',
        ]);

        $message_charge = new MessageCharge();
        $message_charge->title = $request->title;
        $message_charge->cost_per_sms = $request->cost_per_sms;
        $message_charge->end_date = $request->end_date;
        $message_charge->save();
        Toastr::success('Message Charge created Successfully');
        return redirect()->route('admin.message-charge.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $message_charge = MessageCharge::find($id);
        return view('backend.admin.message_charge.edit',compact('message_charge'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'cost_per_sms' => 'required',
            'end_date' => 'required',
        ]);
        $message_charge = MessageCharge::find($id);
        $message_charge->title = $request->title;
        $message_charge->cost_per_sms = $request->cost_per_sms;
        $message_charge->end_date = $request->end_date;
        $message_charge->save();
        Toastr::success('Message Charge updated Successfully');
        return redirect()->route('admin.message-charge.index');

    }

    public function destroy($id)
    {
        //
    }
}
