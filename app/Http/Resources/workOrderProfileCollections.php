<?php

namespace App\Http\Resources;

use App\Model\Seller;
use Illuminate\Http\Resources\Json\ResourceCollection;

class workOrderProfileCollections extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $days = \Carbon\Carbon::parse($data->created_at)->diffInDays(\Carbon\Carbon::now());
                $complete_bids = \App\Model\ProductBid::where('sender_user_id',$data->id)->where('bid_status',1)->count();
                $reviews = \App\Model\Review::where('receiver_user_id',$data->id)->count();

                if ($data->user_type == 'seller'){
                    $seller = Seller::where('user_id',$data->id)->first();
                    return [
                        //dd($data),
                        'id' => $data->id,
                        'referral_code' => $data->referral_code,
                        'user_type' => (string) 'receiver',
                        'employer_status' => (integer) $seller->employer_status,
                        'multiple_user_types' => $data->multiple_user_types,
                        'name' => (string) $data->name,
                        'email' => (string) $data->email,
                        'phone' => (string) $data->phone,
                        'country_code' => (string) $data->country_code,
                        'verification_code' => (integer) $data->country_code,
                        'avatar_original' => (string) $data->avatar_original,
                        'address' => (string) $data->address,
                        'banned' => (int) $data->banned,
                        'balance' => (double) $data->balance,
                        'membership_package_id' => (integer) $data->membership_package_id,
                        'membership_package_name' => $data->membershipPackage->package_name,
                        'membership_activation_date' => (string) $data->membership_activation_date,
                        'membership_expired_date' => (string) $data->membership_expired_date,
                        'remaining_uploads' => (string) $data->remaining_uploads,
                        'created_at' => (string) $data->remaining_uploads,
                        'updated_at' => (string) $data->remaining_uploads,
                        'experience' => (integer) $days,
                        'complete_bids' => (integer) $complete_bids,
                        'reviews' => (integer) $reviews,
                        'ratings' => (float) userRating($data->id),
                        'company_name' => (string) $seller->company_name,
                        'company_phone' => (string) $seller->company_phone,
                        'company_address' => (string) $seller->company_address,
                        'trade_licence' => (string) $seller->trade_licence,
                        'nid' => (string) $seller->nid,

                    ];
                }else{
                    return [
                        'id' => $data->id,
                        'referral_code' => $data->referral_code,
                        'user_type' => (string) 'provider',
                        'multiple_user_types' => $data->multiple_user_types,
                        'name' => (string) $data->name,
                        'email' => (string) $data->email,
                        'phone' => (string) $data->phone,
                        'country_code' => (string) $data->country_code,
                        'verification_code' => (integer) $data->country_code,
                        'avatar_original' => (string) $data->avatar_original,
                        'address' => (string) $data->address,
                        'banned' => (int) $data->banned,
                        'balance' => (double) $data->balance,
                        'membership_package_id' => (integer) $data->membership_package_id,
                        'membership_package_name' => $data->membershipPackage->package_name,
                        'membership_activation_date' => (string) $data->membership_activation_date,
                        'membership_expired_date' => (string) $data->membership_expired_date,
                        'remaining_uploads' => (string) $data->remaining_uploads,
                        'created_at' => (string) $data->remaining_uploads,
                        'updated_at' => (string) $data->remaining_uploads,
                        'experience' => (integer) $days,
                        'complete_bids' => (integer) $complete_bids,
                        'reviews' => (integer) $reviews,
                        'ratings' => (float) userRating($data->id),
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
