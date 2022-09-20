<?php

namespace App\Http\Controllers\Seller;

use App\Helpers\UserInfo;
use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Employee;
use App\Model\Employer;
use App\Model\IndustryEmployeeType;
use App\Model\IndustrySubCategory;
use App\Model\MessageCharge;
use App\Model\Offer;
use App\Model\Seller;
use App\Model\Shortlist;
use App\Model\Message;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployerController extends Controller
{
    public function index(){
        $membership_package_id = checkMembershipStatus(Auth::id());
        $user_type = checkUserType(Auth::id());
        if($user_type == 'seller' && $membership_package_id == 1){
            Toastr::warning('Upgrade your membership package!');
            return redirect()->route('seller.memberships-package-list');
        }

        $seller = Seller::where('user_id',Auth::id())->first();
        $seller->employer_status = 1;
        $seller->save();
        $employer = Employer::where('user_id',Auth::id())->first();
        if (empty($employer)){
            $employer = new Employer();
            $employer->user_id = Auth::id();
            $employer->seller_id = $seller->id;
            $employer->save();

            $user = User::find(Auth::id());
            $user->user_type = 'seller';
            $multiple_user_types = json_decode($user->multiple_user_types);
            if(!in_array("employer", $multiple_user_types)){
                array_push($multiple_user_types, "employer");
                $user->multiple_user_types = $multiple_user_types;
            }
            $user->save();

        }
        $employees = '';
        $industry_category_id = '';
        $industry_sub_category_id = '';
        $industry_employee_type_id = '';
        return view('frontend.seller.employer.dashboard',compact('employees','industry_category_id','industry_sub_category_id','industry_employee_type_id'));
    }
    public function profile(){
        return view('frontend.seller.employer.profile');
    }
    public function profileUpdate(Request $request){
        $user = User::find(Auth::id());
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;

        $seller = Seller::where('user_id',Auth::id())->first();
        $seller->company_name = $request->company_name;
        $seller->company_phone = $request->company_phone;
        $seller->company_address = $request->company_address;
        if($request->hasFile('trade_licence')){
            $seller->trade_licence = $request->trade_licence->store('uploads/seller_info/trade_licence');
        }

        $employer = Employer::where('user_id',Auth::id())->first();
        $employer->owner_name = $request->owner_name;
        $employer->industry_category_id = $request->industry_category_id;

        $employer->no_of_employee = $request->no_of_employee;
        $employer->salary_type = $request->salary_type;
        $employer->established_year = $request->established_year;

        if($request->hasFile('owner_nid_front')){
            $employer->owner_nid_front = $request->owner_nid_front->store('uploads/employer_info/nid');
        }
        if($request->hasFile('owner_nid_back')){
            $employer->owner_nid_back = $request->owner_nid_back->store('uploads/employer_info/nid');
        }
        if($request->hasFile('vat')){
            $employer->vat = $request->vat->store('uploads/employer_info/vat');
        }
        if($request->hasFile('factory_certificate')){
            $employer->factory_certificate = $request->factory_certificate->store('uploads/employer_info/factory_certificate');
        }
        if($request->hasFile('fire_licence')){
            $employer->fire_licence = $request->fire_licence->store('uploads/employer_info/fire_licence');
        }
        if($request->hasFile('membership_image')){
            $employer->membership_image = $request->membership_image->store('uploads/employer_info/membership_image');
        }
        $user->save();
        $seller->save();
        $employer->save();
        Toastr::success('Profile Updated Successfully');
        return redirect()->route('employer-dashboard');
    }

    public function get_industry_subcategories(Request $request){
        $industry_subcategories = IndustrySubCategory::where('industry_category_id',$request->industry_category_id)->orderBy('name','ASC')->get();
        return $industry_subcategories;
    }
    public function get_industry_employee_type(Request $request){
        //dd($request->all());
        $industry_employee_types = IndustryEmployeeType::where('industry_category_id',$request->industry_category_id)->where('industry_sub_category_id',$request->industry_subcategory_id)->orderBy('name','ASC')->get();
        return $industry_employee_types;
    }
    public function searchCandidate(Request $request){
        $industry_category_id = $request->industry_category_id ? $request->industry_category_id :'';
        $industry_sub_category_id = $request->industry_sub_category_id ? $request->industry_sub_category_id :'';
        $industry_employee_type_id = $request->industry_employee_type_id ? $request->industry_employee_type_id :'';

        if($industry_category_id != NULL && $industry_sub_category_id != NULL && $industry_employee_type_id != NULL){
            $employees = Employee::where('industry_category_id',$industry_category_id)
                ->where('industry_sub_category_id',$industry_sub_category_id)
                ->where('industry_employee_type_id',$industry_employee_type_id)
                ->where('current_job_status',0)
                ->where('verification_status',1)
                ->get();
        }elseif($industry_category_id != NULL && $industry_sub_category_id != NULL){
            $employees = Employee::where('industry_category_id',$industry_category_id)
                ->where('industry_sub_category_id',$industry_sub_category_id)
                ->where('current_job_status',0)
                ->where('verification_status',1)
                ->get();
        }elseif($industry_category_id != NULL){
            $employees = Employee::where('industry_category_id',$industry_category_id)
                ->where('current_job_status',0)
                ->where('verification_status',1)
                ->get();
        }else{
            $employees = Employee::where('industry_category_id',$industry_category_id)
                ->where('industry_sub_category_id',$industry_sub_category_id)
                ->where('industry_employee_type_id',$industry_employee_type_id)
                ->where('current_job_status',0)
                ->where('verification_status',1)
                ->get();
        }

        return view('frontend.seller.employer.dashboard',compact('employees','industry_category_id','industry_sub_category_id','industry_employee_type_id'));
    }

    public function viewEmployeeDetails($id){
        $employee = Employee::find($id);
        return view('frontend.seller.employee.view_profile',compact('employee'));
    }

    public function employeeShortlistUnshortlist($id){

        $employer_id = getEmployerIdByUserId(Auth::user()->id);
        $check_exists = checkAlreadyShortlisted($employer_id, $id);
        if(!empty($check_exists)){
            $shortlist = Shortlist::where('employer_id',$employer_id)->where('employee_id',$id)->first();
            if($check_exists->status == 1){
                $shortlist->status=0;
                $shortlist->save();
                Toastr::success('Employee Shortlisted Removed Successfully');
            }else{
                $shortlist->status=1;
                $shortlist->save();
                Toastr::success('Employee Shortlisted Created Successfully');
            }
        }else{
            $shortlist = new Shortlist();
            $shortlist->employer_user_id=Auth::user()->id;
            $shortlist->seller_id=getSellerIdByUserId(Auth::user()->id);
            $shortlist->employer_id=$employer_id;
            $shortlist->employee_user_id=getEmployeeUserIdByEmployeeId($id);
            $shortlist->employee_id=$id;
            $shortlist->status=1;
            $shortlist->save();

            Toastr::success('Employee Shortlisted Created Successfully');
        }

        return redirect()->back();
    }

    public function employerToEmployeeMessage(Request $request){
        $message_count = ceil(strlen($request->message)/60) ;

        for ($i = 0; $i< $message_count; $i++){

        }



        $title = 'Interview Message';
        $message_charge = MessageCharge::latest()->first();

        $checkTotalFreeSMSSent = checkTotalFreeSMSSent(Auth::user()->id);
        $membership_package_id = Auth::user()->membership_package_id;
        $checkTotalFreeSMSLimit = checkTotalFreeSMSLimit(Auth::user()->id,$membership_package_id);
        if($checkTotalFreeSMSSent < $checkTotalFreeSMSLimit){
            $message_charge_status = 'Free';
            $message_charge_id = NULL;
            $cost_per_sms = 0;
            $total_cost_sms = 0;
        }else{
            $message_charge_status = 'Charge Include';
            $message_charge_id = $message_charge->id;
            $cost_per_sms = $message_charge->cost_per_sms;
            $total_cost_sms = $message_charge->cost_per_sms*1;
        }

        // offer
        $offer = new Offer();
        $offer->title=$title;
        $offer->message=$request->message;
        $offer->sender_user_id=Auth::user()->id;
        $offer->total_candidate=1;
        $offer->total_sms_sent=1;
        $offer->message_charge_status=$message_charge_status;
        $offer->message_charge_id=$message_charge_id;
        $offer->cost_per_sms=$cost_per_sms;
        $offer->total_cost_sms=$total_cost_sms;
        $offer->save();
        $offer_id=$offer->id;
        if($offer_id){

//            dd(strlen($request->message));
            $message_count = ceil(strlen($request->message)/60) ;

            for ($i = 0; $i< $message_count; $i++){

                $message = new Message();
                $message->offer_id=$offer_id;
                $message->sender_user_id=Auth::user()->id;
                $message->receiver_user_id=$request->employee_user_id;
                $message->title=$title;
                $message->message=$request->message;
                $message->message_charge_status=$message_charge_status;
                $message->message_charge_id=$message_charge_id;
                $message->cost_per_sms=$cost_per_sms;
                $message->save();
                $insert_id_2=$message->id;
                if($insert_id_2){

                    $user = User::where('id',$request->employee_user_id)->first();
                    $message_content = $request->message;
                    createNotification($user->id,$title,$message_content);
                    if($user->country_code == '+880') {
                        UserInfo::smsAPI('880'.$user->phone, $message_content);
                        SmsNotification($user->id,$title,$message_content);
                    }
                }
            }


        }

        Toastr::success('Message Send Successfully');
        return redirect()->back();
    }

    public function employerToEmployeeMultipleMessage(Request $request){
        //dd($request->all());
        $row_count = count(json_decode($request->employee_user_ids));
        $employee_user_ids = json_decode($request->employee_user_ids);
        // For Multiple SMS Sent
        $title = 'Interview Message';
        $message_charge = MessageCharge::latest()->first();

        $checkTotalFreeSMSSent = checkTotalFreeSMSSent(Auth::user()->id);
        $membership_package_id = Auth::user()->membership_package_id;
        $checkTotalFreeSMSLimit = checkTotalFreeSMSLimit(Auth::user()->id,$membership_package_id);
        if($checkTotalFreeSMSSent < $checkTotalFreeSMSLimit){
            $message_charge_status = 'Free';
            $message_charge_id = NULL;
            $cost_per_sms = 0;
            $total_cost_sms = 0;
        }else{
            $message_charge_status = 'Charge Include';
            $message_charge_id = $message_charge->id;
            $cost_per_sms = $message_charge->cost_per_sms;
            $total_cost_sms = $message_charge->cost_per_sms*1;
        }

        // offer
        $offer = new Offer();
        $offer->title=$title;
        $offer->message=$request->message;
        $offer->sender_user_id=Auth::user()->id;
        $offer->save();
        $offer_id=$offer->id;
        if($offer_id){
            $total_candidate = 0;
            $total_sms_sent = 0;
            // message
            for($i=0; $i<$row_count; $i++){
                $message = new Message();
                $message->offer_id=$offer_id;
                $message->sender_user_id=Auth::user()->id;
                $message->receiver_user_id=$employee_user_ids[$i];
                $message->title=$title;
                $message->message=$request->message;
                $message->message_charge_status=$message_charge_status;
                $message->message_charge_id=$message_charge_id;
                $message->cost_per_sms=$cost_per_sms;
                $message->save();

                $total_candidate += 1;
                $total_sms_sent += 1;
            }

            // update offer
            $update_offer = Offer::find($offer_id);
            $update_offer->total_candidate=$total_candidate;
            $update_offer->total_sms_sent=$total_sms_sent;
            $update_offer->message_charge_status=$message_charge_status;
            $update_offer->message_charge_id=$message_charge_id;
            $update_offer->cost_per_sms=$cost_per_sms;
            $update_offer->total_cost_sms=$message_charge->cost_per_sms*$total_sms_sent;
            $update_offer->save();

            foreach($employee_user_ids as $emp_id){
                // sms send off for few times
                $user = User::where('id',$emp_id)->first();
                $message_content = $request->message;
                createNotification($user->id,$title,$message_content);
                if($user->country_code == '+880') {
                    UserInfo::smsAPI('880'.$user->phone, $message_content);
                    SmsNotification($user->id,$title,$message_content);
                }
            }

        }

        Toastr::success('Multiple Message Send Successfully');
        return redirect()->back();
    }
}
