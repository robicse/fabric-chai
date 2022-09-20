<?php

namespace App\Http\Controllers\Seller\WorkOrder;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Currency;
use App\Model\Seller;
use App\Model\Unit;
use App\Model\WorkOrderCategory;
use App\Model\WorkOrderProduct;
use App\Model\WorkOrderProductDetails;
use App\Model\WorkOrderQuotationRequest;
use App\Model\WorkOrderReview;
use App\Model\WorkOrderSaleRecord;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use NumberFormatter;

class WorkOrderController extends Controller
{
    public function index(){
        $workOrderProducts = WorkOrderProduct::where('published',1)->where('user_type', 'buyer')->latest()->get();
        return view('frontend.seller.work_order.product.all_work_order',compact('workOrderProducts'));
    }
    public function createWOProduct(){
        $categories = Category::all();
        $units = Unit::all();
        $currencies = Currency::where('status',1)->get();
        return view('frontend.seller.work_order.product.create',compact('categories','units','currencies'));
    }
    public function editWOProduct($id){
        $workOrderProduct = WorkOrderProduct::find(decrypt($id));
        $categories = Category::all();
        $units = Unit::all();
        $currencies = Currency::where('status',1)->get();
        return view('frontend.seller.work_order.product.edit',compact('workOrderProduct','categories','units','currencies'));
    }
    public function WOProductList(){
        $workOrderProducts = WorkOrderProduct::where('user_id',Auth::id())->where('user_type', 'seller')->latest()->get();
        return view('frontend.seller.work_order.product.index',compact('workOrderProducts'));
    }
    public function storeWOProduct(Request $request){
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

        $membership_package_id = checkMembershipStatus(Auth::id());
        $user_type = checkUserType(Auth::id());
        if($user_type == 'seller' && $membership_package_id != 3){
            return response()->json(['success'=>false,'response'=> 'Upgrade your membership package!'], 401);
        }
        $row_count = count($request->machine_type_id);
        $workOrderProduct = new WorkOrderProduct();
        $workOrderProduct->wish_to_work = $request->wish_to_work;
        $workOrderProduct->types_of_industry = $request->types_of_industry;
        $workOrderProduct->user_id = Auth::id();
        $workOrderProduct->user_type = 'seller';

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

        if(currency()->code == 'BDT'){
            $unit_price = $request->unit_price;
        }else{
            $unit_price = convert_to_bdt($request->unit_price);
        }
        $workOrderProduct->quantity = $request->quantity;
        $workOrderProduct->unit_id = $request->unit_id;
        $workOrderProduct->unit_price = $unit_price;
        $workOrderProduct->currency_id = 27;
        $workOrderProduct->description = $request->description;
        $workOrderProduct->published = 1;
        $workOrderProduct->featured = 0;
        $workOrderProduct->verification_status = 1;
        $workOrderProduct->bid_status = 'Applied';
        $workOrderProduct->slug = Str::slug($request->wish_to_work).'-'.Str::random(5);
        $workOrderProduct->save();
        for($i=0; $i<$row_count;$i++){
            $details = new WorkOrderProductDetails();
            $details->work_order_product_id = $workOrderProduct->id;
            $details->machine_type_id = $request->machine_type_id[$i];
            $details->no_of_machines = $request->no_of_machines[$i];
            $details->pc_per_day = $request->pc_per_day[$i];
            $details->total_pc_per_day = $request->total_pc_per_day[$i];
            $details->moq = $request->moq[$i];
            $details->max_oq = $request->max_oq[$i];
            $details->production_time = $request->production_time[$i];
            $details->finishing_time = $request->finishing_time[$i];
            $details->delivery_time = $request->delivery_time[$i];
            $details->save();

        }
        $insert_id = $workOrderProduct->id;
        if ($insert_id){
            $woCategories = new WorkOrderCategory();
            $woCategories->work_order_product_id = $workOrderProduct->id;
            $woCategories->category_id = $request->category_id;
            $woCategories->sub_category_id = $sub_category_id;
            $woCategories->sub_sub_category_id = $sub_sub_category_id;
            $woCategories->sub_sub_child_category_id = $sub_sub_child_category_id;
            $woCategories->sub_sub_child_child_category_id = $sub_sub_child_child_category_id;
            $woCategories->category_six_id = $category_six_id;
            $woCategories->category_seven_id = $category_seven_id;
            $woCategories->category_eight_id = $category_eight_id;
            $woCategories->category_nine_id = $category_nine_id;
            $woCategories->category_ten_id = $category_ten_id;
            $woCategories->save();

        }
        if($insert_id){
            $user = User::where('id',Auth::id())->first();
            $title = 'Seller Work Order Product Create';
            $message = $user->name .' Added A New Product '.$workOrderProduct->name.' .';
            createWONotificationWithProductId(9,$title,$message,$insert_id);
        }
        Toastr::success("Product Inserted Successfully. Now Waiting For Approval","Success");
        return redirect()->route('seller.my-work-order-product.list');
    }
    public function updateWOProduct(Request $request,$id){

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

        $row_count = count($request->machine_type_id);
        $workOrderProduct = WorkOrderProduct::find($id);
        $workOrderProduct->wish_to_work = $request->wish_to_work;
        $workOrderProduct->types_of_industry = $request->types_of_industry;

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

        if(currency()->code == 'BDT'){
            $unit_price = $request->unit_price;
        }else{
            $unit_price = convert_to_bdt($request->unit_price);
        }
        $workOrderProduct->quantity = $request->quantity;
        $workOrderProduct->unit_id = $request->unit_id;
        $workOrderProduct->unit_price = $unit_price;
        $workOrderProduct->currency_id = 27;
        $workOrderProduct->description = $request->description;
        $workOrderProduct->published = 1;
        $workOrderProduct->featured = 0;
        $workOrderProduct->verification_status = 1;
        $workOrderProduct->bid_status = 'Applied';
        $workOrderProduct->slug =  Str::slug($request->wish_to_work).'-'.Str::random(5);
        $workOrderProduct->save();
        for($i=0; $i<$row_count;$i++){

            $details = WorkOrderProductDetails::find($request->detail_id[$i]);
            $details->work_order_product_id = $workOrderProduct->id;
            $details->machine_type_id = $request->machine_type_id[$i];
            $details->no_of_machines = $request->no_of_machines[$i];
            $details->pc_per_day = $request->pc_per_day[$i];
            $details->total_pc_per_day = $request->total_pc_per_day[$i];
            $details->moq = $request->moq[$i];
            $details->max_oq = $request->max_oq[$i];
            $details->production_time = $request->production_time[$i];
            $details->finishing_time = $request->finishing_time[$i];
            $details->delivery_time = $request->delivery_time[$i];
            $details->save();

        }
        $insert_id = $workOrderProduct->id;
        if ($insert_id){
            if ($workOrderProduct->workOrderCategory){
                $woCategories = WorkOrderCategory::where('work_order_product_id',$workOrderProduct->id)->first();
            }else{
                $woCategories =new WorkOrderCategory();
                $woCategories->work_order_product_id = $workOrderProduct->id;
            }

            $woCategories->category_id = $request->category_id;
            $woCategories->sub_category_id = $sub_category_id;
            $woCategories->sub_sub_category_id = $sub_sub_category_id;
            $woCategories->sub_sub_child_category_id = $sub_sub_child_category_id;
            $woCategories->sub_sub_child_child_category_id = $sub_sub_child_child_category_id;
            $woCategories->category_six_id = $category_six_id;
            $woCategories->category_seven_id = $category_seven_id;
            $woCategories->category_eight_id = $category_eight_id;
            $woCategories->category_nine_id = $category_nine_id;
            $woCategories->category_ten_id = $category_ten_id;
            $woCategories->save();
        }
        if($insert_id){
            $user = User::where('id',Auth::id())->first();
            $title = 'Seller Work Order Product Edit';
            $message = $user->name .' Updated product '.$workOrderProduct->name.' .';
            createWONotificationWithProductId(9,$title,$message,$insert_id);
        }
        Toastr::success("Product Updated Successfully.","Success");
        return redirect()->route('seller.my-work-order-product.list');
    }
    public function WOProductDetails($slug){
        $workOrderProduct = WorkOrderProduct::where('slug',$slug)->first();
        return view('frontend.seller.work_order.product.wo_product_details',compact('workOrderProduct'));
    }
    public function WOBuyerDetails($id){
        $workOrder = WorkOrderProduct::find(decrypt($id));
        return view('frontend.seller.work_order.product.wo_buyer_details',compact('workOrder'));
    }
    public function workOrderRecordedTransaction(){
        $wo_sale_records = WorkOrderSaleRecord::where('seller_user_id',Auth::id())->where('type','buyer_work_order')->latest()->get();
        return view('frontend.seller.work_order.product.wo_recorded_transaction',compact('wo_sale_records'));
    }

    public function getWorkOrderProductReview($id){
        $wo_product = WorkOrderProduct::find($id);
        $reviews = WorkOrderReview::where('work_order_product_id',$id)->where('status',1)->latest()->get();
        return view('frontend.seller.work_order.review.product_review',compact('reviews','wo_product'));
    }

    public function myWODetails($slug){
        $workOrderProduct = WorkOrderProduct::where('slug',$slug)->first();
        return view('frontend.seller.work_order.product.my_work_order_details',compact('workOrderProduct'));
    }
    public function myWOQuotationList($id){
        $workOrderProduct = WorkOrderProduct::find(decrypt($id));
        $wo_qoutations = WorkOrderQuotationRequest::where('work_order_product_id',$workOrderProduct->id)->where('seller_user_id',Auth::id())->get();
        return view('frontend.seller.work_order.product.my_work_order_quotation_list',compact('workOrderProduct','wo_qoutations'));
    }
    public function myWOQuotationDetails($id){
        $wo_qoutation = WorkOrderQuotationRequest::find(decrypt($id));
        return view('frontend.seller.work_order.product.my_work_order_quotation_details',compact('wo_qoutation'));
    }
    public function myWOQuotationAccept($id){
        $get_invoice_code = WorkOrderSaleRecord::orderBy('created_at','DESC')->first();
        if(!empty($get_invoice_code)){
            $invoice_no = "FLL-WO".date('Y')."-".str_pad($get_invoice_code->id + 1, 8, "0", STR_PAD_LEFT);;
        }else{
            $invoice_no = "FLL-WO".date('Y')."-"."00000001";
        }

        $wo_qoutation = WorkOrderQuotationRequest::find($id);
        $wo_qoutation->status = 1;

        $seller = Seller::where('user_id',Auth::id())->first();
        $commission = ($wo_qoutation->total_price * sellerCurrentCommission(Auth::id()))/100;
        $vat = vat($commission);
        $admin_commission = $commission + $vat;
//        $seller->pay_to_admin += $admin_commission;
//        $seller->save();
        $wo_qoutation->save();

        $woSaleRecord = new WorkOrderSaleRecord();
        $woSaleRecord->buyer_user_id = $wo_qoutation->buyer_user_id;
        $woSaleRecord->seller_user_id = Auth::id();
        $woSaleRecord->type = 'seller_work_order';

        $woSaleRecord->work_order_product_id = $wo_qoutation->work_order_product_id;
        $woSaleRecord->work_order_quotation_request_id  = $wo_qoutation->id;
        $woSaleRecord->amount = $wo_qoutation->total_price;
        $woSaleRecord->commission = $commission;
        $woSaleRecord->vat = $vat;
        $woSaleRecord->admin_commission = $admin_commission;
        $woSaleRecord->payment_status = 'Pending';
        $woSaleRecord->invoice_code = $invoice_no;
        $woSaleRecord->save();

        $user = User::find($wo_qoutation->buyer_user_id);
        $title = 'Accepted Work Order Quotation Request';
        $message = 'Dear, '. $user->name .' your work order quotation request for '.$wo_qoutation->workOrderProduct->wish_to_work.' has been accepted ';
        createWONotification($user->id,$title,$message);
        //UserInfo::smsAPI("0".$user->phone,$message);
//        if($user->country_code == '+880') {
//            UserInfo::smsAPI($user->country_code . $seller->phone, $message);
//            SmsNotification($user->id,$title,$message);
//        }

        Toastr::success('Work Order Request Accepted Successfully');
        return redirect()->back();
    }
    public function myWOReviewSubmit(Request $request){
        $wo_quotation = WorkOrderQuotationRequest::find($request->work_order_quotation_request_id);
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
                    Toastr::error('Something went wrong, work order product review update!');
                    return redirect()->back();
                }
            }
            Toastr::success('Successfully review submitted.');
            return redirect()->back();
        }else{
            Toastr::error('You have already reviewed this buyer');
            return redirect()->back();
        }
    }
    public function myWOAcceptedQuotationList(){
        $wo_quotations = WorkOrderQuotationRequest::where('seller_user_id',Auth::id())->where('status',1)->latest()->get();
        return view('frontend.seller.work_order.product.my_work_order_accepted_quotation_list',compact('wo_quotations'));
    }
    public function myWORecordedTransaction(){
        $wo_sale_records = WorkOrderSaleRecord::where('seller_user_id',Auth::id())->where('type','seller_work_order')->latest()->get();
        return view('frontend.seller.work_order.product.my_work_order_recorded_transaction',compact('wo_sale_records'));
    }
    public function woTransactionPrint($id){
        $wo_sale_record = WorkOrderSaleRecord::find(decrypt($id));
        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return view('frontend.buyer.work_order.quotation_request.wo_print',compact('wo_sale_record','digit'));
    }
}
