<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductMyWorkOrderBidCollection;
use App\Http\Resources\WorkOrderAcceptedBuyerDetailsCollection;
use App\Model\WorkOrderBid;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WorkOrderBidController extends Controller
{
    public function sellerMyWorkOrderBids(){
        $my_bids = WorkOrderBid::where('sender_user_id',Auth::id())->latest()->get();
        return new ProductMyWorkOrderBidCollection($my_bids);
    }

    public function sellerMyWorkOrderAcceptedBids(){
        $my_bids = WorkOrderBid::where('sender_user_id',Auth::id())->where('bid_status',1)->latest()->get();
        return new ProductMyWorkOrderBidCollection($my_bids);
    }

    public function workOrderAcceptedBuyerDetails($id){
        return new WorkOrderAcceptedBuyerDetailsCollection(WorkOrderBid::where('id',$id)->get());
    }

}
