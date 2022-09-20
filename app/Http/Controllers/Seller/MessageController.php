<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Controllers\StripePaymentController;
use App\Model\PaymentHistory;
use App\Model\SaleRecord;
use App\Model\Shortlist;
use App\Model\Message;
use App\Model\SmsCostPaymentHistory;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MessageController extends Controller
{
    public function index(){
        $seller_id = Auth::user()->id;
        $messages = Message::where('offer_id','!=',null)->where('sender_user_id',Auth::user()->id)->latest()->get();
//        dd($messages);
        return view('frontend.seller.employer.message',compact('messages','seller_id'));
    }

    public function pay_now_sms_cost(Request $request){
        if($request->payment_with == 'Pay Online'){

            if($request->payment_type == 'SSL Commerz') {
                if (currency()->code != 'BDT') {
                    Toastr::warning('You first change to currency mode into BDT.');
                    return redirect()->back();
                }

                $due_amount = $request->due_amount;
                $online_charge = online_charge($due_amount);
                $due_amount += $online_charge;

                $sms_cost_payment_history = new SmsCostPaymentHistory();
                $sms_cost_payment_history->invoice_code = date('Ymd-his');
                $sms_cost_payment_history->user_id = Auth::id();
                $sms_cost_payment_history->user_type = Auth::user()->user_type;
                $sms_cost_payment_history->due_amount = 0;
                $sms_cost_payment_history->amount = $due_amount;
                $sms_cost_payment_history->payment_status = 'Pending';
                $sms_cost_payment_history->payment_with = $request->payment_with;
                $sms_cost_payment_history->payment_type = $request->payment_type;
                $sms_cost_payment_history->online_charge = $online_charge;
                $sms_cost_payment_history->check_number = NULL;
                $sms_cost_payment_history->transaction_id = NULL;
                $sms_cost_payment_history->description = NULL;
                $sms_cost_payment_history->ssl_status = NULL;
                $sms_cost_payment_history->currency = 'BDT';
                $sms_cost_payment_history->amount_after_getaway_fee = NULL;
                $sms_cost_payment_history->payment_details = NULL;
                $sms_cost_payment_history->date = date('Y-m-d');
                $sms_cost_payment_history->save();

                Session::put('sms_cost_payment_history_id', $sms_cost_payment_history->id);
                Session::put('current_table_name','sms_cost_payment_histories');
                Session::put('user_type','seller');

                //return redirect()->route('pay2');
                return redirect()->route('pay');
            }
            elseif($request->payment_type == 'Stripe') {
                if (currency()->code == 'BDT') {
                    Toastr::warning('You first change to currency mode into USD.');
                    return redirect()->back();
                }
                $due_amount = $request->due_amount;
                $online_charge = convert_price(online_charge($due_amount));
                $due_amount += $online_charge;
                $sms_cost_payment_history = new SmsCostPaymentHistory();
                $sms_cost_payment_history->invoice_code = date('Ymd-his');
                $sms_cost_payment_history->user_id = Auth::id();
                $sms_cost_payment_history->user_type = Auth::user()->user_type;
                $sms_cost_payment_history->due_amount = 0;
                $sms_cost_payment_history->amount = $due_amount;
                $sms_cost_payment_history->payment_status = 'Pending';
                $sms_cost_payment_history->payment_with = $request->payment_with;
                $sms_cost_payment_history->payment_type = $request->payment_type;
                $sms_cost_payment_history->online_charge = $online_charge;
                $sms_cost_payment_history->check_number = NULL;
                $sms_cost_payment_history->transaction_id = NULL;
                $sms_cost_payment_history->description = NULL;
                $sms_cost_payment_history->ssl_status = NULL;
                $sms_cost_payment_history->currency = 'USD';
                $sms_cost_payment_history->amount_after_getaway_fee = NULL;
                $sms_cost_payment_history->payment_details = NULL;
                $sms_cost_payment_history->date = date('Y-m-d');
                $sms_cost_payment_history->save();

                Session::put('sms_cost_payment_history_id', $sms_cost_payment_history->id);
                Session::put('current_table_name','sms_cost_payment_histories');

                //return redirect()->route('stripe2');
                if ($request->session()->get('sms_cost_payment_history_id') != null) {
                    $stripe = new StripePaymentController;
                    return $stripe->stripe3();
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
                $due_amount = $request->due_amount;

            }else{
                $due_amount = convert_to_bdt($request->due_amount);
                $due_amount = number_format((float)$due_amount, 5, '.', '');
            }

            $sms_cost_payment_history = new SmsCostPaymentHistory();
            $sms_cost_payment_history->invoice_code = date('Ymd-his');
            $sms_cost_payment_history->user_id = Auth::id();
            $sms_cost_payment_history->user_type = Auth::user()->user_type;
            $sms_cost_payment_history->due_amount = 0;
            $sms_cost_payment_history->amount=$due_amount;
            $sms_cost_payment_history->payment_status='Partial Paid';
            $sms_cost_payment_history->payment_with=$request->payment_with;
            $sms_cost_payment_history->payment_type=$request->payment_type;
            $sms_cost_payment_history->bank_name=$request->bank_name ? $request->bank_name : NULL;
            $sms_cost_payment_history->check_number=$request->check_number ? $request->check_number : NULL;
            $sms_cost_payment_history->dispatch_date=$request->dispatch_date ? $request->dispatch_date : NULL;
            $sms_cost_payment_history->description=$request->description ? $request->description : NULL;
            $sms_cost_payment_history->transaction_id=NULL;
            $sms_cost_payment_history->ssl_status=NULL;
            $sms_cost_payment_history->currency=currency()->code;
            $sms_cost_payment_history->amount_after_getaway_fee = NULL;
            $sms_cost_payment_history->payment_details = NULL;
            $sms_cost_payment_history->date = date('Y-m-d');
            $insert_id = $sms_cost_payment_history->save();
            if($insert_id){
                $user = User::where('id',Auth::id())->first();
                $title = 'Payment';
                $message = 'Dear, '. $user->name .' payment '. $due_amount .' tk with '.$request->payment_type;
                createNotification($user->id,$title,$message);
                // admin sms
//                UserInfo::smsAPI('8801725930131', $message);
            }

            Toastr::success('Successfully Done');
            return redirect()->back();
        }
    }

}
