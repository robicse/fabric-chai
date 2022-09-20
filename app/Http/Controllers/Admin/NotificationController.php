<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:notifications-list', ['only' => ['index']]);
        $this->middleware('permission:notifications-details', ['only' => ['details']]);
    }
    public function index(){
        $notifications = Notification::latest()->get();
//        foreach ($notifications as $notification){
//            $notification->admin_sidebar_view_status = 1;
//            $notification->save();
//        }
        return view('backend.admin.notification.index',compact('notifications'));
    }
    public function notificationAjax(){
        return Notification::ajaxNotification();
    }

    public function details($id){
        $notification = Notification::find($id);
        $notification->admin_view_status = 1;
        $notification->save();
        return view('backend.admin.notification.details',compact('notification'));
    }

}
