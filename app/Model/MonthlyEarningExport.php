<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MonthlyEarningExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        $from_date = Session::get('from_date');
        $to_date = Session::get('to_date');
        $monthly_reports = DB::table('sale_records')
            ->join('users','sale_records.seller_user_id','=','users.id')
            ->select('sale_records.seller_user_id',DB::raw('COUNT(sale_records.id) as total_product_sold'))
            ->whereBetween('sale_records.created_at', [$from_date." 00:00:00", $to_date." 23:59:59"])
            ->groupBy('sale_records.seller_user_id')
            ->orderBy('total_product_sold', 'DESC')
            ->get();
        return $monthly_reports;
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
    public function map($monthly_report): array
    {
        $from_date = Session::get('from_date');
        $to_date = Session::get('to_date');
        $seller = \App\User::where('id',$monthly_report->seller_user_id)->first();
        $total_commission =  getTotalCommissionAmountDateBetween($seller->id,$from_date, $to_date);
        $total_earning =  getTotalCommissionPaidAmountDateBetween($seller->id,$from_date, $to_date);

        return [
            $seller->name,
            $monthly_report->total_product_sold,
            $total_commission,
            $total_earning,

        ];
    }

}
