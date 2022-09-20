<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationCollection;
use App\Model\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public $successStatus = 201;
    public $failStatus = 401;

    public function index(){
        $notifications = Notification::where('receiver_user_id',Auth::user()->id)->latest()->get();
        return new NotificationCollection($notifications);

    }
    public function count(){
        $notifications = Notification::where('receiver_user_id',Auth::id())->where('receiver_view_status',0)->count();

        return (string) getNumberToBangla($notifications);
    }
    public function statusUpdate($id){
        $notification = Notification::find($id);
        if ($notification->receiver_view_status == 0){
            $notification->receiver_view_status = 1;
            $notification->save();
        }
        $success['id'] =(integer) $notification->id;
        $success['product_id'] =(integer) $notification->product_id;
        $success['sender_name'] = $notification->sender->name;
        $success['title'] = $notification->title;
        $success['message'] = $notification->message;
        $success['receiver_view_status'] = (integer) $notification->receiver_view_status;
        $success['date'] = date('j M Y h:i A',strtotime($notification->created_at));

        if($notification){
            return response()->json(['success'=>true,'response' => $success], $this->successStatus);
        }else{
            return response()->json(['success'=>false,'response'=>'Something went wrong!'], $this->failStatus);
        }

    }
}
