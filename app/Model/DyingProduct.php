<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DyingProduct extends Model
{
    public function dyingCategory(){
        return $this->belongsTo('App\Model\DyingCategory','dying_category_id');
    }
    public function dyingSubcategory(){
        return $this->belongsTo('App\Model\DyingSubcategory','dying_sub_category_id');
    }
}
