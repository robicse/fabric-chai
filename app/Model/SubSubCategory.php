<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SubSubCategory extends Model
{
    protected $guarded = [];

    public function subcategory(){
        return $this->belongsTo('App\Model\SubCategory', 'sub_category_id');
    }

    public function subsubchildcategories(){
        return $this->hasMany(SubSubChildCategory::class, 'sub_sub_category_id' );
    }

    public function products(){
        return $this->hasMany(Product::class, 'sub_sub_category_id');
    }
}
