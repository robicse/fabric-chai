<?php

namespace App\Model;





use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TotalPackageSellExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        $start_date = Session::get('start_date');
        $end_date = Session::get('end_date');
        $package_type = Session::get('package_type');
        if ($start_date && $end_date && $package_type== 'platinum'){
            $totalPackageSells = DB::table('user_membership_packages')
                ->where('membership_package_id','=',3)
                ->where('payment_status','=','Paid')
                ->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->orderBy('created_at', 'DESC')
                ->get();
        }
        else{
            $totalPackageSells = DB::table('user_membership_packages')
                ->where('membership_package_id','=',2)
                ->where('payment_status','=','Paid')
                ->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->orderBy('created_at', 'DESC')
                ->get();
        }

        return $totalPackageSells;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Package Amount',
            'Date',

        ];
    }
    public function map($totalPackageSell): array
    {
        $user = \App\User::find($totalPackageSell->user_id);
        $date = date('d-m-Y',strtotime($totalPackageSell->created_at));
        return [
            $user->name,
            $totalPackageSell->amount,
            $date,
        ];
    }

}
