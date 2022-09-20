<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    protected $guarded = [];
    public function seller()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
