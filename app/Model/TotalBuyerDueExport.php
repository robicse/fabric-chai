<?php

namespace App\Model;





use App\User;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TotalBuyerDueExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        $users = User::where('name',null)
            ->orWhere('phone',null)
            ->orWhere('email',null)
            ->get();
        return $users;
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
    public function map($user): array
    {

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
