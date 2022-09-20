<?php

namespace App\Http\Controllers\Seller\WorkOrder;

use App\Helpers\UserInfo;
use App\Http\Controllers\Controller;
use App\Model\WorkOrderBid;
use App\Model\WorkOrderProduct;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkOrderBidController extends Controller
{
    public function WOBidStore(Request $request, $id){
        $membership_package_id = checkMembershipStatus(Auth::id());
        $user_type = checkUserType(Auth::id());
        if($user_type == 'seller' && $membership_package_id != 3){
            Toastr::warning('Upgrade your membership package!');
            return redirect()->route('seller.work-order.memberships-package-list');
        }
        $workOrderProduct = WorkOrderProduct::find($id);
        $bidCheck = WorkOrderBid::where('sender_user_id',Auth::id())->where('work_order_product_id',$id)->first();
        if (!empty($bidCheck)){
            Toastr::warning("You've already bidden for this product");
            return back();
        }else{

            if(currency()->code != 'BDT'){
                $bid_price = convert_to_bdt($request->bid_price);
            }else{
                //$bid_price = single_price_without_symbol($request->bid_price);
                $bid_price = $request->bid_price;
            }

            $woBid = new WorkOrderBid();
            $woBid->sender_user_id =Auth::id();
            $woBid->receiver_user_id = $workOrderProduct->user_id;
            $woBid->work_order_product_id = $workOrderProduct->id;
            $woBid->quantity = $workOrderProduct->moq;
            $woBid->unit_price = $bid_price;
            $woBid->total_price = $bid_price * $workOrderProduct->moq;
            $woBid->bid_status = 0;
            $woBid->save();
            $bidder = User::where('id',Auth::id())->first();

            $user = User::where('id',$workOrderProduct->user_id )->first();

            $title = 'Placed Work Order Bid';
            $message = 'Dear, '.$user->name.' your Work Order "'.$workOrderProduct->name.'" has been bidden by '.$bidder->name.' with '.$woBid->unit_price.currency()->symbol.' unit bid amount';
            workOrderPlacedBidNotification($workOrderProduct->id,$workOrderProduct->user_id,$title,$message);
//            if($user->country_code == '+880') {
//                UserInfo::smsAPI($user->country_code . $user->phone, $message);
//                SmsNotification($user->id,$title,$message);
//            }
            Toastr::success('Work Order Bid submitted successfully');
//            return redirect()->route('seller.work-order.dashboard');
            return back();
        }
    }

    public function WOBidBidHistory(){
        $woBids = WorkOrderBid::where('sender_user_id',Auth::id())->latest()->get();
        return view('frontend.seller.work_order.product_bid.bid_history',compact('woBids'));
    }

    public function WOAcceptedBidList(){
        $woAcceptedBidLists = WorkOrderBid::where('sender_user_id',Auth::id())->latest()->where('bid_status',1)->get();
        return view('frontend.seller.work_order.product_bid.accepted_bid_list',compact('woAcceptedBidLists'));
    }

    public function getAcceptedBuyerDetails($id){
        $WOProductBid = WorkOrderBid::find($id);
        //dd($WOProductBid);
        $buyer = User::where('id',$WOProductBid->receiver_user_id)->first();
        return view('frontend.seller.work_order.product_bid.accepted_buyer_details',compact('WOProductBid','buyer'));
    }
}
