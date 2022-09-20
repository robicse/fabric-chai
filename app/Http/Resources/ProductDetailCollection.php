<?php

namespace App\Http\Resources;

use App\Model\BusinessSetting;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Model\Review;

class ProductDetailCollection extends ResourceCollection
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
                    'name' => getNameByBnEn($data),
//                    'categories' => allCategoryPrint($data),

                    'category_list' => allCategoryForApi($data),
                    'photos' => json_decode($data->photos),
                    'thumbnail_image' => $data->thumbnail_img,
                    'quantity' =>(string) getNumberToBangla($data->quantity),
                    'unit_id' => (integer) $data->unit_id,
                    'unit_name' =>(string) $data->unit ? getNameByBnEn($data->unit): null,
                    'unit_price_bdt' =>(string) getNumberToBangla($unit_price_bdt),
                    'total_price_bdt' =>(string) getNumberToBangla($total_price_bdt),
                    'unit_price_usd' => (string) getNumberToBangla($unit_price_usd),
                    'total_price_usd' =>(string) getNumberToBangla($total_price_usd),
                    'currency_id' =>(integer) $data->currency_id,
                    'currency_name' => $data->currency->code,
                    'rating' =>(string) getNumberToBangla( $data->rating),
                    'review_count' =>(string) getNumberToBangla($review_count) ,
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
