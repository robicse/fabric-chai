<?php

namespace App\Http\Controllers\Api;

use App\Helpers\UserInfo;
use App\Http\Controllers\Controller;
use App\Model\VerificationCode;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class OtpVerificationController extends Controller
{
    public $successStatus = 201;
    public $failStatus = 401;

//    public function OtpSend(Request $request)
//    {
//        //return 'ok';
//        $verification = VerificationCode::where('phone',$request->phone)->where('status',0)->first();
//        if (!empty($verification)){
//            $verification->status = 1;
//            $verification->save();
//        }
//        $text = $verification->code. "is your One-Time Password (OTP) for Doctor Pathao. Enjoy with Doctor Pathao";
////        echo $text;exit();
//        UserInfo::smsAPI("88".$verification->phone,$text);
//        return response()->json([
//            'message' => 'OTP successfully sent to user'
//        ], 201);
//    }

    public function OtpCheck(Request $request)
    {
//        return $request->all();
        $verification = VerificationCode::where('phone',$request->phone)->where('status',0)->where('code',$request->code)->first();
        if (!empty($verification)){
            $verification->status = 1;
            $verification->save();
            $user = User::where('phone',$request->phone)->first();
            $user->banned = 0;
            $user->verification_code = $request->code;
            $user->save();
            if (!empty($user)) {
                return response()->json([
                    'message' => 'OTP Checked successfully'
                ], 201);
            }
        }else{
            return response()->json([
                'message' => 'OTP Code does not match!!'
            ], 401);
        }

    }

    public function resendOtp(Request $request) {
        $user = User::where('phone',$request->phone)->first();
        if (!empty($user)){
            mobileVerification($user);
            $success['token'] = $user->createToken('Fabric Lagbe')-> accessToken;
            $success['details'] = $user;
            return response()->json(['success'=>true,'response' =>$success], $this->successStatus);
        }else{
            return response()->json(['success'=>false,'response' =>'Something went wrong!'], $this->failStatus);
        }
    }

}
