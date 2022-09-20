<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Shortlist extends Model
{
    public function user(){
        return $this->belongsTo('App\User','employee_user_id');
    }

    public function employee(){
        return $this->belongsTo('App\Model\Employee','employee_id');
    }
}
