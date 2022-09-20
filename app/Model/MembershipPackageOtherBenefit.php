<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MembershipPackageOtherBenefit extends Model
{
    public function membershipPackage(){
        return $this->belongsTo(MembershipPackage::class);
    }
}
