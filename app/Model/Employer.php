<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\DataTables;

class Employer extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function seller()
    {
        return $this->belongsTo('App\Model\Seller', 'seller_id');
    }

    public static function ajaxEmployerList(){
//        $query = Employer::query()->latest();
        $query = User::join('employers','users.id','employers.user_id')
            ->join('sellers','users.id','sellers.user_id')
            ->select(
                'users.id',
                'users.name',
                'users.country_code',
                'users.phone',
                'users.created_at',
                'users.verification_code',
                'users.banned',
                'users.reg_by',
                'sellers.company_name as company_name',
                'sellers.company_phone as company_phone',
                'sellers.company_address as company_address',
                'employers.id as employer_id',
                'employers.user_id',
                'employers.owner_name'
            )
            ->orderBy('users.id','desc')
            ->get();
        return DataTables::of($query)
            ->editColumn('created_at', function ($model) {
                return date('dS F, Y',strtotime($model->created_at));
            })
            ->addColumn('name', function ( $model) {
                return $model->name;
            })
            ->addColumn('company_name', function ( $model) {
                return $model->company_name;
            })
            ->addColumn('company_owner', function ( $model) {
                return $model->owner_name;
            })
            ->addColumn('company_phone', function ( $model) {
                return $model->company_phone;
            })
            ->addColumn('company_location', function ( $model) {
                return $model->company_address;
            })
            ->addColumn('reg_by', function ( $model) {
                return $model->reg_by;
            })
            ->addColumn('details', function ( $model) {
                $html = '
                <button class="btn btn-outline-info waves-effect waves-light mBtn" data-toggle="modal" data-target="#exampleModal" onclick="show_details_modal(\''.$model->employer_id.'\');">Details</button>
                ';
                return $html;

            })
            ->addColumn('actions', function ( $model) {
                $html = '
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="bg-info dropdown-item" href="'.route('admin.employer.edit',encrypt($model->employer_id)).'">
                       Edit Profile
                   </a>
                        <a class="bg-info dropdown-item" href="'.route('admin.employer.edit-password',encrypt($model->employer_id)).'">
                         Edit Password
                       </a>
                  </div>
                </div>
                ';
                return $html;

            })
            ->rawColumns([
                'actions', 'details',
            ])
            ->toJson();
    }
    public static function ajaxUnApproveEmployerList(){
//        $query = Employer::query()->latest();
        $query = User::join('employers','users.id','employers.user_id')
            ->join('sellers','users.id','sellers.user_id')
            ->select(
                'users.id',
                'users.name',
                'users.country_code',
                'users.phone',
                'users.created_at',
                'users.verification_code',
                'users.banned',
                'users.reg_by',
                'sellers.company_name as company_name',
                'sellers.company_phone as company_phone',
                'sellers.company_address as company_address',
                'employers.id as employer_id',
                'employers.user_id',
                'employers.owner_name'
            )
            ->orderBy('users.id','desc')
            //  ->where('employers.owner_name','=','fdkishigkh')
             ->whereverification_status(!1)
            ->get();
        return DataTables::of($query)
            ->editColumn('created_at', function ($model) {
                return date('dS F, Y',strtotime($model->created_at));
            })
            ->addColumn('name', function ( $model) {
                return $model->name;
            })
            ->addColumn('company_name', function ( $model) {
                return $model->company_name;
            })
            ->addColumn('company_owner', function ( $model) {
                return $model->owner_name;
            })
            ->addColumn('company_phone', function ( $model) {
                return $model->company_phone;
            })
            ->addColumn('company_location', function ( $model) {
                return $model->company_address;
            })
            ->addColumn('reg_by', function ( $model) {
                return $model->reg_by;
            })
            ->addColumn('details', function ( $model) {
                $html = '
                <button class="btn btn-outline-info waves-effect waves-light mBtn" data-toggle="modal" data-target="#exampleModal" onclick="show_details_modal(\''.$model->employer_id.'\');">Details</button>
                ';
                return $html;

            })
            ->addColumn('actions', function ( $model) {
                $html = '
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="bg-info dropdown-item" href="'.route('admin.employer.edit',encrypt($model->employer_id)).'">
                       Edit Profile
                   </a>
                        <a class="bg-info dropdown-item" href="'.route('admin.employer.edit-password',encrypt($model->employer_id)).'">
                         Edit Password
                       </a>
                  </div>
                </div>
                ';
                return $html;

            })
            ->rawColumns([
                'actions', 'details',
            ])
            ->toJson();
    }

}
