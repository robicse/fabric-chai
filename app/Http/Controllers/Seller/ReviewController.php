<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Model\Review;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class
ReviewController extends Controller
{
    public function index(){
        $reviews = Review::where('receiver_user_id',Auth::id())->latest()->get();
        return view('frontend.seller.review.index',compact('reviews'));
    }
    public function getBiddersReview($id){
        $bidder = User::find($id);
        $reviews = Review::where('receiver_user_id',$id)->where('status',1)->latest()->get();
        return view('frontend.seller.review.bidder_review',compact('bidder','reviews'));
    }
}
