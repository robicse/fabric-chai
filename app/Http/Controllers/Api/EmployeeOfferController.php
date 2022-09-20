<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeListCollection;
use App\Http\Resources\EmployeeOfferCollection;
use App\Http\Resources\EmployeeOfferDetailCollection;
use App\Http\Resources\OfferEmployeeListCollection;
use App\Model\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeOfferController extends Controller
{
    public $successStatus = 201;
    public $failStatus = 401;

    public function offerList(){
        $messages = Message::where('receiver_user_id',Auth::user()->id)->where('offer_id','!=',null)->get();
        return new EmployeeOfferCollection($messages);
    }
    public function offerDetail($id){
        $message = Message::join('users','users.id','messages.sender_user_id')
                ->join('sellers','users.id','sellers.user_id')
                ->join('employers','users.id','employers.user_id')
                ->where('messages.id', $id)
                ->select('messages.id','messages.title','messages.message','users.name','users.avatar_original','messages.created_at','sellers.company_address','sellers.company_phone','sellers.company_email','employers.no_of_employee','employers.established_year','employers.owner_name','employers.salary_type')
                ->get();
        return new EmployeeOfferDetailCollection($message);
    }

    public function offerReplyMessage(Request $request){
        $message_reply = Message::find($request->message_id);
        $message_reply->receiver_agree_status = $request->receiver_agree_status;
        $message_reply->receiver_reply_message = $request->receiver_reply_message;
        $message_reply->save();
       if (!empty($message_reply)){
           return response()->json(['success'=>true,'response'=> 'Reply message send successfully'], 200);
       }else{
           return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
       }
    }
    public function getReplyMessage($id){
        $message = Message::find($id);
        $success['id'] = $message->id;
        $success['receiver_agree_status'] = $message->receiver_agree_status;
        $success['receiver_reply_message'] = $message->receiver_reply_message;
        $success['reply_status'] = $message->receiver_reply_message? 1 : 0;
        if (!empty($message->receiver_reply_message)){
            return response()->json(['success'=>true,'response'=> $success], 200);
        }else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
}
