<?php

namespace App\Http\Resources;

use App\Model\Shop;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class AllRequestedProductCollection extends ResourceCollection
{
    public function toArray($request)
    {
        //return 'products collections';
        return [
            'data' => $this->collection->map(function($data) {
                $productBid = \App\Model\ProductBid::where('product_id',$data->id)->where('sender_user_id',Auth::id())->first();
                if (!empty($productBid) && $productBid->bid_status == 1){
                    $status = 'Sold';
                }elseif (!empty($productBid)){
                    $status = 'Applied';
                }else{
                    $status = 'Open';
                }
                if ($data->category_id == 9 && $data->sizingProduct){
                    $unit_price_bdt = $data->sizingProduct->price;
                    $total_price_bdt = $data->sizingProduct->total_price;
                    $unit_price_usd = convert_to_usd($data->sizingProduct->price);
                    $total_price_usd = convert_to_usd($data->sizingProduct->total_price);
                }
                else{
                    $unit_price_bdt = $data->unit_price ? getNumberToBangla($data->unit_price) : '';
                    $total_price_bdt = $data->expected_price ? getNumberToBangla($data->expected_price):'';
                    $unit_price_usd =$data->unit_price ? getNumberToBangla(convert_to_usd($data->unit_price)):'';
                    $total_price_usd =$data->expected_price ? getNumberToBangla(convert_to_usd($data->expected_price)):'';
                }
                if ($data->quantity){
                    $qty =(double) $data->quantity;
                }else{
                    $qty = '';
                }

                return [
                    'id' => $data->id,
                    'name' =>(string) getNameByBnEn($data),
                    'thumbnail_image' => $data->thumbnail_img,
                    'quantity' =>(string) getNumberToBangla($qty),
                    'unit_name' =>(string) $data->unit ? getNameByBnEn($data->unit) : null,
                    'unit_price_bdt' =>(string)$unit_price_bdt,
                    'total_price_bdt' =>(string) $total_price_bdt ,
                    'unit_price_usd' =>(string) $unit_price_usd ,
                    'total_price_usd' =>(string) $total_price_usd,
                    'currency_name' => $data->currency->code,
                    'date' => (string) getDateConvertByBnEn($data->created_at),
                    'bid_count' =>(string) getNumberToBangla(bidCount($data->id)),
                    'status' => $status,
                    'link'=> [
                        'product_details' => route('product.details', $data->id),
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
