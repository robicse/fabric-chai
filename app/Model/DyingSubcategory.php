<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DyingSubcategory extends Model
{
    public function dyingCategory(){
        return $this->belongsTo('App\Model\DyingCategory','dying_category_id');
    }
}
