<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CommissionReportExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        $commissionReports =DB::table('sale_records')
            ->join('users','users.id','=','sale_records.seller_user_id')
            ->select('sale_records.seller_user_id')
            ->groupBy('sale_records.seller_user_id')
            ->get();
        return $commissionReports;
    }

    public function headings(): array
    {
        return [
            'Seller Name',
            'Total Product Sold',
            'Commission',
            'Paid',
            'Pending',

        ];
    }
    public function map($commissionReport): array
    {

        $seller = \App\User::where('id',$commissionReport->seller_user_id)->first();
        $totalSale = getTotalSaleAmount($seller->id);
        $commission = getTotalCommissionAmount($seller->id);
        $CommissionPaidAmount = getTotalCommissionPaidAmount($seller->id);
        $pendingAmount = getTotalCommissionAmount($seller->id) - $CommissionPaidAmount;


        return [
            $seller->name,
            $totalSale,
            $commission,
            $CommissionPaidAmount,
            $pendingAmount,

        ];
    }

}
