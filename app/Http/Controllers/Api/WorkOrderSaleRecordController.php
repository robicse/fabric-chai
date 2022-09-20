<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\WorkOrderSaleRecordCollection;
use App\Model\WorkOrderProduct;
use App\Model\WorkOrderSaleRecord;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class WorkOrderSaleRecordController extends Controller
{
    public function sellerWorkOrderRecordedTransaction(){
        $wo_sale_records = WorkOrderSaleRecord::where('seller_user_id',Auth::id())->latest()->get();
        return new WorkOrderSaleRecordCollection($wo_sale_records);
    }
}
