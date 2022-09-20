<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\DataTables;

class Employee extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function division(){
        return $this->belongsTo('App\Model\Division', 'division_id');
    }

    public function district(){
        return $this->belongsTo('App\Model\District', 'district_id');
    }

    public function upazila(){
        return $this->belongsTo('App\Model\Upazila', 'upazila_id');
    }
    public function union(){
        return $this->belongsTo('App\Model\Union', 'union_id');
    }


    public function industrycategory(){
        return $this->belongsTo('App\Model\IndustryCategory', 'industry_category_id');
    }

    public function industrysubcategory(){
        return $this->belongsTo('App\Model\IndustrySubCategory', 'industry_sub_category_id');
    }

    public function industryemployeetype(){
        return $this->belongsTo('App\Model\IndustryEmployeeType', 'industry_employee_type_id');
    }
    public function lookingForJob(){
        return $this->belongsTo('App\Model\IndustryCategory', 'looking_job_industry_category_id');
    }
    public function employeeEducation(){
        return $this->hasMany('App\Model\EmployeeEducation', 'employee_id');
    }
    public function employeeJobExperience(){
        return $this->hasMany('App\Model\EmployeeJobExperience', 'employee_id');
    }
    public static function ajaxEmployeeList(){
//        $query = Employee::query()->latest();
        $query = User::join('employees','users.id','employees.user_id')
            ->select(
                'users.id',
                'users.name',
                'users.country_code',
                'users.phone',
                'users.created_at',
                'users.verification_code',
                'users.banned',
                'users.reg_by',
                'employees.id as employee_id',
                'employees.user_id',
                'employees.verification_status',
                'employees.gender',
                'employees.age'
            )
            ->orderBy('users.id','desc')
            ->get();
        return DataTables::of($query)
            ->editColumn('created_at', function ($model) {
                return date('dS F, Y',strtotime($model->created_at));
            })
            ->addColumn('name', function ($model) {
                return $model->name;
            })

            ->addColumn('phone', function ($model) {
                return $model->country_code.$model->phone;
            })
            ->addColumn('reg_by', function ($model) {
                return $model->reg_by;
            })
            ->addColumn('verification_status', function ($model) {
                if ($model->verification_status == 1){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $html = '
               <div class="form-group col-md-2">
                      <label class="switch" style="margin-top:40px;">
                          <input onchange="verification_status(this)" value="' . $model->employee_id . '"  type="checkbox" '.$checked.'>
                           <span class="slider round"></span>
                      </label>
               </div>
                ';
                return $html;
            })
            ->addColumn('details', function ($model) {
                $html = '
                <button class="btn btn-outline-info waves-effect waves-light mBtn" data-toggle="modal" data-target="#exampleModal" onclick="show_details_modal(\''.$model->employee_id.'\');">Details</button>
                ';
                return $html;

            })
            ->addColumn('actions', function ($model) {
                $html = '
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="bg-info dropdown-item" href="'.route('admin.employee.edit',encrypt($model->employee_id)).'">
                       Edit Profile
                   </a>
                        <a class="bg-info dropdown-item" href="'.route('admin.employee.edit-password',encrypt($model->employee_id)).'">
                         Edit Password
                       </a>
                  </div>
                </div>
                ';
                return $html;

            })
            ->rawColumns([
                'verification_status', 'actions', 'details',
            ])
            ->toJson();
    }
    public static function ajaxUnApproveEmployeeList(){
//        $query = Employee::query()->latest();
        $query = User::join('employees','users.id','employees.user_id')
            ->select(
                'users.id',
                'users.name',
                'users.country_code',
                'users.phone',
                'users.created_at',
                'users.verification_code',
                'users.banned',
                'users.reg_by',
                'employees.id as employee_id',
                'employees.user_id',
                'employees.verification_status',
                'employees.gender',
                'employees.age'
            )
            ->orderBy('users.id','desc')
            ->whereverification_status(!1)
            ->get();
        return DataTables::of($query)
            ->editColumn('created_at', function ($model) {
                return date('dS F, Y',strtotime($model->created_at));
            })
            ->addColumn('name', function ($model) {
                return $model->name;
            })

            ->addColumn('phone', function ($model) {
                return $model->country_code.$model->phone;
            })
            ->addColumn('reg_by', function ($model) {
                return $model->reg_by;
            })
            ->addColumn('verification_status', function ($model) {
                if ($model->verification_status == 1){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $html = '
               <div class="form-group col-md-2">
                      <label class="switch" style="margin-top:40px;">
                          <input onchange="verification_status(this)" value="' . $model->employee_id . '"  type="checkbox" '.$checked.'>
                           <span class="slider round"></span>
                      </label>
               </div>
                ';
                return $html;
            })
            ->addColumn('details', function ($model) {
                $html = '
                <button class="btn btn-outline-info waves-effect waves-light mBtn" data-toggle="modal" data-target="#exampleModal" onclick="show_details_modal(\''.$model->employee_id.'\');">Details</button>
                ';
                return $html;

            })
            ->addColumn('actions', function ($model) {
                $html = '
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="bg-info dropdown-item" href="'.route('admin.employee.edit',encrypt($model->employee_id)).'">
                       Edit Profile
                   </a>
                        <a class="bg-info dropdown-item" href="'.route('admin.employee.edit-password',encrypt($model->employee_id)).'">
                         Edit Password
                       </a>
                  </div>
                </div>
                ';
                return $html;

            })
            ->rawColumns([
                'verification_status', 'actions', 'details',
            ])
            ->toJson();
    }
}
