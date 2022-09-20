<?php

namespace App\Model;





use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TotalEmployersExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        $start_date = Session::get('start_date');
        $end_date = Session::get('end_date');
        $totalEmployers = Employer::whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('created_at', 'DESC')
            ->get();

        return $totalEmployers;
    }

    public function headings(): array
    {
        return [
            'Employer Name',
            'Phone',
            'Company Name',
            'Company Phone',
            'Date',

        ];
    }
    public function map($totalEmployer): array
    {
        $date = date('d-m-Y',strtotime($totalEmployer->created_at));
        return [
            $totalEmployer->user->name,
            $totalEmployer->user->phone,
            $totalEmployer->seller->company_name,
            $totalEmployer->seller->company_phone,
            $date,
        ];
    }

}
