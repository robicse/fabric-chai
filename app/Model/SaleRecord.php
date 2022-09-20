<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SaleRecord extends Model
{
    public function product()
    {
        return $this->belongsTo('App\Model\Product', 'product_id');
    }

    public function selleruser()
    {
        return $this->belongsTo('App\User', 'seller_user_id');
    }

    public function buyeruser()
    {
        return $this->belongsTo('App\User', 'buyer_user_id');
    }
    public function productBid()
    {
        return $this->belongsTo('App\Model\ProductBid', 'product_bid_id');
    }
}
