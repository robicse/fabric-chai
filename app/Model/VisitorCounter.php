<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VisitorCounter extends Model
{
    protected $fillable = ['ip','count'];
}
