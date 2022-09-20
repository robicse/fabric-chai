<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;

use App\Model\Employee;
use App\Model\Message;
use App\Model\Offer;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    public function index(){
        $offers = Offer::where('sender_user_id',Auth::user()->id)->latest()->get();
        return view('frontend.seller.employer.offer',compact('offers'));
    }

    public function viewOfferDetails($id){
        $offer = Offer::find($id);
        $messages = Message::where('offer_id',$id)->get();
        return view('frontend.seller.employer.offer_detail',compact('messages','offer'));
    }
    public function candidatesList($id){
        $messages = Message::where('offer_id',$id)->get();
        return view('frontend.seller.employer.candidate_list',compact('messages'));
    }

}
