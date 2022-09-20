<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MembershipPackageCollection;
use App\Model\MembershipPackage;
use App\Model\MembershipPackageDetail;
use App\Model\MembershipPackageOtherBenefit;
use Illuminate\Http\Request;

class MembershipPackageController extends Controller
{
    public function packageLists(){
//        return new MembershipPackageCollection(MembershipPackage::all());
        $packages = MembershipPackage::all();
        $nestedData = [];
        foreach ($packages as $package){
            $data['id']=$package->id;
            $data['name']= getPackageNameByBnEn($package);
            $data['price']=(string) getNumberToBangla($package->price);
            array_push($nestedData,$data);
        }

        if (!empty($nestedData)){
            return response()->json(['success'=>true,'response'=> $nestedData], 200);
        }else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function packageDetails(){
        $mp_details = MembershipPackageDetail::all();
        if (!empty($mp_details)){
            return response()->json(['success'=>true,'response'=> $mp_details], 200);
        }else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function packageOtherBenefits(){
        $mp_other_benefits = MembershipPackageOtherBenefit::all();
        if (!empty($mp_other_benefits)){
            return response()->json(['success'=>true,'response'=> $mp_other_benefits], 200);
        }else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
}
