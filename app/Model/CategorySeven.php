<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CategorySeven extends Model
{
    public function categorySix(){
        return $this->belongsTo(CategorySix::class,'category_six_id');
    }

    public function categoryeights(){
        return $this->hasMany(CategoryEight::class, 'category_seven_id' );
    }
}
