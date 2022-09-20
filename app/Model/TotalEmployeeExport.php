<?php

namespace App\Model;





use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TotalEmployeeExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return Employee::latest()->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Phone',
            'Email',
            'Registration By',
            'Registration Date',

        ];
    }
    public function map($employee): array
    {
        $user = \App\User::find($employee->user_id);
        $date = date('d-m-Y',strtotime($user->created_at));
        return [
            $user->name,
            $user->phone,
            $user->email,
            $user->reg_by,
            $date,
        ];
    }

}
