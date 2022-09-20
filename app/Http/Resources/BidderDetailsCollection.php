<?php

namespace App\Http\Resources;

use App\Model\Shop;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BidderDetailsCollection extends ResourceCollection
{
    public function toArray($request)
    {
        //return 'products collections';

        return [
            'data' => $this->collection->map(function($data) {
                $days = \Carbon\Carbon::parse($data->sender->created_at)->diffInDays(\Carbon\Carbon::now());
                $complete_bids = \App\Model\ProductBid::where('sender_user_id',$data->sender->id)->where('bid_status',1)->count();
                $reviews = \App\Model\Review::where('receiver_user_id',$data->sender->id)->count();

                $unit_bid_price_bdt = $data->unit_bid_price;
                $total_bid_price_bdt = $data->total_bid_price;
                $unit_bid_price_usd = convert_to_usd($data->unit_bid_price);
                $total_bid_price_usd = convert_to_usd($data->total_bid_price);

                if ($data->product->user_type == 'seller'){
                    return [

                        'experience' =>(string) getNumberToBangla($days),
                        'complete_bids' =>(string) getNumberToBangla($complete_bids),
                        'review' =>(string) getNumberToBangla($reviews),
                        'ratings' =>(string) getNumberToBangla(userRating($data->sender->id)),
                        'name' =>(string) getNameByBnEn($data->sender),
                        'address' =>(string) $data->sender->address,
                        'phone' =>(string) $data->sender->country_code.$data->sender->phone,
                        'unit_bid_price_bdt' =>(string) getNumberToBangla($unit_bid_price_bdt),
                        'total_bid_price_bdt' =>(string) getNumberToBangla($total_bid_price_bdt),
                        'unit_bid_price_usd' =>(string) getNumberToBangla($unit_bid_price_usd),
                        'total_bid_price_usd' =>(string) getNumberToBangla($total_bid_price_usd),
                        'date' =>(string) getDateConvertByBnEn($data->created_at),

                        'links' => [
                            'see_review' => route('see-review', $data->sender->id),

                        ]
                    ];
                }else{
                    return [

                        'experience' =>(string) getNumberToBangla($days),
                        'complete_bids' =>(string) getNumberToBangla($complete_bids),
                        'review' =>(string) getNumberToBangla($reviews),
                        'ratings' =>(string) getNumberToBangla(userRating($data->sender->id)),
                        'name' =>(string) getNameByBnEn($data->sender),
                        'phone' =>(string) $data->sender->country_code.$data->sender->phone,
                        'company_name' =>(string) $data->sender->seller->company_name,
                        'company_address' =>(string) $data->sender->seller->company_address,
                        'company_phone' =>(string) $data->sender->seller->company_phone,
                        'unit_bid_price_bdt' =>(string) getNumberToBangla($unit_bid_price_bdt),
                        'total_bid_price_bdt' =>(string) getNumberToBangla($total_bid_price_bdt),
                        'unit_bid_price_usd' =>(string) getNumberToBangla($unit_bid_price_usd),
                        'total_bid_price_usd' =>(string) getNumberToBangla($total_bid_price_usd),
                        'date' =>(string) getDateConvertByBnEn($data->created_at),

                        'links' => [
                            'see_review' => route('see-review', $data->sender->id),

                        ]
                    ];
                }
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
