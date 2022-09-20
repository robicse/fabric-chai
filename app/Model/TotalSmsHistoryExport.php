<?php

namespace App\Model;





use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TotalSmsHistoryExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        $start_date = Session::get('start_date');
        $end_date = Session::get('end_date');
        $totalSmsHistories = Message::whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('created_at', 'DESC')
            ->get();
        return $totalSmsHistories;
    }

    public function headings(): array
    {
        return [
            'Total SMS Send',
            'Total SMS Received',
            'Total SMS Sale',
            'Date',
        ];
    }
    public function map($totalSmsHistories): array
    {
        $start_date = Session::get('start_date');
        $end_date = Session::get('end_date');
        $date = date('dS M, Y',strtotime($start_date)). ' to '.date('dS M, Y',strtotime($end_date));
        return [
            $totalSmsHistories->count('sender_user_id'),
            $totalSmsHistories->count('receiver_user_id'),
            $date,
        ];
    }

}
