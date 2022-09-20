<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class IndustryEmployeeType extends Model
{
    public function industrycategory(){
        return $this->belongsTo('App\Model\IndustryCategory', 'industry_category_id');
    }

    public function industrysubcategory(){
        return $this->belongsTo('App\Model\IndustrySubCategory', 'industry_sub_category_id');
    }
}
