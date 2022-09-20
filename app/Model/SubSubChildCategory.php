<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SubSubChildCategory extends Model
{
    protected $guarded = [];

    public function subsubcategory(){
        return $this->belongsTo(SubSubCategory::class,'sub_sub_category_id');
    }

    public function subsubchildchildcategories(){
        return $this->hasMany(SubSubChildChildCategory::class, 'sub_sub_child_cat_id' );
    }

//    public function products(){
//        return $this->hasMany(Product::class, 'sub_sub_child_cat_id');
//    }
}
