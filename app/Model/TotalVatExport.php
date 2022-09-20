<?php

namespace App\Model;





use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TotalVatExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        $start_date = Session::get('start_date');
        $end_date = Session::get('end_date');
        $totalVats = DB::table('sale_records')
            ->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('created_at', 'DESC')
            ->get();
        return $totalVats;
    }

    public function headings(): array
    {
        return [
            'Vat Amount',
            'Date',

        ];
    }
    public function map($totalVats): array
    {

        $date = date('d-m-Y',strtotime($totalVats->created_at));
        return [
            $totalVats->vat,
            $date,
        ];
    }

}
