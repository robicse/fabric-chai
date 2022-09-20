<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EducationDegree extends Model
{
    public function educationLevel(){
        return $this->belongsTo('App\Model\EducationLevel','education_level_id');
    }
}
