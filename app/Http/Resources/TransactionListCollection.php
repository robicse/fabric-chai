<?php

namespace App\Http\Resources;

use App\Model\Shop;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TransactionListCollection extends ResourceCollection
{
    public function toArray($request)
    {
        //return 'products collections';
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id' => $data->id,
                    'invoice_code' => getInvoiceByBnEn($data->invoice_code),
                    'seller_name' => getNameByBnEn($data->seller),
                    'payment_with' => getPaymentByBnEn($data->payment_with),
                    'payment_type' => getCashByBnEn($data->payment_type),
                    'transaction_id' => $data->transaction_id,
                    'currency_code' => $data->currency,
                    'amount_bdt' =>(string) getNumberToBangla($data->amount),
                    'amount_usd' =>(string) getNumberToBangla(convert_to_usd($data->currency)),
                    'description' =>$data->description,
                    'date' =>(string) getDateConvertByBnEn($data->created_at),
                    'payment_status' =>getPaidStatusByBnEn($data->payment_status),
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
