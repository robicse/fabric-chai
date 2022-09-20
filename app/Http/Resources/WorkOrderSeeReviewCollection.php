<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class WorkOrderSeeReviewCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'reviewer_name' =>getNameByBnEn($data->sender),
                    'rating' =>(string) getNumberToBangla($data->rating),
                    'comment' =>(string) $data->comment,
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
