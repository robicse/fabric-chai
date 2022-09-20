<?php

namespace App\Http\Resources;

use App\Model\Shop;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SellerRecordedTransactionCollection extends ResourceCollection
{
    public function toArray($request)
    {
        //return 'products collections';
        return [
            'data' => $this->collection->map(function($data) {
                $sale_amount_usd = convert_to_usd($data->amount);
                return [
                    'id' => $data->id,
                    'invoice_code' => getInvoiceByBnEn($data->invoice_code),
                    'seller_name' =>(string) getNameByBnEn($data->selleruser),
                    'buyer_name' => (string) getNameByBnEn($data->buyeruser),
                    'thumbnail_image' => $data->product->thumbnail_img,
                    'product_name' =>(string) getNameByBnEn($data->product),
                    'quantity' =>(string) getNumberToBangla($data->product->quantity),
                    'unit_name' => $data->product->unit ? getNameByBnEn($data->product->unit) : null,
                    'sale_amount_bdt' =>(string) getNumberToBangla($data->amount),
                    'sale_amount_usd' =>(string) getNumberToBangla($sale_amount_usd),
                    'commission_bdt' =>(string) getNumberToBangla($data->commission),
                    'commission_usd' =>(string) getNumberToBangla(convert_to_usd($data->commission)),
                    'vat_percentage' =>(string) getNumberToBangla($data->vat_percentage),
                    'vat_bdt' =>(string) getNumberToBangla($data->vat),
                    'vat_usd' =>(string) getNumberToBangla(convert_to_usd($data->vat)),
                    'total_commission_bdt' =>(string) getNumberToBangla($data->admin_commission),
                    'total_commission_usd' =>(string) getNumberToBangla(convert_to_usd($data->admin_commission)),
                    'currency_name' => $data->product->currency->code,
                    'date' =>(string) getDateConvertByBnEn($data->created_at),
                    'status' => getPaidStatusByBnEn($data->payment_status),
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
