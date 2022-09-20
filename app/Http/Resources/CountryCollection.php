<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CountryCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    //'id' => $data->id,
                    'country_name' =>$data->country_name,
//                    'banner' => $data->banner,
//                    'icon' => $data->icon,
//                    'links' => [
//                        'sub_categories' => route('subCategories.index', $data->id)
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
