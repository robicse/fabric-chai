<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\MembershipPackage;
use App\Model\PaymentHistory;
use App\Model\SaleRecord;
use App\Model\UserMembershipPackage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function iosMembershipPackagePayment(Request $request){
        UserMembershipPackage::where('payment_status','Pending')
            ->where('user_id',Auth::id())
            ->where('user_type',Auth::user()->user_type)
            ->delete();

        $membership_package = MembershipPackage::find($request->package_id);

        $user_membership_package = new UserMembershipPackage();
        $user_membership_package->user_id = Auth::user()->id;
        $user_membership_package->membership_package_id = $request->package_id;
        $user_membership_package->invoice_no = '';
        $user_membership_package->membership_activation_date = date('Y-m-d');
        $user_membership_package->membership_expired_date = date('Y-m-d', strtotime('+1 year'));;
        $user_membership_package->payment_status = 'Paid';
        $user_membership_package->amount = $membership_package->price + vat($membership_package->price);
        $user_membership_package->payment_type = 'apple pay';
        $user_membership_package->save();
        $insert_id = $user_membership_package->id;
        if ($insert_id){
            return response()->json(['success'=>true,'response'=> ['Payment Successful']], 200);
        }else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function iosCommissionPayment(Request $request){
        $sale_record_id = $request->sale_record_id;
        PaymentHistory::where('sale_record_id',$sale_record_id)
            ->where('payment_status','Pending')
            ->where('payment_type','!=','Cash')
            ->delete();

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
        $payment_history->payment_with = 'Pay Online';
        $payment_history->payment_type = 'apple pay';
        $payment_history->online_charge = null;
        $payment_history->check_number = NULL;
        $payment_history->transaction_id = NULL;
        $payment_history->description = NULL;
        $payment_history->ssl_status = 'Completed';
        $payment_history->currency = 'BDT';
        $payment_history->amount_after_getaway_fee = $amount;
        $payment_history->payment_details = 'apple pay';
        $payment_history->date = date('Y-m-d');
        $payment_history->save();

        $sale_recode = SaleRecord::find($sale_record_id);
        $sale_recode->payment_status = 'Paid';
        $sale_recode->save();

        $insert_id = $payment_history->id;
        if ($insert_id){
            return response()->json(['success'=>true,'response'=> ['Payment Successful']], 200);
        }else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
}
