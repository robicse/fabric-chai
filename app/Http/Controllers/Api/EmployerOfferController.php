<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeOfferCollection;

use App\Http\Resources\EmployerOfferCollection;
use App\Http\Resources\EmployerOfferDetailCollection;
use App\Http\Resources\OfferEmployeeListCollection;
use App\Model\Message;
use App\Model\Offer;
use Illuminate\Support\Facades\Auth;

class EmployerOfferController extends Controller
{
    public $successStatus = 201;
    public $failStatus = 401;

    public function offerSendList(){
        $offers = Offer::where('sender_user_id',Auth::user()->id)->latest()->get();
        return new EmployerOfferCollection($offers);

    }

    public function offerDetail($id){
        $messages = Message::where('offer_id',$id)->get();
        return new EmployerOfferDetailCollection($messages);
    }
    public function candidatesList($id){
        $messages = Message::where('offer_id',$id)->get();
        return new OfferEmployeeListCollection($messages);
    }
}
