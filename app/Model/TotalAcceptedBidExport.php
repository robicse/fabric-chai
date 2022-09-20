<?php

namespace App\Model;





use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TotalAcceptedBidExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        $start_date = Session::get('start_date');
        $end_date = Session::get('end_date');
        $totalAcceptedBids = ProductBid::where('bid_status',1)
            ->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('created_at', 'DESC')
            ->get();

        return $totalAcceptedBids;
    }

    public function headings(): array
    {
        return [
            'Product Name',
            'Bid Unit Price',
            'Bid Total Price',
            'Date',

        ];
    }
    public function map($totalAcceptedBid): array
    {
        $date = date('d-m-Y',strtotime($totalAcceptedBid->created_at));
        return [
            $totalAcceptedBid->product->name,
            $totalAcceptedBid->unit_bid_price,
            $totalAcceptedBid->total_bid_price,
            $date,
        ];
    }

}
