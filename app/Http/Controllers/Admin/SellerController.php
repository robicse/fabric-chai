<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UserInfo;
use App\Http\Controllers\Controller;
use App\Model\PaymentHistory;
use App\Model\SaleRecord;
use App\Model\Seller;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SellerController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:seller-list|seller-profile|seller-password|seller-verification|seller-ban-unban', ['only' => ['index']]);
        $this->middleware('permission:seller-profile', ['only' => ['profileShow','updateProfile']]);
        $this->middleware('permission:seller-password', ['only' => ['updatePassword']]);
        $this->middleware('permission:seller-verification', ['only' => ['verification']]);
        $this->middleware('permission:seller-ban-unban', ['only' => ['banSeller']]);
        $this->middleware('permission:seller-payment-list', ['only' => ['sellerPayment']]);
//        $this->middleware('permission:units-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $start_date = $request->start_date ?? 0;
        $end_date = $request->end_date ?? 0;
//        $sellerInfos = Seller::latest()->get();
        return view('backend.admin.seller.index',compact('start_date','end_date'));
    }
    public function sellerListAjax($start_date = null, $end_date = null){
        return Seller::ajaxSellerList($start_date, $end_date);
    }

    public function individualSeller($seller_id)
    {
        $sellerInfos = Seller::where('id',$seller_id)->latest()->get();
        return view('backend.admin.seller.index',compact('sellerInfos'));
    }
    public function verification(Request $request)
    {
        $seller = Seller::find($request->id);
        $seller->verification_status = $request->status;
        if($seller->save() && $seller->verification_status==1){
            $user = User::where('id',$seller->user_id)->first();
            $title = 'Approved Seller';
            $message = 'Dear, '. $user->name .' your seller account has been approved by fabriclagbe.com';
            createNotification($seller->user_id,$title,$message);
            if($user->country_code == '+880') {
                UserInfo::smsAPI('880' . $user->phone, $message);
                SmsNotification($user->id,$title,$message);
            }
            return 1;
        }
        return 0;
    }

    public function profileShow($id)
    {
        $sellerInfo = User::find(decrypt($id));
        return view('backend.admin.seller.profile', compact('sellerInfo'));
    }
    public function profileEdit($id){
        $sellerInfo = User::find(decrypt($id));
        return view('backend.admin.seller.edit_profile', compact('sellerInfo'));
    }

    public function updateProfile(Request $request, $id)
    {

        $this->validate($request, [
            'name' =>  'required',
            'phone' => 'required|unique:users,phone,'.$id,
            //'email' =>  'required|email|unique:users,email,'.$id,
        ]);
        $user =  User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();

        $seller = Seller::where('user_id',$id)->first();
        $seller->company_name = $request->company_name;
        $seller->designation = $request->designation;
        $seller->company_phone = $request->company_phone;
        $seller->company_email = $request->company_email;
        $seller->company_address = $request->company_address;
        $seller->division_id = $request->division_id;
        $seller->district_id = $request->district_id;
        if ( $request->selected_category){
            $seller->selected_category= implode(',', $request->selected_category);
        }
        if($request->hasFile('trade_licence')){
            $seller->trade_licence = $request->trade_licence->store('uploads/seller_info/trade_licence');
        }
        if($request->hasFile('nid_front')){
            $seller->nid_front = $request->nid_front->store('uploads/seller_info/nid');
        }
        if($request->hasFile('nid_back')){
            $seller->nid_back = $request->nid_back->store('uploads/seller_info/nid');
        }
        $seller->save();

        Toastr::success('Seller Profile Updated Successfully','Success');
        return redirect()->back();
    }

    public function updatePassword(Request $request, $id)
    {
        $this->validate($request, [
            'password' =>  'required|min:8',
        ]);

        $user =  User::find($id);
        $hashedPassword = $user->password;

        if (!Hash::check($request->password, $hashedPassword)) {
            if ($request->confirm_password == $request->password) {
                $user->password = Hash::make($request->password);
                $user->save();
                Toastr::success('Password Updated Successfully','Success');
                return redirect()->back();
            }else{
                Toastr::error('New password does not match with confirm password.', 'Error');
                return redirect()->back();
            }
        } else {
            Toastr::error('New password cannot be the same as old password.', 'Error');
            return redirect()->back();
        }
//        $user->password = Hash::make($request->password);
//        $user->save();
//        Toastr::success('Seller Password Updated Successfully','Success');
//        return redirect()->back();
    }

    public function banSeller($id){
        $user =  User::find($id);
        if($user->banned == 0){
            $user->banned = 1;
            $user->save();
            Toastr::success('Customer has been banned Successfully','Success');
        }else{
            $user->banned = 0;
            $user->save();
            Toastr::success('Customer has been unbanned Successfully','Success');
        }

        return redirect()->back();
    }

    public function paymentStatusUpdate(Request $request){

        $payment_status = PaymentHistory::find($request->id);
        $payment_status->payment_status = $request->payment_status;
        if($payment_status->save()){
            $sale_record = SaleRecord::find($payment_status->sale_record_id);
            $sale_record->payment_status = $request->payment_status;
            $sale_record->save();
            return 1;
        }
        return 0;
    }

    public function sellerPayment(){
        $transaction_reports = PaymentHistory::where('payment_status','Partial Paid')->get();
        return view('backend.admin.seller.transaction_report',compact('transaction_reports'));
    }

    public function seller_commission_due_list(Request $request, $id){
        $seller_commission_due_lists = SaleRecord::where('seller_user_id',$id)->get();
//        $seller_commission_due_lists = DB::table('payment_histories')
//            ->join('sale_records','sale_records.id','=','payment_histories.sale_record_id')
//            ->where()
//            ->get();

        return view('backend.admin.seller.seller_commission_due_list',compact('seller_commission_due_lists'));
    }
}
