<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class buyerProfileCollections extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $days = \Carbon\Carbon::parse($data->created_at)->diffInDays(\Carbon\Carbon::now());
                $complete_bids = \App\Model\ProductBid::where('sender_user_id',$data->id)->where('bid_status',1)->count();
                $reviews = \App\Model\Review::where('receiver_user_id',$data->id)->count();
                return [
                    'id' => (integer) $data->id,
                    'name' => (string) getNameByBnEn($data),
                    'email' => (string) $data->email,
                    'country_code' => (string) $data->country_code,
                    'phone' => (string) getNumberToBangla($data->phone),
                    'avatar_original' => (string) $data->avatar_original,
                    'address' => (string) getAddressByBnEn($data),
                    'experience' =>(string) getNumberToBangla($days),
                    'complete_bids' =>(string) getNumberToBangla($complete_bids),
                    'reviews' =>(string) getNumberToBangla($reviews),
                    'ratings' => (string) getNumberToBangla(userRating($data->id)),
                    'current_membership' =>  checkCurrentMembershipName(Auth::User()->id),

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
