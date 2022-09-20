<?php

namespace App\Http\Resources;

use App\Model\Product;
use App\Model\Review;
use App\Model\Shop;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class AcceptedBiddersDetailsCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {

                $product = Product::find($data->product_id);
                if ($product->user_type == 'seller'){
                    $days = \Carbon\Carbon::parse($data->receiver->created_at)->diffInDays(\Carbon\Carbon::now());
                    $complete_bids = \App\Model\ProductBid::where('receiver_user_id',$data->receiver->id)->where('bid_status',1)->count();
                    $reviews = \App\Model\Review::where('receiver_user_id',$data->receiver->id)->count();
//                return $data->product->user_type;
                    $review_check = Review::where('product_id',$data->product_id)->where('sender_user_id',Auth::id())->first();
                    if (!empty($review_check)){
                        $review_status = 'is_reviewed';
                    }else{
                        $review_status = 'not_reviewed';
                    }
                    return [
                        'bidder_info' => [
                            'experience' => (string) getNumberToBangla($days),
                            'complete_bids' =>(string) getNumberToBangla($complete_bids),
                            'review' =>(string)  getNumberToBangla($reviews),
                            'ratings' =>(string) getNumberToBangla(userRating($data->receiver->id)),
                            'name' => getNameByBnEn($data->receiver),
                            'address' => $data->receiver->address,
                            'phone' => $data->receiver->country_code.$data->receiver->phone,
                            'review_status' =>(string) $review_status,
                        ],
                        'links' => [
                            'see_review' => route('see-review', $data->sender->id),
                            'for_review' => route('for-review', $data->id),
                        ]
                    ];
                }else{
                    $days = \Carbon\Carbon::parse($data->sender->created_at)->diffInDays(\Carbon\Carbon::now());
                    $complete_bids = \App\Model\ProductBid::where('sender_user_id',$data->sender->id)->where('bid_status',1)->count();
                    $reviews = \App\Model\Review::where('receiver_user_id',$data->sender->id)->count();
//                return $data->product->user_type;
                    $review_check = Review::where('product_id',$data->product_id)->where('sender_user_id',Auth::id())->first();
                    if (!empty($review_check)){
                        $review_status = 'is_reviewed';
                    }else{
                        $review_status = 'not_reviewed';
                    }
                    return [
                        'bidder_info' => [
                            'experience' =>(string) getNumberToBangla($days),
                            'complete_bids' =>(string) getNumberToBangla($complete_bids),
                            'review' =>(string) getNumberToBangla($reviews),
                            'ratings' =>(string) getNumberToBangla(userRating($data->receiver->id)),
                            'name' =>(string) getNameByBnEn($data->receiver),
                            'phone' =>(string) $data->sender->country_code.$data->sender->phone,
                            'company_name' =>(string) $data->sender->seller->company_name,
                            'company_address' =>(string) $data->sender->seller->company_address,
                            'company_phone' =>(string) $data->sender->seller->company_phone,
                            'review_status' =>(string) $review_status,
                        ],
                        'links' => [
                            'see_review' => route('see-review', $data->sender->id),
                            'for_review' => route('for-review', $data->id),
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
