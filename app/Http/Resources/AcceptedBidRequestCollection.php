<?php

namespace App\Http\Resources;

use App\Model\Shop;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class AcceptedBidRequestCollection extends ResourceCollection
{
    public function toArray($request)
    {
        //return 'products collections';

        return [
            'data' => $this->collection->map(function($data) {


                    $unit_bid_price_bdt = $data->unit_bid_price;
                    $total_bid_price_bdt = $data->total_bid_price;
                    $unit_bid_price_usd = convert_to_usd($data->unit_bid_price);
                    $total_bid_price_usd = convert_to_usd($data->total_bid_price);

                if (Auth::user()->user_type == 'seller'){
                    return [
                        'id' => $data->id,
                        'buyer_image' => $data->receiver->avatar_original,
                        'buyer_name' =>(string)getNameByBnEn($data->receiver),
                        'product_name' =>(string) getNameByBnEn($data->product),
                        'unit_bid_price_bdt' =>(string) getNumberToBangla($unit_bid_price_bdt),
                        'total_bid_price_bdt' =>(string) getNumberToBangla($total_bid_price_bdt),
                        'unit_bid_price_usd' =>(string) getNumberToBangla($unit_bid_price_usd),
                        'total_bid_price_usd' =>(string) getNumberToBangla($total_bid_price_usd),
                        'currency_name' => $data->product->currency->code,
                        'status' => 'Accepted',
                        'links' => [
                            'buyer_details' => route('accepted-buyer-details', $data->id)
                        ]
                    ];
                }
                if (Auth::user()->user_type == 'buyer'){
                    return [
                        'id' => $data->id,
                        'bidder_image' =>(string) $data->sender->avatar_original,
                        'bidder_name' =>(string)getNameByBnEn($data->sender),
                        'product_name' =>(string) getNameByBnEn($data->product),
                        'unit_bid_price_bdt' =>(string) getNumberToBangla($unit_bid_price_bdt),
                        'total_bid_price_bdt' =>(string) getNumberToBangla($total_bid_price_bdt),
                        'unit_bid_price_usd' =>(string) getNumberToBangla($unit_bid_price_usd),
                        'total_bid_price_usd' =>(string) getNumberToBangla($total_bid_price_usd),
                        'currency_name' => $data->product->currency->code,
                        'status' => 'Accepted',
                        'links' => [
                            'bidder_details' => route('accepted-bidder-details', $data->id)
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
