<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function user(){
        return $this->belongsTo('App\User','receiver_user_id');
    }
    public function sender(){
        return $this->belongsTo('App\User','sender_user_id');
    }
}
