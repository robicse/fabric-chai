<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Model\SaleRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use NumberFormatter;

class SaleRecordController extends Controller
{
    public function index(){
        $saleRecords = SaleRecord::where('seller_user_id',Auth::id())->where('type','seller_product')->latest()->get();
        return view('frontend.seller.recorded_transaction.index',compact('saleRecords'));
    }
    public function requestedRecordTransaction(){
        $saleRecords = SaleRecord::where('seller_user_id',Auth::id())->where('type','requested_product')->latest()->get();
        return view('frontend.seller.recorded_transaction.index',compact('saleRecords'));
    }
    public function recordedTransactionPrint($id){
        $saleRecord = SaleRecord::find(decrypt($id));
        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return view('frontend.seller.recorded_transaction.invoice',compact('saleRecord','digit'));
    }
}
