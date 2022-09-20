<?php

namespace App\Http\Controllers\Seller\WorkOrder;

use App\Http\Controllers\Controller;
use App\Model\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkOrderNotificationController extends Controller
{
    public function index(){
        $notifications = Notification::where('receiver_user_id',Auth::id())
            ->where('work_order_status',1)
            ->latest()
            ->get();
        return view('frontend.seller.work_order.wo_notifications',compact('notifications'));

    }
    public function details($id){
        $notification = Notification::find(decrypt($id));
        $notification->receiver_view_status = 1;
        $notification->save();
        return view('frontend.seller.work_order.wo_notification_details',compact('notification'));
    }
}
