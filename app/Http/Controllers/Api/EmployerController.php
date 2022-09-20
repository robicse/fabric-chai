<?php

namespace App\Http\Controllers\Api;

use App\Helpers\UserInfo;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeListCollection;
use App\Model\Employee;
use App\Model\Employer;
use App\Model\Message;
use App\Model\MessageCharge;
use App\Model\Offer;
use App\Model\Seller;
use App\Model\Shortlist;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployerController extends Controller
{
    public function switchToEmployer(){
        $seller = Seller::where('user_id',Auth::id())->first();
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
            $seller->employer_status = 1;
            $seller->save();
        }
        if (!empty($employer))
        {
            $seller->employer_status = 1;
            $seller->save();
            return response()->json(['success'=>true,'response'=> 'Welcome to Employer Dashboard'], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }

    }
    public function profileDetails(){
        $employer = Employer::where('user_id',Auth::id())->first();
//        dd($employer);
        $data['name'] = getNameByBnEn($employer->user);
        $data['email'] = $employer->user->email;
        $data['country_code'] = getCountryCodeByBnEn($employer->user->country_code);
        $data['phone'] =(string) getNumberToBangla($employer->user->phone);
        $data['address'] = getAddressByBnEn($employer->user);
        $data['company_name'] = getCompanyNameByBnEn($employer->seller);
        $data['company_owner_name'] = getOwnerNameByBnEn($employer);
        $data['company_phone'] =(string) getNumberToBangla($employer->seller->company_phone);
        $data['company_email'] = $employer->seller->company_email;
        $data['company_address'] = getCompanyAddressByBnEn($employer->seller);
        $data['no_of_employee'] = $employer->no_of_employee;
        $data['salary_type'] = $employer->salary_type;
        $data['established_year'] = $employer->established_year;
        $data['trade_licence'] = $employer->seller->trade_licence;
        $data['vat'] = $employer->vat;
        $data['owner_nid_front'] = $employer->owner_nid_front;
        $data['owner_nid_back'] = $employer->owner_nid_back;
        $data['factory_certificate'] = $employer->factory_certificate;
        $data['fire_licence'] = $employer->fire_licence;
        $data['industry_category_id'] = $employer->industry_category_id;

        if (!empty($data))
        {
            return response()->json(['success'=>true,'response'=> $data], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
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
        $employer->industry_category_id = json_encode($request->industry_category_id);
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

        if (!empty($employer))
        {
            return response()->json(['success'=>true,'response'=> 'Profile Updated Successfully'], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }

    }
    public function searchEmployee(Request $request){
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
//        $employees = Employee::where('industry_category_id',$request->industry_category_id)->where('industry_sub_category_id',$request->industry_sub_category_id)->where('industry_employee_type_id',$request->industry_employee_type_id)->where('current_job_status',0)->get();
        return new EmployeeListCollection($employees);

    }
    public function employeeDetails($id){
        $employee = Employee::find($id);
        if ($employee->current_salary){
            $current_salary = explode(' - ',$employee->current_salary);
            $current_salary_range = getNumberWithCurrencyByBnEn($current_salary[0]) .' - '. getNumberWithCurrencyByBnEn($current_salary[1]);
        }else{
            $current_salary_range = '';
        }
        if ($employee->expected_salary){
            $expected_salary = explode(' - ',$employee->expected_salary);
            $expected_salary_range = getNumberWithCurrencyByBnEn($expected_salary[0]) .' - '. getNumberWithCurrencyByBnEn($expected_salary[1]);
        }else{
            $expected_salary_range = '';
        }
        $data['id'] =(integer) $employee->id;
        $data['name'] = getNameByBnEn($employee->user);
        $data['image'] = $employee->employee_pic;
        $data['marital_status'] = $employee->marital_status;
        $data['age'] =(string) getNumberToBangla($employee->age);
        $data['gender'] = $employee->gender;
        $data['division'] = getNameByBnEn($employee->division);
        $data['district'] = getNameByBnEn($employee->district);
        $data['thana'] = getNameByBnEn($employee->upazila);
        $data['post_office'] = getNameByBnEn($employee->union);
        $data['village_or_area'] = $employee->village_or_area;
        $data['contact_no'] = $employee->user->country_code.$employee->user->phone;
        $data['current_salary'] = $current_salary_range;
        $data['expected_salary'] = $expected_salary_range;
        $data['looking_for_job'] = $employee->lookingForJob ? getNameByBnEn($employee->lookingForJob) : '';
        $data['joining_duration'] = $employee->joining_duration;
        $data['experience'] = $employee->experience;
        $data['expertise'] =$employee->industrycategory ? getNameByBnEn($employee->industrycategory) : '';
        $data['link']= [
            'message' => route('employee.send-message', $employee->id),
            'shortlist' => route('employee.shortlist', $employee->id),
        ];

        if (!empty($data))
        {
            return response()->json(['success'=>true,'response'=> $data], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function employeeSendMessage(Request $request, $id){
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
            // message
            $message = new Message();
            $message->offer_id=$offer_id;
            $message->sender_user_id=Auth::user()->id;
            $message->receiver_user_id=$id;
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

                // sms send off for few times
//                $user = User::where('id',$request->employee_user_id)->first();
//                $message_content = $request->message;
//                createNotification($user->id,$title,$message);
//                if($user->country_code == '+880') {
//                    UserInfo::smsAPI($user->country_code . $user->phone, $message_content);
//                    SmsNotification($user->id,$title,$message_content);
//                }
            }
        }

        if (!empty($message))
        {
            return response()->json(['success'=>true,'response'=> 'Message sent successfully'], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function employeeShortList($id){
        $employer_id = getEmployerIdByUserId(Auth::user()->id);
        $check_exists = checkAlreadyShortlisted($employer_id, $id);
        if(!empty($check_exists)){
            $shortlist = Shortlist::where('employer_id',$employer_id)->where('employee_id',$id)->first();
            if($check_exists->status == 1){
                $shortlist->status=0;
                $shortlist->save();
                return response()->json(['success'=>true,'response'=> 'Employee Shortlisted Removed Successfully'], 200);
            }else{
                $shortlist->status=1;
                $shortlist->save();
                return response()->json(['success'=>true,'response'=> 'Employee Shortlisted Created Successfully'], 200);
            }
        }else{
            $shortlist = new Shortlist();
            $shortlist->employer_user_id = Auth::user()->id;
            $shortlist->seller_id = getSellerIdByUserId(Auth::user()->id);
            $shortlist->employer_id = $employer_id;
            $shortlist->employee_user_id = getEmployeeUserIdByEmployeeId($id);
            $shortlist->employee_id = $id;
            $shortlist->status = 1;
            $shortlist->save();
            return response()->json(['success'=>true,'response'=> 'Employee Shortlisted Created Successfully'], 200);
        }
    }
    public function employerToEmployeeMultipleMessage(Request $request){


        $row_count = count($request->employee_user_ids);
        $employee_user_ids = $request->employee_user_ids;

//        dd($employee_user_ids);
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
            // sms send off for few times
//            $user = User::where('id',$request->employee_user_id)->first();
//            $message_content = $request->message;
//            createNotification($user->id,$title,$message);
//            if($user->country_code == '+880') {
//                UserInfo::smsAPI($user->country_code . $user->phone, $message_content);
//                SmsNotification($user->id,$title,$message_content);
//            }
        }
        if (!empty($update_offer))
        {
            return response()->json(['success'=>true,'response'=> 'Message been sent to all users successfully'], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
}
