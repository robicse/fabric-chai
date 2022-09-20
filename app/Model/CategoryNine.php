<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CategoryNine extends Model
{
    public function categoryEight(){
        return $this->belongsTo(CategoryEight::class,'category_eight_id');
    }

    public function categorytens(){
        return $this->hasMany(CategoryTen::class, 'category_nine_id' );
    }
}
