<?php

namespace App\Model;





use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TotalEmployerExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return Employer::latest()->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Company Name',
            'Company Owner Name',
            'Company Phone',
            'Company Address',
            'Registration By',
            'Registration Date',

        ];
    }
    public function map($employer): array
    {
        $user = \App\User::find($employer->user_id);
        $date = date('d-m-Y',strtotime($user->created_at));
        return [
            $user->name,
            $employer->seller->company_name,
            $employer->owner_name,
            $employer->seller->company_phone,
            $employer->seller->company_address,
            $user->reg_by,
            $date,
        ];
    }

}
