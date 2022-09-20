<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UserInfo;
use App\Http\Controllers\Controller;
use App\Model\Employee;
use App\Model\MembershipPackage;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:employee-list|employee-create|employee-profile-edit', ['only' => ['index','store']]);
        $this->middleware('permission:employee-create', ['only' => ['create','store']]);
        $this->middleware('permission:employee-profile-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:employee-password-edit', ['only' => ['editPassword','updatePassword']]);
        $this->middleware('permission:employee-verification', ['only' => ['verification']]);
    }
    public function index(){
        $employees = Employee::latest()->get();
        return view('backend.admin.employee.index',compact('employees'));
    }
    public function employeeListAjax(){
        return Employee::ajaxEmployeeList();
    }

    public function create()
    {
        return view('backend.admin.employee.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' =>  'required',
            'phone' =>  'required',
            //'password' => 'required|min:8',
        ]);
        $phn1 = (int)$request->phone;
        $check = User::where('phone',$phn1)->first();
        if (!empty($check)){
            Toastr::error('This phone number already exist');
            return back();
        }

        if($request->countyCodePrefix == +880){
            $phn = (int)$request->phone;
        }else{
            $phn = $request->phone;
        }

        $membership_package_id = MembershipPackage::where('package_name','General')->pluck('id')->first();
        if(empty($membership_package_id)){
            Toastr::error('General Membership Package Not Found Yet!');
            return back();
        }

        // default password
        $default_password = '123456';

        $userReg = new User();
        $userReg->name = $request->name;
        $userReg->country_code= $request->countyCodePrefix;
        $userReg->phone= $phn;
        $userReg->email = $request->email;
        $userReg->password = Hash::make($default_password);
        $userReg->user_type = 'employee';
        $userReg->multiple_user_types = json_encode(["employee"]);
        $userReg->membership_package_id = $membership_package_id;
        $userReg->membership_activation_date = date('Y-m-d');
        $userReg->membership_expired_date = date('Y-m-d', strtotime('+1 year'));
        $userReg->banned = 0;

        $insert_id = $userReg->save();
        if($insert_id){
            $employee = new Employee();
            $employee->user_id = $userReg->id;
            $employee->division_id= $request->countyCodePrefix == '+880' ? $request->division_id : NULL;
            $employee->district_id= $request->countyCodePrefix == '+880' ? $request->district_id : NULL;
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
            $employee->verification_status= 1;


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
                $message = 'Dear, '. $userReg->name .' New Registration Completed As A Employee From NSTAR Administrator. Site URL: https://fabriclagbe.com/ .Your username:' . $phn . ' and password: '. $default_password;
                registrationNotificationAdmin($userReg->id,$title,$message);
                Toastr::success('Employee Registration Created Successfully');
                return redirect()->route('admin.employee.index');
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
    public function edit($id){
        $employee = Employee::find(decrypt($id));
        return view('backend.admin.employee.edit',compact('employee'));
    }
    public function update(Request $request, $id){

        $employee = Employee::find($id);
        $user = User::find($employee->user_id);
        $phn1 = (int)$request->phone;

        $check = User::where('id','!=',$user->id)->where('phone',$phn1)->first();
        if (!empty($check)){
            Toastr::error('This phone number already exist');
            return back();
        }
        if($request->countyCodePrefix == +880){
            $phn = (int)$request->phone;
        }else{
            $phn = $request->phone;
        }
        $user->name = $request->name;
        $user->country_code= $request->countyCodePrefix;
        $user->phone= $phn;
        $user->email = $request->email;



        $employee->division_id= $request->countyCodePrefix == '+880' ? $request->division_id : NULL;
        $employee->district_id= $request->countyCodePrefix == '+880' ? $request->district_id : NULL;
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

        if($request->hasFile('nid_front_side')){
            $employee->nid_front_side = $request->nid_front_side->store('uploads/employee_info/nid_front_side');
        }

        if($request->hasFile('nid_back_side')){
            $employee->nid_back_side = $request->nid_back_side->store('uploads/employee_info/nid_back_side');
        }

        if($request->hasFile('employee_pic')){
            $employee->employee_pic = $request->employee_pic->store('uploads/employee_info/employee_pic');
        }
        $user->save();
        $employee->save();
        Toastr::success('Employee Updated Successfully');
        return redirect()->route('admin.employee.index');
    }

    public function detailsModal(Request $request){
        $employee = Employee::find($request->id);
        return view('backend.admin.employee.details_modal',compact('employee'));
    }

    public function verification(Request $request)
    {
        $employee = Employee::find($request->id);
        $employee->verification_status = $request->status;
        if($employee->save()){
            $user = User::where('id',$employee->user_id)->first();
            $title = 'Approved Employee';
            $message = 'Dear, '. $user->name .' your employee account has been approved by fabriclagbe.com';
            createNotification($employee->user_id,$title,$message);
            if($user->country_code == '+880') {
                UserInfo::smsAPI('880'. $user->phone, $message);
                SmsNotification($user->id,$title,$message);
            }
            return 1;
        }
        return 0;
    }
    public function editPassword($id){
        $employee = Employee::find(decrypt($id));
        $user = User::find($employee->user_id);
        return view('backend.admin.employee.edit_password',compact('employee','user'));
    }

    public function updatePassword(Request $request, $id){

        $this->validate($request, [
            'password' =>  'required|min:8',
        ]);
        $user = User::find($id);
        if ($request->confirm_password == $request->password) {
            $user->password = Hash::make($request->password);
            $user->save();
            Toastr::success('Password Updated Successfully','Success');
            return redirect()->route('admin.employee.index');
        }else{
            Toastr::error('New password does not match with confirm password.', 'Error');
            return redirect()->back();
        }
    }


public function unApproveEmployeeList(){
    return view('backend.admin.employee.unapproved_user_list');
}
public function unApproveEmployeeListAjax(){
    return Employee::ajaxUnApproveEmployeeList();
}

public function unApproveEmployerList(){
    return view('backend.admin.employee.unapproved_user_list');
}


}
