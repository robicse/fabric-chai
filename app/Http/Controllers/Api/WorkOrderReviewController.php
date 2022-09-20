<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ReviewCollection;
use App\Http\Resources\SeeReviewCollection;
use App\Http\Resources\WorkOrderReviewCollection;
use App\Http\Resources\WorkOrderSaleRecordCollection;
use App\Http\Resources\WorkOrderSeeReviewCollection;
use App\Model\Product;
use App\Model\ProductBid;
use App\Model\Review;
use App\Http\Controllers\Controller;
use App\Model\SaleRecord;
use App\Model\WorkOrderBid;
use App\Model\WorkOrderProduct;
use App\Model\WorkOrderQuotationRequest;
use App\Model\WorkOrderReview;
use App\Model\WorkOrderSaleRecord;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class WorkOrderReviewController extends Controller
{
    public function seeReview($id){
        $user = User::find($id);
        $woReviews = WorkOrderReview::where('receiver_user_id',$user->id)->latest()->get();
        return new WorkOrderSeeReviewCollection($woReviews);
    }
    public function reviewSubmit(Request $request){
        $wo_quotation = WorkOrderQuotationRequest::find($request->quotation_id);
        $review_check = WorkOrderReview::where('sender_user_id',Auth::id())->where('work_order_product_id',$wo_quotation->work_order_product_id)->first();
        if (empty($review_check)){
            $workOrderReview = new WorkOrderReview();
            $workOrderReview->sender_user_id = Auth::id();
            $workOrderReview->receiver_user_id = $wo_quotation->buyer_user_id;
            $workOrderReview->work_order_product_id = $wo_quotation->work_order_product_id;
            $workOrderReview->rating = $request->rating;
            $workOrderReview->comment = $request->comment;
            if($workOrderReview->save()){
                $workOrderProduct = WorkOrderProduct::findOrFail($wo_quotation->work_order_product_id);
                if(count(WorkOrderReview::where('work_order_product_id', $workOrderProduct->id)->where('status', 1)->get()) > 0){
                    $workOrderProduct->rating = WorkOrderReview::where('work_order_product_id', $workOrderProduct->id)->where('status', 1)->sum('rating')/count(WorkOrderReview::where('work_order_product_id', $workOrderProduct->id)->where('status', 1)->get());
                }
                else {
                    $workOrderProduct->rating = 0;
                }
                $affected_row = $workOrderProduct->save();
                if(empty($affected_row)){
                    return response()->json(['success'=>false,'response'=>'Something went wrong!'], 401);
                }
            }
            return response()->json(['success'=>true,'response' => 'Review Submitted Successfully '], 201);
        }else{
            return response()->json(['success'=>true,'response'=>'Review already submitted'], 201);
        }
    }

    public function sellerRecordedTransaction(){
        $wo_sale_records = WorkOrderSaleRecord::where('seller_user_id',Auth::id())->where('type','seller_work_order')->latest()->get();
        return new WorkOrderSaleRecordCollection($wo_sale_records);
    }
    public function buyerecordedTransaction(){
        $wo_sale_records = WorkOrderSaleRecord::where('buyer_user_id',Auth::id())->where('type','seller_work_order')->latest()->get();
        return new WorkOrderSaleRecordCollection($wo_sale_records);
    }

    public function workOrderReviewLists(){
        return new WorkOrderReviewCollection(WorkOrderReview::where('receiver_user_id',Auth::id())->latest()->get());
    }
}
