<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EmployerOfferDetailCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id' => (integer) $data->id,
                    'candidate' =>(string) getNumberToBangla(1),
                    'sms_sent' =>(string) getNumberToBangla(1),
                    'cost_per_sms' =>(string) getNumberWithCurrencyByBnEn($data->cost_per_sms) ,
                    'date' => getDateConvertByBnEn($data->created_at),
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
}
