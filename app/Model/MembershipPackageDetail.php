<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MembershipPackageDetail extends Model
{
    protected $guarded = [];

    public function membershipPackage(){
        return $this->belongsTo(MembershipPackage::class);
    }
}
