<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EmployerMessageCollection extends ResourceCollection
{
    public function toArray($request)
    {

        return [
            'data' => $this->collection->map(function($data) {
                $user_name = User::where('id',$data->receiver_user_id)->pluck('name')->first();
                return [
                    'id' => $data->id,
                    //'offer_id' => $data->offer_id,
                    //'sender_user_id' => $data->sender_user_id,
                    //'receiver_user_id' => $data->receiver_user_id,
                    'receiver_name' => $user_name,
                    //'title' => $data->title,
                    'message' => $data->message,
                    //'message_charge_status' =>$data->message_charge_status,
                    //'message_charge_id' => $data->message_charge_id,
                    'cost_per_sms' => (double) $data->cost_per_sms,
                    'date' => date('j M Y h:i A',strtotime($data->created_at)),
                    'link'=> [
                        'offer_details' => route('offer.details', $data->id),
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
