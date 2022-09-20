<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SeeReviewCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [

                    'name' =>(string) getNameByBnEn($data->sender),
                    'role' => $data->sender->user_type,
                    'rating' =>(string) getNumberToBangla($data->rating) ,
                    'comment' => $data->comment,
                    'time' =>(string) getDateConvertByBnEn($data->created_at),
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
