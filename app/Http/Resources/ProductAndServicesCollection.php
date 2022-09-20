<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductAndServicesCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id' => (integer) $data->id,
                    'name' => (string) getNameByBnEn($data),
                    'category_id' => (integer) $data->home_category_id,
                    'category_name' => getNameByBnEn($data->homeCategory->category),
                    'slug' => (string) $data->slug,
                    'image' =>(string) $data->image,
                    'image_alt' =>(string) $data->image,
                    'short_description' =>(string) getShortDescriptionByBnEn($data),
                    'long_description' =>(string) getLongDescriptionByBnEn($data),
                    'created_at' =>(string) getDateConvertByBnEn($data->created_at),
                    'updated_at' =>(string)getDateConvertByBnEn($data->updated_at),
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
