<?php

namespace App\Model;





use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TotalTransactionExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        $start_date = Session::get('start_date');
        $end_date = Session::get('end_date');
        $totalTransactions = DB::table('sale_records')
            ->whereBetween('sale_records.created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('sale_records.created_at', 'DESC')
            ->get();
        return $totalTransactions;
    }

    public function headings(): array
    {
        return [
            'Transaction Amount',
            'Date',

        ];
    }
    public function map($totalTransaction): array
    {

        $date = date('d-m-Y',strtotime($totalTransaction->created_at));
        return [
            $totalTransaction->amount + $totalTransaction->admin_commission,
            $date,
        ];
    }

}
