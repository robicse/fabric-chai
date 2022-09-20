<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\CommissionReportExport;
use App\Model\MonthlyEarningExport;
use App\Model\SaleReportExport;
use App\Model\SmsExport;
use App\Model\TopSellerExport;
use App\Model\TotalAcceptedBidExport;
use App\Model\TotalAdvertisementExport;
use App\Model\TotalBuyerDueExport;
use App\Model\TotalBuyerExport;
use App\Model\TotalBuyRequestedProductsExport;
use App\Model\TotalEmployeeDueExport;
use App\Model\TotalEmployeeExport;
use App\Model\TotalEmployeesExport;
use App\Model\TotalEmployersExport;
use App\Model\TotalManufacturerPostsExport;
use App\Model\TotalPackageSellExport;
use App\Model\TotalProductsExport;
use App\Model\TotalRevenueExport;
use App\Model\TotalSaleExport;
use App\Model\TotalSellerDueExport;
use App\Model\TotalSellerExport;
use App\Model\TotalSmsHistoryExport;
use App\Model\TotalTransactionExport;
use App\Model\TotalVatExport;
use App\Model\TotalWOProvidedExport;
use App\Model\TotalWOReceivedExport;
use App\Model\TransactionReportExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ExportExcelController extends Controller
{
    public function exportTotalBuyerReport(){
        return Excel::download(new TotalBuyerExport(), 'total_buyer_list.xlsx');
    }
    public function exportTotalSellerReport(){
        return Excel::download(new TotalSellerExport(), 'total_seller_list.xlsx');
    }
    public function exportSellerDueReport(){
        return Excel::download(new TotalSellerDueExport(), 'total_seller_due_list.xlsx');
    }
    public function exportBuyerDueReport(){
        return Excel::download(new TotalBuyerDueExport(), 'total_buyer_due_list.xlsx');
    }
    public function exportEmployeeDueReport(){
        return Excel::download(new TotalEmployeeDueExport(), 'total_employee_due_list.xlsx');
    }
    public function exportTotalEmployeeReport(){
        return Excel::download(new TotalEmployeeExport(), 'total_employee_list.xlsx');
    }
    public function exportTotalEmployerReport(){
        return Excel::download(new TotalEmployeeExport(), 'total_employee_list.xlsx');
    }

    public function exportTotalSaleReport($start_date, $end_date,$sale_type){
        Session::put('start_date',$start_date);
        Session::put('end_date',$end_date);
        Session::put('sale_type',$sale_type);
        return Excel::download(new TotalSaleExport(), 'total_sale_report.xlsx');
    }
    public function exportTotalRevenueReport($start_date, $end_date,$sale_type){
        Session::put('start_date',$start_date);
        Session::put('end_date',$end_date);
        Session::put('sale_type',$sale_type);
        return Excel::download(new TotalRevenueExport(), 'total_revenue_report.xlsx');
    }
    public function exportTotalVatReport($start_date, $end_date){
        Session::put('start_date',$start_date);
        Session::put('end_date',$end_date);
        return Excel::download(new TotalVatExport(), 'total_vat_report.xlsx');
    }
    public function exportTotalPackageSellReport($start_date, $end_date,$package_type){
        Session::put('start_date',$start_date);
        Session::put('end_date',$end_date);
        Session::put('package_type',$package_type);
        return Excel::download(new TotalPackageSellExport(), 'total_package_sell_report.xlsx');
    }
    public function exportTotalTransactionsReport($start_date, $end_date){
        Session::put('start_date',$start_date);
        Session::put('end_date',$end_date);
        return Excel::download(new TotalTransactionExport(), 'total_transaction_report.xlsx');
    }
    public function exportTotalBidAcceptedReport($start_date, $end_date){
        Session::put('start_date',$start_date);
        Session::put('end_date',$end_date);
        return Excel::download(new TotalAcceptedBidExport(), 'total_bid_accepted_report.xlsx');
    }
    public function exportTotalProductsReport($start_date, $end_date){
        Session::put('start_date',$start_date);
        Session::put('end_date',$end_date);
        return Excel::download(new TotalProductsExport(), 'total_products_report.xlsx');
    }
    public function exportTotalBuyRequestedProductsReport($start_date, $end_date){
        Session::put('start_date',$start_date);
        Session::put('end_date',$end_date);
        return Excel::download(new TotalBuyRequestedProductsExport(), 'total_buy_requested_products_report.xlsx');
    }
    public function exportTotalAdvertisementsReport($start_date, $end_date,$type){
        Session::put('start_date',$start_date);
        Session::put('end_date',$end_date);
        Session::put('type',$type);
        return Excel::download(new TotalAdvertisementExport(), 'total_branding_report.xlsx');
    }
    public function exportTotalManufacturerPostsReport($start_date, $end_date){
        Session::put('start_date',$start_date);
        Session::put('end_date',$end_date);
        return Excel::download(new TotalManufacturerPostsExport(), 'total_manufacturer_posts_report.xlsx');
    }
    public function exportTotalEmployeesReport($start_date, $end_date){
        Session::put('start_date',$start_date);
        Session::put('end_date',$end_date);
        return Excel::download(new TotalEmployeesExport(), 'total_employees_report.xlsx');
    }
    public function exportTotalEmployersReport($start_date, $end_date){
        Session::put('start_date',$start_date);
        Session::put('end_date',$end_date);
        return Excel::download(new TotalEmployersExport(), 'total_employers_report.xlsx');
    }
    public function exportTotalWOProvidedReport($start_date, $end_date){
        Session::put('start_date',$start_date);
        Session::put('end_date',$end_date);
        return Excel::download(new TotalWOProvidedExport(), 'total_work_order_provided_report.xlsx');
    }
    public function exportTotalWOReceivedReport($start_date, $end_date){
        Session::put('start_date',$start_date);
        Session::put('end_date',$end_date);
        return Excel::download(new TotalWOReceivedExport(), 'total_work_order_received_report.xlsx');
    }
    public function exportTotalSmsHistoryReport($start_date, $end_date){
        Session::put('start_date',$start_date);
        Session::put('end_date',$end_date);
        return Excel::download(new TotalSmsHistoryExport(), 'total_sms_history_report.xlsx');
    }





    public function exportSaleReport(){
        return Excel::download(new SaleReportExport(), 'sale_report.xlsx');
    }
    public function exportMonthlyEarningReport($from_date, $to_date,$sale_type){
        Session::put('from_date',$from_date);
        Session::put('to_date',$to_date);
        Session::put('sale_type',$sale_type);
        return Excel::download(new MonthlyEarningExport(), 'monthly_earning_report.xlsx');
    }
    public function exportSmsReport($from_date, $to_date){
        Session::put('from_date',$from_date);
        Session::put('to_date',$to_date);
        return Excel::download(new SmsExport(), 'sms_report.xlsx');
    }
    public function exportTopSeller(){
        return Excel::download(new TopSellerExport(), 'top_seller_report.xlsx');
    }
    public function exportCommissionReport(){
        return Excel::download(new CommissionReportExport(), 'commission_report_report.xlsx');
    }
    public function exportTransactionReport($from_date, $to_date){
        Session::put('from_date',$from_date);
        Session::put('to_date',$to_date);
        return Excel::download(new TransactionReportExport(), 'monthly_earning_report.xlsx');
    }
}
