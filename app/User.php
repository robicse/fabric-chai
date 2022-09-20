<?php

namespace App;

use App\Model\MembershipPackage;
use App\Model\Seller;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;
use Yajra\DataTables\DataTables;

class User extends Authenticatable
{
    use Notifiable, HasRoles,HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 'email','phone','user_type', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo('App\Role');
    }
    public function seller()
    {
        return $this->hasOne('App\Model\Seller','user_id');
    }
    public function buyer()
    {
        return $this->hasOne('App\Model\Buyer','user_id');
    }
    public function employee()
    {
        return $this->hasOne('App\Model\Employee','user_id');
    }
    public function employer()
    {
        return $this->hasOne('App\Model\Employer','user_id');
    }
    public function products()
    {
        return $this->hasMany('App\Model\Product','user_id');
    }
    public function membershipPackage(){
        return $this->belongsTo('App\Model\MembershipPackage','membership_package_id');
//        return $this->belongsTo(MembershipPackage::class);
    }
    public static function ajaxSellerList(){
        $query = \App\User::query()->where('user_type','seller')->latest();
        return DataTables::of($query)
            ->editColumn('created_at', function (User $model) {
                if ($model->seller){
                    return date('dS F, Y',strtotime($model->created_at));
                }

            })
            ->editColumn('name', function (User $model) {
                if($model->seller && $model->verification_code != null && $model->banned == 1){

                    $html='<strong class="badge badge-danger">Banned</strong>';
                    return $model->name. ' '.$html;
                }else{
                    return $model->name;
                }
            })
            ->editColumn('phone', function (User $model) {
                //return $model->phone;
                if ($model->seller) {
                    return $model->country_code . $model->phone;
                }
            })
            ->addColumn('status', function (User $model) {
                if ($model->seller) {
                if ( $model->seller->verification_status == 0 ){
                    $btn = 'info';
                    $value = 'Applied';
                }else{
                    $btn = 'success';
                    $value = 'Approved';
                }
                $html = '<span class="btn btn-'.$btn.'">'.$value.'</span>';
                return $html;
                }
            })
            ->addColumn('verification_status', function (User $model) {
                if ($model->seller) {
                    if ($model->seller->verification_status == 1) {
                        $checked = 'checked';
                    } else {
                        $checked = '';
                    }
                    if ($model->verification_code != null && $model->banned == 0) {
                        $html = '
               <div class="form-group col-md-2">
                                            <label class="switch" style="margin-top:40px;">
                                                <input onchange="verification_status(this)" value="' . $model->seller->id . '"  type="checkbox" ' . $checked . '>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                ';
                    } elseif ($model->verification_code == null) {
                        $html = ' <strong class="badge badge-danger w-100">Deactivated</strong>';
                    } else {
                        $html = ' <strong class="badge badge-danger w-100">Banned</strong>';
                    }

                    return $html;
                }
            })
            ->editColumn('reg_by', function (\App\User $model) {
                if ($model->seller) {
                    return $model->reg_by;
                }


            })
            ->addColumn('actions', function (User $model) {
                if ($model->verification_code != null && $model->banned != 1){
                    $url =route('admin.seller.ban', $model->id);
                    $html = '
                <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                    <div class="dropdown-menu">
                         <a class="bg-dark dropdown-item" href="'.route('admin.seller.profile.show',encrypt($model->id)).'">
                                                        <i class="fa fa-user"></i> Profile
                          </a>
                          <a class=" dropdown-item " href="#" onclick="confirm_ban(\''.$url.'\')"> Ban this Seller <i class="fa fa-ban text-danger" aria-hidden="true"></i> </a>
                    </div>
                </div>
                ';

                }elseif($model->verification_code == null){
                    $url =route('admin.buyer.activate', $model->id);
                    $html = '
                <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                    <div class="dropdown-menu">
                         <a class="bg-dark dropdown-item" href="'.route('admin.seller.profile.show',encrypt($model->id)).'">
                                                        <i class="fa fa-user"></i> Profile
                          </a>
                          <a class=" dropdown-item " href="#" onclick="confirm_activate(\''.$url.'\');"> Activate this Seller <i class="fa fa-check text-success" aria-hidden="true"></i> </a>
                    </div>
                </div>
                ';
                }else{
                    $url =route('admin.seller.ban', $model->id);
                    $html = '
                <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                    <div class="dropdown-menu">
                         <a class="bg-dark dropdown-item" href="'.route('admin.seller.profile.show',encrypt($model->id)).'">
                                                        <i class="fa fa-user"></i> Profile
                          </a>
                          <a class=" dropdown-item " href="#" onclick="confirm_unban(\''.$url.'\');"> Unban this Seller <i class="fa fa-check text-success" aria-hidden="true"></i> </a>
                    </div>
                </div>
                ';
                }
                return $html;
            })
            ->rawColumns([
                'name', 'status', 'verification_status', 'actions',
            ])
            ->toJson();
    }
}
