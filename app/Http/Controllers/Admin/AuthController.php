<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UserInfo;
use App\Http\Controllers\Controller;
use App\Model\Department;
use App\Model\VerificationCode;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Contracts\Role;

class AuthController extends Controller
{
    public function ShowLoginForm()
    {
        return view('auth.admin.login');
    }

    public function LoginCheck(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $departmentID = $user->roles()->pluck('department_id');
//        $credential = [
//            'email' => $user->email,
//            'password' => $user->password,
//            'user_type' => 'admin',
//        ];
//        if (Auth::attempt($credential)){
//            return redirect()->route('admin.dashboard');
//        }
        Session::put('email',$request->email);
        Session::put('password',$request->password);
        Session::put('user_type',$user->user_type);
        if (!empty($user) && $user->user_type == 'admin') {
            $verification = VerificationCode::where('phone','1672777779')->first();
            if (!empty($verification)){
                $verification->delete();
            }
            $verCode = new VerificationCode();
            $verCode->phone = '1672777779';
            $verCode->code = mt_rand(1111,9999);
            $verCode->status = 0;
            $verCode->save();
            $text = "Your Fabric Lagbe Admin OTP is ".$verCode->code;
            UserInfo::smsAPI('01672777779', $text);
            Toastr::success('Successfully Logged In! Please Submit the OTP.');
            return view('auth.admin.otp_verification');

        }elseif(!empty($user) && $user->user_type == 'staff' && $departmentID[0] == 9){
            $verification = VerificationCode::where('phone','1672777779')->first();
            if (!empty($verification)){
                $verification->delete();
            }
            $verCode = new VerificationCode();
            $verCode->phone = '1672777779';
            $verCode->code = mt_rand(1111,9999);
            $verCode->status = 0;
            $verCode->save();
            $department = Department::find($departmentID[0]);
            $text = "Your Fabric Lagbe ".$department->name." OTP is ".$verCode->code;
            UserInfo::smsAPI('01798805849', $text);
            Toastr::success('Successfully Logged In! Please Submit the OTP.');
            return view('auth.admin.otp_verification');
        }elseif(!empty($user) && $user->user_type == 'staff'){
            $verification = VerificationCode::where('phone','1672777779')->first();
            if (!empty($verification)){
                $verification->delete();
            }
            $verCode = new VerificationCode();
            $verCode->phone = '1672777779';
            $verCode->code = mt_rand(1111,9999);
            $verCode->status = 0;
            $verCode->save();
            $department = Department::find($departmentID[0]);
            $text = "Your Fabric Lagbe ".$department->name." OTP is ".$verCode->code;
            UserInfo::smsAPI('01672777779', $text);
            Toastr::success('Successfully Logged In! Please Submit the OTP.');
            return view('auth.admin.otp_verification');

        }else{
            Toastr::Error('Credential Does not matched!!','Error');
            return redirect()->route('admin.login');
        }
    }
    public function otpVerification(Request $request){
        $check = VerificationCode::where('code',$request->code)->where('phone','1672777779')->first();
        if (!empty($check)) {
            $check->status = 1;
            $check->update();
            $credential = [
                'email' => Session::get('email'),
                'password' => Session::get('password'),
                'user_type' => Session::get('user_type'),
            ];
            if (Auth::attempt($credential) && (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff')) {
                Session::forget('email');
                Session::forget('password');
                Toastr::success('OTP successfully verified.', 'Success');
                return redirect()->route('admin.dashboard');

            }else {
                Toastr::Error('Credential Does not matched!!','Error');
                return redirect()->route('admin.login');
            }

        }else{
            Auth::logout();
            Toastr::error("OTP didn't matched.", 'Error');
            return redirect()->route('admin.login');
        }
    }
    //Without OTP
    public function LoginCheck1(Request $request)
    {

        $user = User::where('email', $request->email)->first();
        if (!empty($user) && $user->user_type == 'admin') {
            $credential = [
                'email' => $request->email,
                'password' => $request->password,
                'user_type' => 'admin',
            ];
            if (Auth::attempt($credential)) {
                Toastr::success('Successfully Logged In!');
                return redirect()->route('admin.dashboard');
            }else {
                //dd('sdfsadf');
                Toastr::Error('Credential Does not matched!!','Error');
                return redirect()->route('admin.login');
            }
        }elseif(!empty($user) && $user->user_type == 'staff'){
            $credential = [
                'email' => $request->email,
                'password' => $request->password,
                'user_type' => 'staff',
            ];
            if (Auth::attempt($credential)) {
                Toastr::success('Successfully Logged In!');
                return redirect()->route('admin.dashboard');
            }else {
                //dd('sdfsadf');
                Toastr::Error('Credential Does not matched!!','Error');
                return redirect()->route('admin.login');
            }
        }else{
            Toastr::Error('Credential Does not matched!!','Error');
            return redirect()->route('admin.login');
        }


    }
}
