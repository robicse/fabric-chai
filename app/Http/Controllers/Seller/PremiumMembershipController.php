<?php

namespace App\Http\Controllers\Seller;

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
    public function index(){
        $memberships_packages = MembershipPackage::all();
        return view('frontend.seller.premium_membership.index',compact('memberships_packages'));
    }
    public function buyNowDetails($id){
        $membershipPackage = MembershipPackage::find($id);
        $bkashAmount = $membershipPackage->price + vat($membershipPackage->price);
        Session::put('bkash_amount',$bkashAmount);
        Session::put('membership_id',$id);
        return view('frontend.seller.premium_membership.buy_now_details',compact('membershipPackage','bkashAmount'));
    }

    public function buy_now($id){
        //dd($id);
        if(currency()->code != 'BDT'){
            Toastr::warning('You first change to currency mode into BDT.');
            return redirect()->back();
        }

        // middle point data deleted
        UserMembershipPackage::where('payment_status','Pending')
            //->where('membership_package_id',$id)
            ->where('user_id',Auth::id())
            ->where('user_type',Auth::user()->user_type)
            ->delete();

        $user = User::find(Auth::id());
        $gold = \App\Model\MembershipPackage::find(2);
        $membership_package = MembershipPackage::find($id);

        if ($user->membership_package_id == 2){

            $subAmount = ($membership_package->price - $gold->price) + vat($membership_package->price - $gold->price);
            $activation_date = $user->membership_activation_date;
            $expire_date = $user->membership_expired_date;
        }else{
            $subAmount = $membership_package->price + vat($membership_package->price);
            $activation_date = date('Y-m-d');
            $expire_date = date('Y-m-d', strtotime('+1 year'));
        }



        $user_membership_package = new UserMembershipPackage();
        $user_membership_package->user_id = Auth::user()->id;
        $user_membership_package->user_type = Auth::user()->user_type;
        $user_membership_package->membership_package_id = $id;
        $user_membership_package->invoice_no = '';
        $user_membership_package->membership_activation_date = $activation_date;
        $user_membership_package->membership_expired_date = $expire_date;
        $user_membership_package->payment_status = 'Pending';
        $user_membership_package->amount = $subAmount;
        $user_membership_package->payment_type = 'SSL Commerz';
        $user_membership_package->save();

        Session::put('user_membership_package_id',$user_membership_package->id);
        Session::put('user_type','seller');
        Session::put('current_table_name','user_membership_packages');

        return redirect()->route('ssl.pay');
    }

    public function payNowDetails(Request $request){
        $membershipPackage = MembershipPackage::find($request->id);
        return view('frontend.seller.premium_membership.pay_now_details_modal',compact('membershipPackage'));
    }
    public function payNowUsdDetails(Request $request){
        $membershipPackage = MembershipPackage::find($request->id);
        return view('frontend.seller.premium_membership.usd_pay_now_details_modal',compact('membershipPackage'));
    }

    public function buy_now_stripe(Request $request, $id){
        // middle point data deleted
        UserMembershipPackage::where('payment_status','Pending')
            //->where('membership_package_id',$id)
            ->where('user_id',Auth::id())
            ->where('user_type',Auth::user()->user_type)
            ->delete();
        $user = User::find(Auth::id());
        $gold = \App\Model\MembershipPackage::find(2);
        $membership_package = MembershipPackage::find($id);

        if ($user->membership_package_id == 2){

            $subAmount = ($membership_package->price - $gold->price) + vat($membership_package->price - $gold->price);
            $activation_date = $user->membership_activation_date;
            $expire_date = $user->membership_expired_date;
        }else{
            $subAmount = $membership_package->price + vat($membership_package->price);
            $activation_date = date('Y-m-d');
            $expire_date = date('Y-m-d', strtotime('+1 year'));
        }

        $user_membership_package = new UserMembershipPackage();
        $user_membership_package->user_id = Auth::user()->id;
        $user_membership_package->membership_package_id = $id;
        $user_membership_package->invoice_no = '';
        $user_membership_package->membership_activation_date = $activation_date;
        $user_membership_package->membership_expired_date = $expire_date;
        $user_membership_package->payment_status = 'Pending';
        $user_membership_package->amount = $subAmount;
        $user_membership_package->payment_type = 'Stripe';
        $user_membership_package->save();

        Session::put('user_membership_package_id',$user_membership_package->id);
        //Session::put('user_type','seller');
        Session::put('payment_type', 'cart_payment');

        if ($request->session()->get('user_membership_package_id') != null) {
            $stripe = new StripePaymentController;
            return $stripe->stripe();
        } else {
            Toastr::warning('Select Payment Option.');
            return back();
        }
    }
    public function wo_Package(){
        $memberships_packages = MembershipPackage::all();
        return view('frontend.seller.premium_membership.index',compact('memberships_packages'));
    }
}
