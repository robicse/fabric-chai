<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IndustryCategoryCollection;
use App\Http\Resources\IndustryEmployeeTypeCollection;
use App\Http\Resources\IndustrySubCategoryCollection;
use App\Model\IndustryCategory;
use App\Model\IndustryEmployeeType;
use App\Model\IndustrySubCategory;
use Illuminate\Http\Request;

class IndustryCategoryController extends Controller
{
    public function getIndustryCategories(){
        return new IndustryCategoryCollection(IndustryCategory::all());
    }
    public function getIndustrySubCategories($id){
        return new IndustrySubCategoryCollection(IndustrySubCategory::where('industry_category_id',$id)->orderBy('name','ASC')->get());
    }
    public function getIndustryEmployeeTypes($id){
        return new IndustryEmployeeTypeCollection(IndustryEmployeeType::where('industry_sub_category_id',$id)->orderBy('name','ASC')->get());
    }
}
