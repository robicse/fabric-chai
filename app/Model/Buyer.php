<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\DataTables;

class Buyer extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public static function ajaxBuyerList1($start_date,$end_date){
        if ($start_date && $end_date){
            $query = User::join('buyers','users.id','buyers.user_id')
                ->select(
                    'users.id',
                    'users.name',
                    'users.country_code',
                    'users.phone',
                    'users.created_at',
                    'users.verification_code',
                    'users.banned',
                    'users.reg_by',
                    'buyers.id as buyer_id',
                    'buyers.user_id',
                    'buyers.verification_status'
                )
                ->whereBetween('users.created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
                ->orderBy('users.id','desc')
                ->get();
        }else{
            $query = User::join('buyers','users.id','buyers.user_id')
                ->select(
                    'users.id',
                    'users.name',
                    'users.country_code',
                    'users.phone',
                    'users.created_at',
                    'users.verification_code',
                    'users.banned',
                    'users.reg_by',
                    'buyers.id as buyer_id',
                    'buyers.user_id',
                    'buyers.verification_status'
                )
                ->orderBy('users.id','desc')
                ->get();
        }

        return DataTables::of($query)


            ->editColumn('created_at', function ($model) {
                return date('dS F, Y',strtotime($model->created_at));
            })
            ->addColumn('name', function ($model) {
                if($model->verification_code != null && $model->banned == 1){

                    $html='<strong class="badge badge-danger">Banned</strong>';
                    return $model->name. ' '.$html;
                }else{
                    return $model->name;
                }
            })
            ->addColumn('phone', function ($model) {
                return $model->country_code.$model->phone;
            })

            ->addColumn('status', function ($model) {
                if ($model->verification_status == 0 ){
                    $btn = 'info';
                    $value = 'Applied';
                }else{
                    $btn = 'success';
                    $value = 'Approved';
                }
                $html = '<span class="btn btn-'.$btn.'">'.$value.'</span>';
                return $html;
            })
            ->addColumn('verification_status', function ($model) {
                if ($model->verification_status == 1){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                if ($model->verification_code != null && $model->banned == 0){
                    $html = '
               <div class="form-group col-md-2">
                                            <label class="switch" style="margin-top:40px;">
                                                <input onchange="verification_status(this)" value="' . $model->buyer_id . '"  type="checkbox" '.$checked.'>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                ';
                }elseif ($model->verification_code == null){
                    $html=' <strong class="badge badge-danger w-100">Deactivated</strong>';
                }else{
                    $html=' <strong class="badge badge-danger w-100">Banned</strong>';
                }

                return $html;
            })
            ->addColumn('reg_by', function ($model) {
                return $model->reg_by;
            })
            ->addColumn('actions', function ($model) {
                if ($model->verification_code != null && $model->banned != 1){
                    $url =route('admin.buyer.ban', $model->user_id);
                    $html = '
                <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                    <div class="dropdown-menu">
                        <a class="bg-info dropdown-item" href="'.route('admin.buyer.profile-edit',encrypt($model->id)).'">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <a class="bg-info dropdown-item" href="'.route('admin.buyer-profile',$model->id).'">
                             <i class="fa fa-user"></i> Profile
                        </a>
                          <a class=" dropdown-item " href="#" onclick="confirm_ban(\''.$url.'\')"> Ban this Buyer <i class="fa fa-ban text-danger" aria-hidden="true"></i> </a>
                    </div>
                </div>
                ';

                }elseif($model->verification_code == null){
                    $url =route('admin.buyer.activate', $model->user_id);
                    $html = '
                <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                    <div class="dropdown-menu">
                        <a class="bg-info dropdown-item" href="'.route('admin.buyer.profile-edit',encrypt($model->id)).'">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <a class="bg-info dropdown-item" href="'.route('admin.buyer-profile',$model->id).'">
                             <i class="fa fa-user"></i> Profile
                        </a>
                          <a class=" dropdown-item " href="#" onclick="confirm_activate(\''.$url.'\');"> Activate this Buyer <i class="fa fa-check text-success" aria-hidden="true"></i> </a>
                    </div>
                </div>
                ';
                }else{
                    $url =route('admin.buyer.ban', $model->user_id);
                    $html = '
                <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                    <div class="dropdown-menu">
                    <a class="bg-info dropdown-item" href="'.route('admin.buyer.profile-edit',encrypt($model->id)).'">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <a class="bg-info dropdown-item" href="'.route('admin.buyer-profile',$model->id).'">
                             <i class="fa fa-user"></i> Profile
                        </a>
                          <a class=" dropdown-item " href="#" onclick="confirm_unban(\''.$url.'\');"> Unban this Buyer <i class="fa fa-check text-success" aria-hidden="true"></i> </a>
                    </div>
                </div>
                ';
                }

                return $html;
            })
            ->rawColumns([
                'name',
                'status',
                'verification_status',
                'actions',
            ])
            ->toJson();
    }

    public static function ajaxBuyerList(){
        $query = Buyer::query()->latest();
        return DataTables::of($query)
            ->editColumn('created_at', function (Buyer $model) {
                return date('dS F, Y',strtotime($model->created_at));
            })
            ->addColumn('name', function (Buyer $model) {
                if($model->user->verification_code != null && $model->user->banned == 1){

                    $html='<strong class="badge badge-danger">Banned</strong>';
                    return $model->user->name. ' '.$html;
                }else{
                    return $model->user->name;
                }
            })
            ->addColumn('phone', function (Buyer $model) {
                return $model->user->country_code.$model->user->phone;
            })
            ->addColumn('status', function (Buyer $model) {
                if ($model->verification_status == 0 ){
                    $btn = 'info';
                    $value = 'Applied';
                }else{
                    $btn = 'success';
                    $value = 'Approved';
                }
                $html = '<span class="btn btn-'.$btn.'">'.$value.'</span>';
                return $html;
            })
            ->addColumn('verification_status', function (Buyer $model) {
                if ($model->verification_status == 1){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                if ($model->user->verification_code != null && $model->user->banned == 0){
                    $html = '
               <div class="form-group col-md-2">
                                            <label class="switch" style="margin-top:40px;">
                                                <input onchange="verification_status(this)" value="' . $model->id . '"  type="checkbox" '.$checked.'>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                ';
                }elseif ($model->user->verification_code == null){
                    $html=' <strong class="badge badge-danger w-100">Deactivated</strong>';
                }else{
                    $html=' <strong class="badge badge-danger w-100">Banned</strong>';
                }

                return $html;
            })
            ->addColumn('reg_by', function (Buyer $model) {
                return $model->user->reg_by;
            })
            ->addColumn('actions', function (Buyer $model) {
                if ($model->user->verification_code != null && $model->user->banned != 1){
                    $url =route('admin.buyer.ban', $model->user_id);
                    $html = '
                <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                    <div class="dropdown-menu">
                        <a class="bg-info dropdown-item" href="'.route('admin.buyer.profile-edit',encrypt($model->user->id)).'">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <a class="bg-info dropdown-item" href="'.route('admin.buyer-profile',$model->user_id).'">
                             <i class="fa fa-user"></i> Profile
                        </a>
                          <a class=" dropdown-item " href="#" onclick="confirm_ban(\''.$url.'\')"> Ban this Buyer <i class="fa fa-ban text-danger" aria-hidden="true"></i> </a>
                    </div>
                </div>
                ';

                }elseif($model->user->verification_code == null){
                    $url =route('admin.buyer.activate', $model->user_id);
                    $html = '
                <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                    <div class="dropdown-menu">
                        <a class="bg-info dropdown-item" href="'.route('admin.buyer.profile-edit',encrypt($model->user->id)).'">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <a class="bg-info dropdown-item" href="'.route('admin.buyer-profile',$model->user_id).'">
                             <i class="fa fa-user"></i> Profile
                        </a>
                          <a class=" dropdown-item " href="#" onclick="confirm_activate(\''.$url.'\');"> Activate this Buyer <i class="fa fa-check text-success" aria-hidden="true"></i> </a>
                    </div>
                </div>
                ';
                }else{
                    $url =route('admin.buyer.ban', $model->user_id);
                    $html = '
                <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                    <div class="dropdown-menu">
                    <a class="bg-info dropdown-item" href="'.route('admin.buyer.profile-edit',encrypt($model->user->id)).'">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <a class="bg-info dropdown-item" href="'.route('admin.buyer-profile',$model->user_id).'">
                             <i class="fa fa-user"></i> Profile
                        </a>
                          <a class=" dropdown-item " href="#" onclick="confirm_unban(\''.$url.'\');"> Unban this Buyer <i class="fa fa-check text-success" aria-hidden="true"></i> </a>
                    </div>
                </div>
                ';
                }

                return $html;
            })
            ->rawColumns([
                'name',
                'status',
                'verification_status',
                'actions',
            ])
            ->toJson();
    }
}
