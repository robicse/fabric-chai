<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Advertisement;
use App\Model\Employee;
use App\Model\Employer;
use App\Model\Message;
use App\Model\PaymentHistory;
use App\Model\Product;
use App\Model\ProductBid;
use App\Model\SaleRecord;
use App\Model\Slider;
use App\Model\UserMembershipPackage;
use App\Model\WorkOrderProduct;
use App\Model\WorkOrderQuotationRequest;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use NumberFormatter;

class ReportController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:total-sale-list', ['only' => ['totalSale']]);
        $this->middleware('permission:total-revenue-list', ['only' => ['totalRevenue']]);
        $this->middleware('permission:total-vat-list', ['only' => ['totalVat']]);
        $this->middleware('permission:total-package-sale-list', ['only' => ['totalPackageSell']]);
        $this->middleware('permission:total-transaction-list', ['only' => ['totalTransaction']]);
        $this->middleware('permission:total-bid-accept-list', ['only' => ['totalBidAccepted']]);
        $this->middleware('permission:total-products-entry-list', ['only' => ['totalProducts']]);
        $this->middleware('permission:total-buy-requested-products-list', ['only' => ['totalBuyRequestedProducts']]);
        $this->middleware('permission:total-advertisement-list', ['only' => ['totalAdvertisements']]);
        $this->middleware('permission:total-manufacturer-post-list', ['only' => ['totalManufacturerPosts']]);
        $this->middleware('permission:total-job-seekers-list', ['only' => ['totalJobSeekers']]);
        $this->middleware('permission:total-job-providers-list', ['only' => ['totalJobProvider']]);
        $this->middleware('permission:total-work-order-received-list', ['only' => ['totalWorkOrderReceived']]);
        $this->middleware('permission:total-work-order-provided-list', ['only' => ['totalWorkOrderProvided']]);
    }
    public function totalSale(Request $request){
        $date    =    date('Y-m-d');
        $start_date = $request->start_date ? $request->start_date : date('Y-m-d', strtotime('-7 day'));
        $end_date = $request->end_date ? $request->end_date : $date;
        $sale_type = $request->sale_type ? $request->sale_type : 'buy';
        if ($start_date && $end_date && $request->sale_type == 'buy'){
            $totalSales = DB::table('sale_records')
                ->join('products','sale_records.product_id','=','products.id')
                ->where('products.user_type','=','buyer')
                ->whereBetween('sale_records.updated_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->select('sale_records.*')
                ->orderBy('sale_records.updated_at', 'DESC')
                ->get();
        }elseif ($start_date && $end_date && $request->sale_type == 'sell'){
            $totalSales = DB::table('sale_records')
                ->join('products','sale_records.product_id','=','products.id')
                ->where('products.user_type','=','seller')
                ->whereBetween('sale_records.updated_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->select('sale_records.*')
                ->orderBy('sale_records.updated_at', 'DESC')
                ->get();
        }elseif ($start_date && $end_date && $request->sale_type == 'wo'){
            $totalSales = DB::table('work_order_sale_records')
                ->whereBetween('updated_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->orderBy('updated_at', 'DESC')
                ->get();
        }elseif ($start_date && $end_date && $request->sale_type == 'mp'){
            $totalSales = UserMembershipPackage::where('payment_status','Paid')
                ->whereBetween('updated_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->latest()
                ->get();
        }
        else{
            $totalSales = DB::table('sale_records')
                ->join('products','sale_records.product_id','=','products.id')
                ->where('products.user_type','=','buyer')
                ->whereBetween('sale_records.updated_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->select('sale_records.*')
                ->orderBy('sale_records.updated_at', 'DESC')
                ->get();
        }

        return view('backend.admin.report.total_sale',compact('totalSales','start_date','end_date','sale_type'));
    }
    public function totalRevenue(Request $request){
        $date = date('Y-m-d');
        $start_date = $request->start_date ? $request->start_date :  date('Y-m-d', strtotime('-7 day'));
        $end_date = $request->end_date ? $request->end_date : $date;
        $sale_type = $request->sale_type ? $request->sale_type : 'buy';
        if ($start_date && $end_date && $request->sale_type == 'buy'){
            $totalSales = DB::table('sale_records')
                ->join('products','sale_records.product_id','=','products.id')
                ->where('products.user_type','=','buyer')
                ->whereBetween('sale_records.updated_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->select('sale_records.*')
                ->orderBy('sale_records.updated_at', 'DESC')
                ->get();
        }elseif ($start_date && $end_date && $request->sale_type == 'sell'){
            $totalSales = DB::table('sale_records')
                ->join('products','sale_records.product_id','=','products.id')
                ->where('products.user_type','=','seller')
                ->whereBetween('sale_records.updated_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->select('sale_records.*')
                ->orderBy('sale_records.updated_at', 'DESC')
                ->get();
        }elseif ($start_date && $end_date && $request->sale_type == 'wo'){
            $totalSales = DB::table('work_order_sale_records')
                ->whereBetween('updated_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->orderBy('updated_at', 'DESC')
                ->get();
        }elseif ($start_date && $end_date && $request->sale_type == 'mp'){
            $totalSales = UserMembershipPackage::where('payment_status','Paid')
                ->whereBetween('updated_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->latest()
                ->get();
        }
        else{
            $totalSales = DB::table('sale_records')
                ->join('products','sale_records.product_id','=','products.id')
                ->where('products.user_type','=','buyer')
                ->whereBetween('sale_records.updated_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->select('sale_records.*')
                ->orderBy('sale_records.updated_at', 'DESC')
                ->get();
        }

        return view('backend.admin.report.total_revenue',compact('totalSales','start_date','end_date','sale_type'));
    }

    public function totalVat(Request $request){
        $date = date('Y-m-d');
        $start_date = $request->start_date ? $request->start_date :  date('Y-m-d', strtotime('-7 day'));
        $end_date = $request->end_date ? $request->end_date : $date;
        $totalVats = DB::table('sale_records')
            ->whereBetween('updated_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('updated_at', 'DESC')
            ->get();

        return view('backend.admin.report.total_vat',compact('totalVats','start_date','end_date'));
    }

    public function totalPackageSell(Request $request){
        $date = date('Y-m-d');
        $start_date = $request->start_date ? $request->start_date :  date('Y-m-d', strtotime('-7 day'));
        $end_date = $request->end_date ? $request->end_date : $date;
        $package_type = $request->package_type ? $request->package_type : 'gold';
        if ($start_date && $end_date && $package_type== 'gold'){
            $totalPackageSells = DB::table('user_membership_packages')
                ->where('membership_package_id','=',2)
                ->where('payment_status','=','Paid')
                ->whereBetween('updated_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->orderBy('updated_at', 'DESC')
                ->get();
        }elseif ($start_date && $end_date && $package_type== 'platinum'){
            $totalPackageSells = DB::table('user_membership_packages')
                ->where('membership_package_id','=',3)
                ->where('payment_status','=','Paid')
                ->whereBetween('updated_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->orderBy('updated_at', 'DESC')
                ->get();
        }
        else{
            $totalPackageSells = DB::table('user_membership_packages')
                ->where('membership_package_id','=',2)
                ->where('payment_status','=','Paid')
                ->whereBetween('updated_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->orderBy('updated_at', 'DESC')
                ->get();
        }

        return view('backend.admin.report.total_package_sell',compact('totalPackageSells','start_date','end_date','package_type'));
    }

    public function totalTransaction(Request $request){
        $date = date('Y-m-d');
        $start_date = $request->start_date ? $request->start_date : date('Y-m-d', strtotime('-7 day'));
        $end_date = $request->end_date ? $request->end_date : $date;
        $totalTransactions = SaleRecord::whereBetween('updated_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('updated_at', 'DESC')
            ->get();

        return view('backend.admin.report.total_transaction',compact('totalTransactions','start_date','end_date'));
    }
    public function totalBidAccepted(Request $request){
        $date = date('Y-m-d');
        $start_date = $request->start_date ? $request->start_date : date('Y-m-d', strtotime('-7 day'));
        $end_date = $request->end_date ? $request->end_date : $date;
        $totalAcceptedBids = ProductBid::where('bid_status',1)
            ->whereBetween('updated_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('updated_at', 'DESC')
            ->get();

        return view('backend.admin.report.total_bid_accepted',compact('totalAcceptedBids','start_date','end_date'));
    }
    public function totalBidReject(Request $request){
        $date = date('Y-m-d');
        $start_date = $request->start_date ? $request->start_date : date('Y-m-d', strtotime('-7 day'));
        $end_date = $request->end_date ? $request->end_date : $date;
        $totalRejectedBids = ProductBid::where('bid_status',0)
            ->whereBetween('updated_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('updated_at', 'DESC')
            ->get();

        return view('backend.admin.report.total_bid_rejected',compact('totalRejectedBids','start_date','end_date'));
    }
    public function totalProducts(Request $request){
        $date = date('Y-m-d');
        $start_date = $request->start_date ? $request->start_date : date('Y-m-d', strtotime('-7 day'));
        $end_date = $request->end_date ? $request->end_date : $date;
        $totalProducts = Product::where('user_type','seller')
            ->where('published',1)
            ->whereBetween('updated_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('updated_at', 'DESC')
            ->get();

        return view('backend.admin.report.total_seller_products',compact('totalProducts','start_date','end_date'));
    }
    public function totalBuyRequestedProducts(Request $request){
        $date = date('Y-m-d');
        $start_date = $request->start_date ? $request->start_date : date('Y-m-d', strtotime('-7 day'));
        $end_date = $request->end_date ? $request->end_date : $date;
        $totalProducts = Product::where('user_type','buyer')
            ->where('published',1)
            ->whereBetween('updated_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('updated_at', 'DESC')
            ->get();

        return view('backend.admin.report.total_buyer_products',compact('totalProducts','start_date','end_date'));
    }
    public function totalAdvertisements(Request $request){
        $date = date('Y-m-d');
        $start_date = $request->start_date ? $request->start_date : date('Y-m-d', strtotime('-7 day'));
        $end_date = $request->end_date ? $request->end_date : $date;
        $type = $request->type ? $request->type : 'advertisement';
        if ($start_date && $end_date && $type == 'advertisement'){
            $totalAdvertisements = Advertisement::whereBetween('updated_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->orderBy('updated_at', 'DESC')
                ->get();
        }elseif ($start_date && $end_date && $type == 'slider'){
            $totalAdvertisements = Slider::whereBetween('updated_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->orderBy('updated_at', 'DESC')
                ->get();
        }else{
            $totalAdvertisements = Advertisement::whereBetween('updated_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->orderBy('updated_at', 'DESC')
                ->get();
        }

        return view('backend.admin.report.total_advertisement',compact('totalAdvertisements','start_date','end_date','type'));
    }
    public function totalManufacturerPosts(Request $request){
        $date = date('Y-m-d');
        $start_date = $request->start_date ? $request->start_date : date('Y-m-d', strtotime('-7 day'));
        $end_date = $request->end_date ? $request->end_date : $date;
        $totalManufacturerPosts = WorkOrderProduct::where('user_type','seller')
            ->where('published',1)
            ->whereBetween('updated_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('updated_at', 'DESC')
            ->get();

        return view('backend.admin.report.total_manufacturer_posts',compact('totalManufacturerPosts','start_date','end_date'));
    }
    public function totalJobSeekers(Request $request){
        $date = date('Y-m-d');
        $start_date = $request->start_date ? $request->start_date : date('Y-m-d', strtotime('-7 day'));
        $end_date = $request->end_date ? $request->end_date : $date;
        $totalEmployees = Employee::where('verification_status',1)
            ->whereBetween('updated_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('updated_at', 'DESC')
            ->get();

        return view('backend.admin.report.total_employees',compact('totalEmployees','start_date','end_date'));
    }
    public function totalJobProvider(Request $request){
        $date = date('Y-m-d');
        $start_date = $request->start_date ? $request->start_date : date('Y-m-d', strtotime('-7 day'));
        $end_date = $request->end_date ? $request->end_date : $date;
        $totalEmployers = Employer::whereBetween('updated_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('updated_at', 'DESC')
            ->get();

        return view('backend.admin.report.total_employers',compact('totalEmployers','start_date','end_date'));
    }

    public function totalWorkOrderReceived(Request $request){
        $date = date('Y-m-d');
        $start_date = $request->start_date ? $request->start_date : date('Y-m-d', strtotime('-7 day'));
        $end_date = $request->end_date ? $request->end_date : $date;
        $totalWorkOrders = WorkOrderQuotationRequest::where('status',1)
            ->whereBetween('updated_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('updated_at', 'DESC')
            ->get();

        return view('backend.admin.report.total_work_order_received',compact('totalWorkOrders','start_date','end_date'));
    }
    public function totalWorkOrderProvided(Request $request){
        $date = date('Y-m-d');
        $start_date = $request->start_date ? $request->start_date : date('Y-m-d', strtotime('-7 day'));
        $end_date = $request->end_date ? $request->end_date : $date;
        $totalWorkOrders = WorkOrderQuotationRequest::where('status',1)
            ->whereBetween('updated_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('updated_at', 'DESC')
            ->get();

        return view('backend.admin.report.total_work_order_provided',compact('totalWorkOrders','start_date','end_date'));
    }
    public function totalSmsHistory(Request $request){
        $date = date('Y-m-d');
        $start_date = $request->start_date ? $request->start_date : date('Y-m-d', strtotime('-7 day'));
        $end_date = $request->end_date ? $request->end_date : $date;
        $totalSmsHistories = Message::whereBetween('updated_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('updated_at', 'DESC')
            ->get();

        return view('backend.admin.report.total_sms_history',compact('totalSmsHistories','start_date','end_date'));
    }
    public function refferalCodeReport(Request $request){
        $date = date('Y-m-d');
        $start_date = $request->start_date ? $request->start_date : date('Y-m-d', strtotime('-7 day'));
        $end_date = $request->end_date ? $request->end_date : $date;
        $users = User::where('referral_code','!=',null)->whereBetween('updated_at', [$start_date." 00:00:00", $end_date
            ." 23:59:59"])
            ->orderBy('updated_at', 'DESC')
            ->get();

        return view('backend.admin.report.referral_code_report',compact('users','start_date','end_date'));
    }

    public function registerUserReport(Request $request){
        $date = date('Y-m-d');
        $start_date = $request->start_date ? $request->start_date : date('Y-m-d', strtotime('-7 day'));
        $end_date = $request->end_date ? $request->end_date : $date;
        $registerBy=$request->reg_by?:'all';
        if($registerBy=='all'){
            $users = User::whereBetween('updated_at', [$start_date." 00:00:00", $end_date
                ." 23:59:59"])
                ->orderBy('updated_at', 'DESC')
                ->get();
        }
        else{
            $users = User::wherereg_by($registerBy)->whereBetween('updated_at', [$start_date." 00:00:00", $end_date
                ." 23:59:59"])
                ->orderBy('updated_at', 'DESC')
                ->get();
        }
        return view('backend.admin.report.registration_user_report',compact('users','start_date','end_date','registerBy'));

    }
    public function monthlyRegisterUserReport(Request $request){
        $year = date('Y');
        $month = date('m');
        $year = $request->year ? $request->year : $year;
        $month = $request->month ? $request->month : $month;
        $users = User::whereMonth('updated_at',   $month)
            ->whereYear('updated_at', $year)
            ->orderBy('updated_at', 'DESC')
            ->get();

        return view('backend.admin.report.monthly-registration_user_report',compact('users'));
    }
    public function BidderListReport(Request $request){
        $date = date('Y-m-d');
        $start_date = $request->start_date ? $request->start_date : $date;
        $end_date = $request->end_date ? $request->end_date : $date;
        $bidders = ProductBid::with('product','receiver')->whereBetween('updated_at', [$start_date." 00:00:00", $end_date
            ." 23:59:59"])
            ->orderBy('updated_at', 'DESC')
            ->get();

        return view('backend.admin.report.bidder_report',compact('bidders','start_date','end_date'));
    }














    public function salesReport(){
        $sale_records = SaleRecord::latest()->get();
        return view('backend.admin.report.sales_report',compact('sale_records'));
    }
    public function salesReportDetails(Request $request){
        $sale_record = SaleRecord::find($request->id);
        return view('backend.admin.report.sales_report_details_modal',compact('sale_record'));
    }

    public function monthlyEarningReport(){

        $date    =    date('Y-m-d');//your given date

        $first_date_find = strtotime(date("Y-m-d", strtotime($date)) . ", first day of this month");
        $from_date = date("Y-m-d",$first_date_find);

        $last_date_find = strtotime(date("Y-m-d", strtotime($date)) . ", last day of this month");
        $to_date = date("Y-m-d",$last_date_find);

        $monthly_reports = DB::table('sale_records')
            ->join('users','sale_records.seller_user_id','=','users.id')
            ->select('sale_records.seller_user_id',DB::raw('COUNT(sale_records.id) as total_product_sold'))
            ->whereBetween('sale_records.updated_at', [$from_date." 00:00:00", $to_date." 23:59:59"])
            ->groupBy('sale_records.seller_user_id')
            ->orderBy('total_product_sold', 'DESC')
            ->get();

        return view('backend.admin.report.monthly_earning_report',compact('monthly_reports','from_date','to_date'));
    }
    public function monthlyReportValue(Request $request){
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if (!empty( $from_date && $to_date)){

            $monthly_reports = DB::table('sale_records')
                ->join('users','sale_records.seller_user_id','=','users.id')
                ->select('sale_records.seller_user_id',DB::raw('COUNT(sale_records.id) as total_product_sold'))
                ->whereBetween('sale_records.updated_at', [$from_date." 00:00:00", $to_date." 23:59:59"])
                ->groupBy('sale_records.seller_user_id')
                ->orderBy('total_product_sold', 'DESC')
                ->get();
            return view('backend.admin.report.monthly_earning_report',compact('monthly_reports','from_date','to_date'));
        }
        return redirect()->back();
    }
    public function topSellers(){
        $reports = DB::table('sale_records')
            ->join('users','sale_records.seller_user_id','=','users.id')
            ->select('sale_records.seller_user_id',DB::raw('COUNT(sale_records.id) as total_product_sold'),DB::raw('SUM(sale_records.admin_commission) as total_commission'),DB::raw('SUM(sale_records.amount) as total_sale'))
            ->groupBy('sale_records.seller_user_id')
            ->orderBy('total_product_sold', 'DESC')
            ->get();
//        dd($reports);
        return view('backend.admin.report.top_seller',compact('reports'));

    }
    public function commissionReport(){
        $commissionReports =DB::table('sale_records')
            ->join('users','users.id','=','sale_records.seller_user_id')
            ->select('sale_records.seller_user_id')
            ->groupBy('sale_records.seller_user_id')
            ->get();
        return view('backend.admin.report.commission_report',compact('commissionReports'));
    }
    public function commissionReportModal(Request $request){
        $seller = User::find($request->id);
        $invoice_code = $request->invoice_code;

        return view('backend.admin.report.commission_payment_modal',compact('seller','invoice_code'));
    }
    public function commissionPaymentStore(Request $request, $id){
        //dd($request->all());
        if($request->description == NULL){
            Toastr::warning('Description must be needed. You can try again.');
            return redirect()->back();
        }
        $seller = User::find($id);
        $sale_record_id = SaleRecord::where('invoice_code',$request->invoice_code)->pluck('id')->first();

        // previous middle data deleted
        PaymentHistory::where('sale_record_id',$sale_record_id)
            ->where('payment_status','Pending')
            ->where('payment_type','!=','Cash')
            ->delete();

        $payment_history = new PaymentHistory();
        $payment_history->sale_record_id = $sale_record_id;
        $payment_history->invoice_code = date('Ymd-his');
        $payment_history->user_id=$id;
        $payment_history->user_type=$seller->user_type;
        $payment_history->amount=$request->amount;
        $payment_history->payment_status='Paid';
        $payment_history->payment_with=$request->payment_with;
        $payment_history->payment_type=$request->payment_type;
        $payment_history->bank_name=$request->bank_name ? $request->bank_name : NULL;
        $payment_history->check_number=$request->check_number ? $request->check_number : NULL;
        $payment_history->dispatch_date=$request->dispatch_date ? $request->dispatch_date : NULL;
        $payment_history->description=$request->description ? $request->description : NULL;
        $payment_history->transaction_id=NULL;
        $payment_history->ssl_status=NULL;
        $payment_history->currency='BDT';
        $payment_history->amount_after_getaway_fee=NULL;
        $payment_history->payment_details=NULL;
        $payment_history->date=date('Y-m-d');
        $insert_id = $payment_history->save();

//            if($payment_history->id && $request->payment_type == 'Cash'){
//                $seller = Seller::where('user_id',$payment_history->user_id)->first();
//                $previous_amount = $seller->pay_to_admin;
//                $seller->pay_to_admin = $previous_amount - $request->amount;
//                $seller->save();
//            }

        if($insert_id){
            $sale_recode = SaleRecord::where('invoice_code',$request->invoice_code)->first();
            $sale_recode->payment_status = 'Paid';
            $sale_recode->save();
        }

        Toastr::success('Successfully Done');
        return redirect()->back();
    }
    public function smsReport(){
        $date    =    date('Y-m-d');//your given date
        $first_date_find = strtotime(date("Y-m-d", strtotime($date)) . ", first day of this month");
        $from_date = date("Y-m-d",$first_date_find);
        $last_date_find = strtotime(date("Y-m-d", strtotime($date)) . ", last day of this month");
        $to_date = date("Y-m-d",$last_date_find);
        $sms_reports = DB::table('messages')
            ->join('users','messages.sender_user_id','=','users.id')
            ->select('messages.sender_user_id',DB::raw('COUNT(messages.id) as total_sms'))
            ->whereBetween('messages.updated_at', [$from_date." 00:00:00", $to_date." 23:59:59"])
            ->groupBy('messages.sender_user_id')
            ->orderBy('total_sms', 'DESC')
            ->get();
        return view('backend.admin.report.sms_report',compact('sms_reports','from_date','to_date'));
    }
    public function smsReportValue(Request $request){
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $sms_reports = DB::table('messages')
            ->join('users','messages.sender_user_id','=','users.id')
            ->select('messages.sender_user_id',DB::raw('COUNT(messages.id) as total_sms'))
            ->whereBetween('messages.updated_at', [$from_date." 00:00:00", $to_date." 23:59:59"])
            ->groupBy('messages.sender_user_id')
            ->orderBy('total_sms', 'DESC')
            ->get();
        return view('backend.admin.report.sms_report',compact('sms_reports','from_date','to_date'));
    }

    public function transactionReport(){
//        $transaction_reports = null;
//        $from_date = null;
//        $to_date = null;
        $date    =    date('Y-m-d');//your given date
        $first_date_find = strtotime(date("Y-m-d", strtotime($date)) . ", first day of this month");
        $from_date = date("Y-m-d",$first_date_find);
        $last_date_find = strtotime(date("Y-m-d", strtotime($date)) . ", last day of this month");
        $to_date = date("Y-m-d",$last_date_find);
        $transaction_reports = PaymentHistory::whereBetween('updated_at', [$from_date." 00:00:00", $to_date." 23:59:59"])->get();

        return view('backend.admin.report.transaction_report',compact('transaction_reports','from_date','to_date'));
    }
    public function transactionReportValue(Request $request){
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if (!empty( $from_date && $to_date)){
            $transaction_reports = PaymentHistory::whereBetween('updated_at', [$from_date." 00:00:00", $to_date." 23:59:59"])->get();
            return view('backend.admin.report.transaction_report',compact('transaction_reports','from_date','to_date'));
        }
        return redirect()->back();
    }
    public function saleRecordPrint($id){
        $saleRecord = SaleRecord::find(decrypt($id));
        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return view('backend.admin.report.invoice',compact('saleRecord','digit'));
    }
}
