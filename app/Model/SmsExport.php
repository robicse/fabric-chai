<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SmsExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        $from_date = Session::get('from_date');
        $to_date = Session::get('to_date');
        $sms_reports = DB::table('messages')
            ->join('users','messages.sender_user_id','=','users.id')
            ->select('messages.sender_user_id',DB::raw('COUNT(messages.id) as total_sms'))
            ->whereBetween('messages.created_at', [$from_date." 00:00:00", $to_date." 23:59:59"])
            ->groupBy('messages.sender_user_id')
            ->orderBy('total_sms', 'DESC')
            ->get();
        return $sms_reports;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Phone',
            'SMS Sent',
        ];
    }
    public function map($sms_report): array
    {
        $from_date = Session::get('from_date');
        $to_date = Session::get('to_date');
        $user = \App\User::where('id',$sms_report->sender_user_id)->first();

        return [
            $user->name,
            $user->country_code.$user->phone,
            $sms_report->total_sms,
        ];
    }

}
