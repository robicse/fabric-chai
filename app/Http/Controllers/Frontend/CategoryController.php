<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\CategoryEight;
use App\Model\CategoryNine;
use App\Model\CategorySeven;
use App\Model\CategorySix;
use App\Model\CategoryTen;
use App\Model\DyingSubcategory;
use App\Model\SubCategory;
use App\Model\SubSubCategory;
use App\Model\SubSubChildCategory;
use App\Model\SubSubChildChildCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function ajaxSubCat (Request $request)
    {
        $subcategories = SubCategory::where('category_id', $request->category_id)->get();
        return $subcategories;
    }
    public function ajaxSubSubCat(Request $request)
    {
        $subsubcategories = SubSubCategory::where('sub_category_id', $request->sub_category_id)->get();
        return $subsubcategories;
    }
    public function ajaxSubSubChildCat(Request $request)
    {
        $subsubchildcategories = SubSubChildCategory::where('sub_sub_category_id', $request->sub_sub_category_id)->get();
        return $subsubchildcategories;
    }
    public function ajaxSubSubChldChildCat(Request $request)
    {
        $subsubchildchildcategories = SubSubChildChildCategory::where('sub_sub_child_cat_id', $request->sub_sub_child_category_id)->get();
        return $subsubchildchildcategories;
    }
    public function ajaxCategorySix(Request $request){
        $categorySixes = CategorySix::where('sub_sub_child_child_cat_id',$request->sub_sub_child_child_category_id)->get();
        return $categorySixes;

    }
    public function ajaxCategorySeven(Request $request){
        $categorySevens = CategorySeven::where('category_six_id',$request->category_six_id)->get();
        return $categorySevens;

    }
    public function ajaxCategoryEight(Request $request){
        $categoryEights = CategoryEight::where('category_seven_id',$request->category_seven_id)->get();
        return $categoryEights;
    }
    public function ajaxCategoryNine(Request $request){
        $categoryNines = CategoryNine::where('category_eight_id',$request->category_eight_id)->get();
        return $categoryNines;
    }
    public function ajaxCategoryTen(Request $request){
        $categoryTens = CategoryTen::where('category_nine_id',$request->category_nine_id)->get();
        return $categoryTens;
    }
    public function getDyingSubcategories(Request $request){
        $dyingSubcategories = DyingSubcategory::where('dying_category_id',$request->dying_category_id)->get();
        return $dyingSubcategories;
    }
}
