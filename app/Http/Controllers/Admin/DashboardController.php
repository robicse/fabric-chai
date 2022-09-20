<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Model\Brand;
use App\Model\Buyer;
use App\Model\Seller;
use App\Model\Product;
use App\Model\Category;
use App\Model\Employee;
use App\Model\Employer;
use App\Model\ProductBid;
use App\Model\Attribute;
use App\Model\SaleRecord;
use App\Model\Subcategory;
use Illuminate\Http\Request;
use App\Model\PaymentHistory;
use App\Model\SubSubcategory;
use App\Model\VisitorCounter;
use App\Http\Controllers\Controller;
use App\Model\WorkOrderQuotationRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSellers = Seller::count();
        $totalBuyers = Buyer::count();
        $totalSellerProducts = Product::where('user_type','seller')->count();
        $totalBuyerProducts = Product::where('user_type','buyer')->count();
        $totalSells = SaleRecord::count();
        $totalCategories = Category::count();
        $totalEmployee = Employee::count();
        $totalEmployer = Employer::count();
        $totalPayment = PaymentHistory::count();
        $totalBid = ProductBid::count();
        $totalWOProvided = WorkOrderQuotationRequest::where('status',1)->count();
        $totalWOReceived = WorkOrderQuotationRequest::where('status',1)->count();

        ## Visitor counter
        $total_visitors = VisitorCounter::count();

        //dd($totalBrands);
        return view('backend.admin.dashboard',
            compact('totalSellers','totalBuyers',
                'totalSellerProducts','totalBuyerProducts','totalSells',
                'totalCategories','totalEmployee','totalEmployer','totalWOProvided',
                'totalWOReceived','total_visitors','totalPayment','totalBid'));
    }

    /**
     * Visitor Report
     * @return view visitor reports
     */

    public function  visitor_report(Request $request){
        //$visitors = VisitorCounter::latest()->get();
        $date    =    date('Y-m-d');
        $start_date = $request->start_date ? $request->start_date : $date;
        $end_date = $request->end_date ? $request->end_date : $date;
        $visitors = VisitorCounter::whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('backend.admin.visitors.index',compact('visitors','start_date','end_date'));
    }
}
