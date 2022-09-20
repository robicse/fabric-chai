<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\DataTables;

class Notification extends Model
{
    public function sender(){
        return $this->belongsTo('App\User','sender_user_id');
    }
    public function receiver(){
        return $this->belongsTo('App\User','receiver_user_id');
    }
    public function product(){
        return $this->belongsTo('App\Model\Product','product_id');
    }

    public static function ajaxNotification(){
        $query = Notification::query()->latest();
        return DataTables::of($query)
            ->editColumn('sender', function (Notification $model) {
                return $model->sender ? $model->sender->name : ' ';
            })
            ->editColumn('receiver', function (Notification $model) {
                return $model->receiver ? $model->receiver->name : ' ';
            })
            ->editColumn('created_at', function (Notification $model) {
                return date('j M Y h:i A',strtotime($model->created_at));
            })
            ->addColumn('status', function (Notification $model) {
                $seller = \App\Model\Seller::where('user_id',$model->sender_user_id)->first();
                $buyer = \App\Model\Buyer::where('user_id',$model->sender_user_id)->first();
                if ($model->admin_view_status == 0){
                    $btn = 'info';
                    $viewStatus = 'Unseen';
                }else{
                    $btn = 'success';
                    $viewStatus = 'Seen';
                }
                if ($model->title == 'Seller Registration' && checkSellerApproved($model->sender_user_id) && $model->sender ){
                    $html2 ='
                     <span class="btn btn-'.$btn.'">' .$viewStatus. '</span>
                    <a class="btn btn-warning" href="'.route('admin.individual-seller',$seller->id).'">Approve Seller</a>
                    ';

                }elseif ($model->title == 'Buyer Registration' && checkBuyerApproved($model->sender_user_id) == 0 && $model->sender){
                    $html2 ='
                     <span class="btn btn-'.$btn.'">' .$viewStatus. '</span>
                    <a class="btn btn-warning" href="'.route('admin.individual-buyer',$buyer->id).'">Approve Buyer</a>
                    ';

                }elseif ($model->title == 'Applied for Seller' && checkProductApproved($model->sender_user_id) == 0 && $model->sender){
                    $html2 ='
                     <span class="btn btn-'.$btn.'">' .$viewStatus. '</span>
                    <a class="btn btn-warning" href="'.route('admin.individual-seller',$seller->id).'">Approve Seller</a>
                    ';

                }elseif ($model->title == 'Seller Product Entry' && checkProductApproved($model->product_id) == 0){
                    $html2 ='
                     <span class="btn btn-'.$btn.'">' .$viewStatus. '</span>
                    <a class="btn btn-warning" href="'.url('admin/seller-product-individual/'.$model->sender_user_id.'/'.$model->product_id).'">Approve Product</a>
                    ';

                }elseif ($model->title == 'Buyer Product Entry'){

                    $html2 ='
                     <span class="btn btn-'.$btn.'">' .$viewStatus. '</span>
                    <a class="btn btn-warning" href="'.url('admin/buyer-product-individual/'.$model->sender_user_id.'/'.$model->product_id).'">Approve Product</a>
                    ';

                }elseif ($model->title == 'Seller Work Order Create'){
                    $html2 ='
                     <span class="btn btn-'.$btn.'">' .$viewStatus. '</span>
                    <a class="btn btn-warning" href="'.url('admin/seller-work-order-individual/'.$model->sender_user_id.'/'.$model->work_order_product_id).'">Approve WO</a>
                    ';
                }else{
                    $html2 ='
                     <span class="btn btn-'.$btn.'">' .$viewStatus. '</span> ';
                }
                return $html2;
            })
            ->addColumn('details', function (Notification $model) {
                if ($model->sender && $model->receiver){
                    $html='
                  <a class="bg-info dropdown-item" href="'.route('admin.notification.detail',$model->id).'">
                                                Details
                                            </a>
                ';
                }else{
                    $html=' <span class="badge badge-danger">Deleted</span>
                   ';

                }
                return $html;
            })
            ->rawColumns([
                'status', 'checkbox',
                'details', 'checkbox',
            ])
            ->toJson();
    }
}
