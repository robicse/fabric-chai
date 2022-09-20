<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Model\Buyer;
use App\Model\Employee;
use App\Model\Message;
use App\Model\Notification;
use App\Model\Product;
use App\Model\Slider;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $messages = Message::where('receiver_user_id',Auth::id())->where('offer_id','!=',null)->latest()->get();
        return view('frontend.employee.dashboard',compact('messages'));
    }
    public function changeJobStatus(Request $request){
        $employee = Employee::where('user_id',Auth::id())->first();
        if ($employee->current_job_status == 0){
            $employee->current_job_status = 1;
        }else{
            $employee->current_job_status = 0;
        }
        $employee->save();
        Toastr::success('Current Employment status updated successfully');
        return back();
    }
    public function notification(){
        $notifications = Notification::where('title','Interview Message')->where('receiver_user_id',Auth::id())->latest()->get();
        return view('frontend.employee.notification',compact('notifications'));
    }
    public function notificationDetails($id){
        $notification = Notification::find($id);
        $notification->receiver_view_status = 1;
        $notification->save();
        return view('frontend.employee.notification_details',compact('notification'));
    }
}
