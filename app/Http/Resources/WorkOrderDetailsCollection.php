<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class WorkOrderDetailsCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {

                $abc = [];
                $details = \App\Model\WorkOrderProductDetails::where('work_order_product_id',$data->id)->get();
                foreach ($details as $detail){
                    $nested_data['details_id'] =(integer) $detail->id;
                    $nested_data['machine_type'] =(string) $detail->machineType ? getNameByBnEn($detail->machineType):null;
                    $nested_data['no_of_machines'] =(string) getNumberToBangla($detail->no_of_machines);
                    $nested_data['pc_per_day'] =(string) getNumberToBangla($detail->pc_per_day);
                    $nested_data['total_pc_per_day'] =(string) getNumberToBangla($detail->total_pc_per_day);
                    $nested_data['minimum_order_quantity'] =(string) getNumberToBangla($detail->moq);
                    $nested_data['maximum_order_quantity'] = (string) getNumberToBangla($detail->max_oq);
                    $nested_data['production_time'] =(string) getNumberToBangla($detail->production_time);
                    $nested_data['finishing_time'] =(string) getNumberToBangla($detail->finishing_time);
                    $nested_data['delivery_time'] =(string) getNumberToBangla($detail->delivery_time) ;

                    array_push($abc,$nested_data);
                }

                return [
                    'id' => $data->id,
                    'user_id' => $data->user_id,
                    'wish_to_work' => $data->wish_to_work,
                    'types_of_industry' => $data->types_of_industry,
                    'category_list' => allCategoryForApi($data->workOrderCategory ? $data->workOrderCategory : ''),
                    'thumbnail_img' => $data->thumbnail_img,
                    'photos' => json_decode($data->photos),
                    'unit_id' =>(integer) $data->unit_id,
                    'unit_name' => $data->unit ? getNameByBnEn($data->unit) : null,
                    'unit_price_bdt' =>(string) getNumberToBangla($data->unit_price),
                    'unit_price_usd' =>(string) getNumberToBangla(convert_to_usd($data->unit_price)),
                    'description' => $data->description,
                    'production_infos' => $abc,
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
