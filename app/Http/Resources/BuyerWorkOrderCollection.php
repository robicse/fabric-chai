<?php

namespace App\Http\Resources;

use App\Model\WorkOrderQuotationRequest;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class BuyerWorkOrderCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $quotationCheck = \App\Model\WorkOrderQuotationRequest::where('buyer_user_id',Auth::id())->where('work_order_product_id',$data->id)->first();

               if (empty($quotationCheck)){
                    $status = 'Open';
                }elseif ($quotationCheck->status == 1){
                   $status = 'Sold';
               }
               else{
                    $status = 'Applied';
                }
                return [
                    'id' => $data->id,
                    'thumbnail_img' => $data->thumbnail_img,
                    'wish_to_work' => $data->wish_to_work,
                    'unit_price_bdt' =>(string) getNumberToBangla($data->unit_price),
                    'unit_price_usd' =>(string) getNumberToBangla(convert_to_usd($data->unit_price)),
                    'date' => getDateConvertByBnEn($data->created_at),
                    'status' => $status,
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
