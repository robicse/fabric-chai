<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CategorySix extends Model
{
    public function categoryFive(){
        return $this->belongsTo(SubSubChildChildCategory::class,'sub_sub_child_child_cat_id');
    }
    public function categorysevens(){
        return $this->hasMany(CategorySeven::class, 'category_six_id' );
    }
}
