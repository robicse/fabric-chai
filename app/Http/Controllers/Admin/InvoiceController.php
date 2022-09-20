<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\SaleRecord;
use Illuminate\Http\Request;
use NumberFormatter;

class InvoiceController extends Controller
{
    public function sale_invoice($id,$sale_type){
        if ( $sale_type == 'buy' || $sale_type == 'sell'){
            $saleRecord = SaleRecord::find(decrypt($id));
            $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
            return view('backend.admin.report.sale_invoice',compact('saleRecord','digit'));
        }else{
            return "Testing";
        }

    }
}
