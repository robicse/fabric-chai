<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryTenCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id' => $data->id,
                    'name' => getNameByBnEn($data),
//                    'links' => [
//                        'category_ten' => route('getCategoryTen.index', $data->id)
//                    ]
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