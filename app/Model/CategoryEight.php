<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CategoryEight extends Model
{
    public function categorySeven(){
        return $this->belongsTo(CategorySeven::class,'category_seven_id');
    }

    public function categorynines(){
        return $this->hasMany(CategoryNine::class, 'category_eight_id' );
    }
}
