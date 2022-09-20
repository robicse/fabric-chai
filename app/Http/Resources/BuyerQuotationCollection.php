<?php

namespace App\Http\Resources;

use App\Model\WorkOrderQuotationRequest;
use App\Model\WorkOrderReview;
use App\User;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class BuyerQuotationCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {

                $quotationCheck = WorkOrderQuotationRequest::where('buyer_user_id',Auth::id())->where('work_order_product_id',$data->workOrderProduct->id)->where('status',1)->first();
                $reviewCheck = WorkOrderReview::where('sender_user_id',Auth::id())->where('work_order_product_id',$data->workOrderProduct->id)->first();

                if (empty($quotationCheck)){
                    $quotationStatus = 'pending';
                }else{
                    $quotationStatus = 'completed';
                }
                if (empty($reviewCheck)){
                    $reviewStatus = 'pending';
                }else{
                    $reviewStatus = 'completed';
                }
                return [
                    'id' =>(integer) $data->id,
                    'work_order_image' => (string) $data->workOrderProduct->thumbnail_img,
                    'work_order_name' =>(string) $data->workOrderProduct->wish_to_work,
                    'requested_quantity' => $data->quantity.' '.$data->workOrderProduct->unit ? $data->workOrderProduct->unit->name: null,
                    'requested_unit_price_bdt' =>(string) getNumberToBangla($data->unit_price),
                    'requested_unit_price_usd' =>(string) getNumberToBangla(convert_to_usd($data->unit_price)),
                    'requested_total_price_bdt' =>(string) getNumberToBangla($data->total_price),
                    'requested_total_price_usd' =>(string) getNumberToBangla(convert_to_usd($data->total_price)),
                    'date' =>(string) getDateConvertByBnEn($data->created_at),
                    'quotation_status' => $quotationStatus,
                    'review_status' => $reviewStatus,
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
