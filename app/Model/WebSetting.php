<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WebSetting extends Model
{
    public function getLanguage($id){
        $language = DB::table('languages')
                ->select('languages.*')
                ->where('id','=',$id)
                ->first();
        return $language;
    }

//    public function getCurrency($currency_id){
//      $currency = DB::table('currencies')->where('id',$currency_id)->first();
//      return $currency;
//    }
}
