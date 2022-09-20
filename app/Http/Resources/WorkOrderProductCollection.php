<?php

namespace App\Http\Resources;

use App\Model\WorkOrderQuotationRequest;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class WorkOrderProductCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $quotations = WorkOrderQuotationRequest::where('seller_user_id',Auth::id())->where('work_order_product_id',$data->id)->count();
               $quotationCheck = WorkOrderQuotationRequest::where('seller_user_id',Auth::id())->where('work_order_product_id',$data->id)->where('status',1)->first();
                if ($quotations == 0){
                   $status = 'Edit';
                }elseif (!empty($quotationCheck)){
                    $status = 'Sold';
                }else{
                    $status = 'Open';
                }
                return [
                    'id' => $data->id,
                    'thumbnail_img' => $data->thumbnail_img,
                    'wish_to_work' => $data->wish_to_work,
                    'unit_price_bdt' =>(string) getNumberToBangla($data->unit_price) ,
                    'unit_price_usd' =>(string) getNumberToBangla(convert_to_usd($data->unit_price)),
                    'rfqs' =>(string) getNumberToBangla($quotations),
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
