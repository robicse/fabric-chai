<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WorkOrderReview extends Model
{
    public function workOrderProduct()
    {
        return $this->belongsTo('App\Model\WorkOrderProduct', 'work_order_product_id');
    }

    public function sender(){
        return $this->belongsTo('App\User','sender_user_id');
    }
}
