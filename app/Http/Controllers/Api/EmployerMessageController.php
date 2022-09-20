<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\StripePaymentController;
use App\Http\Resources\EmployerOfferCollection;
use App\Http\Resources\EmployerOfferDetailCollection;
use App\Model\Message;
use App\Model\SmsCostPaymentHistory;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class EmployerMessageController extends Controller
{
    public $successStatus = 201;
    public $failStatus = 401;

    public function messageLogList(){
        $messages = Message::where('sender_user_id',Auth::user()->id)->where('offer_id','!=',null)->get();
        return new EmployerOfferCollection($messages);
    }
    public function messagePaymentHistory(){
        $user_id = User::where('id',Auth::id())->pluck('id')->first();
        $per_sms_cost = \App\Model\MessageCharge::pluck('cost_per_sms')->first();
        $total_paid_sms_cost = totalSMSSend($user_id) > totalFreeSMS($user_id) ? totalSMSSend($user_id) > totalFreeSMS($user_id) : 0 * $per_sms_cost;
        $due_total_sms_cost = $total_paid_sms_cost - checkTotalSmsCostSentAmount($user_id);
        $paid_sms_used =totalSMSSend($user_id) > totalFreeSMS($user_id) ? totalSMSSend($user_id) > totalFreeSMS($user_id) : 0;
//        $sale_amount_usd = convert_to_usd($data->amount);
        $success['total_free_sms'] =(string) getNumberToBangla(totalFreeSMS($user_id));
        $success['total_sms_send'] =(string) getNumberToBangla(totalSMSSend($user_id)) ;
        $success['remaining_free_sms'] = (string)getNumberToBangla(totalFreeSMS($user_id) - totalSMSSend($user_id)) ;
        $success['paid_sms_used'] =(string) getNumberToBangla($paid_sms_used) ;
        $success['per_paid_sms_cost_bdt'] =(string) getNumberToBangla($per_sms_cost) ;
        $success['per_paid_sms_cost_usd'] =(string) getNumberToBangla(convert_to_usd($per_sms_cost)) ;
        $success['total_paid_sms_cost_bdt'] =(string) getNumberToBangla($total_paid_sms_cost) ;
        $success['total_paid_sms_cost_usd'] =(string) getNumberToBangla(convert_to_usd($total_paid_sms_cost));
        $success['payment_done_bdt'] =(string) getNumberToBangla(checkTotalSmsCostSentAmount($user_id) ? checkTotalSmsCostSentAmount($user_id) : 0 ) ;
        $success['payment_done_usd'] =(string) getNumberToBangla(convert_to_usd(checkTotalSmsCostSentAmount($user_id)) ? convert_to_usd(checkTotalSmsCostSentAmount($user_id)) : 0);
        $success['due_sms_cost_bdt'] = (string) getNumberToBangla($due_total_sms_cost) ;
        $success['due_sms_cost_usd'] =(string) getNumberToBangla(convert_to_usd($due_total_sms_cost)) ;
        return response()->json(['success'=>true,'response'=> $success], 200);
    }
    public function pay_now_sms_cost(Request $request){
        if($request->payment_with == 'Pay Online'){

            if($request->payment_type == 'SSL Commerz') {

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
                $insert_id = $sms_cost_payment_history->id;
                if ($insert_id){
                    return response()->json(['success'=>true,'response'=> ['payment_history_id'=>$insert_id]], 200);
                }else{
                    return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
                }

//                Session::put('sms_cost_payment_history_id', $sms_cost_payment_history->id);
//                Session::put('current_table_name','sms_cost_payment_histories');
//                Session::put('user_type','seller');

//                return redirect()->route('pay');
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
                $insert_id = $sms_cost_payment_history->id;
                if ($insert_id){
                    return response()->json(['success'=>true,'response'=> ['payment_history_id'=>$insert_id]], 200);
                }else{
                    return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
                }

//                Session::put('sms_cost_payment_history_id', $sms_cost_payment_history->id);
//                Session::put('current_table_name','sms_cost_payment_histories');

                //return redirect()->route('stripe2');
//                if ($request->session()->get('sms_cost_payment_history_id') != null) {
//                    $stripe = new StripePaymentController;
//                    return $stripe->stripe3();
//                } else {
//                    Toastr::warning('Something Went Wrong!');
//                    return back();
//                }
            }
        }elseif ($request->payment_with == 'Pay Offline'){
            if($request->description == NULL){
                return response()->json(['success'=>false,'response'=> 'Description must be needed. You can try again.'], 404);
            }
            if(currency()->code == 'BDT'){
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
            return response()->json(['success'=>true,'response'=> 'Successfully Done'], 200);
//            Toastr::success('Successfully Done');
//            return redirect()->back();
        }
    }
}
