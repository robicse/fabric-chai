<?php
namespace App\Http\Controllers\Api;

use App\Model\PaymentHistory;
use App\Model\SaleRecord;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

session_start();

class PublicSslCommerzPayment2Controller extends Controller
{
    public function index2(Request $request, $id)
    {
        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "orders"
        # In orders table order uniq identity is "order_id","order_status" field contain status of the transaction, "grand_total" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.
        $order =  PaymentHistory::find($id);
        $post_data = array();
        $post_data['total_amount'] = $order->amount; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid('', true); // tran_id must be unique

//        $order->total = $post_data['total_amount'];
        $order->currency = $post_data['currency'];
        $order->transaction_id = $post_data['tran_id'];
        $order->ssl_status = 'Pending';
        $order->save();


        #Start to save these value  in session to pick in success page.
        $_SESSION['payment_values']['tran_id']=$post_data['tran_id'];
        #End to save these value  in session to pick in success page.
        $server_name=$request->root()."/";
        $post_data['success_url'] = $server_name . "success2";
        $post_data['fail_url'] = $server_name . "fail2";
        $post_data['cancel_url'] = $server_name . "cancel2";

        #Before  going to initiate the payment order status need to update as Pending.
        $update_product = DB::table('payment_histories')
            ->where('transaction_id', $post_data['tran_id'])
            ->update(['ssl_status' => 'Pending','currency' => $post_data['currency']]);
        $sslc = new SSLCommerz();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->initiate($post_data, false);
        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }
    public function success2(Request $request)
    {
        $sslc = new SSLCommerz();
        #Start to received these value from session. which was saved in index function.
        $tran_id = $request->tran_id;
        #End to received these value from session. which was saved in index function.
        #Check order status in order tabel against the transaction id or order id.
        $order_detials = DB::table('payment_histories')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'ssl_status','currency','amount')->first();
        $chekTotal = $order_detials->amount;
        if($order_detials->ssl_status=='Pending')
        {

            $validation = $sslc->orderValidate($tran_id, $chekTotal, $order_detials->currency, $request->all());
            if($validation == TRUE)
            {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */
                $order=PaymentHistory::where('transaction_id',$tran_id)->first();
                $order->ssl_status='Completed';
                $order->payment_status='Paid';
                $order->payment_type=$_POST['card_type'];
                //$order->amount_after_getaway_fee=$_POST['store_amount'];
                $order->payment_details=json_encode($_POST);
                $order->update();

                $sale_recode = SaleRecord::find($order->sale_record_id);
                $sale_recode->payment_status = 'Paid';
                $sale_recode->save();

                if (!empty($sale_recode)) {
                    return response()->json(['success' => true, 'response' => 'SSL Payment Success'], 200);
                } else {
                    return response()->json(['success' => false, 'response' => 'Something Went Wrong!'], 401);
                }
            }
            else
            {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                Here you need to update order status as Failed in order table.
                */
                DB::table('payment_histories')
                    ->where('transaction_id', $tran_id)
                    ->update(['ssl_status' => 'Failed']);
                //echo "validation Fail";
                return response()->json(['success' => false, 'response' => 'SSL Payment Failed!'], 401);
            }
        }
        else if($order_detials->ssl_status=='Processing' || $order_detials->ssl_status=='Complete')
        {
            /*
             That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
             */
            //echo "Transaction is successfully Complete ash";
            //return redirect('api/ssl/redirect/fail');
            return response()->json(['success' => false, 'response' => 'SSL Payment Failed!'], 401);
        }
        else
        {
            #That means something wrong happened. You can redirect customer to your product page.
            //echo "Invalid Transaction";
            //return redirect('api/ssl/redirect/fail');
            return response()->json(['success' => false, 'response' => 'SSL Payment Failed!'], 401);
        }

    }
    public function fail2(Request $request)
    {
        $tran_id = $_SESSION['payment_values']['tran_id'];
        $order_detials = DB::table('payment_histories')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'ssl_status','currency','amount')->first();
        if($order_detials->order_status=='Pending')
        {
            DB::table('payment_histories')
                ->where('transaction_id', $tran_id)
                ->update(['ssl_status' => 'Failed']);
            //return redirect('api/ssl/redirect/fail');
            return response()->json(['success' => false, 'response' => 'SSL Payment Failed!'], 401);
        }
        else if($order_detials->ssl_status=='Processing' || $order_detials->ssl_status=='Complete')
        {
            //Toastr::success('Transaction is already Successful','Success');
            //return redirect('api/ssl/redirect/fail');
            return response()->json(['success' => false, 'response' => 'SSL Payment Failed!'], 401);
        }
        else
        {
            //Toastr::error('Transaction is Invalid','Error');
            //return redirect('api/ssl/redirect/fail');
            return response()->json(['success' => false, 'response' => 'SSL Payment Failed!'], 401);
        }

    }
    public function cancel2(Request $request)
    {
        $tran_id = $_SESSION['payment_values']['tran_id'];
        $order_detials = DB::table('payment_histories')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'ssl_status','currency','amount')->first();
        if($order_detials->ssl_status=='Pending')
        {
            DB::table('payment_histories')
                ->where('transaction_id', $tran_id)
                ->update(['ssl_status' => 'Canceled']);
            //Toastr::error('Transaction is Cancel','Error');
            //return redirect('api/ssl/redirect/fail');
            return response()->json(['success' => false, 'response' => 'SSL Payment Failed!'], 401);
        }
        else if($order_detials->ssl_status=='Processing' || $order_detials->ssl_status=='Complete')
        {
            //Toastr::success('Transaction is already Successful','Success');
            //return redirect('api/ssl/redirect/fail');
            return response()->json(['success' => false, 'response' => 'SSL Payment Failed!'], 401);
        }
        else
        {
            //Toastr::error('Transaction is Invalid','Error');
            //return redirect('api/ssl/redirect/fail');
            return response()->json(['success' => false, 'response' => 'SSL Payment Failed!'], 401);
        }

    }
    public function ipn2(Request $request)
    {
        //dd('ipn');
        #Received all the payement information from the gateway
        if($request->input('tran_id')) #Check transation id is posted or not.
        {
            $tran_id = $request->input('tran_id');
            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'ssl_status','currency','grand_total')->first();
            if($order_details->ssl_status =='Pending')
            {
                $sslc = new SSLCommerz();
                $validation = $sslc->orderValidate($tran_id, $order_details->grand_total, $order_details->currency, $request->all());
                if($validation == TRUE)
                {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successfull transaction to customer
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['ssl_status' => 'Processing']);

                    echo "Transaction is successfully Complete";
                }
                else
                {
                    /*
                    That means IPN worked, but Transation validation failed.
                    Here you need to update order status as Failed in order table.
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['ssl_status' => 'Failed']);

                    echo "validation Fail";
                }

            }
            else if($order_details->ssl_status == 'Processing' || $order_details->ssl_status =='Complete')
            {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Complete";
            }
            else
            {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        }
        else
        {
            echo "Inavalid Data";
        }
    }
}
