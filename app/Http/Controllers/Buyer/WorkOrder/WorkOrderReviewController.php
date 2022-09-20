<?php

namespace App\Http\Controllers\Buyer\WorkOrder;

use App\Http\Controllers\Controller;
use App\Model\WorkOrderReview;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkOrderReviewController extends Controller
{
    public function getWorkOrderBiddersReview($id){
        $bidder = User::find(decrypt($id));
        $reviews = WorkOrderReview::where('receiver_user_id',$bidder->id)->latest()->get();
        return view('frontend.buyer.work_order.wo_see_review',compact('bidder','reviews'));
    }
    public function WOReviews(){
        $wo_reviews = WorkOrderReview::where('receiver_user_id',Auth::id())->latest()->get();
        return view('frontend.buyer.work_order.work_order_reviews',compact('wo_reviews'));
    }
}
