<?php

namespace App\Http\Controllers\Api;

use App\Helpers\UserInfo;
use App\Http\Controllers\Controller;
use App\Http\Resources\DistrictCollection;
use App\Http\Resources\DivisionCollection;
use App\Http\Resources\SalaryRangeCollection;
use App\Http\Resources\UnionCollection;
use App\Http\Resources\UnitCollection;
use App\Http\Resources\UpazilaCollection;
use App\Http\Resources\userProfileCollections;
use App\Http\Resources\workOrderProfileCollections;
use App\Model\BusinessSetting;
use App\Model\Buyer;
use App\Model\Category;
use App\Model\District;
use App\Model\Division;
use App\Model\Employee;
use App\Model\Employer;
use App\Model\IndustryCategory;
use App\Model\IndustryEmployeeType;
use App\Model\IndustrySubCategory;
use App\Model\MembershipPackage;
use App\Model\SalaryRange;
use App\Model\Seller;
use App\Model\Union;
use App\Model\Upazila;
use App\Model\VerificationCode;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class AuthController extends Controller
{
    public $successStatus = 201;
    public $failStatus = 401;
    public function sellerLogin(Request $request)
    {
        $credentials = [
            'phone' => $request->phone,
            'password' => $request->password,
            'banned' => 0,
        ];
        if(Auth::attempt($credentials))
        {
            $user = Auth::user();
            if ($user->user_type != 'employee' ){
                $user->user_type = 'seller';
                $user->save();
                $seller = Seller::where('user_id',Auth::id())->first();
                if (empty($seller)){
                    $seller = new Seller();
                    $seller->user_id = Auth::id();
                    $seller->employer_status = 0;
                    $seller->verification_status = 0;
                    $seller->save();
                }
                $seller->employer_status = 0;
                $seller->save();
                $success['token'] = $user->createToken('Fabric Lagbe')-> accessToken;
                $success['user'] = new userProfileCollections(User::where('id',$user->id)->get());
                return response()->json(['success'=>true,'response'=>$success], 201);
            }
            else{
                return response()->json(['success'=>false,'response'=>'Unauthorised'], 401);
            }

        }else{
            return response()->json(['success'=>false,'response'=>'Unauthorised'], 401);
        }
    }
    public function buyerLogin(Request $request)
    {
        //dd($request->all());
        $credentials = [
            'phone' => $request->phone,
            'password' => $request->password,
            'banned' => 0,
        ];
        if(Auth::attempt($credentials))
        {
            $user = Auth::user();
            if ($user->user_type != 'buyer'){
                $user->user_type = 'buyer';
                $user->save();
            }
            $success['token'] = $user->createToken('Fabric Lagbe')-> accessToken;
            $success['user'] = new userProfileCollections(User::where('id',$user->id)->get());
            return response()->json(['success'=>true,'response'=>$success], 201);
        }else{
            return response()->json(['success'=>false,'response'=>'Unauthorised'], 401);
        }
    }
    public function employerLogin(Request $request)
    {
        $credentials = [
            'phone' => $request->phone,
            'password' => $request->password,
            'banned' => 0,
        ];
        if(Auth::attempt($credentials))
        {
            $user = Auth::user();
            $employer = Employer::where('user_id',Auth::id())->first();
            if (empty($employer)){
                return response()->json(['success'=>false,'response'=>'You are not an Employer. Please register.'], 401);
            }
            if ($user->user_type != 'employee'){

                $seller = Seller::where('user_id',Auth::id())->first();
                if (empty($seller)){
                    return response()->json(['success'=>false,'response'=>'You can not be Employer. Apply for seller first.'], 401);
                }
                $user->user_type = 'seller';
                $user->save();

                $seller->employer_status = 1;
                $seller->save();
                $success['token'] = $user->createToken('Fabric Lagbe')-> accessToken;
                $success['user'] = new userProfileCollections(User::where('id',$user->id)->get());
                return response()->json(['success'=>true,'response'=>$success], 201);
            }else{
                return response()->json(['success'=>false,'response'=>'You can not be Employer'], 401);
            }

        }else{
            return response()->json(['success'=>false,'response'=>'Unauthorised'], 401);
        }
    }
    public function employeeLogin(Request $request)
    {
        //dd($request->all());
        $credentials = [
            'phone' => $request->phone,
            'password' => $request->password,
            'banned' => 0,
        ];
        if(Auth::attempt($credentials))
        {
            $user = Auth::user();
            if ($user->user_type == 'employee'){
                $success['token'] = $user->createToken('Fabric Lagbe')-> accessToken;
                $success['user'] = new userProfileCollections(User::where('id',$user->id)->get());
                return response()->json(['success'=>true,'response'=>$success], 201);
            }else{
                return response()->json(['success'=>false,'response'=>'Not Employee.'], 404);
            }

        }else{
            return response()->json(['success'=>false,'response'=>'Unauthorised'], 401);
        }
    }
    public function receiverLogin(Request $request)
    {
        //dd($request->all());
        $credentials = [
            'phone' => $request->phone,
            'password' => $request->password,
            'banned' => 0,
        ];
        if(Auth::attempt($credentials))
        {
            $user = Auth::user();
            if ($user->user_type != 'employee' ){
                $user->user_type = 'seller';
                $user->save();
                $seller = Seller::where('user_id',Auth::id())->first();
                if (empty($seller)){
                    $seller = new Seller();
                    $seller->user_id = Auth::id();
                    $seller->employer_status = 0;
                    $seller->verification_status = 0;
                    $seller->save();
                }
                $seller->employer_status = 0;
                $seller->save();
                $success['token'] = $user->createToken('Fabric Lagbe')-> accessToken;
                $success['user'] = new workOrderProfileCollections(User::where('id',$user->id)->get());
                return response()->json(['success'=>true,'response'=>$success], 201);
            }
            else{
                return response()->json(['success'=>false,'response'=>'Unauthorised'], 401);
            }

        }else{
            return response()->json(['success'=>false,'response'=>'Unauthorised'], 401);
        }
    }
    public function providerLogin(Request $request)
    {
        //dd($request->all());
        $credentials = [
            'phone' => $request->phone,
            'password' => $request->password,
            'banned' => 0,
        ];
        if(Auth::attempt($credentials))
        {
            $user = Auth::user();
            if ($user->user_type != 'buyer'){
                $user->user_type = 'buyer';
                $user->save();
            }
            $success['token'] = $user->createToken('Fabric Lagbe')-> accessToken;
            $success['user'] = new workOrderProfileCollections(User::where('id',$user->id)->get());
            return response()->json(['success'=>true,'response'=>$success], 201);
        }else{
            return response()->json(['success'=>false,'response'=>'Unauthorised'], 401);
        }
    }

    //========================== Seller registration  ============================//
    public function register(Request $request)
    {
        $this->validate($request, [

            'phone' => 'required|unique:users',
            'password' => 'required|min:8',
        ]);
        $phn1 = (int)$request->phone;
        $check = User::where('phone',$phn1)->first();
        if (!empty($check)){
            return response()->json(['success'=>true,'response' =>'This phone number already exist!'], $this->failStatus);
        }

        if($request->country_code == +880){
            $phn = (int)$request->phone;
        }else{
            $this->validate($request, [
                'email' => 'required',
            ]);
            $phn = $request->phone;
        }

        $membership_package_id = MembershipPackage::where('package_name','General')->pluck('id')->first();
        if(empty($membership_package_id)){
            return response()->json(['success'=>true,'response' =>'General Membership Package Not Found Yet!'], $this->failStatus);
        }
        $reffCheck = User::where('referral_code',$request->referred_by)->first();
        $seller = '';
        $buyer = '';
        if ($request->user_type == 'seller'){

            $selected_categories = json_decode($request->selected_category);
            foreach ($selected_categories as $selected_cat){
                $idss[] = $selected_cat;
            }
            $selected_category = implode(',', $idss);

            $userReg = new User();
            $userReg->name = $request->name;
            $userReg->name_bn = $request->name_bn;
            $userReg->email = $request->email;
            $userReg->address = $request->home_address;
            $userReg->address_bn = $request->address_bn;
            $userReg->country_code= $request->country_code;
            $userReg->phone= $phn;
            $userReg->password = Hash::make($request->password);
            $userReg->user_type = 'seller';
            $userReg->multiple_user_types = json_encode(["seller"]);
            $userReg->membership_package_id = $membership_package_id;
            $userReg->membership_activation_date = date('Y-m-d');
            $userReg->membership_expired_date = date('Y-m-d', strtotime('+1 year'));
            $userReg->banned = 1;
            $userReg->reg_by = 'apps';
            $userReg->referral_code = mt_rand(000000,999999);
            if ($reffCheck){
                $userReg->referred_by = $request->referred_by;
            }
            $userReg->save();

            $seller = new Seller();
            $seller->user_id = $userReg->id;
            $seller->company_name = $request->company_name;
            $seller->company_name_bn = $request->company_name_bn;
            $seller->company_phone = $request->company_phone;
            $seller->company_email = $request->company_email;
            $seller->company_address = $request->company_address;
            $seller->company_address_bn = $request->company_address_bn;
            $seller->verification_status= 0;
            $seller->division_id= $request->division_id;
            $seller->district_id= $request->district_id;
            $seller->designation= $request->designation;
            $seller->selected_category_old = $selected_category;

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
                // admin sms
//                    UserInfo::smsAPI('8801725930131', $message);
//                    SmsNotification(9,$title,$message);
            }
        }
        else{
            $userReg = new User();
            $userReg->name = $request->name;
            $userReg->name_bn = $request->name_bn;
            $userReg->email = $request->email;
            $userReg->address = $request->home_address;
            $userReg->address_bn = $request->address_bn;
            //$userReg->country_code= $request->country_code;
            $userReg->country_code= '+880';
            $userReg->phone= $phn;
            $userReg->password = Hash::make($request->password);
            $userReg->user_type = 'buyer';
            $userReg->multiple_user_types = json_encode(["buyer"]);
            $userReg->membership_package_id = $membership_package_id;
            $userReg->membership_activation_date = date('Y-m-d');
            $userReg->membership_expired_date = date('Y-m-d', strtotime('+1 year'));
            $userReg->banned = 1;
            $userReg->reg_by = 'apps';
            $userReg->referral_code = mt_rand(000000,999999);
            if ($reffCheck){
                $userReg->referred_by = $request->referred_by;
            }
            $userReg->save();

            $buyer = new Buyer();
            $buyer->user_id = $userReg->id;
            $buyer->status = 0;
            $buyer->verification_status	= 1;
            $insert_id = $buyer->save();
            if($insert_id){
                $title = 'Buyer Registration';
                $message = $userReg->name .' registered as a new buyer.';
                registrationNotification($userReg->id,$title,$message);
                // admin sms
//                UserInfo::smsAPI('8801725930131', $message);
//                SmsNotification(9,$title,$message);
            }
        }

        if (!empty($userReg)){
            mobileVerification($userReg);
            $success['token'] = $userReg->createToken('Fabric Lagbe')-> accessToken;
            $success['details'] = $userReg;
            $success['seller'] = $seller;
            $success['buyer'] = $buyer;
            return response()->json(['success'=>true,'response' =>$success], $this->successStatus);
        }else{
            return response()->json(['success'=>false,'response' =>'Something went wrong!'], $this->failStatus);
        }
    }

    public function employeeRegister(Request $request){
        $this->validate($request, [

            'phone' => 'required|unique:users',
            'password' => 'required|min:8',
        ]);
        $phn1 = (int)$request->phone;
        $check = User::where('phone',$phn1)->first();
        if (!empty($check)){
            return response()->json(['success'=>true,'response' =>'This phone number already exist!'], $this->failStatus);
        }
        if($request->country_code == +880){
            $phn = (int)$request->phone;
        }else{
            $this->validate($request, [
                'email' => 'required',
            ]);
            $phn = $request->phone;
        }
        if ($request->confirm_password != $request->password) {
            return response()->json(['success'=>false,'response' =>'Password does not match with Confirm password'], $this->failStatus);
        }
        $membership_package_id = MembershipPackage::where('package_name','General')->pluck('id')->first();
        $reffCheck = User::where('referral_code',$request->referred_by)->first();
        $userReg = new User();
        $userReg->name = $request->name;
        $userReg->name_bn = $request->name_bn;
        $userReg->email = $request->email;
        $userReg->address = $request->home_address;
        $userReg->address_bn = $request->address_bn;
        $userReg->country_code= $request->country_code;
        $userReg->phone= $phn;
        $userReg->password = Hash::make($request->password);
        $userReg->user_type = 'employee';
        $userReg->multiple_user_types = json_encode(["employee"]);
        $userReg->membership_package_id = $membership_package_id;
        $userReg->membership_activation_date = date('Y-m-d');
        $userReg->membership_expired_date = date('Y-m-d', strtotime('+1 year'));
        $userReg->banned = 1;
        $userReg->reg_by = 'apps';
        $userReg->referral_code = mt_rand(000000,999999);
        if ($reffCheck){
            $userReg->referred_by = $request->referred_by;
        }
        $insert_id = $userReg->save();

        $employee = new Employee();
        $employee->user_id = $userReg->id;
        $employee->division_id= $request->division_id;
        $employee->district_id= $request->district_id;
        $employee->upazila_id = $request->upazila_id;
        $employee->union_id = $request->union_id;
        $employee->village_or_area = $request->village_or_area;
        $employee->marital_status = $request->marital_status;
        $employee->gender = $request->gender;
        $employee->age = $request->age;
        $employee->current_salary = $request->current_salary;
        $employee->expected_salary = $request->expected_salary;
        $employee->joining_duration = $request->joining_duration;
        $employee->experience = $request->experience;
        $employee->looking_job_industry_category_id = $request->looking_job_industry_category_id;
        $employee->industry_category_id = $request->industry_category_id;
        $employee->industry_sub_category_id = $request->industry_sub_category_id;
        $employee->industry_employee_type_id = $request->industry_employee_type_id;
        $employee->verification_status= 0;

        if($request->hasFile('nid_front_side')){
            $employee->nid_front_side = $request->nid_front_side->store('uploads/employee_info/nid_front_side');
        }

        if($request->hasFile('nid_back_side')){
            $employee->nid_back_side = $request->nid_back_side->store('uploads/employee_info/nid_back_side');
        }

        if($request->hasFile('employee_pic')){
            $employee->employee_pic = $request->employee_pic->store('uploads/employee_info/employee_pic');
        }
        $employee_insert_id = $employee->save();
        if($employee_insert_id){
            $title = 'Employee Registration';
            $message =  $userReg->name .' registered as a new employee.';
            registrationNotification($userReg->id,$title,$message);
            // admin sms
//                    UserInfo::smsAPI('8801725930131', $message);
        }else{
            User::find($insert_id)->delete();
            return response()->json(['success'=>false,'response' =>'Something went wrong. Please Try Again!'], $this->failStatus);
        }
        if (!empty($userReg)){
            mobileVerification($userReg);
            $success['token'] = $userReg->createToken('Fabric Lagbe')-> accessToken;
            $success['details'] = $userReg;
            $success['employee'] = $employee;
            return response()->json(['success'=>true,'response' =>$success], $this->successStatus);
        }else{
            return response()->json(['success'=>false,'response' =>'Something went wrong!'], $this->failStatus);
        }
    }

    public function employerRegister(Request $request){

       $seller = Seller::where('user_id',Auth::id())->first();
        $seller->company_name = $request->company_name;
        $seller->company_phone = $request->company_phone;
        $seller->company_email = $request->company_email;
        $seller->company_address = $request->company_address;
        $seller->save();

        $checkEmployer = Employer::where('seller_id',$seller->id)->first();
        if (!empty($checkEmployer)){
            return response()->json(['success'=>false,'response' =>'You are already a Employer'], $this->failStatus);
        }
        $employer = new Employer();
        $employer->user_id = Auth::id();
        $employer->seller_id = $seller->id;
        $employer->industry_category_id = json_encode($request->industry_category_id);
        $employer->no_of_employee = $request->no_of_employee;
        $employer->salary_type = $request->salary_type;
        $employer->owner_name = $request->owner_name;
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
        $employer->save();
        if (!empty($employer)){
            return response()->json(['success'=>true,'response' =>'Registration Successful'], $this->successStatus);
        }else{
            return response()->json(['success'=>false,'response' =>'Something went wrong!'], $this->failStatus);
        }
    }
    //========================== Logout  ============================//
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function userDetails()
    {
        return new  userProfileCollections(User::where('id',Auth::id())->get());
    }

    //================================== change password ======================================//
    public function changePass(Request $request)
    {
        $this->validate($request, [
            'new_password' => 'required|min:8',
        ]);
        $user = User::where('phone',$request->phone)->first();
        $user->password = Hash::make($request->new_password);
        $user->save();
        if (!empty($user))
        {
            return response()->json(['success'=>true,'response'=> $user], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }

    }
    public function getDivisions(){
//        return new DivisionCollection(Division::all());
        $divisions = Division::orderBy('name','ASC')->get();
        $nestedData = [];
        foreach ($divisions as $division){
            $data['id']=$division->id;
            $data['name']=getNameByBnEn($division);
            array_push($nestedData,$data);
        }
        if (!empty($nestedData)){
            return response()->json(['success'=>true,'response' =>$nestedData], $this->successStatus);
        }else{
            return response()->json(['success'=>false,'response' =>'Something went wrong!'], $this->failStatus);
        }
    }
    public function getDistricts($id){
//        return new DistrictCollection(District::where('division_id',$id)->orderBy('name','ASC')->get());
        $districts = District::where('division_id',$id)->orderBy('name','ASC')->get();
        $nestedData = [];
        foreach ($districts as $district){
            $data['id']=$district->id;
            $data['name']=getNameByBnEn($district);
            array_push($nestedData,$data);
        }
        if (!empty($nestedData)){
            return response()->json(['success'=>true,'response' =>$nestedData], $this->successStatus);
        }else{
            return response()->json(['success'=>false,'response' =>'Something went wrong!'], $this->failStatus);
        }
    }
    public function getThanas($id){
//        return new UpazilaCollection(Upazila::where('district_id',$id)->orderBy('name','ASC')->get());
        $thanas = Upazila::where('district_id',$id)->orderBy('name','ASC')->get();
        $nestedData = [];
        foreach ($thanas as $thana){
            $data['id']=$thana->id;
            $data['name']=getNameByBnEn($thana);
            array_push($nestedData,$data);
        }
        if (!empty($nestedData)){
            return response()->json(['success'=>true,'response' =>$nestedData], $this->successStatus);
        }else{
            return response()->json(['success'=>false,'response' =>'Something went wrong!'], $this->failStatus);
        }
    }
    public function getPostOffices($id){
//        return new UnionCollection(Union::where('upazilla_id',$id)->orderBy('name','ASC')->get());
        $postOffices = Union::where('upazilla_id',$id)->orderBy('name','ASC')->get();
        $nestedData = [];
        foreach ($postOffices as $postOffice){
            $data['id']=$postOffice->id;
            $data['name']=getNameByBnEn($postOffice);
            array_push($nestedData,$data);
        }

        if (!empty($nestedData)){
            return response()->json(['success'=>true,'response' =>$nestedData], $this->successStatus);
        }else{
            return response()->json(['success'=>false,'response' =>'Something went wrong!'], $this->failStatus);
        }
    }
    public function getSalaryRanges(){
        $salaryRanges = SalaryRange::all();
        return new SalaryRangeCollection($salaryRanges);
    }
    public function getIndustryCategories(){
        $industryCategories = IndustryCategory::all();
//        $nestedData = [];
//        foreach ($industryCategories as $industryCategory){
//            $data['id']=$industryCategory->id;
//            $data['user_id']=$employeeJob->user_id;
//            $data['employee_id']=$employeeJob->employee_id;
//            $data['created_at']=$employeeJob->created_at;
//            $data['updated_at']=$employeeJob->updated_at;
//            array_push($nestedData,$data);
//        }

        if (!empty($industryCategories)){
            return response()->json(['success'=>true,'response' =>$industryCategories], $this->successStatus);
        }else{
            return response()->json(['success'=>false,'response' =>'Something went wrong!'], $this->failStatus);
        }
    }
    public function getIndustrySubCategories($id){
        $industrySubCategories = IndustrySubCategory::where('industry_category_id',$id)->get();

        if (!empty($industrySubCategories)){
            return response()->json(['success'=>true,'response' =>$industrySubCategories], $this->successStatus);
        }else{
            return response()->json(['success'=>false,'response' =>'Something went wrong!'], $this->failStatus);
        }
    }
    public function getIndustryEmployeeTypes(Request $request){
        $industryEmployeeTypes = IndustryEmployeeType::where('industry_category_id',$request->industry_category_id)->where('industry_sub_category_id',$request->industry_sub_category_id)->get();
        if (!empty($industryEmployeeTypes)) {
            return response()->json(['success'=>true,'response' =>$industryEmployeeTypes], $this->successStatus);
        }else{
            return response()->json(['success'=>false,'response' =>'Something went wrong!'], $this->failStatus);
        }
    }
    public function getCategories(){
        $categories = Category::all();

        if (!empty($categories)){
            return response()->json(['success'=>true,'response' =>$categories], $this->successStatus);
        }else{
            return response()->json(['success'=>false,'response' =>'Something went wrong!'], $this->failStatus);
        }
    }

    public function checkPhoneNumber(Request $request){
        $user = User::where('phone',$request->phone)->where('country_code',$request->country_code)->first();
        if (!empty($user)) {
            mobileVerification($user);
            return response()->json(['success'=>true,'response' =>'Phone number matched successfully. Please send OTP code to change password.'], $this->successStatus);
        }else{
            return response()->json(['success'=>false,'response'=>'This phone number does not exist to the system'], 401);
        }
    }
    public function profileImageUpdate(Request $request){
        $this->validate($request,[
           'avatar_original' => 'required',
        ]);
        $user = User::find(Auth::id());
        if ($request->hasFile('avatar_original')){
            $user->avatar_original = $request->avatar_original->store('uploads/profile');
        }
        $user->save();
        if ($user){
            return response()->json(['success'=>true,'response'=>'Profile Picture Updated Successfully'],200);
        }else{
            return response()->json(['success'=>false,'response'=>'Something Went Wrong'],401);
        }
    }

}
