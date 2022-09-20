<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WorkOrderBid extends Model
{

//    public function workorderproduct()
//    {
//        return $this->belongsTo(WorkOrderProduct::class, 'work_order_product_id');
//    }
    public function workOrderProduct()
    {
        return $this->belongsTo('App\Model\WorkOrderProduct', 'work_order_product_id');
    }
    public function sender(){
        return $this->belongsTo('App\User','sender_user_id');
    }
    public function receiver(){
        return $this->belongsTo('App\User','receiver_user_id');
    }
}
