<?php

namespace App\Model;





use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TotalEmployeeDueExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        $employees = Employee::where('company_name',null)
            ->orWhere('company_address',null)
            ->orWhere('trade_licence',null)
            ->orWhere('nid_front',null)
            ->orWhere('nid_back',null)
            ->get();
        return $employees;


    }

    public function headings(): array
    {
        return [
            'Name',
            'Phone',
            'Email',
            'Company Name',
            'Company Phone',
            'Company Address',
            'Trade Licence',
            'Nid Front',
            'Nid Back',
            'Registration By',
            'Registration Date',

        ];
    }
    public function map($seller): array
    {
        $user = \App\User::find($seller->user_id);
        $date = date('d-m-Y',strtotime($user->created_at));
        return [
            $user->name,
            $user->phone,
            $user->email,
            $seller->company_name,
            $seller->company_phone,
            $seller->company_address,
            $seller->trade_licence != null ? 'Yes' : 'N/A',
            $seller->nid_front != null ? 'Yes' : 'N/A',
            $seller->nid_back != null ? 'Yes' : 'N/A',
            $user->reg_by,
            $date,
        ];
    }

}
