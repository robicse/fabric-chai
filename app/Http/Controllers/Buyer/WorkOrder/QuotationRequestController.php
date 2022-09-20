<?php

namespace App\Http\Controllers\Buyer\WorkOrder;

use App\Http\Controllers\Controller;
use App\Model\WorkOrderProduct;
use App\Model\WorkOrderQuotationRequest;
use App\Model\WorkOrderSaleRecord;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use NumberFormatter;

class QuotationRequestController extends Controller
{
    public function sellerWorkOrderList(){
        $workOrderProducts = WorkOrderProduct::where('user_id','!=',Auth::user())
            ->where('user_type','seller')
            ->where('published',1)
            ->where('verification_status',1)
            ->latest()
            ->get();
        return view('frontend.buyer.work_order.quotation_request.seller_work_order_list',compact('workOrderProducts'));
    }
    public function quotationStore(Request $request){

        $membership_package_id = checkMembershipStatus(Auth::id());
        $user_type = checkUserType(Auth::id());
        if($user_type == 'buyer' && $membership_package_id != 3){
            Toastr::warning('Upgrade your membership package!');
            return redirect()->route('buyer.work-order.memberships-package-list');
        }

        $woProduct = WorkOrderProduct::find($request->work_order_product_id);
        $check = WorkOrderQuotationRequest::where('buyer_user_id',Auth::id())->where('work_order_product_id',$request->work_order_product_id)->first();
        if (!empty($check)){
            Toastr::error('You already send quotation for this work order');
            return back();
        }else{
            if(currency()->code != 'BDT'){
                $bid_price = convert_to_bdt($request->bid_price);
            }else{
                //$bid_price = single_price_without_symbol($request->bid_price);
                $bid_price = $request->bid_price;
            }
            $quotation = new WorkOrderQuotationRequest();
            $quotation->buyer_user_id = Auth::id();
            $quotation->seller_user_id = $woProduct->user_id;
            $quotation->work_order_product_id = $request->work_order_product_id;
            $quotation->quantity = $request->qty;
            $quotation->unit_price = $bid_price;
            $quotation->total_price = $bid_price * $request->qty;
            $quotation->details = $request->details;
            $quotation->status = 0;
            $quotation->save();

            $bidder = User::where('id',Auth::id())->first();

            $user = User::where('id',$woProduct->user_id )->first();
            $title = 'Request for Quotation';
            $message = 'Dear, '.$user->name.' your Work Order "'.$woProduct->wish_to_work.'" has been requested for Quotation by '.$bidder->name.' with '.$woProduct->unit_price.currency()->symbol.' unit bid amount';
            workOrderPlacedBidNotification($woProduct->id,$woProduct->user_id,$title,$message);
//            if($user->country_code == '+880') {
//                UserInfo::smsAPI($user->country_code . $user->phone, $message);
//                SmsNotification($user->id,$title,$message);
//            }
            Toastr::success('Your Quotation Request submitted successfully');
            return redirect()->route('buyer.work-order.dashboard');

        }
    }
    public function quotationList(){
        $quotations = WorkOrderQuotationRequest::where('buyer_user_id',Auth::id())->latest()->get();
        return view('frontend.buyer.work_order.quotation_request.quotation_list',compact('quotations'));
    }
    public function acceptedQuotationList(){
        $wo_quotations = WorkOrderQuotationRequest::where('buyer_user_id',Auth::id())->where('status',1)->latest()->get();
        return view('frontend.buyer.work_order.quotation_request.accepted_quotation_list',compact('wo_quotations'));
    }
    public function acceptedQuotationDetails($id){
        $wo_quotation = WorkOrderQuotationRequest::find(decrypt($id));
        return view('frontend.buyer.work_order.quotation_request.accepted_seller_details',compact('wo_quotation'));
    }
    public function quotationRecordedTransaction(){
        $wo_sale_records = WorkOrderSaleRecord::where('buyer_user_id',Auth::id())->where('type','seller_work_order')->latest()->get();
        return view('frontend.buyer.work_order.quotation_request.quotation_recorded_transaction',compact('wo_sale_records'));
    }
    public function quotationPrint($id){
        $wo_sale_record = WorkOrderSaleRecord::find(decrypt($id));
        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return view('frontend.buyer.work_order.quotation_request.wo_print',compact('wo_sale_record','digit'));
    }
}
