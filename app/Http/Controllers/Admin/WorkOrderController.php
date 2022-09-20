<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UserInfo;
use App\Http\Controllers\Controller;
use App\Model\WorkOrderCategory;
use App\Model\WorkOrderProduct;
use App\Model\WorkOrderProductDetails;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WorkOrderController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:seller-work-order-list|seller-work-order-verification-status|permission:seller-work-order-featured-status', ['only' => ['sellerWorkOrderList']]);
        $this->middleware('permission:seller-work-order-verification-status', ['only' => ['verificationStatusUpdate']]);
        $this->middleware('permission:seller-work-order-featured-status', ['only' => ['featuredStatusUpdate']]);
        $this->middleware('permission:seller-work-order-edit', ['only' => ['sellerWorkOrderEdit']]);

    }
    public function sellerWorkOrderList(){
        $workOrderProducts = WorkOrderProduct::where('user_type','seller')->latest()->get();
        return view('backend.admin.work_order.seller_work_orders',compact('workOrderProducts'));
    }
    public function sellerWorkOrderEdit($id){
        $workOrderProduct = WorkOrderProduct::find($id);
        return view('backend.admin.work_order.seller_work_order_edit',compact('workOrderProduct'));
    }
    public function sellerWorkOrderUpdate(Request $request,$id){
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
//        if($insert_id){
//            $user = User::where('id',Auth::id())->first();
//            $title = 'Seller Work Order Product Edit';
//            $message = $user->name .' Updated product '.$workOrderProduct->name.' .';
//            createWONotificationWithProductId(9,$title,$message,$insert_id);
//        }
        Toastr::success("Work Order Updated Successfully.","Success");
        return redirect()->route('admin.seller-work-order.list');
    }
    public function buyerWorkOrderList(){
        $workOrderProducts = WorkOrderProduct::where('user_type','buyer')->latest()->get();
        return view('backend.admin.work_order.buyer_work_orders',compact('workOrderProducts'));
    }
    public function verificationStatusUpdate(Request $request){
        $workOrderProduct = WorkOrderProduct::findOrFail($request->id);
        $workOrderProduct->verification_status = $request->verification_status;
        if($workOrderProduct->save()){
            if ($workOrderProduct->verification_status == 1){
                $user = User::where('id',$workOrderProduct->user_id)->first();
                // current user notification
                $title = 'Approved Work Order';
                $message = 'Dear '. $user->name .' Your Work Order "'.$workOrderProduct->name.'" has been Approved by fabriclagbe.com';
                createNotification($workOrderProduct->user_id,$title,$message);
                if($user->country_code == '+880') {
//                    UserInfo::smsAPI($user->country_code.$user->phone, $message);
                    SmsNotification($user->id,$title,$message);
                }
            }

            return 1;
        }
        return 0;
    }
    public function featuredStatusUpdate(Request $request){
        $workOrderProduct = WorkOrderProduct::findOrFail($request->id);
        $workOrderProduct->featured_product = $request->featured_status;
        if($workOrderProduct->save()){
            return 1;
        }
        return 0;
    }
    public function sellerWOIndividual($seller_id, $wo_id){
        $workOrderProducts = WorkOrderProduct::where('user_type','seller')->where('user_id',$seller_id)->where('id',$wo_id)->latest()->get();
        return view('backend.admin.work_order.seller_work_orders',compact('workOrderProducts'));
    }
    public function buyerWOIndividual($buyer_id, $wo_id){
        $workOrderProducts = WorkOrderProduct::where('user_type','buyer')->where('user_id',$buyer_id)->where('id',$wo_id)->latest()->get();
        return view('backend.admin.work_order.buyer_work_orders',compact('workOrderProducts'));
    }

    public function unApproveSellerWorkOrderList(){
        $workOrderProducts = WorkOrderProduct::where('user_type','seller')->whereverification_status(0)->latest()->get();
        return view('backend.admin.work_order.un_approve_seller_work_orders',compact('workOrderProducts'));
    }
}
