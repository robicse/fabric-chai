<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\UserInfo;
use App\Http\Controllers\Controller;
use App\Mail\MyEmail;
use App\Model\Blog;
use App\Model\Buyer;
use App\Model\District;
use App\Model\EducationDegree;
use App\Model\EducationLevel;
use App\Model\Employee;
use App\Model\IndustryEmployeeType;
use App\Model\IndustrySubCategory;
use App\Model\MembershipPackage;
use App\Model\PriorityBuyer;
use App\Model\Seller;
use App\Model\Union;
use App\Model\Upazila;
use App\Model\VerificationCode;
use App\Model\VisitorCounter;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

use Rakibhstu\Banglanumber\NumberToBangla;

class FrontendController extends Controller
{
    /**
    Store visitor unique IP address and count
     */

    public function index(){
        $priority_buyers = PriorityBuyer::all();


        return view('frontend.index',compact('priority_buyers'));
    }
    public function getSellerForm(Request $request){
        return view('frontend.partials.seller_form');
    }
    public function getEmployeeForm(Request $request){
        return view('frontend.partials.employee_form');
    }
    public function checkUserPhone(Request $request){
        $phn1 = (int)$request->phone_val;
        $check = User::where('phone',$phn1)->first();
        if (!empty($check)){
            return 1;
        }else{
            return 0;
        }
    }
    public function getDistrict (Request $request)
    {
        $districts = District::where('division_id', $request->division_id)->get();
        return $districts;
    }
    public function getUpazila (Request $request)
    {
        $upazilas = Upazila::where('district_id', $request->district_id)->get();
        return $upazilas;
    }
    public function getUnion (Request $request)
    {
        $unions = Union::where('upazilla_id', $request->upazila_id)->get();
        return $unions;
    }
    public function getIndustrySubCategory (Request $request)
    {
        $industrySubCategories = IndustrySubCategory::where('industry_category_id', $request->industry_category_id)->orderBy('name','ASC')->get();
        return $industrySubCategories;
    }
    public function getIndustryEmployeeType (Request $request)
    {
        $industryEmployeeTypes = IndustryEmployeeType::where('industry_sub_category_id', $request->industry_sub_category_id)->orderBy('name','ASC')->get();
        return $industryEmployeeTypes;
    }
    public function register(Request $request) {
//        dd($request->all());

        $this->validate($request, [
            'name' =>  'required',
            'password' => 'required|min:8',
        ]);

        $phn1 = (int)$request->phone;
        $check = User::where('phone',$phn1)->first();
        if (!empty($check)){
            Toastr::error('This phone number already exist');
            return back();
        }

        if($request->countyCodePrefix == '+880'){

            $this->validate($request, [
                'phone' => 'required|regex:/(1)[0-9]{9}/|unique:users',
            ]);
            $phn = (int)$request->phone;
        }else{
            $this->validate($request, [
                'email' => 'required',
            ]);
            $phn = $request->phone;
        }
        if ($request->confirm_password != $request->password) {
            Toastr::error('Password does not match with Confirm password');
            return back();
        }

        $membership_package_id = MembershipPackage::where('package_name','General')->pluck('id')->first();
        if(empty($membership_package_id)){
            Toastr::error('General Membership Package Not Found Yet!');
            return back();
        }
        $reffCheck = User::where('referral_code',$request->referred_by)->first();

        //Selected Categories
        $selectedCategories['category_1']=$request->category_1;
        $selectedCategories['category_2']=$request->category_2;
        $selectedCategories['category_3']=$request->category_3;
        $selectedCategories['category_4']=$request->category_4;
        $selectedCategories['category_5']=$request->category_5;
        $selectedCategories['category_6']=$request->category_6;
        $selectedCategories['category_7']=$request->category_7;
        $selectedCategories['category_8']=$request->category_8;
        $selectedCategories['category_9']=$request->category_9;
        $selectedCategories['category_10']=$request->category_10;

        if ($request->user_type == 'seller'){
            $userReg = new User();
            $userReg->name = $request->name;
            $userReg->name_bn = $request->name_bn;
            $userReg->email = $request->email;
            $userReg->address = $request->address;
            $userReg->address_bn = $request->address_bn;
            $userReg->country_code= $request->countyCodePrefix;
            $userReg->phone= $phn;
            $userReg->password = Hash::make($request->password);
            $userReg->user_type = 'seller';
            if($request->hasFile('nid_front')){
                $userReg->nid_front = $request->nid_front->store('uploads/nid');
            }
            if($request->hasFile('nid_back')){
                $userReg->nid_back = $request->nid_back->store('uploads/nid');
            }
            $userReg->multiple_user_types = json_encode(["seller"]);
            $userReg->membership_package_id = $membership_package_id;
            $userReg->membership_activation_date = date('Y-m-d');
            $userReg->membership_expired_date = date('Y-m-d', strtotime('+1 year'));
            $userReg->banned = 1;
            $userReg->reg_by = 'web';
            $userReg->referral_code = mt_rand(000000,999999);
            if ($reffCheck){
                $userReg->referred_by = $request->referred_by;
            }

            $insert_id = $userReg->save();
            if($insert_id){
                $seller = new Seller();
                $seller->user_id = $userReg->id;
                $seller->company_name = $request->company_name;
                $seller->company_name_bn = $request->company_name_bn;
                $seller->company_phone = $request->company_phone;
                $seller->company_email = $request->company_email;
                $seller->company_address = $request->company_address;
                $seller->company_address_bn = $request->company_address_bn;
                $seller->verification_status= 0;
                $seller->division_id= $request->countyCodePrefix == '+880' ? $request->division_id : NULL;
                $seller->district_id= $request->countyCodePrefix == '+880' ? $request->district_id : NULL;
                $seller->designation= $request->designation;
                $seller->selected_category = json_encode($selectedCategories);
                if($request->hasFile('trade_licence')){
                    $seller->trade_licence = $request->trade_licence->store('uploads/seller_info/trade_licence');
                }

                if($request->hasFile('nid_front')){
                    $seller->nid_front = $request->nid_front->store('uploads/seller_info/nid');
                }
                if($request->hasFile('nid_back')){
                    $seller->nid_back = $request->nid_back->store('uploads/seller_info/nid');
                }

                $seller_insert_id = $seller->save();
                if($seller_insert_id){
                    $title = 'Seller Registration';
                    $message = $userReg->name .' registered as a new seller';
                    registrationNotification($userReg->id,$title,$message);
                }else{
                    Toastr::error('Seller Information Something Went Wrong. Please Try Again!');
                    User::find($insert_id)->delete();
                    return back();
                }
            }else{
                Toastr::error('Something Went Wrong. Please Try Again!');
                return back();
            }
        }else if ($request->user_type == 'employee'){
            $userReg = new User();
            $userReg->name = $request->name;
            $userReg->name_bn = $request->name_bn;
            $userReg->email = $request->email;
            $userReg->address = $request->address;
            $userReg->address_bn = $request->address_bn;
            $userReg->country_code= $request->countyCodePrefix;
            $userReg->phone= $phn;
            $userReg->password = Hash::make($request->password);
            $userReg->user_type = 'employee';
            if($request->hasFile('nid_front')){
                $userReg->nid_front = $request->nid_front->store('uploads/nid');
            }
            if($request->hasFile('nid_back')){
                $userReg->nid_back = $request->nid_back->store('uploads/nid');
            }
            $userReg->multiple_user_types = json_encode(["employee"]);
            $userReg->membership_package_id = $membership_package_id;
            $userReg->membership_activation_date = date('Y-m-d');
            $userReg->membership_expired_date = date('Y-m-d', strtotime('+1 year'));
            $userReg->banned = 1;
            $userReg->reg_by = 'web';
            $userReg->referral_code = mt_rand(000000,999999);
            if ($reffCheck){
                $userReg->referred_by = $request->referred_by;
            }

            $insert_id = $userReg->save();
            if($insert_id){
                $employee = new Employee();
                $employee->user_id = $userReg->id;
                $employee->gender = $request->gender;
                $employee->verification_status= 0;
                if($request->hasFile('nid_front_side')){
                    $employee->nid_front_side = $request->nid_front->store('uploads/employee_info/nid_front_side');
                }
                if($request->hasFile('nid_back_side')){
                    $employee->nid_back_side = $request->nid_back->store('uploads/employee_info/nid_back_side');
                }

                $employee_insert_id = $employee->save();
                if($employee_insert_id){
                    $title = 'Employee Registration';
                    $message =  $userReg->name .' registered as a new employee.';
                    registrationNotification($userReg->id,$title,$message);
                    // admin sms
//                    UserInfo::smsAPI('8801725930131', $message);
                }else{
                    Toastr::error('Employee Information Something Went Wrong. Please Try Again!');
                    User::find($insert_id)->delete();
                    return back();
                }
            }else{
                Toastr::error('Something Went Wrong. Please Try Again!');
                return back();
            }
        }
        else{
            $userReg = new User();
            $userReg->name = $request->name;
            $userReg->name_bn = $request->name_bn;
            $userReg->email = $request->email;
            $userReg->address = $request->address;
            $userReg->address_bn = $request->address_bn;
            $userReg->country_code= $request->countyCodePrefix;
            $userReg->phone= $phn;
            $userReg->password = Hash::make($request->password);
            $userReg->user_type = 'buyer';
            if($request->hasFile('nid_front')){
                $userReg->nid_front = $request->nid_front->store('uploads/nid');
            }
            if($request->hasFile('nid_back')){
                $userReg->nid_back = $request->nid_back->store('uploads/nid');
            }
            $userReg->multiple_user_types = json_encode(["buyer"]);
            $userReg->membership_package_id = $membership_package_id;
            $userReg->membership_activation_date = date('Y-m-d');
            $userReg->membership_expired_date = date('Y-m-d', strtotime('+1 year'));
            $userReg->banned = 1;
            $userReg->reg_by = 'web';
            $userReg->referral_code = mt_rand(000000,999999);

            if ($reffCheck){
                $userReg->referred_by = $request->referred_by;
            }
            $userReg->save();

            $buyer = new Buyer();
            $buyer->user_id = $userReg->id;
            $buyer->selected_category= json_encode($selectedCategories);
            $buyer->status = 0;
            $buyer->verification_status	= 1;
            $insert_id = $buyer->save();
            if($insert_id){
                $title = 'Buyer Registration';
                $message = $userReg->name .' registered as a new buyer.';
                registrationNotification($userReg->id,$title,$message);
            }
        }


        Session::put('phone',$request->phone);
        Session::put('password',$request->password);
        Session::put('user_type',$userReg->user_type);

        Toastr::success('Your registration successfully done! Please wait for admin approval.');
        return redirect()->route('get-verification-code',$userReg->id);

//        Toastr::success('Your registration successfully done! Please wait for admin approval.');
//        if ($userReg->user_type == 'seller')
//        {
//            return redirect()->route('seller.dashboard');
//        }
//        elseif ($userReg->user_type == 'employee')
//        {
//            return redirect()->route('employee.dashboard');
//        }
//        elseif ($userReg->user_type == 'buyer')
//        {
//            return redirect()->route('buyer.dashboard');
//        }

    }
    public function getPhoneNumber(){
        return view('auth.password_verification.check_phone_number');
    }

    public function checkPhoneNumber(Request $request){
        $user = User::where('phone',$request->phone)->first();
        if (!empty($user)) {
            $verification = VerificationCode::where('phone',$user->phone)->first();
            if (!empty($verification)){
                $verification->delete();
            }
            $verCode = new VerificationCode();
            $verCode->phone = $user->phone;
            $verCode->code = mt_rand(1111,9999);
            $verCode->status = 0;
            $verCode->save();
            $text = "Dear ".$user->name.", Your Fabric Lagbe OTP is ".$verCode->code;

            if($user->country_code == '+880') {
                UserInfo::smsAPI('880'.$verCode->phone, $text);
                $title = 'Forget Password';
                RegistrationSmsNotification($user->id,$title,$text);
                Toastr::success('Please check your Phone for OTP' ,'Success');
            }else{
                $receiver_email = $user->email;
//                $receiver_email = 'sayka.starit@gmail.com';
                $receiver_name = $user->name;
                $sender_email = 'fabricslagbe@gmail.com';
                $sender_name='Fabric Lagbe';
                $subject='Welcome To Fabric Lagbe';
                $message="<h3>Dear $user->name,<br /> welcome to <a href='https://www.fabriclagbe.com/'>fabriclagbe.com</a>!</h3><br /><b>Your OTP is $verCode->code.</b> <br/>
            <br/>
            <p> Best Regards</p>
            <p> Team, Fabric Lagbe LTD </p>";
                send_mailjet_mail1($receiver_email,$receiver_name,$sender_email,$sender_name,$subject,$message);
                $title = 'Forget Password';
                RegistrationSmsNotification($user->id,$title,$text);
                Toastr::success('Please check your Email for OTP' ,'Success');
            }

            return view('auth.password_verification.verification_code',compact('verCode'));
        }else{
            Toastr::error('This phone number does not exist to the system');
            return redirect()->back();
        }
    }
    public function otpStore(Request $request) {
        if ($request->isMethod('post')){
            $check = VerificationCode::where('code',$request->code)->where('phone',$request->phone)->where('status',0)->first();
            if (!empty($check)) {
                $check->status = 1;
                $check->update();
                $user = User::where('phone',$request->phone)->first();
                $user->verification_code = $request->code;
                $user->banned = 0;
                $user->save();
                if(Auth::check() && Auth::user()->user_type == 'seller'){
                    Toastr::success('Your phone number successfully verified. Now change your Password' ,'Success');
                    return redirect()->route('seller.edit-password');
                }elseif (Auth::check() && Auth::user()->user_type == 'buyer'){
                    Toastr::success('Your phone number successfully verified. Now change your Password' ,'Success');
                    return redirect()->route('buyer.edit-password');
                }
                else{
                    Toastr::success('Your phone number successfully verified.' ,'Success');
                    return view('auth.password_verification.reset_password',compact('user'));
                }

            }else{
                //$verCode = $request->phone;
                $verCode = VerificationCode::where('phone',$request->phone)->where('status',0)->first();
                Toastr::error('Invalid Code' ,'Error');
                return view('auth.password_verification.verification_code',compact('verCode'));
            }
        }
    }
    public function passwordUpdate(Request $request, $id) {
        $this->validate($request, [
            'password' => 'required|min:8',
        ]);
        $user = User::find($id);
        $user->password = Hash::make($request->password);
        $user->save();
        Toastr::success('Your Password Updated successfully verified.' ,'Success');
        return redirect()->route('login');
    }

    public function jobRegistration(){
        Session::put('type','employer_login');
        return view('auth.job_registration');
    }

    public function jobRegistrationEmployee(){
        return view('auth.register');
    }

    public function jobRegistrationEmployer(){
        Session::put('type','employer_register');
        return view('auth.register');
    }

    //Work Order
    public function workOrderRegistration(){
        Session::put('type','work_order_login');
        return view('auth.work_order_registration');
    }
    public function workOrderRegistrationBuyer(){
        Session::put('type','work_order_register');
        return view('auth.register');
    }
    public function workOrderRegistrationSeller(){
        Session::put('type','work_order_register');
        return view('auth.register');
    }
    public function getEducationDegree(Request $request){
        $educationLevel = EducationLevel::where('name',$request->degree_name)->first();
        $educationDegrees = EducationDegree::where('education_level_id',$educationLevel->id)->get();
        return $educationDegrees;
    }

}
