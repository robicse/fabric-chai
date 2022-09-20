<?php

namespace App\Model;





use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TotalManufacturerPostsExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        $start_date = Session::get('start_date');
        $end_date = Session::get('end_date');
        $totalManufacturerPosts = WorkOrderProduct::where('user_type','seller')
            ->where('published',1)
            ->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('created_at', 'DESC')
            ->get();

        return $totalManufacturerPosts;
    }

    public function headings(): array
    {
        return [
            'Manufacturer Name',
            'Production Capability Name',
            'Types of Industry',
            'Unit Price',
            'Date',
        ];
    }
    public function map($totalManufacturerPost): array
    {
        $date = date('d-m-Y',strtotime($totalManufacturerPost->created_at));
        return [
            $totalManufacturerPost->user->name,
            $totalManufacturerPost->wish_to_work,
            $totalManufacturerPost->types_of_industry,
            $totalManufacturerPost->unit_price,
            $date,
        ];
    }

}
