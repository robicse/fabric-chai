<?php

namespace App\Model;





use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TotalAdvertisementExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        $start_date = Session::get('start_date');
        $end_date = Session::get('end_date');
        $type = Session::get('type');
        if ($start_date && $end_date && $type == 'slider'){
            $totalAdvertisements = Slider::whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->orderBy('created_at', 'DESC')
                ->get();
        }else{
            $totalAdvertisements = Advertisement::whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->orderBy('created_at', 'DESC')
                ->get();
        }

        return $totalAdvertisements;
    }

    public function headings(): array
    {
        return [
            'Title',
            'Date',

        ];
    }
    public function map($totalAdvertisement): array
    {
        $date = date('d-m-Y',strtotime($totalAdvertisement->created_at));
        return [
            $totalAdvertisement->title,
            $date,
        ];
    }

}
