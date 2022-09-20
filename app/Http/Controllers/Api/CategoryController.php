<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllCategoryCollection;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryEightCollection;
use App\Http\Resources\CategoryNineCollection;
use App\Http\Resources\CategorySevenCollection;
use App\Http\Resources\CategorySixCollection;
use App\Http\Resources\CategoryTenCollection;
use App\Http\Resources\HomeCategoryCollection;
use App\Http\Resources\SubCategoryCollection;
use App\Http\Resources\SubSubCategoryCollection;
use App\Http\Resources\SubSubChildCategoryCollection;
use App\Http\Resources\SubSubChildChildCategoryCollection;
use App\Model\Category;
use App\Model\CategoryEight;
use App\Model\CategoryNine;
use App\Model\CategorySeven;
use App\Model\CategorySix;
use App\Model\CategoryTen;
use App\Model\HomeCategory;
use App\Model\SubCategory;
use App\Model\SubSubCategory;
use App\Model\SubSubChildCategory;
use App\Model\SubSubChildChildCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getAllCategories(){
        return new AllCategoryCollection(Category::where('type','product')->get());
    }
    public function getCategories(Request $request){
        if ($request->segment(2) == 'work-order'){
            return new CategoryCollection(Category::where('type','work_order')->get());
        }else{
            return new CategoryCollection(Category::where('type','product')->get());
        }

    }
    public function getHomeCategories(){
            return new HomeCategoryCollection(HomeCategory::all());
    }
    public function getSubCategories($id)
    {
        $category = Category::find($id);
        if ($category->type == 'work_order'){
            return new SubCategoryCollection(SubCategory::where('category_id', $id)->where('type','work_order')->get());
        }else{
            return new SubCategoryCollection(SubCategory::where('category_id', $id)->where('type','product')->get());
        }

    }
    public function getSubSubCategories($id)
    {
        $subCategory = SubCategory::find($id);
        return new SubSubCategoryCollection(SubSubCategory::where('sub_category_id', $id)->get());
    }
    public function getsubSubChildCategories($id)
    {
        $subSubCategory = SubSubCategory::find($id);
        return new SubSubChildCategoryCollection(SubSubChildCategory::where('sub_sub_category_id', $id)->get());
    }
    public function getsubSubChildChildCategories($id)
    {
        $subSubChildCategory = SubSubChildCategory::find($id);
        return new SubSubChildChildCategoryCollection(SubSubChildChildCategory::where('sub_sub_child_cat_id', $id)->get());
    }
    public function getCategorySix($id)
    {
        $subSubChildChildCategory = SubSubChildChildCategory::find($id);
        return new CategorySixCollection(CategorySix::where('sub_sub_child_child_cat_id', $id)->get());
    }
    public function getCategorySeven($id)
    {
        $categorySix= CategorySix::find($id);
        return new CategorySevenCollection(CategorySeven::where('category_six_id', $id)->get());
    }
    public function getCategoryEight($id)
    {
        $categorySeven= CategorySeven::find($id);
        return new CategoryEightCollection(CategoryEight::where('category_seven_id', $id)->get());
    }
    public function getCategoryNine($id)
    {
        $categoryEight = CategoryEight::find($id);
        return new CategoryNineCollection(CategoryNine::where('category_eight_id', $id)->get());
    }
    public function getCategoryTen($id)
    {
        $categoryNine = CategoryNine::find($id);
        return new CategoryTenCollection(CategoryTen::where('category_nine_id', $id)->get());
    }
}
