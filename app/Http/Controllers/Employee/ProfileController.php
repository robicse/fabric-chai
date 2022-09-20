<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Model\Employee;
use App\Model\EmployeeEducation;
use App\Model\EmployeeJobExperience;
use App\Model\ProductBid;
use App\Model\SalaryRange;
use App\Model\Seller;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function viewProfile(){
        $employee = Employee::where('user_id',Auth::id())->first();
        return view('frontend.employee.view_profile',compact('employee'));
    }
    public function editProfile(){
        $employee = Employee::where('user_id',Auth::id())->first();
        return view('frontend.employee.edit_profile',compact('employee'));
    }

    public function updateProfile(Request $request) {

        $this->validate($request, [
            'name' => 'required',
        ]);
        $user = User::findOrFail(Auth::id());
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->hasFile('avatar_original')){
            $user->avatar_original = $request->avatar_original->store('uploads/profile');
        }
        $user->update();

        $employee = Employee::where('user_id',Auth::id())->first();
        $employee->division_id= $request->division_id ? $request->division_id : NULL;
        $employee->district_id= $request->district_id ? $request->district_id : NULL;
        $employee->upazila_id = $request->upazila_id;
        $employee->union_id = $request->union_id;
        $employee->village_or_area = $request->village_or_area;
        $employee->city_corporation = $request->city_corporation;
        $employee->marital_status = $request->marital_status;
        $employee->gender = $request->gender;
        $employee->age = $request->age;
        $employee->current_salary = $request->current_salary;
        $employee->expected_salary = $request->expected_salary;
        $employee->joining_duration = $request->joining_duration;
        $employee->experience = $request->experience;
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
        $employee->save();

        Toastr::success('Profile Updated Successfully');
        return redirect()->route('employee.view-profile');

    }
    public function editPassword(){
        return view('frontend.employee.edit_password');
    }
    public function updatePassword(Request $request) {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8',
        ]);
        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->old_password, $hashedPassword)) {
            if (!Hash::check($request->password, $hashedPassword)) {
                if ($request->confirm_password == $request->password) {
                    $user = \App\User::find(Auth::id());
                    $user->password = Hash::make($request->password);
                    $user->save();
                    Toastr::success('Password Updated Successfully','Success');
                    Auth::logout();
                    return redirect()->route('login');
                }else{
                    Toastr::error('New password does not match with confirm password.', 'Error');
                    return redirect()->back();
                }

            } else {
                Toastr::error('New password cannot be the same as old password.', 'Error');
                return redirect()->back();
            }
        } else {
            Toastr::error('Current password not match.', 'Error');
            return redirect()->back();
        }
    }
    public function educationStore(Request $request){
        $employee = Employee::where('user_id',Auth::id())->first();
        $employeeEd = new EmployeeEducation();

        $employeeEd->user_id= Auth::id();
        $employeeEd->employee_id= $employee->id;
        $employeeEd->level= $request->level;
        $employeeEd->degree = $request->degree;
        $employeeEd->institute = $request->institute;
        $employeeEd->passing_year = $request->passing_year;
        $employeeEd->group = $request->group;
        $employeeEd->result = $request->result;
        $employeeEd->save();

        Toastr::success('Employee Education Added Successfully');
        return back();
    }
    public function educationEdit(Request $request){
        $education = EmployeeEducation::find($request->id);
        return view('frontend.employee.education_edit_modal',compact('education'));
    }
    public function educationUpdate(Request $request){
        $education = EmployeeEducation::find($request->education_id);
        $education->level= $request->level;
        $education->degree = $request->degree;
        $education->institute = $request->institute;
        $education->passing_year = $request->passing_year;
        $education->group = $request->group;
        $education->result = $request->result;
        $education->save();

        Toastr::success('Employee Education Updated Successfully');
        return back();
    }
    public function educationDelete($id){
        $education = EmployeeEducation::find($id);
        $education->delete();
        Toastr::success('Employee Education Deleted Successfully');
        return back();
    }
    public function jobExperienceStore(Request $request){
        $employee = Employee::where('user_id',Auth::id())->first();

        $employeeJob = new EmployeeJobExperience();
        $employeeJob->user_id = Auth::id();
        $employeeJob->employee_id = $employee->id;
        $employeeJob->designation = $request->designation;
        $employeeJob->company_name = $request->company_name;
        $employeeJob->start_year = $request->start_year;
        $employeeJob->end_year = $request->end_year;
        $employeeJob->response = $request->response;
        $employeeJob->save();

        Toastr::success('Employee Job Experience Added Successfully');
        return back();
    }
    public function jobExperienceEdit(Request $request){
        $employeeJob = EmployeeJobExperience::find($request->id);
        return view('frontend.employee.job_experience_edit_modal',compact('employeeJob'));
    }
    public function jobExperienceUpdate(Request $request){
        $employeeJob = EmployeeJobExperience::find($request->id);
        $employeeJob->designation = $request->designation;
        $employeeJob->company_name = $request->company_name;
        $employeeJob->start_year = $request->start_year;
        $employeeJob->end_year = $request->end_year;
        $employeeJob->response = $request->response;
        $employeeJob->save();

        Toastr::success('Employee Job Experience Updated Successfully');
        return back();
    }
    public function jobExperienceDelete($id){
        $employeeJob = EmployeeJobExperience::find($id);
        $employeeJob->delete();
        Toastr::success('Employee Job Experience Deleted Successfully');
        return back();
    }
}
