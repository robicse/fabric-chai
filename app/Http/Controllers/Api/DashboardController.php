<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\userProfileCollections;
use App\Model\Buyer;
use App\Model\Seller;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public $successStatus = 201;
    public $failStatus = 401;

    public function applyForSellerStore(Request $request){

        $user = User::find(Auth::id());
        $seller = Seller::where('user_id',$user->id)->first();
        if (!empty($seller)){
            return response()->json(['success'=>false,'response'=>'You are already a seller.'], $this->failStatus);
        }
        $user->user_type = 'seller';
        $multiple_user_types = json_decode($user->multiple_user_types);
        if(!in_array("seller", $multiple_user_types)){
            array_push($multiple_user_types, "seller");
            $user->multiple_user_types = $multiple_user_types;
        }
        $user->save();


        $seller = new Seller();
        $seller->user_id = $user->id;
        $seller->company_name = $request->company_name;
        $seller->company_name_bn = $request->company_name_bn;
        $seller->company_phone = $request->company_phone;
        $seller->company_email = $request->company_email;
        $seller->company_address = $request->company_address;
        $seller->company_address_bn = $request->company_address_bn;
        $seller->verification_status	= 0;
        $seller->division_id= $request->division_id ? $request->division_id : NULL;
        $seller->district_id= $request->district_id ? $request->district_id : NULL;
        $seller->designation= $request->designation;
        $seller->selected_category= $request->selected_category;

        $tl = array();
        if($request->hasFile('trade_licence')){
            foreach ($request->trade_licence as $key => $photo) {
                $path = $photo->store('uploads/seller_info/trade_licence');
                array_push($tl, $path);
            }
            $seller->trade_licence = json_encode($tl);
        }

        if($request->hasFile('nid_front')){
            $seller->nid_front = $request->nid_front->store('uploads/seller_info/nid');
        }
        if($request->hasFile('nid_back')){
            $seller->nid_back = $request->nid_back->store('uploads/seller_info/nid');
        }
        $insert_id = $seller->save();
        if($insert_id){
            $title = 'Applied for Seller';
            $message = $user->name .' applied for seller.';
            registrationNotification($user->id,$title,$message);
            // admin sms
//                    UserInfo::smsAPI('8801725930131', $message);
//                    SmsNotification(9,$title,$message);
        }
        if($insert_id){
            return response()->json(['success'=>true,'response' => $user,'seller_info' => $seller], $this->successStatus);
        }else{
            return response()->json(['success'=>false,'response'=>'No Successfully Updated!'], $this->failStatus);
        }
    }

    public function switchToSeller(){
        $user = User::find(Auth::id());
        $user->user_type = 'seller';
        $multiple_user_types = json_decode($user->multiple_user_types);
        if(!in_array("seller", $multiple_user_types)){
            array_push($multiple_user_types, "seller");
            $user->multiple_user_types = $multiple_user_types;
        }
        $affected_row = $user->save();

        if($affected_row){
            $success['token'] = $user->createToken('Fabric Lagbe')-> accessToken;
            $success['user'] = new userProfileCollections(User::where('id',$user->id)->get());
            return response()->json(['success'=>true,'response' => $success], $this->successStatus);
        }else{
            return response()->json(['success'=>false,'response'=>'Something went wrong'], $this->failStatus);
        }
    }

    public function switchToBuyer(){
        $user = User::find(Auth::id());
        $user->user_type = 'buyer';
        $multiple_user_types = json_decode($user->multiple_user_types);
        if(!in_array("buyer", $multiple_user_types)){
            array_push($multiple_user_types, "buyer");
            $user->multiple_user_types = $multiple_user_types;
        }
        $affected_row = $user->save();

        $checkBuyerUser = Buyer::where('user_id',$user->id)->first();
        if(empty($checkBuyerUser)){
            $buyer = new Buyer();
            $buyer->user_id = $user->id;
            $buyer->status = 0;
            $buyer->verification_status	= 0;
            $buyer->save();
        }

        if($affected_row){
            $success['token'] = $user->createToken('Fabric Lagbe')-> accessToken;
            $success['user'] = new userProfileCollections(User::where('id',$user->id)->get());
            return response()->json(['success'=>true,'response' => $success], $this->successStatus);
        }else{
            return response()->json(['success'=>false,'response'=>'Something went wrong'], $this->failStatus);
        }
    }
}
