<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\StripePaymentController;
use App\Model\MembershipPackage;
use App\Model\SaleRecord;
use App\Model\UserMembershipPackage;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PremiumMembershipController extends Controller
{

    public function buy_now($id){
        //dd($id);
//        if(currency()->code != 'BDT'){
//            Toastr::warning('You first change to currency mode into BDT.');
//            return redirect()->back();
//        }

        // middle point data deleted
        UserMembershipPackage::where('payment_status','Pending')
            //->where('membership_package_id',$id)
            ->where('user_id',Auth::id())
            ->where('user_type',Auth::user()->user_type)
            ->delete();

        $membership_package = MembershipPackage::find($id);


        $user_membership_package = new UserMembershipPackage();
        $user_membership_package->user_id = Auth::user()->id;
        $user_membership_package->membership_package_id = $id;
        $user_membership_package->invoice_no = '';
        $user_membership_package->membership_activation_date = date('Y-m-d');
        $user_membership_package->membership_expired_date = date('Y-m-d', strtotime('+1 year'));;
        $user_membership_package->payment_status = 'Pending';
        $user_membership_package->amount = $membership_package->price + vat($membership_package->price);
        $user_membership_package->payment_type = 'SSL Commerz';
        $user_membership_package->save();
        $insert_id = $user_membership_package->id;
        if ($insert_id){
            return response()->json(['success'=>true,'response'=> ['user_membership_package_id'=>$insert_id]], 200);
        }else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }

    public function buy_now_stripe(Request $request, $id){
        // middle point data deleted
        UserMembershipPackage::where('payment_status','Pending')
            //->where('membership_package_id',$id)
            ->where('user_id',Auth::id())
            ->where('user_type',Auth::user()->user_type)
            ->delete();

        $membership_package = MembershipPackage::find($id);

        $user_membership_package = new UserMembershipPackage();
        $user_membership_package->user_id = Auth::user()->id;
        $user_membership_package->membership_package_id = $id;
        $user_membership_package->invoice_no = '';
        $user_membership_package->membership_activation_date = date('Y-m-d');
        $user_membership_package->membership_expired_date = date('Y-m-d', strtotime('+1 year'));;
        $user_membership_package->payment_status = 'Pending';
        $user_membership_package->amount = $membership_package->price + vat($membership_package->price);
        $user_membership_package->payment_type = 'Stripe';
        $user_membership_package->save();

        $insert_id = $user_membership_package->id;
        if ($insert_id){
            return response()->json(['success'=>true,'response'=> ['user_membership_package_id'=>$insert_id]], 200);
        }else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }

//        Session::put('user_membership_package_id',$user_membership_package->id);
//        //Session::put('user_type','seller');
//        Session::put('payment_type', 'cart_payment');
//
//        if ($request->session()->get('user_membership_package_id') != null) {
//            $stripe = new StripePaymentController;
//            return $stripe->stripe();
//        } else {
//            Toastr::warning('Select Payment Option.');
//            return back();
//        }
    }
}
