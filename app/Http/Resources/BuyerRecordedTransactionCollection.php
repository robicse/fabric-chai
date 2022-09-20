<?php

namespace App\Http\Resources;

use App\Model\Shop;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BuyerRecordedTransactionCollection extends ResourceCollection
{
    public function toArray($request)
    {

        return [
            'data' => $this->collection->map(function($data) {
                $sale_amount_usd = convert_to_usd($data->amount);
                return [
                    'id' => $data->id,
                    'invoice_code' => getInvoiceByBnEn($data->invoice_code),
                    'seller_name' =>(string) getNameByBnEn($data->selleruser),
                    'buyer_name' =>(string) getNameByBnEn($data->buyeruser),
                    'thumbnail_image' => $data->product->thumbnail_img,
                    'product_name' =>(string) getNameByBnEn($data->product),
                    'quantity' =>(string) getNumberToBangla($data->product->quantity),
                    'unit_name' =>(string) $data->product->unit ? getNameByBnEn($data->product->unit): null,
                    'sale_amount_bdt' =>(string) getNumberToBangla($data->amount),
                    'sale_amount_usd' =>(string) getNumberToBangla($sale_amount_usd),
                    'currency_name' => $data->product->currency->code,
                    'date' =>(string) getDateConvertByBnEn($data->created_at),
                    'status' => 'Successful',
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
