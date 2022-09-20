<?php

namespace App\Http\Resources;

use App\Model\Review;
use App\Model\Shop;
use App\User;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class WorkOrderAcceptedBuyerDetailsCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [

            'data' => $this->collection->map(function($data) {
                if ($data->receiver_user_id != Auth::id()){
                    $buyer = User::where('id',$data->receiver_user_id)->first();
                    $days = \Carbon\Carbon::parse($buyer->created_at)->diffInDays(\Carbon\Carbon::now());
                    $complete_bids = \App\Model\WorkOrderBid::where('receiver_user_id',$buyer->id)->where('bid_status',1)->count();
                    $reviews = \App\Model\WorkOrderReview::where('receiver_user_id',$buyer->id)->count();
                    $review_check = Review::where('product_id',$data->product_id)->where('sender_user_id',Auth::id())->first();
                    if (!empty($review_check)){
                        $review_status = 'is_reviewed';
                    }else{
                        $review_status = 'not_reviewed';
                    }
                    return [
                        'bidder_info' => [
                            'experience' => $days,
                            'complete_bids' => $complete_bids,
                            'review' => $reviews,
                            'ratings' =>(float) userWorkOrderRating($buyer->id),
                            'name' => $buyer->name,
                            'address' => $buyer->address,
                            'phone' => $buyer->country_code.$buyer->phone,
                            'review_status' =>(string) $review_status,
                        ],
                        'links' => [
//                            'see_review' => route('see-review', $buyer->id),
//                            'for_review' => route('for-review', $data->id),
                        ]
                    ];
                }else{
                    $buyer = User::where('id',$data->sender_user_id)->first();
                    $days = \Carbon\Carbon::parse($buyer->created_at)->diffInDays(\Carbon\Carbon::now());
                    $complete_bids = \App\Model\WorkOrderBid::where('receiver_user_id',$buyer->id)->where('bid_status',1)->count();
                    $reviews = \App\Model\WorkOrderReview::where('receiver_user_id',$buyer->id)->count();
                    $review_check = Review::where('product_id',$data->product_id)->where('sender_user_id',Auth::id())->first();
                    if (!empty($review_check)){
                        $review_status = 'is_reviewed';
                    }else{
                        $review_status = 'not_reviewed';
                    }
                    return [
                        'bidder_info' => [
                            'experience' => $days,
                            'complete_bids' => $complete_bids,
                            'review' => $reviews,
                            'ratings' =>(float) userWorkOrderRating($buyer->id),
                            'name' => $buyer->name,
                            'address' => $buyer->address,
                            'phone' => $buyer->country_code.$buyer->phone,
                            'review_status' =>(string) $review_status,
                        ],
                        'links' => [
//                            'see_review' => route('see-review', $buyer->id),
//                            'for_review' => route('for-review', $data->id),
                        ]
                    ];
                }

            })
        ];

    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
}
