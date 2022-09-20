<?php

namespace App\Model;





use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TotalSellerExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return Seller::latest()->get();
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
            $user->reg_by,
            $date,
        ];
    }

}
