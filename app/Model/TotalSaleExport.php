<?php

namespace App\Model;





use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TotalSaleExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        $start_date = Session::get('start_date');
        $end_date = Session::get('end_date');
        $sale_type = Session::get('sale_type');
        if ($start_date && $end_date && $sale_type == 'sell'){
            $totalSales = DB::table('sale_records')
                ->join('products','sale_records.product_id','=','products.id')
                ->where('products.user_type','=','seller')
                ->whereBetween('sale_records.created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->orderBy('sale_records.created_at', 'DESC')
                ->get();
        }  elseif ($start_date && $end_date && $sale_type == 'wo'){
            $totalSales = DB::table('work_order_sale_records')
                ->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->orderBy('created_at', 'DESC')
                ->get();
        }elseif ($start_date && $end_date && $sale_type == 'mp'){
            $totalSales = UserMembershipPackage::where('payment_status','Paid')
                ->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->latest()
                ->get();
        }
        else{
            $totalSales = DB::table('sale_records')
                ->join('products','sale_records.product_id','=','products.id')
                ->where('products.user_type','=','buyer')
                ->whereBetween('sale_records.created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->orderBy('sale_records.created_at', 'DESC')
                ->get();
        }

        return $totalSales;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Sale Amount',
            'Date',

        ];
    }
    public function map($totalSales): array
    {

        $sale_type = Session::get('sale_type');
        if($sale_type == 'buy'){
            $user = \App\User::find($totalSales->buyer_user_id);
        }elseif ($sale_type == 'mp'){
            $user = \App\User::find($totalSales->user_id);
        }else{
            $user = \App\User::find($totalSales->seller_user_id);
        }


        $date = date('d-m-Y',strtotime($totalSales->created_at));
        return [
            $user->name,
            $totalSales->amount,
            $date,
        ];
    }

}
