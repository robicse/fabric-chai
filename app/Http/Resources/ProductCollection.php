<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class ProductCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $checkBidder = \App\Model\ProductBid::where('product_id',$data->id)->where('sender_user_id',Auth::id())->first();
                if (!empty($checkBidder)){
                    $status = 'Applied';
                }else{
                    $status = 'Not Applied';
                }
                if ($data->category_id == 9 && $data->sizingProduct){
                    $unit_price_bdt = $data->sizingProduct->price;
                    $total_price_bdt = $data->sizingProduct->total_price;
                    $unit_price_usd = convert_to_usd($data->sizingProduct->price);
                    $total_price_usd = convert_to_usd($data->sizingProduct->total_price);
                }
                else{
                    $unit_price_bdt = $data->unit_price;
                    $total_price_bdt = $data->expected_price;
                    $unit_price_usd = convert_to_usd($data->unit_price);
                    $total_price_usd = convert_to_usd($data->expected_price);
                }
                $qty = (double) $data->quantity;
                return [
                    'id' => $data->id,
                    'name' =>(string) getNameByBnEn($data),
                    'thumbnail_image' => $data->thumbnail_img,
                    'currency_name' => $data->currency->code,
                    'quantity' =>(string) $qty ? (string) getNumberToBangla($qty):null,
                    'unit_name' => $data->unit ? (string) getNameByBnEn($data->unit) : '',
                    'unit_price_bdt' =>(string) $unit_price_bdt? (string) getNumberToBangla($unit_price_bdt):0,
                    'total_price_bdt' =>(string)$total_price_bdt? (string) getNumberToBangla($total_price_bdt):0,
                    'unit_price_usd' =>(string) $unit_price_usd ? (string) getNumberToBangla($unit_price_usd):0,
                    'total_price_usd' =>(string) $total_price_usd? (string) getNumberToBangla($total_price_usd):0,
                    'rating' =>(string) getNumberToBangla($data->rating),
                    'rating_count' =>(string) getNumberToBangla(getRatingPerson($data->id)),
                    'bid_status' => $status,
                    'links' => [
                        'product_details' => route('product.details', $data->id)
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
