<?php

namespace App\Http\Controllers\Seller;

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
        if (Auth::user()->user_type == 'buyer'){
            return redirect()->route('buyer.dashboard');
        }
        $products = Product::where('user_id','!=',Auth::id())
            ->where('user_type','buyer')
            ->where('published',1)
            ->where('verification_status',1)
            ->where('bid_status','Applied')
//            ->where('price_validity','>=',date('Y-m-d'))
            ->latest()->take(9)->get();
        $featured_products = Product::where('user_id','!=',Auth::id())
            ->where('user_type','buyer')
            ->where('published',1)
            ->where('verification_status',1)
            ->where('featured_product',1)
            ->where('bid_status','Applied')
//            ->where('price_validity','>=',date('Y-m-d'))
            ->latest()->take(9)->get();
        $seller = Seller::where('user_id',Auth::id())->first();
        if (empty($seller)){
            $newSeller = new Seller();
            $newSeller->user_id = Auth::id();
            $newSeller->employer_status = 0;
            $newSeller->verification_status = 0;
            $newSeller->save();
            $seller_id = $newSeller->id;
            return view('frontend.seller.dashboard',compact('products','featured_products','seller_id'));
        }
        if ($seller->employer_status == 1){
            $seller->employer_status = 0;
            $seller->save();
            $seller_id = $seller->id;
            return view('frontend.seller.dashboard',compact('products','featured_products','seller_id'));
        }else{
            $seller_id = $seller->id;
            return view('frontend.seller.dashboard',compact('products','featured_products','seller_id'));
        }
    }

    public function switchToBuyer(Request $request){
        $user = User::find(Auth::id());
        $user->user_type = 'buyer';
        $multiple_user_types = json_decode($user->multiple_user_types);
        if(!in_array("buyer", $multiple_user_types)){
            array_push($multiple_user_types, "buyer");
            $user->multiple_user_types = $multiple_user_types;
        }
        $user->save();

        $checkBuyerUser = Buyer::where('user_id',$user->id)->first();
        if(empty($checkBuyerUser)){
            $buyer = new Buyer();
            $buyer->user_id = $user->id;
            $buyer->status = 0;
            $buyer->verification_status	= 0;
            $buyer->save();
        }

        Toastr::success('Congratulations! You are a buyer now');
        return redirect()->route('buyer.dashboard');
    }

    public function allRecentProducts(){
        $products = Product::where('user_id','!=',Auth::id())
            ->where('user_type','buyer')
            ->where('published',1)
            ->where('verification_status',1)
            ->where('bid_status','Applied')
//            ->where('price_validity','>=',date('Y-m-d'))
            ->latest()->get();

        $title = 'Recent Products';
        return view('frontend.seller.view_all_products',compact('products','title'));
    }
    public function allFeaturedProducts(){
        $products = Product::where('user_id','!=',Auth::id())
            ->where('user_type','buyer')
            ->where('published',1)
            ->where('verification_status',1)
            ->where('featured_product',1)
            ->where('bid_status','Applied')
//            ->where('price_validity','>=',date('Y-m-d'))
            ->latest()->get();

        $title = 'Featured Products';
        return view('frontend.seller.view_all_products',compact('products','title'));
    }
}
