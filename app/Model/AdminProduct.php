<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdminProduct extends Model
{
    public function homeCategory(){
        return $this->belongsTo(HomeCategory::class);
    }
}
