<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\StripePaymentController;
use App\Http\Resources\SellerRecordedTransactionCollection;
use App\Model\PaymentHistory;
use App\Model\SaleRecord;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller
{
    public function allSellRecord(){
        $saleRecords = SaleRecord::where('seller_user_id',Auth::id())->latest()->get();
        return new SellerRecordedTransactionCollection($saleRecords);
    }

    public function allSellRecordDetails(){
        $getTotalSaleAmount = getTotalSaleAmount(Auth::user()->id);
        $getTotalCommissionAmount = getTotalCommissionAmount(Auth::user()->id);
        $getTotalCommissionPaidAmount = getTotalCommissionPaidAmount(Auth::user()->id);

        $success['total_sale_amount_bdt'] =(string) getNumberToBangla($getTotalSaleAmount) ;
        $success['total_sale_amount_usd'] =(string) getNumberToBangla(convert_to_usd($getTotalSaleAmount));
        $success['total_sale_commission_amount_bdt'] =(string) getNumberToBangla($getTotalCommissionAmount);
        $success['total_sale_commission_amount_usd'] = (string) getNumberToBangla(convert_to_usd($getTotalCommissionAmount));
        $success['total_commission_paid_amount_bdt'] =(string) getNumberToBangla($getTotalCommissionPaidAmount);
        $success['total_commission_paid_amount_usd'] =(string) getNumberToBangla(convert_to_usd($getTotalCommissionPaidAmount));

        if ($success){
            return response()->json(['success'=>true,'response'=> $success], 200);
        }else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }

    }

    public function pay_now(Request $request){

        $sale_record_id = $request->sale_record_id;
        PaymentHistory::where('sale_record_id',$sale_record_id)
            ->where('payment_status','Pending')
            ->where('payment_type','!=','Cash')
            ->delete();

        if($request->payment_with == 'Pay Online'){

            if($request->payment_type == 'SSL Commerz') {
                if($request->amount < 10){
                    return response()->json(['success'=>false,'response'=> 'Minimum 10 amount commission need to pay SSL Commerz(BDT).'], 404);
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

                $insert_id = $payment_history->id;
                if ($insert_id){
                    return response()->json(['success'=>true,'response'=> ['payment_history_id'=>$insert_id]], 200);
                }else{
                    return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
                }

            }
            elseif($request->payment_type == 'Stripe') {

                if($request->amount < 1){
                    return response()->json(['success'=>false,'response'=> 'Minimum 1 dollar amount commission need to pay SSL Commerz(USD).'], 404);
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

                $insert_id = $payment_history->id;
                if ($insert_id){
                    return response()->json(['success'=>true,'response'=> ['payment_history_id'=>$insert_id]], 200);
                }else{
                    return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
                }
            }
        }else{
            if($request->description == NULL){
                return response()->json(['success'=>false,'response'=> 'Description must be needed. You can try again.'], 404);
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
            return response()->json(['success'=>true,'response'=>'Successfully Done'], 200);
        }
    }
}
