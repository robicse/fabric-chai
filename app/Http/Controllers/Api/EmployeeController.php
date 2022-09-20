<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityCorporationCollection;
use App\Model\CityCorporation;
use App\Model\EducationDegree;
use App\Model\EducationLevel;
use App\Model\Employee;
use App\Model\EmployeeEducation;
use App\Model\EmployeeJobExperience;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function profileDetails(){
        $employee = Employee::where('user_id',Auth::id())->first();
        $current_salary = explode(' - ',$employee->current_salary);
        $expected_salary = explode(' - ',$employee->expected_salary);
        $data['name'] = getNameByBnEn($employee->user);
        $data['email'] = $employee->user->email;
        $data['country_code'] = $employee->user->country_code;
        $data['phone'] = $employee->user->phone;
        $data['marital_state'] = $employee->marital_status;
        $data['age'] =(string) getNumberToBangla($employee->age);
        $data['gender'] = $employee->gender;
        $data['division_id'] =(integer) $employee->division_id;
        $data['division_name'] =(string) $employee->division? getNameByBnEn($employee->division) : '';
        $data['district_id'] =(integer) $employee->district_id;
        $data['district_name'] =(string) $employee->district ? getNameByBnEn($employee->district) :'';
        $data['upazila_id'] =(integer) $employee->upazila_id;
        $data['upazila_name'] =(string) $employee->upazila ? getNameByBnEn($employee->upazila) : '';
        $data['union_id'] =(integer) $employee->union_id;
        $data['union_name'] =(string) $employee->union ? getNameByBnEn($employee->union) : '';
        $data['city_corporation'] =(string) $employee->city_corporation;
        $data['village_or_area'] = $employee->village_or_area;
        $data['current_salary_bdt'] =(string) $employee->current_salary ?  getNumberToBangla($current_salary[0]) .' - '. getNumberToBangla($current_salary[1]):'';
        $data['current_salary_usd'] =(string) $employee->current_salary ? getNumberToBangla(convert_to_usd($current_salary[0])) .' - '. getNumberToBangla(convert_to_usd($current_salary[1])): '';
        $data['expected_salary_bdt'] = (string) $employee->expected_salary ?getNumberToBangla($expected_salary[0])  .' - '. getNumberToBangla($expected_salary[1]):'';
        $data['expected_salary_usd'] =(string) $employee->expected_salary ? getNumberToBangla(convert_to_usd($expected_salary[0])) .' - '. getNumberToBangla(convert_to_usd($expected_salary[1])) : '';
        $data['experience'] = $employee->experience;
        $data['looking_job_id'] =(integer) $employee->looking_job_industry_category_id;
        $data['looking_for_job_name'] = $employee->lookingForJob ? getNameByBnEn($employee->lookingForJob):'';
        $data['joining_duration'] = $employee->joining_duration;
        $data['employee_type_id'] =(integer) $employee->industry_employee_type_id;
        $data['employee_type_name'] = $employee->industryemployeetype ? getNameByBnEn($employee->industryemployeetype) : '';
        $data['industry_subcategory_id'] =(integer) $employee->industry_sub_category_id;
        $data['industry_subcategory_name'] =$employee->industrysubcategory ? getNameByBnEn($employee->industrysubcategory) : '';
        $data['industry_category_id'] =(integer) $employee->industry_category_id;
        $data['industry_category_name'] =$employee->industrycategory ? getNameByBnEn($employee->industrycategory) : '';
        $data['nid_front_side'] = $employee->nid_front_side;
        $data['nid_back_side'] = $employee->nid_back_side;
        $data['employee_pic'] = $employee->employee_pic;
        if (!empty($data))
        {
            return response()->json(['success'=>true,'response'=> $data], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }

    }
    public function profileUpdate(Request $request){
        $employee = Employee::where('user_id',Auth::id())->first();
        $user = User::find(Auth::id());

        $user->name = $request->name;
        $user->email = $request->email;
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

//        $job_experience = [];
//        if (!empty($request->designation)){
//            $row = count($request->designation);
//            for ($i = 0 ; $i < $row; $i++){
//                $data['designation']= $request->designation[$i];
//                $data['company_name']= $request->company_name[$i];
//                $data['start_year']= $request->start_year[$i];
//                $data['end_year']= $request->end_year[$i];
//                $data['response']= $request->response[$i];
//                array_push($job_experience,$data);
//            }
//        }
//        $employee->job_experience = $job_experience;



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
        if (!empty($employee))
        {
            return response()->json(['success'=>true,'response'=> 'Profile Updated Successfully'], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function jobStatusUpdate(){
        $employee = Employee::where('user_id',Auth::id())->first();
        if ($employee->current_job_status == 0){
            $employee->current_job_status = 1;
        }else{
            $employee->current_job_status = 0;
        }
        $employee->save();
        $success['current_job_status']=(integer)$employee->current_job_status;
        $success['response']='Current Job Status Updated Successfully';
        if (!empty($employee))
        {
            return response()->json(['success'=>true,'response'=> $success], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function getCityCorporation(){
//        return new CityCorporationCollection(CityCorporation::all());
        $cityCorporations = CityCorporation::all();
        $nestedData = [];
        foreach ($cityCorporations as $cityCorporation){
            $data['id']=$cityCorporation->id;
            $data['name']=getNameByBnEn($cityCorporation);
            array_push($nestedData,$data);
        }
        if (!empty($nestedData))
        {
            return response()->json(['success'=>true,'response'=> $nestedData], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function geteducationLevels(){
        $levels = EducationLevel::all();
        if (!empty($levels))
        {
            return response()->json(['success'=>true,'response'=> $levels], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function getEducationDegree($id){
        $degree = EducationDegree::where('education_level_id',$id)->get();
        if (!empty($degree))
        {
            return response()->json(['success'=>true,'response'=> $degree], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
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

        if (!empty($employeeEd))
        {
            return response()->json(['success'=>true,'response'=> 'Employee Education Added Successfully'], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function educationUpdate(Request $request,$id){
        $education = EmployeeEducation::find($id);
        $education->level= $request->level;
        $education->degree = $request->degree;
        $education->institute = $request->institute;
        $education->passing_year = $request->passing_year;
        $education->group = $request->group;
        $education->result = $request->result;
        $education->save();

        if (!empty($education))
        {
            return response()->json(['success'=>true,'response'=> 'Employee Education Updated Successfully'], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function educationDelete($id){
        $education = EmployeeEducation::find($id);
        if($education->delete()){
            return response()->json(['success'=>true,'response'=> 'Employee Education deleted Successfully'], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }

    }
    public function educationDetails(){

        $educations = EmployeeEducation::where('user_id',Auth::id())->get();

        $nestedData = [];
        foreach ($educations as $education){
            $data['id']=$education->id;
            $data['user_id']=$education->user_id;
            $data['employee_id']=$education->employee_id;
            $data['level']=$education->level;
            $data['degree']=$education->degree;
            $data['institute']=$education->institute;
            $data['passing_year']=(string) getNumberToBangla($education->passing_year);
            $data['group']=$education->group;
            $data['result']=(string) getNumberToBangla($education->result);
            $data['created_at']=$education->created_at;
            $data['updated_at']=$education->updated_at;
            array_push($nestedData,$data);
        }
        if (!empty($nestedData))
        {
            return response()->json(['success'=>true,'response'=> $nestedData], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
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
        if (!empty($employeeJob))
        {
            return response()->json(['success'=>true,'response'=> 'Employee Job Experience Added Successfully'], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function jobExperienceUpdate(Request $request, $id){
        $employeeJob = EmployeeJobExperience::find($id);
        $employeeJob->designation = $request->designation;
        $employeeJob->company_name = $request->company_name;
        $employeeJob->start_year = $request->start_year;
        $employeeJob->end_year = $request->end_year;
        $employeeJob->response = $request->response;
        $employeeJob->save();
        if (!empty($employeeJob))
        {
            return response()->json(['success'=>true,'response'=> 'Employee Job Experience Updated Successfully'], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function jobExperienceDelete($id){
        $employeeJob = EmployeeJobExperience::find($id);
        if($employeeJob->delete()){
            return response()->json(['success'=>true,'response'=> 'Employee Job Experience deleted Successfully'], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }

    }
    public function jobExperienceDetails(){
        $employeeJobs = EmployeeJobExperience::where('user_id',Auth::id())->get();
        $nestedData = [];
        foreach ($employeeJobs as $employeeJob){
            $data['id']=$employeeJob->id;
            $data['user_id']=$employeeJob->user_id;
            $data['employee_id']=$employeeJob->employee_id;
            $data['designation']=$employeeJob->designation;
            $data['company_name']=$employeeJob->company_name;
            $data['start_year']=(string) getNumberToBangla($employeeJob->start_year);
            $data['end_year']=(string) getNumberToBangla($employeeJob->end_year);
            $data['response']=$employeeJob->response;
            $data['created_at']=$employeeJob->created_at;
            $data['updated_at']=$employeeJob->updated_at;
            array_push($nestedData,$data);
        }
        if (!empty($nestedData))
        {
            return response()->json(['success'=>true,'response'=> $nestedData], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
}
