<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TopSellerExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        $topSellers = DB::table('sale_records')
            ->join('users','sale_records.seller_user_id','=','users.id')
            ->select('sale_records.seller_user_id',DB::raw('COUNT(sale_records.id) as total_product_sold'),DB::raw('SUM(sale_records.admin_commission) as total_commission'),DB::raw('SUM(sale_records.amount) as total_sale'))
            ->groupBy('sale_records.seller_user_id')
            ->orderBy('total_product_sold', 'DESC')
            ->get();
        return $topSellers;
    }

    public function headings(): array
    {
        return [
            'Seller Name',
            'Total Product Sold',
            'Total Commission',
            'Total Earning',

        ];
    }
    public function map($topSeller): array
    {

        $seller = \App\User::where('id',$topSeller->seller_user_id)->first();
        $total_commission = getTotalCommissionAmount($seller->id);
        $total_earning = getTotalCommissionPaidAmount($seller->id);

        return [
            $seller->name,
            $topSeller->total_product_sold,
            $total_commission,
            $total_earning,

        ];
    }

}
