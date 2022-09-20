<?php

namespace App\Http\Controllers\Buyer\WorkOrder;

use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\ProductBid;
use App\Model\WorkOrderProduct;
use App\Model\WorkOrderQuotationRequest;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $membership_package_id = checkMembershipStatus(Auth::id());
        $user_type = checkUserType(Auth::id());
//        if($user_type == 'buyer' && $membership_package_id != 3){
//            Toastr::warning('Upgrade your membership package!');
//            return redirect()->route('buyer.memberships-package-list');
//        }
        $featured_companies = WorkOrderProduct::where('user_id','!=',Auth::id())
            ->where('user_type','=','seller')
            ->where('published',1)
            ->where('verification_status','=',1)
            ->select('user_id')
            ->groupBy('user_id')
            ->take(6)
            ->get();


        $featured_products = WorkOrderProduct::where('user_id','!=',Auth::id())
            ->where('user_type','seller')
            ->where('published',1)
            ->where('verification_status',1)
            ->where('bid_status','Applied')
            ->latest()->take(6)->get();
        return view('frontend.buyer.work_order.dashboard',compact('featured_companies','featured_products'));
    }

    public function WOCompanies(){
        $featured_companies = WorkOrderProduct::where('user_id','!=',Auth::id())
            ->where('user_type','=','seller')
            ->where('published',1)
            ->where('verification_status','=',1)
            ->select('user_id')
            ->groupBy('user_id')
            ->get();
        return view('frontend.buyer.work_order.work_order_companies',compact('featured_companies'));
    }
    public function WOfeaturedProducts(){
        $featured_products = WorkOrderProduct::where('user_id','!=',Auth::id())
            ->where('user_type','seller')
            ->where('published',1)
            ->where('verification_status',1)
            ->where('bid_status','Applied')
            ->latest()->get();
        return view('frontend.buyer.work_order.product.work_order_featured_products',compact('featured_products'));
    }
    public function profile(){
        return view('frontend.buyer.work_order.wo_profile');
    }
    public function profileUpdate(Request $request){
        $bid_check = ProductBid::where('sender_user_id',Auth::id())->first();
        $quotation_check = WorkOrderQuotationRequest::where('buyer_user_id',Auth::id())->first();
        if (!empty($bid_check)){
            Toastr::error('You can not change your profile because you have placed bid. ');
            return redirect()->back();
        }
        if (!empty($quotation_check)){
            Toastr::error('You can not change your profile because you have requested for quotation. ');
            return redirect()->back();
        }
        $this->validate($request, [
            'name' => 'required',
        ]);

        $user = User::find(Auth::id());
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        if($request->hasFile('avatar_original')){
            $user->avatar_original = $request->avatar_original->store('uploads/profile');
        }
        $user->save();
        Toastr::success('Profile Updated Successfully');
        return back();
    }
}
