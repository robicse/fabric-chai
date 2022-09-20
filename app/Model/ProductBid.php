<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductBid extends Model
{
    public function product()
    {
        return $this->belongsTo('App\Model\Product', 'product_id');
    }
    public function sender(){
        return $this->belongsTo('App\User','sender_user_id');
    }
    public function receiver(){
        return $this->belongsTo('App\User','receiver_user_id');
    }
}
