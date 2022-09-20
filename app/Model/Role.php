<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function department(){
        $this->belongsTo('App\Model\Department','department_id');
    }
}
