<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WorkOrderQuotationRequest extends Model
{
    public function workOrderProduct()
    {
        return $this->belongsTo('App\Model\WorkOrderProduct', 'work_order_product_id');
    }
    public function sellerUser(){
        return $this->belongsTo('App\User','seller_user_id');
    }
    public function buyerUser(){
        return $this->belongsTo('App\User','buyer_user_id');
    }
}
