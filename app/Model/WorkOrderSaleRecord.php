<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WorkOrderSaleRecord extends Model
{
    public function workOrderProduct()
    {
        return $this->belongsTo('App\Model\WorkOrderProduct', 'work_order_product_id');
    }
    public function requestedQuotation()
    {
        return $this->belongsTo('App\Model\WorkOrderQuotationRequest', 'work_order_quotation_request_id');
    }
    public function selleruser()
    {
        return $this->belongsTo('App\User', 'seller_user_id');
    }

    public function buyeruser()
    {
        return $this->belongsTo('App\User', 'buyer_user_id');
    }
}
