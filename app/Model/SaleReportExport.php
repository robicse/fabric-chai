<?php

namespace App\Model;



use App\Model\SaleRecord;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SaleReportExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return SaleRecord::latest()->get();
    }

    public function headings(): array
    {
        return [
            'Product Name',
            'Seller Name',
            'Buyer Name',
            'Buyer Amount',
            'Buyer Rating',
            'Buyer Status',
            'Seller Rating',

        ];
    }
    public function map($sale_record): array
    {
        $seller = \App\User::where('id',$sale_record->seller_user_id)->first();
        $buyer = \App\User::where('id',$sale_record->buyer_user_id)->first();
        $buyer_rating =  userRating($sale_record->buyer_user_id);
        $seller_rating = userRating($sale_record->seller_user_id);
        if ($sale_record->sale_status == 1){
            $sale_record->sale_status = 'Complete';
            }else{
            $sale_record->sale_status = 'In-Complete';
            }
        return [
            $sale_record->product->name,
            $seller->name,
            $buyer->name,
            $sale_record->amount,
            $buyer_rating,
            $sale_record->sale_status,
            $seller_rating,

        ];
    }

}
