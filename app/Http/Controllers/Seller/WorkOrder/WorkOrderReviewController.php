<?php

namespace App\Http\Controllers\Seller\WorkOrder;

use App\Http\Controllers\Controller;
use App\Model\WorkOrderBid;
use App\Model\WorkOrderProduct;
use App\Model\WorkOrderReview;
use App\Model\WorkOrderSaleRecord;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkOrderReviewController extends Controller
{
    public function workOrderReviewStore(Request $request){
        //dd($request->all());
        $work_order_bid = WorkOrderBid::find($request->work_order_bid_id);
        //$workOrderSaleRecord = WorkOrderSaleRecord::where('work_order_bid_id',$work_order_bid->id)->first();
        $review_check = WorkOrderReview::where('sender_user_id',Auth::id())->where('work_order_product_id',$work_order_bid->work_order_product_id)->first();

        if (empty($review_check)){
            $workOrderReview = new WorkOrderReview();
            $workOrderReview->sender_user_id = Auth::id();
            $workOrderReview->receiver_user_id = $work_order_bid->receiver_user_id;
            $workOrderReview->work_order_product_id = $work_order_bid->work_order_product_id;
            $workOrderReview->rating = $request->rating;
            $workOrderReview->comment = $request->comment;
            if($workOrderReview->save()){
                $workOrderProduct = WorkOrderProduct::findOrFail($work_order_bid->work_order_product_id);
                if(count(WorkOrderReview::where('work_order_product_id', $workOrderProduct->id)->where('status', 1)->get()) > 0){
                    $workOrderProduct->rating = WorkOrderReview::where('work_order_product_id', $workOrderProduct->id)->where('status', 1)->sum('rating')/count(WorkOrderReview::where('work_order_product_id', $workOrderProduct->id)->where('status', 1)->get());
                }
                else {
                    $workOrderProduct->rating = 0;
                }
                $affected_row = $workOrderProduct->save();
                if(empty($affected_row)){
                    Toastr::error('Something went wrong, work order product review update!');
                    return redirect()->back();
                }
            }
            Toastr::success('Successfully review created.');
            return redirect()->route('seller.work-order.accepted-buyer-details',$work_order_bid->id);
        }else{
            Toastr::error('You have already reviewed this buyer');
            return redirect()->back();
        }
    }

    public function getWorkOrderBiddersReview($id){
        $bidder = User::find(decrypt($id));
        $reviews = WorkOrderReview::where('receiver_user_id',$bidder->id)->where('status',1)->latest()->get();
        return view('frontend.seller.work_order.review.bidder_review',compact('bidder','reviews'));
    }
    public function WOReviews(){
        $wo_reviews = WorkOrderReview::where('receiver_user_id',Auth::id())->latest()->get();
        return view('frontend.seller.work_order.review.index',compact('wo_reviews'));
    }
}
