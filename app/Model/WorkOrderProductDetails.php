<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WorkOrderProductDetails extends Model
{
    public function machineType()
    {
        return $this->belongsTo('App\Model\MachineType', 'machine_type_id');
    }
}
