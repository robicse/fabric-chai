<?php

namespace App\Http\Controllers\Seller\WorkOrder;

use App\Http\Controllers\Controller;
use App\Model\Countries;
use App\Model\Employer;
use App\Model\Product;
use App\Model\Seller;
use App\Model\WorkorderFactory;
use App\Model\WorkOrderProduct;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $membership_package_id = checkMembershipStatus(Auth::id());
        $check_profile_complete_status = checkProfileCompleteStatus(Auth::id());
        $user_type = checkUserType(Auth::id());
        $seller = Seller::where('user_id',Auth::id())->first();

        $factoryCheck = WorkorderFactory::where('user_id',Auth::id())->first();
        if (empty($factoryCheck)){
            $factory = new WorkorderFactory();
            $factory->user_id = Auth::id();
            $factory->seller_id = $seller->id;
            $factory->save();
        }

        if($user_type == 'seller' && $membership_package_id != 3){
            Toastr::warning('Upgrade your membership package!');
            return redirect()->route('seller.memberships-package-list');
        }
        if($user_type == 'seller' && $check_profile_complete_status == 0){
            Toastr::warning('Please complete your profile info!');
            return redirect()->route('seller.work-order-profile');
        }

//        $employerCheck = Employer::where('user_id',Auth::id())->first();
//        if (empty($employerCheck)){
//            $employer = new Employer();
//            $employer->user_id = Auth::id();
//            $employer->seller_id = $seller->id;
//            $employer->save();
//        }
        $products = Product::where('user_id',Auth::id())
            ->where('user_type','seller')
            ->where('published',1)
            ->where('verification_status',1)
            ->where('bid_status','Applied')
            ->latest()->take(9)->get();

        $recent_work_orders = WorkOrderProduct::where('user_id',Auth::id())
            ->where('user_type','seller')
            ->where('published',1)
            ->where('verification_status',1)
            ->where('bid_status','Applied')
            ->latest()->take(6)->get();
        return view('frontend.seller.work_order.dashboard',compact('products','recent_work_orders'));
    }
    public function allProducts(){
        $all_work_order_products = WorkOrderProduct::where('user_id',Auth::id())
            ->where('user_type','seller')
            ->where('published',1)
            ->where('verification_status',1)
            ->where('bid_status','Applied')
            ->latest()->get();
        return view('frontend.seller.work_order.wo_all_products',compact('all_work_order_products'));
    }
    public function woProfile(){
        $countries = Countries::all();
        return view('frontend.seller.work_order.wo_profile',compact('countries'));
    }
    public function woProfileUpdate(Request $request){
        //dd($request->all());
        $user = User::find(Auth::id());
        $seller = Seller::where('user_id',Auth::id())->first();
        $seller->company_name = $request->company_name;
        $seller->company_name_bn = $request->company_name_bn;
        $seller->company_phone = $request->company_phone;
        $seller->company_email = $request->company_email;
        $seller->company_address = $request->company_address;
        $seller->company_address_bn = $request->company_address_bn;
        $seller->company_owner_name = $request->company_owner_name;
        $seller->company_no_of_employee = $request->company_no_of_employee;


        $factoryCheck = WorkorderFactory::where('user_id',Auth::id())->first();
        if (empty($factoryCheck)) {
            $factory = new WorkorderFactory();
            $factory->user_id = Auth::id();
            $factory->seller_id = $seller->id;
            $factory->mill_representative_name_1 = $request->mill_representative_name_1;
            $factory->mill_representative_name_2 = $request->mill_representative_name_2;
            $factory->mill_representative_phone_1 = $request->mill_representative_phone_1;
            $factory->mill_representative_phone_2 = $request->mill_representative_phone_2;
            $factory->ownership_of_the_factory = $request->ownership_of_the_factory;
            $factory->mill_production_strength = $request->mill_production_strength;
            $factory->membership = implode(',', $request->membership);
            $factory->bank_name_and_address = $request->bank_name_and_address;
            $factory->certificate = implode(',', $request->certificate);
            $factory->source_of_gas_and_electricity = $request->source_of_gas_and_electricity;
            $factory->total_no_of_worker = $request->total_no_of_worker;
            $factory->location_of_the_mill = $request->location_of_the_mill;
            $factory->trade_license_authority = $request->trade_license_authority;
            $factory->country_of_origin = $request->country_of_origin;

            if($request->hasFile('factory_image')){
                $factory->factory_image = $request->factory_image->store('uploads/seller_info/factory_image');
            }
            if($request->hasFile('vat_certificate')){
                $factory->vat_certificate = $request->vat_certificate->store('uploads/seller_info/vat_certificate');
            }
            if($request->hasFile('tin_certificate')){
                $factory->tin_certificate = $request->tin_certificate->store('uploads/seller_info/tin_certificate');
            }
            if($request->hasFile('environment_certificate')){
                $factory->environment_certificate = $request->environment_certificate->store('uploads/seller_info/environment_certificate');
            }
            if($request->hasFile('industrial_certificate')){
                $factory->industrial_certificate = $request->industrial_certificate->store('uploads/seller_info/industrial_certificate');
            }
            $factory->save();
            //profile complete status
            if($factory->id){
//                $seller = Seller::where('user_id',Auth::id())->first();
                $seller->profile_complete_status=1;
                $seller->save();
            }
        }else{
            $factoryCheck->mill_representative_name_1 = $request->mill_representative_name_1;
            $factoryCheck->mill_representative_name_2 = $request->mill_representative_name_2;
            $factoryCheck->mill_representative_phone_1 = $request->mill_representative_phone_1;
            $factoryCheck->mill_representative_phone_2 = $request->mill_representative_phone_2;
            $factoryCheck->ownership_of_the_factory = $request->ownership_of_the_factory;
            $factoryCheck->mill_production_strength = $request->mill_production_strength;
            $factoryCheck->membership = implode(',', $request->membership);
            $factoryCheck->bank_name_and_address = $request->bank_name_and_address;
            $factoryCheck->certificate = implode(',', $request->certificate);
            $factoryCheck->source_of_gas_and_electricity = $request->source_of_gas_and_electricity;
            $factoryCheck->total_no_of_worker = $request->total_no_of_worker;
            $factoryCheck->location_of_the_mill = $request->location_of_the_mill;
            $factoryCheck->trade_license_authority = $request->trade_license_authority;
            $factoryCheck->country_of_origin = $request->country_of_origin;

            if($request->hasFile('factory_image')){
                $factoryCheck->factory_image = $request->factory_image->store('uploads/seller_info/factory_image');
            }
            if($request->hasFile('vat_certificate')){
                $factoryCheck->vat_certificate = $request->vat_certificate->store('uploads/seller_info/vat_certificate');
            }
            if($request->hasFile('tin_certificate')){
                $factoryCheck->tin_certificate = $request->tin_certificate->store('uploads/seller_info/tin_certificate');
            }
            if($request->hasFile('environment_certificate')){
                $factoryCheck->environment_certificate = $request->environment_certificate->store('uploads/seller_info/environment_certificate');
            }
            if($request->hasFile('industrial_certificate')){
                $factoryCheck->industrial_certificate = $request->industrial_certificate->store('uploads/seller_info/industrial_certificate');
            }

            $update=$factoryCheck->save();

            //profile complete status
            if($update){
//                $seller = Seller::where('user_id',Auth::id())->first();
                $seller->profile_complete_status=1;
                $seller->save();
            }
        }
        Toastr::success('Company and Factory Updated Successfully');
        return redirect()->route('seller.work-order.dashboard');
    }
}
