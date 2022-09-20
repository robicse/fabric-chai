<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ReviewCollection;
use App\Http\Resources\SeeReviewCollection;
use App\Model\Product;
use App\Model\ProductBid;
use App\Model\Review;
use App\Http\Controllers\Controller;
use App\Model\SaleRecord;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        return new ReviewCollection(Review::where('receiver_user_id',Auth::id())->latest()->get());
    }
    public function seeReview($id){
        return new SeeReviewCollection(Review::where('receiver_user_id',$id)->latest()->get());
    }
    public function checkReview($id){
        $product_bid = ProductBid::find($id);
        $review_check = Review::where('sender_user_id',Auth::id())->where('product_id',$product_bid->product_id)->first();
        if (empty($review_check)){
            return response()->json(['success'=>true,'response' => 'Can review'], 201);
        }else{
            return response()->json(['success'=>false,'response'=>'Can not Review'], 401);
        }
    }
    public function reviewSubmit(Request $request, $id){
        $product_bid = ProductBid::find($id);
        $review_check = Review::where('sender_user_id',Auth::id())->where('product_id',$product_bid->product_id)->first();

        if (empty($review_check)){
            $review = new Review();
            $review->sender_user_id = Auth::id();
            if ($product_bid->product->user->user_type == Auth::user()->user_type){
                $review->receiver_user_id = $product_bid->sender_user_id;
            }else{
                $review->receiver_user_id = $product_bid->receiver_user_id;
            }
            $review->product_id = $product_bid->product_id;
            $review->rating = $request->rating;
            $review->comment = $request->comment;
            $review->save();

            if($review->save()){
                $product = Product::findOrFail($product_bid->product_id);
                if(count(Review::where('product_id', $product->id)->where('status', 1)->get()) > 0){
                    $product->rating = Review::where('product_id', $product->id)->where('status', 1)->sum('rating')/count(Review::where('product_id', $product->id)->where('status', 1)->get());
                }
                else {
                    $product->rating = 0;
                }
                $product->save();
            }
            return response()->json(['success'=>true,'response' => 'Review Submitted Successfully '], 201);

        }else{
            return response()->json(['success'=>false,'response'=>'You have already reviewed this bidder'], 401);
        }
    }
    public function reviewLists($id){
        return new ReviewCollection(Review::where('receiver_user_id',$id)->latest()->get());
    }
}
