<?php

namespace App\Http\Controllers\Api;

use App\Helpers\UserInfo;
use App\Http\Controllers\Controller;
use App\Http\Resources\AcceptedBiddersDetailsCollection;
use App\Http\Resources\AcceptedBidRequestCollection;
use App\Http\Resources\AcceptedBidRequestedCollection22;
use App\Http\Resources\AcceptedBuyerDetailsCollection;
use App\Http\Resources\BidderDetailsCollection;
use App\Http\Resources\BidderListCollection;
use App\Http\Resources\BuyerRecordedTransactionCollection;
use App\Http\Resources\ProductBidCollection;
use App\Http\Resources\ProductMyBidCollection;
use App\Http\Resources\ProductsListCollection;
use App\Http\Resources\SellerRecordedTransactionCollection;
use App\Http\Resources\TransactionListCollection;
use App\Model\PaymentHistory;
use App\Model\Product;
use App\Model\ProductBid;
use App\Model\SaleRecord;
use App\Model\Seller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductBidController extends Controller
{
    public function productBidSubmit(Request $request){
        $product = Product::find($request->product_id);
        $bidCheck = ProductBid::where('product_id',$product->id)->where('sender_user_id',Auth::id())->first();

        $membership_package_id = checkMembershipStatus(Auth::id());
        $user_type = checkUserType(Auth::id());
        if($user_type == 'seller' && $membership_package_id == 1){
            return response()->json(['success'=>false,'response'=>'Upgrade your membership package!'], 401);
        }
        if($request->currency_id != 27){
            $bid_price = convert_to_bdt($request->unit_bid_price);
        }else{
            $bid_price = $request->unit_bid_price;
        }
        if (empty($bidCheck)){
            $productBid = new ProductBid();
            $productBid->sender_user_id = Auth::id();
            $productBid->receiver_user_id = $product->user_id;
            $productBid->product_id = $request->product_id;
            $productBid->unit_bid_price = $bid_price;
            $productBid->total_bid_price = $bid_price * $product->quantity;
            $productBid->bid_status = 0;
            $productBid->save();
            $bidder = User::where('id',$productBid->sender_user_id )->first();

            $user = User::where('id',$productBid->receiver_user_id )->first();

            //$productOwnerInfo = productOwnerInfo($request->product_id);
            $title = 'Placed Bid';
            $message = 'Dear '.$user->name.', your product "'.$product->name.'" has been bidden by '.$bidder->name.' with '.$productBid->unit_bid_price.currency()->symbol.' unit bid amount';
            placedBidNotification($product->id,$product->user->id,$title,$message);
            if($user->country_code == '+880') {
                UserInfo::smsAPI('880'.$user->phone, $message);
                SmsNotification($user->id,$title,$message);
            }

            if(!empty($productBid))
            {
                return response()->json(['success'=>true,'response' => 'Your bid placed successfully '], 201);
            }else{
                return response()->json(['success'=>false,'response'=>'Something went wrong'], 401);
            }


        }else{
            return response()->json(['success'=>false,'response'=>'You have already bidden for this products.'], 401);
        }

    }
    public function bidderList($id){
        $product_bids = ProductBid::where('receiver_user_id',Auth::id())->where('product_id',$id)->get();
        return new BidderListCollection($product_bids);

    }
    public function getBidderDetails($id){
        $product_bid = ProductBid::where('id',$id)->get();
        return new BidderDetailsCollection($product_bid);

    }
    public function sellerAcceptedBids(){
        $accepted_bids = ProductBid::where('receiver_user_id',Auth::id())->where('bid_status',1)->latest()->get();
        return new ProductBidCollection($accepted_bids);
    }
    public function AcceptedBidderDetails($id){

        return new AcceptedBiddersDetailsCollection(ProductBid::where('id',$id)->get());
    }
    public function AcceptedBuyerDetails($id){
        return new AcceptedBuyerDetailsCollection(ProductBid::where('id',$id)->get());
    }
    public function buyerAcceptedBids(){
        $accepted_bids = ProductBid::where('sender_user_id',Auth::id())->where('bid_status',1)->latest()->get();
        return new ProductBidCollection($accepted_bids);
    }
    public function sellerMyBids(){
        $my_bids = ProductBid::where('sender_user_id',Auth::id())->latest()->get();
        return new ProductMyBidCollection($my_bids);
    }
    public function buyerMyBids(){
        $my_bids = ProductBid::where('sender_user_id',Auth::id())->latest()->get();
        return new ProductMyBidCollection($my_bids);
    }

    public function buyerRecordedTransaction(){
        $saleRecords = SaleRecord::where('buyer_user_id',Auth::id())->where('type','seller_product')->latest()->get();
        return new BuyerRecordedTransactionCollection($saleRecords);
    }
    public function sellerRecordedTransaction(){
        $saleRecords = SaleRecord::where('seller_user_id',Auth::id())->where('type','seller_product')->latest()->get();
        return new SellerRecordedTransactionCollection($saleRecords);
    }

    public function bidAccept($id){
        $check = ProductBid::where('id',$id)->where('bid_status',1)->first();
        if (empty(!$check)){
            return response()->json(['success'=>false,'response'=>'You have already bidden for this product'], 401);
        }
        $get_invoice_code = SaleRecord::orderBy('created_at','DESC')->first();;
        if(!empty($get_invoice_code)){
            $invoice_no = "FLL".date('Y')."-".str_pad($get_invoice_code->id + 1, 8, "0", STR_PAD_LEFT);;
        }else{
            $invoice_no = "FLL".date('Y')."-"."00000001";
        }
        $product_bid = ProductBid::find($id);
        $product_bid->bid_status = 1;

        if (Auth::user()->user_type == 'seller'){
            $seller = Seller::where('user_id',$product_bid->receiver_user_id)->first();
            $commission = ($product_bid->total_bid_price * sellerCurrentCommission($product_bid->receiver_user_id))/100;
            $vat = vat($commission);
            $admin_commission = $commission + $vat;

            $seller->pay_to_admin += $admin_commission;
            $seller->save();
            $product_bid->save();

            $saleRecord = new SaleRecord();
            $saleRecord->seller_user_id = Auth::id();
            if($product_bid->receiver_user_id == Auth::id()){
                $saleRecord->buyer_user_id = $product_bid->sender_user_id;
                $saleRecord->type = 'seller_product';
            } else{
                $saleRecord->buyer_user_id = $product_bid->receiver_user_id;
                $saleRecord->type = 'requested_product';
            }

            $commission = ($product_bid->total_bid_price * sellerCurrentCommission($product_bid->receiver_user_id))/100;
            $vat = vat($commission);
            $admin_commission = $commission + $vat;
            $saleRecord->product_id = $product_bid->product_id;
            $saleRecord->product_bid_id = $product_bid->id;
            $saleRecord->membership_package_id = checkMembershipStatus(Auth::id());
            $saleRecord->amount = $product_bid->total_bid_price;
            $saleRecord->commission = $commission;
            $saleRecord->vat_percentage = \App\Model\Vat::first()->vat_percentage;
            $saleRecord->vat = $vat;
            $saleRecord->admin_commission = $admin_commission;
            $saleRecord->payment_status = 'Pending';
            $saleRecord->buy_status = 0;
            $saleRecord->invoice_code = $invoice_no;
            $saleRecord->save();

            $user = User::where('id',$product_bid->sender_user_id)->first();
            $title = 'Accepted Bid';
            $message = 'Dear'. $user->name .', your bid for "'. $product_bid->product->name .'" product has been accepted.';
            createNotification($user->id,$title,$message);
            //UserInfo::smsAPI("0".$user->phone,$message);
            if($user->country_code == '+880') {
                UserInfo::smsAPI('880' . $user->phone, $message);
                SmsNotification($user->id,$title,$message);
            }


            //Bid Reject.............
            $product = Product::find($product_bid->product_id);
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

        }else{
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
            $saleRecord->buy_status = 0;
            $saleRecord->invoice_code = $invoice_no;
            $saleRecord->save();

            $user = User::where('id',$product_bid->receiver_user_id)->first();
            $title = 'Accepted Bid';
            $message = 'Dear'. $user->name .', your bid for "'. $product_bid->product->name .'" product has been accepted.';
            createNotification($seller->user_id,$title,$message);
            //UserInfo::smsAPI("0".$user->phone,$message);
            if($user->country_code == '+880') {
                UserInfo::smsAPI('880' . $seller->user->phone, $message);
                SmsNotification($user->id,$title,$message);
            }
            //Bid Reject.............
            $product = Product::find($product_bid->product_id);
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
        }


        $product = Product::find($product_bid->product_id);
        $product->bid_status = 'Accepted';
        $product->save();

        if(!empty($saleRecord))
        {
            return response()->json(['success'=>true,'response' => 'Bid Accepted Successfully'], 201);
        }else{
            return response()->json(['success'=>false,'response'=>'Something went wrong'], 401);
        }
    }

    public function sellerTransactionList(){
        $transaction_reports = PaymentHistory::where('user_id', Auth::user()->id)->get();
        return new TransactionListCollection($transaction_reports);
    }
    public function sellerAcceptedBidRequests(){
        $product_bids = ProductBid::where('sender_user_id',Auth::user()->id)->where('bid_status',1)->latest()->get();
        return new AcceptedBidRequestCollection($product_bids);
    }
    public function buyerAcceptedBidRequests(){
        $product_bids = ProductBid::where('receiver_user_id',Auth::id())->where('bid_status',1)->latest()->get();
        return new AcceptedBidRequestCollection($product_bids);
    }
    public function buyerRequestedRecordedTransaction(){
        $saleRecords = SaleRecord::where('buyer_user_id',Auth::id())->where('type','requested_product')->latest()->get();
        return new BuyerRecordedTransactionCollection($saleRecords);
    }
    public function sellerRequestedRecordedTransaction(){
        $saleRecords = SaleRecord::where('seller_user_id',Auth::id())->where('type','requested_product')->latest()->get();
        return new SellerRecordedTransactionCollection($saleRecords);
    }
}
