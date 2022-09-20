<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Model\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(){
        $notifications = Notification::where('receiver_user_id',Auth::user()->id)->latest()->get();
//        foreach ($notifications as $notification){
//            $notification->receiver_sidebar_view_status = 1;
//            $notification->save();
//        }
        return view('frontend.seller.notification.index',compact('notifications'));
    }

    public function details($id){
        $notification = Notification::find($id);
        $notification->receiver_view_status = 1;
        $notification->save();
        return view('frontend.seller.notification.details',compact('notification'));
    }

}
