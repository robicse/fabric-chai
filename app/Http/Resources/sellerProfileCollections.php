<?php

namespace App\Http\Resources;

use App\Model\ProductBid;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class sellerProfileCollections extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $days = \Carbon\Carbon::parse($data->created_at)->diffInDays(\Carbon\Carbon::now());
                $complete_bids = \App\Model\ProductBid::where('sender_user_id',$data->id)->where('bid_status',1)->count();
                $reviews = \App\Model\Review::where('receiver_user_id',$data->id)->count();
                $bid_status = \App\Model\ProductBid::where('sender_user_id',Auth::id())->first();
                if (empty($bid_status)){
                    $status = 0;
                }else{
                    $status = 1;
                }
                return [
                    //dd($data),

                    'id' => (integer) $data->id,
                    'name' =>(string) getNameByBnEn($data),
                    'email' => (string) $data->email,
                    'country_code' => (string) $data->country_code,
                    'phone' => (string) getNumberToBangla($data->phone),
                    'avatar_original' => (string) $data->avatar_original,
                    'company_name' => (string) getCompanyNameByBnEn($data->seller),
                    'company_phone' => (string) $data->seller->company_phone ? getNumberToBangla($data->seller->company_phone):'',
                    'company_email' => (string) $data->seller->company_email,
                    'company_address' => (string) getCompanyAddressByBnEn($data->seller),
                    'trade_licence' => (string) $data->seller->trade_licence,
                    'nid_front' => (string) $data->seller->nid_front,
                    'nid_back' => (string) $data->seller->nid_back,
                    'experience' =>(string) getNumberToBangla($days),
                    'complete_bids' =>(string) getNumberToBangla($complete_bids),
                    'reviews' =>(string) getNumberToBangla($reviews),
                    'ratings' =>(string) getNumberToBangla(userRating($data->id)),
                    'bid_status' =>  $status,
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
