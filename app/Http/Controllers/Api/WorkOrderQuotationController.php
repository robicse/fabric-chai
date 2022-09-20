<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BuyerAcceptedQuotationCollection;
use App\Http\Resources\BuyerQuotationCollection;
use App\Http\Resources\WorkOrderQuotationListCollection;
use App\Model\Seller;
use App\Model\WorkOrderProduct;
use App\Model\WorkOrderQuotationRequest;
use App\Model\WorkOrderSaleRecord;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkOrderQuotationController extends Controller
{
    public function sellerQuotationList($id){
        $workOrder = WorkOrderProduct::find($id);
        $quotations = WorkOrderQuotationRequest::where('seller_user_id',Auth::id())->where('work_order_product_id',$workOrder->id)->latest()->get();
        return new WorkOrderQuotationListCollection($quotations);
    }
    public function sellerQuotationDetails($id){
        $quotation = WorkOrderQuotationRequest::find($id);
        $user = User::find($quotation->buyer_user_id);
        $days = \Carbon\Carbon::parse($user->created_at)->diffInDays(\Carbon\Carbon::now());
        $complete_rfqs = \App\Model\WorkOrderQuotationRequest::where('buyer_user_id',$user->id)->where('status',1)->count();
        $reviews = \App\Model\WorkOrderReview::where('receiver_user_id',$user->id)->count();

        $nested_data['experience'] =(string) getNumberToBangla($days);
        $nested_data['completed_rfqs'] =(string) getNumberToBangla($complete_rfqs);
        $nested_data['reviews'] =(string) getNumberToBangla($reviews);
        $nested_data['ratings'] =(string) getNumberToBangla(userWorkOrderRating($user->id));
        $nested_data['buyer_id'] =(integer) $user->id;
        $nested_data['name'] =(string) getNameByBnEn($user);
        $nested_data['phone'] = $user->country_code.$user->phone;
        $nested_data['address'] =(string) $user->address;
        $nested_data['work_order_name'] =(string) $quotation->workOrderProduct->wish_to_work;
        $nested_data['requested_quantity'] =(string) getNumberToBangla($quotation->quantity). ' '. getNameByBnEn($quotation->workOrderProduct->unit);
        $nested_data['requested_unit_price_bdt'] =(string) getNumberToBangla($quotation->unit_price);
        $nested_data['requested_unit_price_usd'] =(string) getNumberToBangla(convert_to_usd($quotation->unit_price));
        $nested_data['requested_total_price_bdt'] =(string) getNumberToBangla($quotation->total_price);
        $nested_data['requested_total_price_usd'] =(string) getNumberToBangla(convert_to_usd($quotation->total_price));
        $nested_data['date_and_time'] =(string) getDateConvertByBnEn($quotation->created_at);

        if (!empty($nested_data))
        {
            return response()->json(['success'=>true,'response'=> $nested_data], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function sellerAcceptQuotation($id){

        $get_invoice_code = WorkOrderSaleRecord::orderBy('created_at','DESC')->first();
        if(!empty($get_invoice_code)){
            $invoice_no = "FLL-WO".date('Y')."-".str_pad($get_invoice_code->id + 1, 8, "0", STR_PAD_LEFT);;
        }else{
            $invoice_no = "FLL-WO".date('Y')."-"."00000001";
        }
        $check = WorkOrderSaleRecord::where('work_order_quotation_request_id',$id)->first();
        if (!empty($check)){
            return response()->json(['success'=>false,'response'=> 'Already accepted'], 404);
        }
        $wo_quotation = WorkOrderQuotationRequest::find($id);
        $wo_quotation->status = 1;

        $commission = ($wo_quotation->total_price * sellerCurrentCommission(Auth::id()))/100;
        $vat = vat($commission);
        $admin_commission = $commission + $vat;
        $wo_quotation->save();

        $woSaleRecord = new WorkOrderSaleRecord();
        $woSaleRecord->buyer_user_id = $wo_quotation->buyer_user_id;
        $woSaleRecord->seller_user_id = Auth::id();
        $woSaleRecord->type = 'seller_work_order';

        $woSaleRecord->work_order_product_id = $wo_quotation->work_order_product_id;
        $woSaleRecord->work_order_quotation_request_id  = $wo_quotation->id;
        $woSaleRecord->amount = $wo_quotation->total_price;
        $woSaleRecord->commission = $commission;
        $woSaleRecord->vat = $vat;
        $woSaleRecord->admin_commission = $admin_commission;
        $woSaleRecord->payment_status = 'Pending';
        $woSaleRecord->invoice_code = $invoice_no;
        $woSaleRecord->save();

        $user = User::find($wo_quotation->buyer_user_id);
        $title = 'Accepted Work Order Quotation Request';
        $message = 'Dear, '. $user->name .' your work order quotation request for '.$wo_quotation->workOrderProduct->wish_to_work.' has been accepted ';
        createWONotification($user->id,$title,$message);
        //UserInfo::smsAPI("0".$user->phone,$message);
//        if($user->country_code == '+880') {
//            UserInfo::smsAPI($user->country_code . $seller->phone, $message);
//            SmsNotification($user->id,$title,$message);
//        }
        if (!empty($woSaleRecord))
        {
            return response()->json(['success'=>true,'response'=> 'Quotation Accepted Successfully'], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function sellerAcceptedQuotationList(){
        $quotations = WorkOrderQuotationRequest::where('seller_user_id',Auth::id())->where('status',1)->latest()->get();
        return new WorkOrderQuotationListCollection($quotations);
    }
    public function sellerAcceptedQuotationDetails($id){
        $quotation = WorkOrderQuotationRequest::find($id);
        $user = User::find($quotation->buyer_user_id);
        $days = \Carbon\Carbon::parse($user->created_at)->diffInDays(\Carbon\Carbon::now());
        $complete_rfqs = \App\Model\WorkOrderQuotationRequest::where('buyer_user_id',$user->id)->where('status',1)->count();
        $reviews = \App\Model\WorkOrderReview::where('receiver_user_id',$user->id)->count();

        $nested_data['quotation_id'] =(integer) $quotation->id;
        $nested_data['experience'] =(string) getNumberToBangla($days);
        $nested_data['completed_rfqs'] =(string) getNumberToBangla($complete_rfqs);
        $nested_data['reviews'] =(string) getNumberToBangla($reviews);
        $nested_data['ratings'] =(string) getNumberToBangla(userWorkOrderRating($user->id));
        $nested_data['buyer_id'] =(integer) $user->id;
        $nested_data['name'] =getNameByBnEn($user);
        $nested_data['phone'] = $user->country_code.$user->phone;
        $nested_data['address'] =(string) $user->address;
        $nested_data['work_order_product_id'] =(integer) $quotation->work_order_product_id;
        $nested_data['work_order_name'] =(string) $quotation->workOrderProduct->wish_to_work;
        $nested_data['requested_quantity'] =(string) getNumberToBangla($quotation->quantity). ' '. $quotation->workOrderProduct->unit ? getNameByBnEn($quotation->workOrderProduct->unit):'';
        $nested_data['requested_unit_price_bdt'] =(string) getNumberToBangla($quotation->unit_price);
        $nested_data['requested_unit_price_usd'] =(string) getNumberToBangla(convert_to_usd($quotation->unit_price));
        $nested_data['requested_total_price_bdt'] =(string) getNumberToBangla($quotation->total_price);
        $nested_data['requested_total_price_usd'] =(string) getNumberToBangla(convert_to_usd($quotation->total_price));
        $nested_data['date_and_time'] =(string) getDateConvertByBnEn($quotation->created_at);

        if (!empty($nested_data))
        {
            return response()->json(['success'=>true,'response'=> $nested_data], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function buyerSubmittedRFQ(){
        $quotations = WorkOrderQuotationRequest::where('buyer_user_id',Auth::id())->latest()->get();
        return new BuyerQuotationCollection($quotations);
    }
    public function buyerAcceptedRFQ(){
        $quotations = WorkOrderQuotationRequest::where('buyer_user_id',Auth::id())->where('status',1)->latest()->get();
        return new BuyerAcceptedQuotationCollection($quotations);
    }
    public function buyerAcceptedRFQDetails($id){
        $quotation = WorkOrderQuotationRequest::find($id);

        $user = User::find($quotation->seller_user_id);
        $days = \Carbon\Carbon::parse($user->created_at)->diffInDays(\Carbon\Carbon::now());
        $complete_rfqs = \App\Model\WorkOrderQuotationRequest::where('seller_user_id',$user->id)->where('status',1)->count();
        $reviews = \App\Model\WorkOrderReview::where('receiver_user_id',$user->id)->count();

        $nested_data['quotation_id'] =(integer) $quotation->id;
        $nested_data['experience'] =(string) getNumberToBangla($days);
        $nested_data['completed_rfqs'] =(string) getNumberToBangla($complete_rfqs);
        $nested_data['reviews'] =(string) getNumberToBangla($reviews);
        $nested_data['ratings'] =(string) getNumberToBangla(userWorkOrderRating($user->id));
        $nested_data['seller_id'] =(integer) $user->id;
        $nested_data['name'] =(string) getNameByBnEn($user);
        $nested_data['phone'] = $user->country_code.$user->phone;
        $nested_data['address'] =(string) $user->address;
        $nested_data['work_order_product_id'] =(integer) $quotation->work_order_product_id;
        $nested_data['work_order_name'] =(string) $quotation->workOrderProduct->wish_to_work;
        $nested_data['requested_quantity'] =(string) getNumberToBangla($quotation->quantity) . ' '. getNameByBnEn($quotation->workOrderProduct->unit);
        $nested_data['requested_unit_price_bdt'] =(string) getNumberToBangla($quotation->unit_price);
        $nested_data['requested_unit_price_usd'] =(string) getNumberToBangla(convert_to_usd($quotation->unit_price));
        $nested_data['requested_total_price_bdt'] =(string) getNumberToBangla($quotation->total_price);
        $nested_data['requested_total_price_usd'] =(string) getNumberToBangla(convert_to_usd($quotation->total_price));
        $nested_data['date_and_time'] =(string) getDateConvertByBnEn($quotation->created_at);

        if (!empty($nested_data))
        {
            return response()->json(['success'=>true,'response'=> $nested_data], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function buyerQuotationSubmit(Request $request){
        $membership_package_id = checkMembershipStatus(Auth::id());
        $user_type = checkUserType(Auth::id());
        if($user_type == 'buyer' && $membership_package_id != 3){
            return response()->json(['success'=>false,'response'=> 'Upgrade your membership package!'], 400);
        }

        $woProduct = WorkOrderProduct::find($request->work_order_product_id);
        $check = WorkOrderQuotationRequest::where('buyer_user_id',Auth::id())->where('work_order_product_id',$request->work_order_product_id)->first();
        if (!empty($check)){
            return response()->json(['success'=>false,'response'=> 'You already send quotation for this work order'], 400);
        }
        if($request->currency_id != 27){
            $bid_price = convert_to_bdt($request->requested_amount);
        }else{
            $bid_price = $request->requested_amount;
        }
        $quotation = new WorkOrderQuotationRequest();
        $quotation->buyer_user_id = Auth::id();
        $quotation->seller_user_id = $woProduct->user_id;
        $quotation->work_order_product_id = $request->work_order_product_id;
        $quotation->quantity = $request->quantity;
        $quotation->unit_price = $bid_price;
        $quotation->total_price = $bid_price * $request->quantity;
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
        return response()->json(['success'=>true,'response'=> 'Your Quotation Request submitted successfully'], 201);
    }
}
