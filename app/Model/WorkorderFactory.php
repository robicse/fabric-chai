<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WorkorderFactory extends Model
{
    public function unit()
    {
        return $this->belongsTo('App\Model\Unit', 'unit_id');
    }
    public function seller()
    {
        return $this->belongsTo('App\Model\Seller', 'seller_id');
    }
}
