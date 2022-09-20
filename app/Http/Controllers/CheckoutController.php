<?php

namespace App\Http\Controllers;

use App\Model\PaymentHistory;
use App\Model\SaleRecord;
use App\Model\SmsCostPaymentHistory;
use App\Model\UserMembershipPackage;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    //redirects to this method after a successfull checkout
    public function checkout_done($user_membership_package_id, $payment)
    {
        $payment_decode_data = json_decode($payment);

        $order = UserMembershipPackage::findOrFail($user_membership_package_id);
        $order->payment_status = $payment_decode_data->paid == true ? 'Paid' : 'Pending';
        $order->transaction_id = $payment_decode_data->balance_transaction;
        $order->ssl_status = $payment_decode_data->paid == true ? 'Paid' : 'Unpaid';
        $order->currency = 'USD';
        $order->amount_after_getaway_fee = $payment_decode_data->application_fee_amount;
        $order->payment_details = $payment;
        $insert_id = $order->save();

        if($insert_id){
            $user = User::find($order->user_id);
            $user->membership_package_id = $order->membership_package_id;
            $user->membership_activation_date = $order->membership_activation_date;
            $user->membership_expired_date = $order->membership_expired_date;
            $user->save();
        }

        Session::forget('payment_type');

        Toastr::success('Payment completed.');
        return view('frontend.order_confirmed', compact('order'));
    }

    //redirects to this method after a successfull checkout
    public function checkout2_done($payment_history_id, $payment)
    {
        $payment_decode_data = json_decode($payment);

        $order = PaymentHistory::findOrFail($payment_history_id);
        $order->payment_status = $payment_decode_data->paid == true ? 'Paid' : 'Pending';
        $order->transaction_id = $payment_decode_data->balance_transaction;
        $order->ssl_status = $payment_decode_data->paid == true ? 'Paid' : 'Unpaid';
        $order->currency = 'USD';
        $order->amount_after_getaway_fee = $payment_decode_data->application_fee_amount;
        $order->payment_details = $payment;
        $order->save();
        $insert_id = $order->id;

        if($insert_id){
            $saleRecord = SaleRecord::findOrFail($order->sale_record_id);
            $saleRecord->payment_status='Paid';
            $saleRecord->save();
        }

        Session::forget('payment_history_id');

        Toastr::success('Payment completed.');
        return view('frontend.order_confirmed', compact('order'));
    }

    public function checkout3_done($sms_cost_payment_history_id, $payment)
    {
        $payment_decode_data = json_decode($payment);

        $order = SmsCostPaymentHistory::findOrFail($sms_cost_payment_history_id);
        $order->payment_status = $payment_decode_data->paid == true ? 'Paid' : 'Pending';
        $order->transaction_id = $payment_decode_data->balance_transaction;
        $order->ssl_status = $payment_decode_data->paid == true ? 'Paid' : 'Unpaid';
        $order->currency = 'USD';
        $order->amount_after_getaway_fee = $payment_decode_data->application_fee_amount;
        $order->payment_details = $payment;
        $order->save();
        $insert_id = $order->id;

        Session::forget('sms_cost_payment_history_id');

        Toastr::success('Payment completed.');
        return view('frontend.order_confirmed', compact('order'));
    }
}
