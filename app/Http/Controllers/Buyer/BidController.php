<?php

namespace App\Http\Controllers\Buyer;

use App\Helpers\UserInfo;
use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\ProductBid;
use App\Model\Review;
use App\Model\SaleRecord;
use App\Model\Seller;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BidController extends Controller
{
    public function index(){
        return view('frontend.buyer.product_bids.index');
    }
    public function acceptedBidList(){
        $product_bids = ProductBid::where('sender_user_id',Auth::id())->where('bid_status',1)->latest()->get();
        return view('frontend.buyer.product_bids.accepted_bid_list',compact('product_bids'));
    }
    public function getAcceptedSellerDetails($id){
        $product_bid = ProductBid::find($id);
        $seller = User::where('id',$product_bid->receiver_user_id)->first();
        return view('frontend.buyer.product_bids.accepted_seller_details',compact('product_bid','seller'));
    }
    public function saleRecordStore(Request $request){
        $product_bid = ProductBid::find($request->product_bid_id);
        $saleRecord = SaleRecord::where('product_bid_id',$product_bid->id)->first();
        $review_check = Review::where('sender_user_id',Auth::id())->where('product_id',$product_bid->product_id)->first();
        if (empty($review_check)){
            $review = new Review();
            $review->sender_user_id = Auth::id();
            $review->receiver_user_id = $saleRecord->seller_user_id;
            $review->product_id = $product_bid->product_id;
            $review->rating = $request->rating;
            $review->comment = $request->comment;
            $review->save();
            $review->viewed = '0';

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

            Toastr::success('Successfully received sales record.');
            if($saleRecord->type == 'seller_product'){
                return redirect()->route('buyer.recorded-transaction.list');
            } else{
                return redirect()->route('buyer.requested-recorded-transaction.list');
            }
        }else{
            Toastr::error('You have already reviewed this seller');
            return redirect()->back();
        }

    }
    public function getBidderList($slug){
        $product = Product::where('slug',$slug)->first();
        $product_bids = ProductBid::where('product_id',$product->id)->latest()->get();
        return view('frontend.buyer.product_bids.bidder_list',compact('product_bids'));
    }
    public function getBidderDetails($id){
        $product_bid = ProductBid::find($id);
        $bidder = User::where('id',$product_bid->sender_user_id)->first();
        return view('frontend.buyer.product_bids.bidder_details',compact('product_bid','bidder'));
    }
    public function bidAccept($id){

        $get_invoice_code = SaleRecord::orderBy('created_at','DESC')->first();;
        if(!empty($get_invoice_code)){
            $invoice_no = "FLL".date('Y')."-".str_pad($get_invoice_code->id + 1, 8, "0", STR_PAD_LEFT);;
        }else{
            $invoice_no = "FLL".date('Y')."-"."00000001";
        }

        $product_bid = ProductBid::find($id);
        $product_bid->bid_status = 1;

        $product = Product::where('id',$product_bid->product_id)->first();
        $product->bid_status = 'Accepted';
        $product->save();

        $seller = Seller::where('user_id',$product_bid->sender_user_id)->first();
        $commission = ($product_bid->total_bid_price * sellerCurrentCommission($product_bid->sender_user_id))/100;
        $vat = vat($commission);
        $admin_commission = $commission + $vat;
        $seller->pay_to_admin += $admin_commission;
        $seller->save();
        $product_bid->save();

        $saleRecord = new SaleRecord();
        $saleRecord->buyer_user_id = Auth::id();
        if($product_bid->receiver_user_id == Auth::id()){
            $saleRecord->seller_user_id = $product_bid->sender_user_id;
            $saleRecord->type = 'requested_product';
        } else{
            $saleRecord->seller_user_id = $product_bid->sender_user_id;
            $saleRecord->type = 'seller_product';
        }

        $commission = ($product_bid->total_bid_price * sellerCurrentCommission($product_bid->sender_user_id))/100;
        $vat = vat($commission);
        $admin_commission = $commission + $vat;

        $saleRecord->product_id = $product_bid->product_id;
        $saleRecord->product_bid_id = $product_bid->id;
        $saleRecord->membership_package_id = checkMembershipStatus($product_bid->receiver_user_id);
        $saleRecord->amount = $product_bid->total_bid_price;
        $saleRecord->commission = $commission;
        $saleRecord->vat_percentage = \App\Model\Vat::first()->vat_percentage;
        $saleRecord->vat = $vat;
        $saleRecord->admin_commission = $admin_commission;
        $saleRecord->payment_status = 'Pending';
//        $saleRecord->sale_status = $request->sale_status;
        $saleRecord->buy_status = 0;
        $saleRecord->invoice_code = $invoice_no;
        $saleRecord->save();

        $user = User::where('id',$product_bid->receiver_user_id)->first();
        $title = 'Accepted Bid';
        $message = 'Dear '. $user->name .', your bid for '.$product->name.' has been accepted ';
        createNotification($seller->user_id,$title,$message);

        if($user->country_code == '+880') {
            UserInfo::smsAPI('880' . $seller->phone, $message);
            SmsNotification($user->id,$title,$message);
        }

        //Bid Reject........
        $productBidRejects = ProductBid::where('product_id',$product->id)->where('bid_status',0)->get();
        foreach ($productBidRejects as $productBidReject){
            $title = 'Bid Rejected';
            $message = 'Dear,'. $productBidReject->sender->name .' your bid for "'. $product->name .'" product has been rejected.';
            createNotification($productBidReject->sender_user_id,$title,$message);
            if($user->country_code == '+880') {
                UserInfo::smsAPI('880' . $productBidReject->sender->phone, $message);
                SmsNotification($productBidReject->sender_user_id,$title,$message);
            }
        }

        Toastr::success('Bidder Accepted Successfully');
        return redirect()->route('buyer.accepted-bid-request.list');
    }
    public function acceptedBidRequest(){
        $product_bids = ProductBid::where('receiver_user_id',Auth::id())->where('bid_status',1)->latest()->get();
        return view('frontend.buyer.product_bids.accepted_bid_requests',compact('product_bids'));
    }
    public function getRequestedSellerDetails($id){
        $product_bid = ProductBid::find($id);
        $seller = User::where('id',$product_bid->sender_user_id)->first();
        return view('frontend.buyer.product_bids.accepted_seller_details',compact('product_bid','seller'));
    }


}
