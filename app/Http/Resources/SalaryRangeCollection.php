<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SalaryRangeCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'start_bdt' =>(double) $data->start,
                    'start_usd' =>(double) convert_to_usd($data->start),
                    'end_bdt' =>(double) $data->end,
                    'end_usd' => (double) convert_to_usd($data->end),
                    'range_bdt' => $data->start.' - '.$data->end,
                    'range_usd' =>  convert_to_usd($data->start).' - '.convert_to_usd($data->end),
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
