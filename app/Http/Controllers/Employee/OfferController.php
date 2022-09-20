<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Model\Message;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    public function offerList(){
        $messages = Message::where('receiver_user_id',Auth::id())->where('offer_id','!=',null)->get();
        return view('frontend.employee.offer.offer_list',compact('messages'));
    }
    public function offerDetails($id){
        $message = Message::find($id);
        return view('frontend.employee.offer.offer_details',compact('message'));
    }
    public function companyDetails($id){
        $user = User::find($id);
        return view('frontend.employee.offer.company_details',compact('user'));

    }
    public function offerReplayMessage(Request $request){
        $message_reply = Message::find($request->message_id);
        $message_reply->receiver_agree_status = $request->receiver_agree_status;
        $message_reply->receiver_reply_message = $request->receiver_reply_message;
        $message_reply->save();
        Toastr::success('Replay Message successfully Inserted!');
        return back();
    }

}
