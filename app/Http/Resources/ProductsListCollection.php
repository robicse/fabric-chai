<?php

namespace App\Http\Resources;

use App\Model\Shop;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductsListCollection extends ResourceCollection
{
    public function toArray($request)
    {
        //return 'products collections';
        return [
            'data' => $this->collection->map(function($data) {
                $productBid = \App\Model\ProductBid::where('product_id',$data->id)->where('bid_status',1)->first();
                if (!empty($productBid)){
                    $status = 'Sold';
                }elseif (bidCount($data->id) == 0){
                    $status = 'Edit';
                }else{
                    $status = 'Open';
                }
                if ($data->category_id == 9 && $data->sizingProduct){
                    $unit_price_bdt = $data->sizingProduct->price;
                    $total_price_bdt = $data->sizingProduct->total_price;
                    $unit_price_usd = convert_to_usd($data->sizingProduct->price);
                    $total_price_usd = convert_to_usd($data->sizingProduct->total_price);
                }
                else {
                    $unit_price_bdt = $data->unit_price;
                    $total_price_bdt = $data->expected_price;
                    $unit_price_usd = convert_to_usd($data->unit_price);
                    $total_price_usd = convert_to_usd($data->expected_price);
                }

                return [
                    'id' => $data->id,
                    'category_id' =>(integer) $data->category_id,
                    'category_name' =>(string) $data->category_id ? getNameByBnEn($data->category) : '',
                    'name' =>(string) getNameByBnEn($data),
                    'thumbnail_image' => $data->thumbnail_img,
                    'quantity' =>(string) getNumberToBangla($data->quantity),
                    'unit_name' =>(string) $data->unit ? getNameByBnEn($data->unit) : null,
                    'unit_price_bdt' =>(string) getNumberToBangla($unit_price_bdt),
                    'total_price_bdt' =>(string) getNumberToBangla($total_price_bdt),
                    'unit_price_usd' =>(string) getNumberToBangla($unit_price_usd),
                    'total_price_usd' =>(string) getNumberToBangla($total_price_usd),
                    'currency_name' => $data->currency->code,
                    'date' =>(string) getDateConvertByBnEn($data->created_at),
                    'bid_count' =>(string) getNumberToBangla(bidCount($data->id)),
                    'status' => $status,
                    'link'=> [
                        'product_details' => route('product.details', $data->id),
                        'bidder_list' => route('bidderList.index', $data->id),
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
