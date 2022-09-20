<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Advertisement;
use App\Model\Buyer;
use App\Model\Employee;
use App\Model\Employer;
use App\Model\PaymentHistory;
use App\Model\Product;
use App\Model\ProductBid;
use App\Model\SaleRecord;
use App\Model\Seller;
use App\Model\Slider;
use App\Model\UserMembershipPackage;
use App\Model\WorkOrderProduct;
use App\Model\WorkOrderQuotationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class PdfController extends Controller
{
    public function exportTotalBuyerPDF() {
        $buyers = Buyer::latest()->get();
        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('backend.admin.pdf.total_buyer', compact('buyers'));

        return $pdf->download('total_buyer.pdf');
    }
    public function exportTotalSellerPDF() {
        $sellers = Seller::latest()->get();
        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('backend.admin.pdf.total_seller', compact('sellers'));

        return $pdf->download('total_seller.pdf');
    }
    public function exportTotalEmployeePDF() {
        $employees = Employee::latest()->get();
        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('backend.admin.pdf.total_employee', compact('employees'));

        return $pdf->download('total_employees.pdf');
    }
    public function exportTotalEmployerPDF() {
        $employers = Employer::latest()->get();
        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('backend.admin.pdf.total_employers', compact('employers'));

        return $pdf->download('total_employers.pdf');
    }
    public function exportTotalSalePDF($start_date, $end_date,$sale_type) {
        if ($start_date && $end_date && $sale_type == 'sell'){
            $totalSales = DB::table('sale_records')
                ->join('products','sale_records.product_id','=','products.id')
                ->where('products.user_type','=','seller')
                ->whereBetween('sale_records.created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->orderBy('sale_records.created_at', 'DESC')
                ->get();
        }elseif ($start_date && $end_date && $sale_type == 'wo'){
            $totalSales = DB::table('work_order_sale_records')
                ->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->orderBy('created_at', 'DESC')
                ->get();
        }elseif ($start_date && $end_date && $sale_type == 'mp'){
            $totalSales = UserMembershipPackage::where('payment_status','Paid')
                ->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->latest()
                ->get();
        }
        else{
            $totalSales = DB::table('sale_records')
                ->join('products','sale_records.product_id','=','products.id')
                ->where('products.user_type','=','buyer')
                ->whereBetween('sale_records.created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->orderBy('sale_records.created_at', 'DESC')
                ->get();
        }
        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('backend.admin.pdf.total_sell_report', compact('totalSales','sale_type'));

        return $pdf->download('total_sell_report.pdf');
    }
    public function exportTotalRevenuePDF($start_date, $end_date,$sale_type) {
        if ($start_date && $end_date && $sale_type == 'sell'){
            $totalSales = DB::table('sale_records')
                ->join('products','sale_records.product_id','=','products.id')
                ->where('products.user_type','=','seller')
                ->whereBetween('sale_records.created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->orderBy('sale_records.created_at', 'DESC')
                ->get();
        }elseif ($start_date && $end_date && $sale_type == 'wo'){
            $totalSales = DB::table('work_order_sale_records')
                ->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->orderBy('created_at', 'DESC')
                ->get();
        }elseif ($start_date && $end_date && $sale_type == 'mp'){
            $totalSales = UserMembershipPackage::where('payment_status','Paid')
                ->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->latest()
                ->get();
        }
        else{
            $totalSales = DB::table('sale_records')
                ->join('products','sale_records.product_id','=','products.id')
                ->where('products.user_type','=','buyer')
                ->whereBetween('sale_records.created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->orderBy('sale_records.created_at', 'DESC')
                ->get();
        }
        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('backend.admin.pdf.total_revenue_report', compact('totalSales','sale_type'));

        return $pdf->download('total_revenue_report.pdf');
    }
    public function exportTotalVatReport($start_date, $end_date) {
        $totalVats = DB::table('sale_records')
            ->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('created_at', 'DESC')
            ->get();
        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('backend.admin.pdf.total_vat_report', compact('totalVats'));

        return $pdf->download('total_vat_report.pdf');
    }

    public function exportTotalPackagePDF($start_date, $end_date,$package_type) {
        if ($start_date && $end_date && $package_type== 'platinum'){
            $totalPackageSells = DB::table('user_membership_packages')
                ->where('membership_package_id','=',3)
                ->where('payment_status','=','Paid')
                ->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->orderBy('created_at', 'DESC')
                ->get();
        }
        else{
            $totalPackageSells = DB::table('user_membership_packages')
                ->where('membership_package_id','=',2)
                ->where('payment_status','=','Paid')
                ->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->orderBy('created_at', 'DESC')
                ->get();
        }

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('backend.admin.pdf.total_package_sell_report', compact('totalPackageSells'));

        return $pdf->download('total_package_sells_report.pdf');
    }
    public function exportTotalTransactionsPDF($start_date, $end_date) {
        $totalTransactions = SaleRecord::whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('created_at', 'DESC')
            ->get();

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('backend.admin.pdf.total_transactions_report', compact('totalTransactions'));

        return $pdf->download('total_transactions_report.pdf');
    }
    public function exportTotalBidAcceptedPDF($start_date, $end_date) {
        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 12,
            'default_font' => 'nikosh',

        ]);
        $totalAcceptedBids = ProductBid::where('bid_status',1)
            ->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('created_at', 'DESC')
            ->get();
        $mpdf->WriteHTML();
        $pdf = PDF::loadView('backend.admin.pdf.total_accepted_bid_report', compact('totalAcceptedBids'));

//        $pdf = PDF::setOptions([
//            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
//            'logOutputFile' => storage_path('logs/log.htm'),
//            'tempDir' => storage_path('logs/')
//        ])->loadView('backend.admin.pdf.total_accepted_bid_report', compact('totalAcceptedBids'));

        return $pdf->stream('total_bid_accepted_report.pdf');
//        return $pdf->download('total_bid_accepted_report.pdf');
    }
    public function exportTotalProductsPDF($start_date, $end_date) {
        $totalProducts = Product::where('user_type','seller')
            ->where('published',1)
            ->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('created_at', 'DESC')
            ->get();

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('backend.admin.pdf.total_products_report', compact('totalProducts'));

        return $pdf->download('total_products_entry_report.pdf');
    }
    public function exportTotalBuyRequestedProductsPDF($start_date, $end_date) {
        $totalProducts = Product::where('user_type','buyer')
            ->where('published',1)
            ->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('created_at', 'DESC')
            ->get();

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('backend.admin.pdf.total_buy_requested_products_report', compact('totalProducts'));

        return $pdf->download('total_buy_requested_products_report.pdf');
    }
    public function exportTotalAdvertisementsPDF($start_date, $end_date,$type) {
        if ($start_date && $end_date && $type == 'slider'){
            $totalAdvertisements = Slider::whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->orderBy('created_at', 'DESC')
                ->get();
        }else{
            $totalAdvertisements = Advertisement::whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->orderBy('created_at', 'DESC')
                ->get();
        }

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('backend.admin.pdf.total_advertisement_report', compact('totalAdvertisements','type'));

        return $pdf->download('total_branding_report.pdf');
    }
    public function exportTotalManufacturerPostsPDF($start_date, $end_date) {
        $totalManufacturerPosts = WorkOrderProduct::where('user_type','seller')
            ->where('published',1)
            ->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('created_at', 'DESC')
            ->get();

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('backend.admin.pdf.total_manufacturer_posts_report', compact('totalManufacturerPosts'));

        return $pdf->download('total_manufacturer_posts_report.pdf');
    }
    public function exportTotalEmployeesPDF($start_date, $end_date) {
        $totalEmployees = Employee::where('verification_status',1)
            ->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('created_at', 'DESC')
            ->get();

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('backend.admin.pdf.total_employees_report', compact('totalEmployees'));

        return $pdf->download('total_job_seekers_report.pdf');
    }
    public function exportTotalEmployersPDF($start_date, $end_date) {
        $totalEmployers = Employer::whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('created_at', 'DESC')
            ->get();

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('backend.admin.pdf.total_employers_report', compact('totalEmployers'));

        return $pdf->download('total_job_providers_report.pdf');
    }
    public function exportTotalWOProvidedPDF($start_date, $end_date) {
        $totalWorkOrders = WorkOrderQuotationRequest::where('status',1)
            ->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('created_at', 'DESC')
            ->get();

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('backend.admin.pdf.total_wo_provided_report', compact('totalWorkOrders'));

        return $pdf->download('total_work_order_provided_report.pdf');
    }
    public function exportTotalWOReceivedPDF($start_date, $end_date) {
        $totalWorkOrders = WorkOrderQuotationRequest::where('status',1)
            ->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('created_at', 'DESC')
            ->get();

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('backend.admin.pdf.total_wo_received_report', compact('totalWorkOrders'));

        return $pdf->download('total_work_order_received_report.pdf');
    }



    public function exportSaleReportPDF() {
        $sale_records = SaleRecord::latest()->get();
        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('backend.admin.pdf.sale_record', compact('sale_records'));

        return $pdf->download('sale_records.pdf');
    }
    public function exportMonthlyEarningReportPDF($from_date, $to_date) {
        $monthly_reports = DB::table('sale_records')
            ->join('users','sale_records.seller_user_id','=','users.id')
            ->select('sale_records.seller_user_id',DB::raw('COUNT(sale_records.id) as total_product_sold'))
            ->whereBetween('sale_records.created_at', [$from_date." 00:00:00", $to_date." 23:59:59"])
            ->groupBy('sale_records.seller_user_id')
            ->orderBy('total_product_sold', 'DESC')
            ->get();

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('backend.admin.pdf.monthly_reports', compact('monthly_reports','from_date','to_date'));

        return $pdf->download('monthly_reports.pdf');
    }
    public function exportSmsReportPDF($from_date, $to_date){
        $sms_reports = DB::table('messages')
            ->join('users','messages.sender_user_id','=','users.id')
            ->select('messages.sender_user_id',DB::raw('COUNT(messages.id) as total_sms'))
            ->whereBetween('messages.created_at', [$from_date." 00:00:00", $to_date." 23:59:59"])
            ->groupBy('messages.sender_user_id')
            ->orderBy('total_sms', 'DESC')
            ->get();
        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('backend.admin.pdf.sms_reports', compact('sms_reports','from_date','to_date'));

        return $pdf->download('sms_reports.pdf');
    }

    public function exportTopSellerPDF() {
        $reports = DB::table('sale_records')
            ->join('users','sale_records.seller_user_id','=','users.id')
            ->select('sale_records.seller_user_id',DB::raw('COUNT(sale_records.id) as total_product_sold'),DB::raw('SUM(sale_records.admin_commission) as total_commission'),DB::raw('SUM(sale_records.amount) as total_sale'))
            ->groupBy('sale_records.seller_user_id')
            ->orderBy('total_product_sold', 'DESC')
            ->get();
        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('backend.admin.pdf.top_sellers', compact('reports'));

        return $pdf->download('top_sellers_report.pdf');
    }
    public function exportCommissionPDF(){
        $commissionReports =DB::table('sale_records')
            ->join('users','users.id','=','sale_records.seller_user_id')
            ->select('sale_records.seller_user_id')
            ->groupBy('sale_records.seller_user_id')
            ->get();

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('backend.admin.pdf.commission_report', compact('commissionReports'));

        return $pdf->download('commission_report.pdf');
    }
    public function exportTransactionReportPDF($from_date, $to_date){
        $transaction_reports = PaymentHistory::whereBetween('created_at', [$from_date." 00:00:00", $to_date." 23:59:59"])->get();

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('backend.admin.pdf.transaction_report', compact('transaction_reports'));

        return $pdf->download('transaction_report.pdf');
    }
}
