<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public function sender(){
        return $this->belongsTo('App\User','sender_user_id');
    }
    public function receiver(){
        return $this->belongsTo('App\User','receiver_user_id');
    }
    public function product()
    {
        return $this->belongsTo('App\Model\Product','product_id');
    }
}
