<?php

namespace App\Model;




use App\Model\Buyer;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TotalBuyerExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return Buyer::latest()->get();
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
    public function map($buyers): array
    {
        $user = \App\User::find($buyers->user_id);
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
