<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\BuyerWorkOrderCollection;
use App\Http\Resources\WorkOrderCompanyCollection;
use App\Http\Resources\WorkOrderDetailsCollection;
use App\Http\Resources\WorkOrderProductCollection;
use App\Model\Seller;
use App\Model\WorkOrderBid;
use App\Model\WorkOrderCategory;
use App\Model\WorkorderFactory;
use App\Model\WorkOrderProduct;
use App\Model\WorkOrderProductDetails;
use App\Model\WorkOrderReview;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WorkOrderController extends Controller
{

    public function sellerWorkOrderProductList(){
        $workOrderProducts = WorkOrderProduct::where('user_id',Auth::id())->where('user_type', 'seller')->latest()->get();
        return new WorkOrderProductCollection($workOrderProducts);
    }
    public function sellerWorkOrderProductDetails($id){
        $workOrderProduct =WorkOrderProduct::where('id',$id)->get();
        return new WorkOrderDetailsCollection($workOrderProduct);
    }

    public function buyerRequestedAllWorkOrderList(){
        $workOrderProducts = WorkOrderProduct::where('published',1)->where('user_type', 'buyer')->latest()->get();
        return new WorkOrderProductCollection($workOrderProducts);
    }

    public function sellerWorkOrderProductStore(Request $request){
        $user = User::find(Auth::id());
        if($user->user_type == 'seller' && $user->membership_package_id != 3){
            Toastr::warning('Upgrade your membership package!');
            return redirect()->route('seller.work-order.memberships-package-list');
        }
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

        if($request->currency_id == 27){
            $unit_price = $request->unit_price;
        }else{
            $unit_price = convert_to_bdt($request->unit_price);
        }
//        $workOrderProduct->quantity = $request->quantity;
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
        if (!empty($workOrderProduct)){
            $infos = json_decode($request->infos);


            if ($infos) {
                foreach ($infos as $info){
                    $details = new WorkOrderProductDetails();
                    $details->work_order_product_id = $workOrderProduct->id;
                    $details->machine_type_id = $info->machine_type_id;
                    $details->no_of_machines = $info->no_of_machines;
                    $details->pc_per_day = $info->pc_per_day;
                    $details->total_pc_per_day = $info->total_pc_per_day;
                    $details->moq = $info->moq;
                    $details->max_oq = $info->max_oq;
                    $details->production_time = $info->production_time;
                    $details->finishing_time = $info->finishing_time;
                    $details->delivery_time = $info->delivery_time;
                    $details->save();
                }
            }
        }
        $insert_id = $workOrderProduct->id;
        if ($insert_id){
            $woCategories = new WorkOrderCategory();
            $woCategories->work_order_product_id = $workOrderProduct->id;
            $woCategories->category_id = $request->category_id;
            $woCategories->sub_category_id = $request->sub_category_id;
            $woCategories->sub_sub_category_id = $request->sub_sub_category_id;
            $woCategories->sub_sub_child_category_id = $request->sub_sub_child_category_id;
            $woCategories->sub_sub_child_child_category_id = $request->sub_sub_child_child_category_id;
            $woCategories->category_six_id = $request->category_six_id;
            $woCategories->category_seven_id = $request->category_seven_id;
            $woCategories->category_eight_id = $request->category_eight_id;
            $woCategories->category_nine_id = $request->category_nine_id;
            $woCategories->category_ten_id = $request->category_ten_id;
            $woCategories->save();

        }
        if($insert_id){
            $user = User::where('id',Auth::id())->first();
            $title = 'Seller Work Order Product Create';
            $message = $user->name .' Added A New Product '.$workOrderProduct->name.' .';
            createNotificationWithProductId(9,$title,$message,$insert_id);
        }

        if (!empty($workOrderProduct))
        {
            return response()->json(['success'=>true,'response'=> $workOrderProduct], 201);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 401);
        }
    }

    public function sellerWorkOrderProductUpdate(Request $request,$id){

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

        if($request->currency_id == 27){
            $unit_price = $request->unit_price;
        }else{
            $unit_price = convert_to_bdt($request->unit_price);
        }
//        $workOrderProduct->quantity = $request->quantity;
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
        if (!empty($workOrderProduct)){
            $infos = json_decode($request->infos);
            if ($infos) {
                foreach ($infos as $info){
                    $details = WorkOrderProductDetails::find($info->detail_id);
//                    $details->work_order_product_id = $workOrderProduct->id;
                    $details->machine_type_id = $info->machine_type_id;
                    $details->no_of_machines = $info->no_of_machines;
                    $details->pc_per_day = $info->pc_per_day;
                    $details->total_pc_per_day = $info->total_pc_per_day;
                    $details->moq = $info->moq;
                    $details->max_oq = $info->max_oq;
                    $details->production_time = $info->production_time;
                    $details->finishing_time = $info->finishing_time;
                    $details->delivery_time = $info->delivery_time;
                    $details->save();
                }
            }
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
            $woCategories->sub_category_id = $request->sub_category_id;
            $woCategories->sub_sub_category_id = $request->sub_sub_category_id;
            $woCategories->sub_sub_child_category_id = $request->sub_sub_child_category_id;
            $woCategories->sub_sub_child_child_category_id = $request->sub_sub_child_child_category_id;
            $woCategories->category_six_id = $request->category_six_id;
            $woCategories->category_seven_id = $request->category_seven_id;
            $woCategories->category_eight_id = $request->category_eight_id;
            $woCategories->category_nine_id = $request->category_nine_id;
            $woCategories->category_ten_id = $request->category_ten_id;
            $woCategories->save();
        }
        if($insert_id){
            $user = User::where('id',Auth::id())->first();
            $title = 'Seller Work Order Product Edit';
            $message = $user->name .' Updated product '.$workOrderProduct->name.' .';
            createWONotificationWithProductId(9,$title,$message,$insert_id);
        }

        if (!empty($insert_id))
        {
            return response()->json(['success'=>true,'response'=> $workOrderProduct], 201);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 401);
        }
    }

//buyer

    public function buyerWorkOrderProductList(){
        $workOrderProducts = WorkOrderProduct::where('user_type', 'seller')->latest()->get();
        return new BuyerWorkOrderCollection($workOrderProducts);
    }
    public function buyerWorkOrderProductDetails($id){
        $workOrderProduct =WorkOrderProduct::where('id',$id)->get();
        return new WorkOrderDetailsCollection($workOrderProduct);
    }
    public function buyerCompanyList(){
        $featured_companies = WorkOrderProduct::where('user_id','!=',Auth::id())
            ->where('user_type','=','seller')
            ->where('published',1)
            ->where('verification_status',1)
            ->select('user_id')
            ->groupBy('user_id')
            ->take(6)
            ->get();
        return new WorkOrderCompanyCollection($featured_companies);
    }
    public function buyerCompanyDetails($id){
        $seller = Seller::where('user_id',$id)->first();
        $workOrderFactory = WorkorderFactory::where('user_id',$id)->first();
        $data['factory_image'] = $workOrderFactory->factory_image;
        $data['company_name'] =getCompanyNameByBnEn($seller);
        $data['company_owner_name'] = $seller->company_owner_name;
        $data['company_phone'] = $seller->company_phone;
        $data['company_email'] = $seller->company_email;
        $data['company_address'] = $seller->company_address;
        $data['company_no_of_employee'] = $seller->company_no_of_employee;
        $data['membership_package_id'] = $seller->user->membershipPackage->package_name;
        $data['mill_representative_name_1']= !empty($workOrderFactory) ? $workOrderFactory->mill_representative_name_1 : NULL;
        $data['mill_representative_name_2']= !empty($workOrderFactory) ? $workOrderFactory->mill_representative_name_2 : NULL;
        $data['mill_representative_phone_1']= !empty($workOrderFactory) ? $workOrderFactory->mill_representative_phone_1 : NULL;
        $data['mill_representative_phone_2']= !empty($workOrderFactory) ? $workOrderFactory->mill_representative_phone_2 : NULL;
        $data['ownership_of_the_factory']= !empty($workOrderFactory) ? $workOrderFactory->ownership_of_the_factory : NULL;
        $data['mill_production_strength']= !empty($workOrderFactory) ? $workOrderFactory->mill_production_strength : NULL;
        $data['membership']= !empty($workOrderFactory) ? $workOrderFactory->membership : NULL;
        $data['bank_name_and_address']= !empty($workOrderFactory) ? $workOrderFactory->bank_name_and_address : NULL;
        $data['certificate']= !empty($workOrderFactory) ? $workOrderFactory->certificate : NULL;
        $data['source_of_gas_and_electricity']= !empty($workOrderFactory) ? $workOrderFactory->source_of_gas_and_electricity : NULL;
        $data['total_no_of_worker']= !empty($workOrderFactory) ? $workOrderFactory->total_no_of_worker : NULL;
        $data['trade_license_authority']= !empty($workOrderFactory) ? $workOrderFactory->trade_license_authority : NULL;
        $data['location_of_the_mill']= !empty($workOrderFactory) ? $workOrderFactory->location_of_the_mill : NULL;
        $data['country_of_origin']= !empty($workOrderFactory) ? $workOrderFactory->country_of_origin : NULL;
        $data['factory_image']= !empty($workOrderFactory) ? $workOrderFactory->factory_image : $seller->user->avatar_original;


        if (!empty($data))
        {
            return response()->json(['success'=>true,'response'=> $data], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function buyerCompanyProducts($id){
        $workOrderProducts= \App\Model\WorkOrderProduct::where('user_id',$id)->where('user_type','seller')->where('published',1)->where('verification_status',1)->latest()->get();
        return new BuyerWorkOrderCollection($workOrderProducts);
    }

}
