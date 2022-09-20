<?php

namespace App\Http\Resources;

use App\Model\BusinessSetting;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Model\Review;

class SizingProductDetailCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $review_count = Review::where('receiver_user_id',$data->user_id)->count();

                $unit_price_bdt = $data->unit_price;
                $total_price_bdt = $data->expected_price;
                $unit_price_usd = convert_to_usd($data->unit_price);
                $total_price_usd = convert_to_usd($data->expected_price);

                return [
                    'id' => (integer) $data->id,
                    'name' =>getNameByBnEn($data),
                    'category' => getNameByBnEn($data->category),
                    'total_length' => $data->sizingProduct->total_length,
                    'yarn_count' => $data->sizingProduct->yarn_count,
                    'yarn_csp' => $data->sizingProduct->yarn_csp,
                    'ipi' => $data->sizingProduct->ipi,
                    'lengths_of' => $data->sizingProduct->lengths_of,
                    'warping_lengths' => $data->sizingProduct->warping_lengths,
                    'sizing_lengths' => $data->sizingProduct->sizing_lengths,
                    'wastage_percentage' => $data->sizingProduct->wastage_percentage,
                    'gera' => $data->sizingProduct->gera,
                    'sizing_time' => $data->sizingProduct->sizing_time,

                    'photos' => json_decode($data->photos),
                    'thumbnail_image' => $data->thumbnail_img,
                    'quantity' => (string) getNumberToBangla($data->quantity) ,
                    'unit_name' => 'Meter/Yards',
                    'unit_price_bdt' => (string) $unit_price_bdt ? getNumberToBangla($unit_price_bdt) : getNumberToBangla(0),
                    'total_price_bdt' => (string) $total_price_bdt ?  getNumberToBangla($total_price_bdt) : getNumberToBangla(0),
                    'unit_price_usd' => (string) $unit_price_usd ? getNumberToBangla($unit_price_usd) : getNumberToBangla(0),
                    'total_price_usd' => (string) $total_price_usd ? getNumberToBangla($total_price_usd) : getNumberToBangla(0),
                    'currency_id' =>(integer) $data->currency_id,
                    'currency_name' => $data->currency->code,
                    'rating' => (string) getNumberToBangla($data->rating),
                    'review_count' => (string) getNumberToBangla($review_count),
                    'price_validity' =>(string) $data->price_validity,
                    'made_in' =>(string) $data->made_in,
                    'description' => $data->description,
                    'links' => [
                        'reviews' => route('reviews', $data->user_id),
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

    protected function convertToChoiceOptions($data){
        $result = array();
        foreach ($data as $key => $choice) {
            $item['name'] = $choice->attribute_id;
            $item['title'] = Attribute::find($choice->attribute_id)->name;
            $item['options'] = $choice->values;
            array_push($result, $item);
        }
        return $result;
    }
}
