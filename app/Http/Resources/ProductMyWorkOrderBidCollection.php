<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductMyWorkOrderBidCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $bid_price_bdt = $data->bid_price;
                $bid_price_usd = convert_to_usd($data->bid_price);
                return [
                    'id' => $data->id,
                    'product_name' => $data->workorderproduct->name,
                    'thumbnail_image' => $data->workorderproduct->thumbnail_img,
                    'quantity' =>(integer) $data->workorderproduct->quantity . ' ' .$data->workorderproduct->unit ? $data->workorderproduct->unit->name: null,
//                    'unit_name' => $data->product->unit->name,
                    'bid_price_bdt' => (double) $bid_price_bdt,
                    'bid_price_usd' => (double) $bid_price_usd,
                    'date' => date('j M Y h:i A',strtotime($data->created_at)),
                    'bid_status' => $data->bid_status,
//                    'rating' => (float) userRating($data->product->user_id),

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
