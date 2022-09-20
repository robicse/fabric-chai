<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Model\Buyer;
use App\Model\Product;
use App\Model\Seller;
use App\Model\Slider;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        if (Auth::user()->user_type == 'seller'){
            return redirect()->route('seller.dashboard');
        }
        $products = Product::where('user_id','!=',Auth::id())
            ->where('user_type','seller')
            ->where('published',1)
            ->where('verification_status',1)
            ->where('bid_status','Applied')
//            ->where('price_validity','>=',date('Y-m-d'))
            ->latest()->take(9)->get();

        $featured_products = Product::where('user_id','!=',Auth::id())
            ->where('user_type','seller')
            ->where('published',1)
            ->where('verification_status',1)
            ->where('featured_product',1)
            ->where('bid_status','Applied')
//            ->where('price_validity','>=',date('Y-m-d'))
            ->latest()->take(9)->get();
        return view('frontend.buyer.dashboard',compact('products','featured_products'));
    }
    public function applyForSeller(){
        return view('frontend.buyer.apply_for_seller');
    }
    public function applyForSellerStore(Request $request){
        $user = User::find(Auth::id());
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
        $seller->division_id= $request->division_id;
        $seller->district_id= $request->district_id;
        $seller->designation= $request->designation;
        $seller->selected_category= implode(',', $request->selected_category);

        if($request->hasFile('trade_licence')){
            $seller->trade_licence = $request->trade_licence->store('uploads/seller_info/trade_licence');
        }

        if($request->hasFile('nid_front')){
            $seller->nid_front = $request->nid_front->store('uploads/seller_info/nid');
        }
        if($request->hasFile('nid_back')){
            $seller->nid_back = $request->nid_back->store('uploads/seller_info/nid');
        }

        $seller_insert_id = $seller->save();
        if($seller_insert_id){
            $title = 'Applied for Seller';
            $message = $user->name .' applied for seller';
            registrationNotification($user->id,$title,$message);
            // admin sms
//                    UserInfo::smsAPI('8801725930131', $message);
//                    SmsNotification(9,$title,$message);
        }
        Toastr::success('Congratulations! You are a seller now');
        return redirect()->route('seller.dashboard');
    }

    public function switchToSeller(Request $request){
        $user = User::find(Auth::id());
        $user->user_type = 'seller';
        $multiple_user_types = json_decode($user->multiple_user_types);
        if(!in_array("seller", $multiple_user_types)){
            array_push($multiple_user_types, "seller");
            $user->multiple_user_types = $multiple_user_types;
        }
        $user->save();

        Toastr::success('Congratulations! You are a seller now');
        return redirect()->route('seller.dashboard');
    }

    public function allRecentProducts(){
        $products = Product::where('user_id','!=',Auth::id())
            ->where('user_type','seller')
            ->where('published',1)
            ->where('verification_status',1)
            ->where('bid_status','Applied')
//            ->where('price_validity','>=',date('Y-m-d'))
            ->latest()->get();

        $title = 'Recent Products';
        return view('frontend.buyer.view_all_products',compact('products','title'));
    }
    public function allFeaturedProducts(){
        $products = Product::where('user_id','!=',Auth::id())
            ->where('user_type','seller')
            ->where('published',1)
            ->where('verification_status',1)
            ->where('featured_product',1)
            ->where('bid_status','Applied')
//            ->where('price_validity','>=',date('Y-m-d'))
            ->latest()->get();
        $title = 'Featured Products';
        return view('frontend.buyer.view_all_products',compact('products','title'));
    }
}
