<?php

namespace App\Http\Controllers\Buyer\WorkOrder;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Currency;
use App\Model\Seller;
use App\Model\Unit;
use App\Model\WorkOrderBid;
use App\Model\WorkOrderProduct;
use App\Model\WorkOrderQuotationRequest;
use App\Model\WorkOrderReview;
use App\Model\WorkOrderSaleRecord;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WorkOrderController extends Controller
{
    public function index(){
        $workOrderProducts = WorkOrderProduct::where('user_id',Auth::id())->latest()->get();
        return view('frontend.buyer.work_order.product.my_work_order',compact('workOrderProducts'));
    }
    public function create(){
        $categories = Category::all();
        $units = Unit::all();
        $currencies = Currency::where('status',1)->get();
        return view('frontend.buyer.work_order.product.create',compact('categories','units','currencies'));
    }
    public function store(Request $request){
        $membership_package_id = checkMembershipStatus(Auth::id());
        $user_type = checkUserType(Auth::id());
        if($user_type == 'buyer' && $membership_package_id != 3){
            Toastr::warning('Upgrade your membership package!');
            return redirect()->route('buyer.work-order.memberships-package-list');
        }
        if($request->sub_category_id && ($request->sub_category_id == 'Select Product')){
            $sub_category_id = NULL;
        }else{
            $sub_category_id = $request->sub_category_id;
        }

        if($request->sub_sub_category_id && ($request->sub_sub_category_id == 'Select Product')){
            $sub_sub_category_id = NULL;
        }else{
            $sub_sub_category_id = $request->sub_sub_category_id;
        }

        if($request->sub_sub_child_category_id && ($request->sub_sub_child_category_id == 'Select Product')){
            $sub_sub_child_category_id = NULL;
        }else{
            $sub_sub_child_category_id = $request->sub_sub_child_category_id;
        }

        if($request->sub_sub_child_child_category_id && ($request->sub_sub_child_child_category_id == 'Select Product')){
            $sub_sub_child_child_category_id = NULL;
        }else{
            $sub_sub_child_child_category_id = $request->sub_sub_child_child_category_id;
        }
        if($request->category_six_id && ($request->category_six_id == 'Select Product')){
            $category_six_id = NULL;
        }else{
            $category_six_id = $request->category_six_id;
        }
        if($request->category_seven_id && ($request->category_seven_id == 'Select Product')){
            $category_seven_id = NULL;
        }else{
            $category_seven_id = $request->category_seven_id;
        }
        if($request->category_eight_id && ($request->category_eight_id == 'Select Product')){
            $category_eight_id = NULL;
        }else{
            $category_eight_id = $request->category_eight_id;
        }
        if($request->category_nine_id && ($request->category_nine_id == 'Select Product')){
            $category_nine_id = NULL;
        }else{
            $category_nine_id = $request->category_nine_id;
        }
        if($request->category_ten_id && ($request->category_ten_id == 'Select Product')){
            $category_ten_id = NULL;
        }else{
            $category_ten_id = $request->category_ten_id;
        }

        $workOrderProduct = new WorkOrderProduct();
        $workOrderProduct->name = $request->name;
        $workOrderProduct->user_id = Auth::id();
        $workOrderProduct->user_type = 'buyer';
        $workOrderProduct->category_id = $request->category_id;
        $workOrderProduct->sub_category_id = $sub_category_id;
        $workOrderProduct->sub_sub_category_id = $sub_sub_category_id;
        $workOrderProduct->sub_sub_child_category_id = $sub_sub_child_category_id;
        $workOrderProduct->sub_sub_child_child_category_id = $sub_sub_child_child_category_id;
        $workOrderProduct->category_six_id = $category_six_id;
        $workOrderProduct->category_seven_id = $category_seven_id;
        $workOrderProduct->category_seven_id = $category_seven_id;
        $workOrderProduct->category_eight_id = $category_eight_id;
        $workOrderProduct->category_nine_id = $category_nine_id;
        $workOrderProduct->category_ten_id = $category_ten_id;

        $photos = array();
        if($request->hasFile('photos')){
            $thumbnail_img = $request->photos[0];
            $workOrderProduct->thumbnail_img = $thumbnail_img->store('uploads/work_order/thumbnail');

            foreach ($request->photos as $key => $photo) {
                $path = $photo->store('uploads/work_order/photos');
                array_push($photos, $path);
            }
            $workOrderProduct->photos = json_encode($photos);

        }
        $total_pc_per_day = $request->no_of_machines * $request->pc_per_day;
        $production_time = ceil($request->max_oq / $total_pc_per_day);
        $delivery_time = $production_time + $request->finishing_time;

        $workOrderProduct->quantity = $request->quantity;
        $workOrderProduct->unit_id = $request->unit_id;
        $workOrderProduct->unit_price = $request->unit_price;
        $workOrderProduct->currency_id = $request->currency_id;
        $workOrderProduct->machine_type = json_encode($request->machine_type);
        $workOrderProduct->no_of_machines = $request->no_of_machines;
        $workOrderProduct->pc_per_day = $request->pc_per_day;
        $workOrderProduct->total_pc_per_day = $total_pc_per_day;
        $workOrderProduct->moq = $request->moq;
        $workOrderProduct->max_oq = $request->max_oq;
        $workOrderProduct->production_time = $production_time;
        $workOrderProduct->finishing_time = $request->finishing_time;
        $workOrderProduct->delivery_time = $delivery_time;

        $workOrderProduct->description = $request->description;
        $workOrderProduct->published = 1;
        $workOrderProduct->featured = 0;
        $workOrderProduct->verification_status = 1;
        $workOrderProduct->bid_status = 'Applied';
        $workOrderProduct->slug = $request->slug.'-'.Str::random(5);
        $workOrderProduct->save();
        $insert_id = $workOrderProduct->id;
        if($insert_id){
            $user = User::where('id',Auth::id())->first();
            $title = 'Buyer Work Order Create';
            $message = $user->name .' Added A New Work Order '.$workOrderProduct->name.' .';
            //createNotification($user->id,$title,$message);
            createWONotificationWithProductId(9,$title,$message,$insert_id);
            // admin sms
//            UserInfo::smsAPI('8801725930131', $message);
        }
        Toastr::success("Work Order Inserted Successfully. Now Waiting For Approval","Success");
        return redirect()->route('buyer.my-work-order.list');
    }
    public function edit($id){
        $workOrderProduct = WorkOrderProduct::find(decrypt($id));
        $categories = Category::all();
        $units = Unit::all();
        $currencies = Currency::where('status',1)->get();
        return view('frontend.buyer.work_order.product.edit',compact('workOrderProduct','categories','units','currencies'));
    }

    public function update(Request $request, $id){

        if($request->sub_category_id && ($request->sub_category_id == 'Select Product')){
            $sub_category_id = NULL;
        }else{
            $sub_category_id = $request->sub_category_id;
        }

        if($request->sub_sub_category_id && ($request->sub_sub_category_id == 'Select Product')){
            $sub_sub_category_id = NULL;
        }else{
            $sub_sub_category_id = $request->sub_sub_category_id;
        }

        if($request->sub_sub_child_category_id && ($request->sub_sub_child_category_id == 'Select Product')){
            $sub_sub_child_category_id = NULL;
        }else{
            $sub_sub_child_category_id = $request->sub_sub_child_category_id;
        }

        if($request->sub_sub_child_child_category_id && ($request->sub_sub_child_child_category_id == 'Select Product')){
            $sub_sub_child_child_category_id = NULL;
        }else{
            $sub_sub_child_child_category_id = $request->sub_sub_child_child_category_id;
        }
        if($request->category_six_id && ($request->category_six_id == 'Select Product')){
            $category_six_id = NULL;
        }else{
            $category_six_id = $request->category_six_id;
        }
        if($request->category_seven_id && ($request->category_seven_id == 'Select Product')){
            $category_seven_id = NULL;
        }else{
            $category_seven_id = $request->category_seven_id;
        }
        if($request->category_eight_id && ($request->category_eight_id == 'Select Product')){
            $category_eight_id = NULL;
        }else{
            $category_eight_id = $request->category_eight_id;
        }
        if($request->category_nine_id && ($request->category_nine_id == 'Select Product')){
            $category_nine_id = NULL;
        }else{
            $category_nine_id = $request->category_nine_id;
        }
        if($request->category_ten_id && ($request->category_ten_id == 'Select Product')){
            $category_ten_id = NULL;
        }else{
            $category_ten_id = $request->category_ten_id;
        }

        $workOrderProduct = WorkOrderProduct::find($id);
        $workOrderProduct->name = $request->name;
        $workOrderProduct->category_id = $request->category_id;
        $workOrderProduct->sub_category_id = $sub_category_id;
        $workOrderProduct->sub_sub_category_id = $sub_sub_category_id;
        $workOrderProduct->sub_sub_child_category_id = $sub_sub_child_category_id;
        $workOrderProduct->sub_sub_child_child_category_id = $sub_sub_child_child_category_id;
        $workOrderProduct->category_six_id = $category_six_id;
        $workOrderProduct->category_seven_id = $category_seven_id;
        $workOrderProduct->category_seven_id = $category_seven_id;
        $workOrderProduct->category_eight_id = $category_eight_id;
        $workOrderProduct->category_nine_id = $category_nine_id;
        $workOrderProduct->category_ten_id = $category_ten_id;

        $photos = array();
        if($request->hasFile('photos')){
            $thumbnail_img = $request->photos[0];
            $workOrderProduct->thumbnail_img = $thumbnail_img->store('uploads/work_order/thumbnail');

            foreach ($request->photos as $key => $photo) {
                $path = $photo->store('uploads/work_order/photos');
                array_push($photos, $path);
            }
            $workOrderProduct->photos = json_encode($photos);

        }

        $total_pc_per_day = $request->no_of_machines * $request->pc_per_day;
        $production_time = ceil($request->max_oq / $total_pc_per_day);
        $delivery_time = $production_time + $request->finishing_time;

        $workOrderProduct->quantity = $request->quantity;
        $workOrderProduct->unit_id = $request->unit_id;
        $workOrderProduct->unit_price = $request->unit_price;
        $workOrderProduct->currency_id = $request->currency_id;
        $workOrderProduct->machine_type = json_encode($request->machine_type);
        $workOrderProduct->no_of_machines = $request->no_of_machines;
        $workOrderProduct->pc_per_day = $request->pc_per_day;
        $workOrderProduct->total_pc_per_day = $total_pc_per_day;
        $workOrderProduct->moq = $request->moq;
        $workOrderProduct->max_oq = $request->max_oq;
        $workOrderProduct->production_time = $production_time;
        $workOrderProduct->finishing_time = $request->finishing_time;
        $workOrderProduct->delivery_time = $delivery_time;
        $workOrderProduct->description = $request->description;
        $workOrderProduct->slug = $request->slug.'-'.Str::random(5);
        $workOrderProduct->save();
        $insert_id = $workOrderProduct->id;
        if($insert_id){
            $user = User::where('id',Auth::id())->first();
            $title = 'Buyer Work Order Edit';
            $message = $user->name .' Updated product '.$workOrderProduct->name.' .';
            //createNotification($user->id,$title,$message);
            createWONotificationWithProductId(9,$title,$message,$insert_id);
            // admin sms
//            UserInfo::smsAPI('8801725930131', $message);
        }
        Toastr::success("Work Order Updated Successfully.","Success");
        return redirect()->route('buyer.my-work-order.list');
    }
    public function WOProductDetails($slug){
        $workOrderProduct = WorkOrderProduct::where('slug',$slug)->first();
        return view('frontend.buyer.work_order.product.wo_product_details',compact('workOrderProduct'));
    }
    public function WOCompanyDetails($id){
//        $workOrderProduct = WorkOrderProduct::find(decrypt($id));
        $user = User::find(decrypt($id));
        return view('frontend.buyer.work_order.product.wo_company_details',compact('user'));
    }
    public function myWODetails($slug){
        $workOrderProduct = WorkOrderProduct::where('slug',$slug)->first();
        return view('frontend.buyer.work_order.product.my_work_order_details',compact('workOrderProduct'));
    }
    public function myWOBidderList($id){
        $workOrderProduct = WorkOrderProduct::find(decrypt($id));
        $wo_bids = WorkOrderBid::where('work_order_product_id',$workOrderProduct->id)->where('receiver_user_id',Auth::id())->get();
        return view('frontend.buyer.work_order.product.my_work_order_bidder_list',compact('workOrderProduct','wo_bids'));
    }
    public function myWOBidderDetails($id){
        $wo_bid = WorkOrderBid::find(decrypt($id));
        return view('frontend.buyer.work_order.product.my_work_order_bidder_details',compact('wo_bid'));
    }
    public function myWOBidAccept($id){

        $get_invoice_code = WorkOrderSaleRecord::orderBy('created_at','DESC')->first();
        if(!empty($get_invoice_code)){
            $invoice_no = "FLL-WO".date('Y')."-".str_pad($get_invoice_code->id + 1, 8, "0", STR_PAD_LEFT);;
        }else{
            $invoice_no = "FLL-WO".date('Y')."-"."00000001";
        }

        $wo_bid = WorkOrderBid::find($id);
        $wo_bid->bid_status = 1;

        $seller = Seller::where('user_id',$wo_bid->sender_user_id)->first();
        $commission = ($wo_bid->bid_price * sellerCurrentCommission($wo_bid->sender_user_id))/100;
        $vat = vat($commission);
        $admin_commission = $commission + $vat;
//        $seller->pay_to_admin += $admin_commission;
//        $seller->save();
        $wo_bid->save();

        $woSaleRecord = new WorkOrderSaleRecord();
        $woSaleRecord->buyer_user_id = Auth::id();
        $woSaleRecord->seller_user_id = $seller->user_id;
        $woSaleRecord->type = 'buyer_work_order';

        $woSaleRecord->work_order_product_id = $wo_bid->work_order_product_id;
        $woSaleRecord->work_order_bid_id  = $wo_bid->id;
        $woSaleRecord->amount = $wo_bid->total_price;
        $woSaleRecord->commission = $commission;
        $woSaleRecord->vat = $vat;
        $woSaleRecord->admin_commission = $admin_commission;
        $woSaleRecord->payment_status = 'Pending';
        $woSaleRecord->invoice_code = $invoice_no;
        $woSaleRecord->save();

        $user = User::find($seller->user_id);
        $title = 'Accepted Work Order Bid';
        $message = 'Dear, '. $user->name .' your work order bid for '.$wo_bid->workOrderProduct->name.' has been accepted ';
        createWONotification($seller->user_id,$title,$message);
        //UserInfo::smsAPI("0".$user->phone,$message);
//        if($user->country_code == '+880') {
//            UserInfo::smsAPI($user->country_code . $seller->phone, $message);
//            SmsNotification($user->id,$title,$message);
//        }

        Toastr::success('Work Order Bidder Accepted Successfully');
        return redirect()->back();
    }
    public function myWOAcceptedBidList(){
        $wo_bids = WorkOrderBid::where('receiver_user_id',Auth::id())->where('bid_status',1)->latest()->get();
        return view('frontend.buyer.work_order.product.my_work_order_accepted_bid_list',compact('wo_bids'));
    }
    public function myWORecordedTransaction(){
        $wo_sale_records = WorkOrderSaleRecord::where('buyer_user_id',Auth::id())->where('type','buyer_work_order')->latest()->get();
        return view('frontend.buyer.work_order.product.wo_recorded_transaction',compact('wo_sale_records'));
    }
    public function myWOReviewSubmit(Request $request){
        $wo_quotation = WorkOrderQuotationRequest::find($request->work_order_quotation_request_id);
        $review_check = WorkOrderReview::where('sender_user_id',Auth::id())->where('work_order_product_id',$wo_quotation->work_order_product_id)->first();
        if (empty($review_check)){
            $workOrderReview = new WorkOrderReview();
            $workOrderReview->sender_user_id = Auth::id();
            $workOrderReview->receiver_user_id = $wo_quotation->seller_user_id;
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
                    Toastr::error('Something went wrong, work order product review update!');
                    return redirect()->back();
                }
            }
            Toastr::success('Successfully review submitted.');
            return redirect()->back();
        }else{
            Toastr::error('You have already reviewed this seller');
            return redirect()->back();
        }
    }
}
