<?php

namespace App\Http\Controllers\Seller;

use App\Helpers\UserInfo;
use App\Http\Controllers\Controller;
use App\Http\Controllers\StripePaymentController;
use App\Model\PaymentHistory;
use App\Model\ProductBid;
use App\Model\SaleRecord;
use App\Model\Seller;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller
{
    public function index(){
        $seller = Seller::where('user_id',Auth::id())->first();
        $payment_history = PaymentHistory::where('user_id',Auth::id())->select(DB::raw('sum(amount) as total_paid'),DB::raw('sum(online_charge) as total_online_charge'))->first();
        $total_paid = $payment_history->total_paid;
        $total_paid_online_charge = $payment_history->total_online_charge;
        $final_paid_amount = $total_paid - $total_paid_online_charge;
        $totalSale = ProductBid::where('receiver_user_id',Auth::id())
            ->where('bid_status',1)
            ->sum('total_bid_price');
        $saleRecords = SaleRecord::where('seller_user_id',Auth::id())->latest()->get();
        return view('frontend.seller.account.index',compact('seller','totalSale','total_paid','total_paid_online_charge','final_paid_amount','saleRecords'));
    }
    public function commission_pay($id){
        $saleRecord = SaleRecord::find($id);
        return view('frontend.seller.account.commission_pay',compact('saleRecord'));
    }

    public function salesReportDetails(Request $request){
        $saleRecord = SaleRecord::find($request->id);
        return view('frontend.seller.account.sales_report_details_modal',compact('saleRecord'));
    }

    public function pay_now(Request $request){
        $sale_record_id = SaleRecord::where('invoice_code',$request->invoice_code)->pluck('id')->first();

        // previous middle data deleted
        PaymentHistory::where('sale_record_id',$sale_record_id)
            ->where('payment_status','Pending')
            ->where('payment_type','!=','Cash')
            ->delete();

        if($request->payment_with == 'Pay Online'){

            if($request->payment_type == 'SSL Commerz') {
                if (currency()->code != 'BDT') {
                    Toastr::warning('You first change to currency mode into BDT.');
                    return redirect()->back();
                }

                if($request->amount < 10){
                    Toastr::warning('Minimum 10 amount commission need to pay SSL Commerz(BDT).');
                    return redirect()->back();
                }

                $amount = $request->amount;
                $online_charge = online_charge($amount);
                $amount += $online_charge;

                $payment_history = new PaymentHistory();
                $payment_history->sale_record_id = $sale_record_id;
                $payment_history->invoice_code = date('Ymd-his');
                $payment_history->user_id = Auth::id();
                $payment_history->user_type = Auth::user()->user_type;
                $payment_history->amount = $amount;
                $payment_history->payment_status = 'Pending';
                $payment_history->payment_with = $request->payment_with;
                $payment_history->payment_type = $request->payment_type;
                $payment_history->online_charge = $online_charge;
                $payment_history->check_number = NULL;
                $payment_history->transaction_id = NULL;
                $payment_history->description = NULL;
                $payment_history->ssl_status = NULL;
                $payment_history->currency = 'BDT';
                $payment_history->amount_after_getaway_fee = NULL;
                $payment_history->payment_details = NULL;
                $payment_history->date = date('Y-m-d');
                $payment_history->save();

                Session::put('payment_history_id', $payment_history->id);
                Session::put('current_table_name','payment_histories');
                Session::put('user_type','seller');

                //return redirect()->route('pay2');
                return redirect()->route('ssl.pay');
            }
            elseif($request->payment_type == 'Stripe') {
                if (currency()->code == 'BDT') {
                    Toastr::warning('You first change to currency mode into USD.');
                    return redirect()->back();
                }

                if($request->amount < 1){
                    Toastr::warning('Minimum 1 dollar amount commission need to pay SSL Commerz(USD).');
                    return redirect()->back();
                }

                $amount = $request->amount;
                $online_charge = convert_price(online_charge($amount));
                $amount += $online_charge;
                $payment_history = new PaymentHistory();
                $payment_history->sale_record_id = $sale_record_id;
                $payment_history->invoice_code = date('Ymd-his');
                $payment_history->user_id = Auth::id();
                $payment_history->user_type = Auth::user()->user_type;
                $payment_history->amount = $amount;
                $payment_history->payment_status = 'Pending';
                $payment_history->payment_with = $request->payment_with;
                $payment_history->payment_type = $request->payment_type;
                $payment_history->online_charge = $online_charge;
                $payment_history->check_number = NULL;
                $payment_history->transaction_id = NULL;
                $payment_history->description = NULL;
                $payment_history->ssl_status = NULL;
                $payment_history->currency = 'USD';
                $payment_history->amount_after_getaway_fee = NULL;
                $payment_history->payment_details = NULL;
                $payment_history->date = date('Y-m-d');
                $payment_history->save();

                Session::put('payment_history_id', $payment_history->id);

                //return redirect()->route('stripe2');
                if ($request->session()->get('payment_history_id') != null) {
                    $stripe = new StripePaymentController;
                    return $stripe->stripe2();
                } else {
                    Toastr::warning('Something Went Wrong!');
                    return back();
                }
            }
        }else{
            if($request->description == NULL){
                Toastr::warning('Description must be needed. You can try again.');
                return redirect()->back();
            }
            if(currency()->code == 'BDT'){
                //$amount = single_price_without_symbol($request->amount);
                $amount = $request->amount;

            }else{
                $amount = convert_to_bdt($request->amount);
                $amount = number_format((float)$amount, 5, '.', '');
            }

            $payment_history = new PaymentHistory();
            $payment_history->sale_record_id = $sale_record_id;
            $payment_history->invoice_code = date('Ymd-his');
            $payment_history->user_id=Auth::id();
            $payment_history->user_type=Auth::user()->user_type;
            $payment_history->amount=$amount;
            $payment_history->payment_status='Partial Paid';
            $payment_history->payment_with=$request->payment_with;
            $payment_history->payment_type=$request->payment_type;
            $payment_history->bank_name=$request->bank_name ? $request->bank_name : NULL;
            $payment_history->check_number=$request->check_number ? $request->check_number : NULL;
            $payment_history->dispatch_date=$request->dispatch_date ? $request->dispatch_date : NULL;
            $payment_history->description=$request->description ? $request->description : NULL;
            $payment_history->transaction_id=NULL;
            $payment_history->ssl_status=NULL;
            $payment_history->currency=currency()->code;
            $payment_history->amount_after_getaway_fee=NULL;
            $payment_history->payment_details=NULL;
            $payment_history->date=date('Y-m-d');
            $insert_id = $payment_history->save();
            if($insert_id){
                $sale_recode = SaleRecord::where('invoice_code',$request->invoice_code)->first();
                $sale_recode->payment_status = 'Partial Paid';
                $sale_recode->save();

                $user = User::where('id',Auth::id())->first();
                $title = 'Payment';
                $message = 'Dear, '. $user->name .' payment '. $amount .' tk with '.$request->payment_type;
                createNotification($user->id,$title,$message);
                // admin sms
//                UserInfo::smsAPI('8801725930131', $message);
            }

            Toastr::success('Successfully Done');
            return redirect()->back();
        }
    }

    public function paymentTransactionList(){
        $transaction_reports = PaymentHistory::where('user_id', Auth::user()->id)->get();
        return view('frontend.seller.account.transaction_report',compact('transaction_reports'));
    }
}
