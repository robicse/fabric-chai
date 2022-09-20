<?php

namespace App\Model;





use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TotalProductsExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        $start_date = Session::get('start_date');
        $end_date = Session::get('end_date');
        $totalProducts = Product::where('user_type','seller')
            ->where('published',1)
            ->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('created_at', 'DESC')
            ->get();

        return $totalProducts;
    }

    public function headings(): array
    {
        return [
            'Seller Name',
            'Product Name',
            'Unit Price',
            'Total Price',
            'Quantity',
            'Date',

        ];
    }
    public function map($totalProduct): array
    {
        if($totalProduct->sizingProduct){
            $unitPrice =$totalProduct->sizingProduct->price;
            $totalPrice =$totalProduct->sizingProduct->total_price;
        } else{
            $unitPrice =$totalProduct->unit_price;
            $totalPrice =$totalProduct->expected_price;
        }
        if ($totalProduct->unit){
          $unit =   $totalProduct->unit->name;
        }else{
            $unit = ' ';
        }

        $date = date('d-m-Y',strtotime($totalProduct->created_at));
        return [
            $totalProduct->user->name,
            $totalProduct->name,
            $unitPrice,
            $totalPrice,
            $totalProduct->quantity.' '. $unit,
            $date,
        ];
    }

}
