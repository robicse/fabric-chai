<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\UserInfo;
use App\Http\Controllers\Controller;
use App\Mail\MyEmail;
use App\Model\Seller;
use App\Model\VerificationCode;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class VerificationController extends Controller
{
    public function getVerificationCode($id) {
        $user = User::find($id);
        $verification = VerificationCode::where('phone',$user->phone)->first();
        if (!empty($verification)){
            $verification->delete();
        }
        $verCode = new VerificationCode();
        $verCode->phone = $user->phone;
        $verCode->code = mt_rand(1111,9999);
        $verCode->status = 0;
        $verCode->save();
        $text = "Dear ".$user->name.", Your Fabric Lagbe OTP is ".$verCode->code;

        if($user->country_code == '+880') {
            UserInfo::smsAPI('880' . $verCode->phone, $text);
            $title = 'Registration';
            RegistrationSmsNotification($user->id,$title,$text);
            Toastr::success('Thank you for your registration. We send a verification code in your mobile number. please verify your phone number.' ,'Success');
        }
        else{
            $receiver_email = $user->email;
            $receiver_name = $user->name;
            $sender_email = 'fabricslagbe@gmail.com';
            $sender_name='Fabric Lagbe';
            $subject='Welcome To Fabric Lagbe';
            $message="<h3>Dear $user->name,<br /> welcome to <a href='https://www.fabriclagbe.com/'>fabriclagbe.com</a>!</h3><br /><b>Your OTP is $verCode->code.</b> <br/>
            <br/>
            <p> Best Regards</p>
            <p> Team, Fabric Lagbe LTD </p>";
            send_mailjet_mail1($receiver_email,$receiver_name,$sender_email,$sender_name,$subject,$message);
            $title = 'Registration';
            RegistrationSmsNotification($user->id,$title,$text);
            Toastr::success('Thank you for your registration. Please check your Email for OTP' ,'Success');
        }

        return view('frontend.pages.verification',compact('verCode'));
    }
    public function verification(Request $request){
        if ($request->isMethod('post')){
            $check = VerificationCode::where('code',$request->code)->where('phone',$request->phone)->first();
            if (!empty($check)) {
                $check->status = 1;
                $check->update();
                $user = User::where('phone',$request->phone)->first();
                $user->verification_code = $request->code;
                $user->banned = 0;
                $user->save();
                Toastr::success('Your phone number successfully verified.' ,'Success');
//                return redirect('login');
                $credentials = [
                    'phone' => Session::get('phone'),
                    'password' => Session::get('password'),
                    'user_type' => Session::get('user_type'),
                ];

                if (Auth::attempt($credentials)) {
                    Session::forget('phone');
                    Session::forget('password');
                    $type = Session::get('type');

                    if ($type == 'employer_register'){
                        $user = User::find(Auth::id());
                        $user->user_type = 'seller';
                        $user->save();
                        $seller = Seller::where('user_id',Auth::id())->first();
                        $seller->employer_status = 1;
                        $seller->save();
                        return $this->redirectTo = route('employer-dashboard');
                    }
                    if ($type == 'work_order_register' && Auth::user()->user_type ='buyer')
                    {
                        return redirect()->route('buyer.work-order.dashboard');
                    }
                    elseif ($type == 'work_order_register' && Auth::user()->user_type ='seller')
                    {
                        return redirect()->route('seller.work-order.dashboard');
                    }
                    if (Session::get('user_type') == 'seller')
                    {
                        return redirect()->route('seller.dashboard');
                    }
                    elseif (Session::get('user_type') == 'employee')
                    {
                        return redirect()->route('employee.dashboard');
                    }
                    elseif (Session::get('user_type') == 'buyer')
                    {
                        return redirect()->route('buyer.dashboard');
                    }

                }else{
                    die('no auth');
                }
            }else{
                //$verCode = $request->phone;
                $verCode = VerificationCode::where('phone',$request->phone)->where('status',0)->first();
                Toastr::error('Invalid Code' ,'Error');
                return view('frontend.pages.verification',compact('verCode'));
            }
        }
    }
}
