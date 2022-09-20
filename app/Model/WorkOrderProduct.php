<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WorkOrderProduct extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function category()
    {
        return $this->belongsTo('App\Model\Category', 'category_id');
    }

    public function subcategory(){
        return $this->belongsTo('App\Model\SubCategory', 'sub_category_id');
    }
    public function subsubcategory(){
        return $this->belongsTo('App\Model\SubSubCategory', 'sub_sub_category_id');
    }
    public function subsubchildcategory(){
        return $this->belongsTo('App\Model\SubSubChildCategory', 'sub_sub_child_category_id');
    }
    public function subsubchildchildcategory()
    {
        return $this->belongsTo('App\Model\SubSubChildChildCategory', 'sub_sub_child_child_category_id');
    }
    public function categorySix()
    {
        return $this->belongsTo('App\Model\CategorySix', 'category_six_id');
    }
    public function categorySeven()
    {
        return $this->belongsTo('App\Model\CategorySeven', 'category_seven_id');
    }
    public function categoryEight()
    {
        return $this->belongsTo('App\Model\CategoryEight', 'category_eight_id');
    }
    public function categoryNine()
    {
        return $this->belongsTo('App\Model\CategoryNine', 'category_nine_id');
    }
    public function categoryTen()
    {
        return $this->belongsTo('App\Model\CategoryTen', 'category_ten_id');
    }

    public function unit()
    {
        return $this->belongsTo('App\Model\Unit', 'unit_id');
    }
    public function currency()
    {
        return $this->belongsTo('App\Model\Currency', 'currency_id');
    }
    public function workOrderDetails()
    {
        return $this->hasMany('App\Model\WorkOrderProductDetails', 'work_order_product_id');
    }
    public function workOrderCategory()
    {
        return $this->hasOne('App\Model\WorkOrderCategory', 'work_order_product_id');
    }
}
