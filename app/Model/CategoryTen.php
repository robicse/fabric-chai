<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CategoryTen extends Model
{
    public function categoryNine(){
        return $this->belongsTo(CategoryNine::class,'category_nine_id');
    }
}
