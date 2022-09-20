<?php

namespace App\Http\Resources;

use App\Model\BusinessSetting;
use App\Model\DyingCategory;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Model\Review;

class DyingProductDetailCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $review_count = Review::where('receiver_user_id',$data->user_id)->count();
                if ($data->currency_id == 27){
                    $unit_price_bdt = $data->unit_price;
                    $total_price_bdt = $data->expected_price;
                    $unit_price_usd = convert_to_usd($data->unit_price);
                    $total_price_usd = convert_to_usd($data->expected_price);
                }else{
                    $unit_price_usd = $data->unit_price;
                    $total_price_usd = $data->expected_price;
                    $unit_price_bdt =convert_to_bdt($data->unit_price);
                    $total_price_bdt =convert_to_bdt($data->expected_price);
                }

                return [
                    'id' => (integer) $data->id,
                    'name' => $data->name,
                    'category' => $data->category->name,
                    'product_of_fabric' => $data->dyingProduct->product_of_fabric,
                    'dying_category_id' =>(integer) $data->dyingProduct->dying_category_id,
                    'dying_category_name' => $data->dyingProduct->dyingCategory ? $data->dyingProduct->dyingCategory->name: null,
                    'dying_sub_category_id' =>(integer) $data->dyingProduct->dying_sub_category_id,
                    'dying_sub_category_name' => $data->dyingProduct->dyingSubcategory ? $data->dyingProduct->dyingSubcategory->name: null,
                    'quantity' =>(integer) $data->quantity,
                    'unit_price_bdt' => (double) $unit_price_bdt,
                    'total_price_bdt' => (double) $total_price_bdt,
                    'unit_price_usd' => (double) $unit_price_usd,
                    'total_price_usd' => (double) $total_price_usd,
                    'color' => $data->dyingProduct->color,
                    'fabrics_construction' => $data->dyingProduct->fabrics_construction,
                    'fabrics_composition' => $data->dyingProduct->fabrics_composition,
                    'grey_width' => $data->dyingProduct->grey_width,
                    'grey_unit' => $data->dyingProduct->grey_unit,
                    'finished_width' => $data->dyingProduct->finished_width,
                    'finished_unit' => $data->dyingProduct->finished_unit,
                    'color_test_parameter' => $data->dyingProduct->color_test_parameter,
                    'rubbing' => $data->dyingProduct->rubbing,
                    'tearing_strange' => $data->dyingProduct->tearing_strange,
                    'shining_receive' => $data->dyingProduct->shining_receive,
                    'photos' => json_decode($data->photos),
                    'thumbnail_image' => $data->thumbnail_img,
                    'currency_id' =>(integer) $data->currency_id,
                    'currency_name' => $data->currency->code,
                    'rating' => (double) $data->rating,
                    'review_count' => (integer) $review_count,
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

}
