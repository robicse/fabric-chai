<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EmployerOfferCollection extends ResourceCollection
{
    public function toArray($request)
    {

        return [
            'data' => $this->collection->map(function($data) {
                $user_name = User::where('id',$data->receiver_user_id)->pluck('name')->first();
                $total_candidate = $data->total_candidate ? $data->total_candidate : 0;
                return [
                    'id' => $data->id,
                    'receiver_name' => $user_name,
                    'total_candidate' =>(string) getNumberToBangla($total_candidate),
                    'message' => $data->message,
                    //'cost_per_sms' => (double) $data->cost_per_sms,
                    'date' => getDateConvertByBnEn($data->created_at),
                    'link'=> [
                        'offer_details' => route('employer.offer.details', $data->id),
                    ]
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
