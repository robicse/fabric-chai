<?php

namespace App\Model;





use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TotalEmployeesExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        $start_date = Session::get('start_date');
        $end_date = Session::get('end_date');
        $totalEmployees = Employee::where('verification_status',1)
            ->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('created_at', 'DESC')
            ->get();

        return $totalEmployees;
    }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Phone',
            'Date',

        ];
    }
    public function map($totalEmployee): array
    {
        $date = date('d-m-Y',strtotime($totalEmployee->created_at));
        return [
            $totalEmployee->user->name,
            $totalEmployee->user->phone,
            $date,
        ];
    }

}
