<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationCollection;
use App\Http\Resources\WorkOrderNotificationCollection;
use App\Model\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkOrderNotificationController extends Controller
{
    public $successStatus = 201;
    public $failStatus = 401;

    public function notificationList(){
        $notifications = Notification::where('receiver_user_id',Auth::id())
            ->where('work_order_status',1)
            ->latest()
            ->get();
        return new WorkOrderNotificationCollection($notifications);
    }
    public function notificationDetails($id){
        $notification = Notification::find($id);
        if ($notification->receiver_view_status == 0){
            $notification->receiver_view_status = 1;
            $notification->save();
        }
        $success['id'] =(integer) $notification->id;
        $success['work_order_product_id'] =(integer) $notification->work_order_product_id;
        $success['sender_name'] = getNameByBnEn($notification->sender);
        $success['title'] = $notification->title;
        $success['message'] = $notification->message;
        $success['receiver_view_status'] = (integer) $notification->receiver_view_status;
        $success['date'] = getDateConvertByBnEn($notification->created_at);

        if($notification){
            return response()->json(['success'=>true,'response' => $success], $this->successStatus);
        }else{
            return response()->json(['success'=>false,'response'=>'Something went wrong!'], $this->failStatus);
        }

    }
    public function notificationCount(){
        $notifications = Notification::where('receiver_user_id',Auth::id())->where('work_order_status',1)->where('receiver_view_status',0)->count();
        return response()->json(['success'=>true,'response' =>(string) getNumberToBangla($notifications)], $this->successStatus);
    }
}
