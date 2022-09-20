<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class IndustrySubCategory extends Model
{
    public function industrycategory(){
        return $this->belongsTo('App\Model\IndustryCategory', 'industry_category_id');
    }
}
