<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeListCollection;
use App\Model\Employee;
use App\Model\Employer;
use App\Model\Message;
use App\Model\MessageCharge;
use App\Model\Offer;
use App\Model\Seller;
use App\Model\Shortlist;
use App\Model\WorkorderFactory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkOrderSellerProfileController extends Controller
{

    public function profileDetails(){
        $seller = Seller::where('user_id',Auth::id())->first();
        $workOrderFactory = WorkorderFactory::where('user_id',Auth::id())->first();
        $data['company_name'] = (string) $seller->company_name;
        $data['company_name_bn'] = (string) $seller->company_name_bn;
        $data['company_owner_name'] = $seller->company_owner_name;
        $data['company_phone'] = $seller->company_phone;
        $data['company_email'] = $seller->company_email;
        $data['company_address'] = (string) $seller->company_address;
        $data['company_address_bn'] = (string) $seller->company_address_bn;
        $data['company_no_of_employee'] = $seller->company_no_of_employee;
        $data['membership_package_id'] =(string) getPackageNameByBnEn($seller->user->membershipPackage);
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
        $data['factory_image']= !empty($workOrderFactory) ? $workOrderFactory->factory_image : NULL;
        $data['vat_certificate']= !empty($workOrderFactory) ? $workOrderFactory->vat_certificate : NULL;
        $data['tin_certificate']= !empty($workOrderFactory) ? $workOrderFactory->tin_certificate : NULL;
        $data['environment_certificate']= !empty($workOrderFactory) ? $workOrderFactory->environment_certificate : NULL;
        $data['industrial_certificate']= !empty($workOrderFactory) ? $workOrderFactory->industrial_certificate : NULL;

        if (!empty($data))
        {
            return response()->json(['success'=>true,'response'=> $data], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function profileUpdate(Request $request){
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
            $factory->membership = $request->membership;
            $factory->bank_name_and_address = $request->bank_name_and_address;
            $factory->certificate = $request->certificate;
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
            if (!empty($factory))
            {
                return response()->json(['success'=>true,'response'=> 'Profile Updated Successfully'], 200);
            }
            else{
                return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
            }
        }else{
            $factoryCheck->mill_representative_name_1 = $request->mill_representative_name_1;
            $factoryCheck->mill_representative_name_2 = $request->mill_representative_name_2;
            $factoryCheck->mill_representative_phone_1 = $request->mill_representative_phone_1;
            $factoryCheck->mill_representative_phone_2 = $request->mill_representative_phone_2;
            $factoryCheck->ownership_of_the_factory = $request->ownership_of_the_factory;
            $factoryCheck->mill_production_strength = $request->mill_production_strength;
            $factoryCheck->membership = $request->membership;
            $factoryCheck->bank_name_and_address = $request->bank_name_and_address;
            $factoryCheck->certificate = $request->certificate;
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
            if (!empty($update))
            {
                return response()->json(['success'=>true,'response'=> 'Profile Updated Successfully'], 200);
            }
            else{
                return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
            }
        }


    }
}
