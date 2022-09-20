<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class WorkOrderSaleRecordCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $sale_amount_bdt = $data->amount;
                $sale_amount_usd = convert_to_usd($data->amount);
                return [
                    'id' => $data->id,
                    'production_capability' => $data->workorderproduct->wish_to_work,
                    'production_image' => $data->workorderproduct->thumbnail_img,
                    'sale_quantity' =>(string) getNumberToBangla($data->requestedQuotation->quantity) . ' ' .$data->workorderproduct->unit ? getNameByBnEn($data->workorderproduct->unit) : '',
                    'sale_amount_bdt' =>(string) getNumberToBangla($sale_amount_bdt),
                    'sale_amount_usd' =>(string) getNumberToBangla($sale_amount_usd),
                    'date' => getDateConvertByBnEn($data->created_at),
                    'rating' =>(string) getNumberToBangla(userWorkOrderRating($data->buyer_user_id)),

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
