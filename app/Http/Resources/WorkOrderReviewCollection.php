<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class WorkOrderReviewCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [

                    'reviewer_name' => getNameByBnEn($data->sender),
                    'product_image' => $data->workorderproduct->thumbnail_img,
                    'product_name' => $data->workorderproduct->wish_to_work,
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
