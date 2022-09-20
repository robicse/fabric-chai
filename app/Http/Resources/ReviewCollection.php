<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ReviewCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [

                    'reviewer_name' =>(string) getNameByBnEn($data->sender),
                    'product_image' => $data->product->thumbnail_img,
                    'product_name' =>(string) getNameByBnEn($data->product),
                    'rating' =>(string) getNumberToBangla($data->rating),
                    'comment' => $data->comment,
//                    'time' => $data->created_at->diffForHumans()
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
