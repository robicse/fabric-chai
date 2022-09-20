<?php

namespace App\Http\Resources;

use App\Model\Seller;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EmployeeOfferCollection extends ResourceCollection
{
    public function toArray($request)
    {

        return [
            'data' => $this->collection->map(function($data) {
                $seller = Seller::where('user_id',$data->sender_user_id)->first();
                return [
                    'id' => $data->id,
                    'offer_id' => $data->offer_id,
                    'sender_user_id' => $data->sender_user_id,
                    'company_name' => getCompanyNameByBnEn($seller),
                    'receiver_user_id' => $data->receiver_user_id,
                    'title' => $data->title,
                    'message' => $data->message,
                    'message_charge_status' =>$data->message_charge_status,
                    'message_charge_id' => $data->message_charge_id,
                    'cost_per_sms' =>(string) getNumberToBangla($data->cost_per_sms) ,
                    'date' => getDateConvertByBnEn($data->created_at),
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
