<?php

namespace App\Model;





use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TotalWOProvidedExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        $start_date = Session::get('start_date');
        $end_date = Session::get('end_date');
        $totalWorkOrders = WorkOrderQuotationRequest::where('status',1)
            ->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('created_at', 'DESC')
            ->get();

        return $totalWorkOrders;
    }

    public function headings(): array
    {
        return [
            'Buyer Name',
            'Work Order Type',
            'Amount',
            'Date',
        ];
    }
    public function map($totalWorkOrder): array
    {
        $date = date('d-m-Y',strtotime($totalWorkOrder->created_at));
        return [
            $totalWorkOrder->buyerUser->name,
            $totalWorkOrder->workOrderProduct->wish_to_work,
            $totalWorkOrder->total_price,
            $date,
        ];
    }

}
