<?php

namespace App\Http\Resources;

use App\Model\WorkOrderQuotationRequest;
use App\Model\WorkOrderReview;
use App\User;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class WorkOrderQuotationListCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $buyer = User::find($data->buyer_user_id);
                $quotationCheck = WorkOrderQuotationRequest::where('seller_user_id',Auth::id())->where('work_order_product_id',$data->workOrderProduct->id)->where('status',1)->first();
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
                    'buyer_image' => (string) $buyer->avatar_original,
                    'buyer_name' =>getNameByBnEn($buyer),
                    'requested_quantity' =>(string) getNumberToBangla($data->quantity) .' '.$data->workOrderProduct->unit ? getNameByBnEn($data->workOrderProduct->unit) :'',
                    'requested_unit_price_bdt' => (string)getNumberToBangla($data->unit_price),
                    'requested_unit_price_usd' => (string) getNumberToBangla(convert_to_usd($data->unit_price)),
                    'requested_total_price_bdt' =>(string) getNumberToBangla($data->total_price),
                    'requested_total_price_usd' =>(string) getNumberToBangla(convert_to_usd($data->total_price)),
                    'date' =>(string) getDateConvertByBnEn($data->created_at),
                    'ratings' =>(string) getNumberToBangla(userWorkOrderRating($data->buyer_user_id)),
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
