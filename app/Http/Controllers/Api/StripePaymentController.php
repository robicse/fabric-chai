<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\CheckoutController;
use App\Model\PaymentHistory;
use App\Model\UserMembershipPackage;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Stripe;
use Session;

use App\Http\Controllers\Controller;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe($user_membership_package_id)
    {
        //dd(Session::get('user_membership_package_id'));
        $membership_package = UserMembershipPackage::findOrFail($user_membership_package_id);
        return view('frontend.payment.stripe', compact('membership_package'));
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */

    function stripePost(Request $request)
    {
        if($request->session()->has('payment_type')){
            if($request->session()->get('payment_type') == 'cart_payment'){
                $userMembershipPackage = UserMembershipPackage::findOrFail($request->user_membership_package_id);

                //Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                //Stripe\Stripe::setApiKey('sk_test_9IMkiM6Ykxr1LCe2dJ3PgaxS');
                Stripe\Stripe::setApiKey('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');
                //dd($request->stripeToken);
                try {
                    $payment = json_encode(Stripe\Charge::create ([
                            //"amount" => round(convert_to_usd($userMembershipPackage->amount) * 100),
                            "amount" => $userMembershipPackage->amount,
                            "currency" => "usd",
                            "source" => $request->stripeToken
                    ]));
                } catch (\Exception $e) {
                    Toastr::warning($e->getMessage());
                    return redirect()->back();
                    //return redirect()->route('checkout.payment_info');
                }

                $checkoutController = new CheckoutController();
                return $checkoutController->checkout_done($request->user_membership_package_id, $payment);
            }
        }else{
            Toastr::warning('Something Went Wrong!');
            return redirect()->back();
        }
    }

    function stripe2($payment_history_id){
        $payment_history = PaymentHistory::findOrFail($payment_history_id);
        return view('frontend.payment.stripe', compact('payment_history'));
    }

    function stripe2Post(Request $request){
        $paymentHistory = PaymentHistory::findOrFail($request->payment_history_id);

        //Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
//        Stripe\Stripe::setApiKey('sk_test_9IMkiM6Ykxr1LCe2dJ3PgaxS');
        Stripe\Stripe::setApiKey('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');
        try {
            $payment = json_encode(Stripe\Charge::create ([
                //"amount" => round(convert_to_usd($userMembershipPackage->amount) * 100),
                //"amount" => $paymentHistory->amount * 100,
                "amount" => $paymentHistory->amount,
                "currency" => "usd",
                "source" => $request->stripeToken
            ]));
        } catch (\Exception $e) {
            Toastr::warning($e->getMessage());
            return redirect()->back();
        }

        $checkout2Controller = new CheckoutController();
        return $checkout2Controller->checkout2_done($request->payment_history_id, $payment);
    }
}
