<?php

namespace App\Http\Resources;

use App\Model\Shop;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BidderListCollection extends ResourceCollection
{
    public function toArray($request)
    {
        //return 'products collections';

        return [
            'data' => $this->collection->map(function($data) {
                $bidder = Bidder($data->sender_user_id);
                $bid_check = \App\Model\ProductBid::where('product_id',$data->product_id)->where('bid_status',1)->first();
                if($data->bid_status == 1){
                    $bid_status = 'Accepted';
                }
                elseif(!empty($bid_check)){
                    $bid_status = 'Rejected';
                }
                else{
                    $bid_status = 'Pending';
                }

                    $unit_bid_price_bdt = $data->unit_bid_price;
                    $total_bid_price_bdt = $data->total_bid_price;
                    $unit_bid_price_usd = convert_to_usd($data->unit_bid_price);
                    $total_bid_price_usd = convert_to_usd($data->total_bid_price);

                return [
                    'product_bid_id' =>(integer) $data->id,
                    'bidder_name' =>(string) getNameByBnEn($bidder),
                    'bidder_image' => $bidder->avatar_original,
                    'quantity' =>(string) getNumberToBangla($data->product->quantity),
                    'unit_name' =>(string) $data->product->unit ? getNameByBnEn($data->product->unit): null,
                    'unit_bid_price_bdt' =>(string) getNumberToBangla($unit_bid_price_bdt),
                    'total_bid_price_bdt' =>(string) getNumberToBangla($total_bid_price_bdt),
                    'unit_bid_price_usd' =>(string) getNumberToBangla($unit_bid_price_usd),
                    'total_bid_price_usd' =>(string) getNumberToBangla($total_bid_price_usd),
                    'currency_name' =>(string) $data->product->currency->name,
                    'date' =>(string) getDateConvertByBnEn($data->created_at),
                    'status' => $bid_status,
                    'rating' =>(string) getNumberToBangla(userRating($data->sender_user_id)),
                    'links' => [
                        'bidder_details' => route('bidders-details', $data->id),
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
