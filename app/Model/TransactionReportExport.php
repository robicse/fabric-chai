<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionReportExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        $from_date = Session::get('from_date');
        $to_date = Session::get('to_date');
        $transaction_reports = PaymentHistory::whereBetween('created_at', [$from_date." 00:00:00", $to_date." 23:59:59"])->get();
        return $transaction_reports;
    }

    public function headings(): array
    {
        return [
            'Invoice NO',
            'Seller Name',
            'Transaction ID',
            'Transaction Method',
            'Currency',
            'Commission Amount',
            'Description',
            'Date',
            'Payment Status',

        ];
    }
    public function map($transaction_report): array
    {
       //$date = date('j M Y h:i A',strtotime($transaction_report->created_at);

        return [
            $transaction_report->invoice_code,
            $transaction_report->seller->name,
            $transaction_report->transaction_id,
            $transaction_report->payment_type,
            $transaction_report->currency,
            $transaction_report->amount,
            $transaction_report->description,
            $transaction_report->created_at,
            $transaction_report->payment_status
        ];
    }

}
