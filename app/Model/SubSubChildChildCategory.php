<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SubSubChildChildCategory extends Model
{
    protected $guarded = [];

    public function subsubchildcategory(){
        return $this->belongsTo(SubSubChildCategory::class,'sub_sub_child_cat_id');
    }

    public function categorysixes(){
        return $this->hasMany(CategorySix::class, 'sub_sub_child_child_cat_id' );
    }
}
