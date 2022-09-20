<?php

namespace App\Model;

use App\Model\SubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class Product extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function category()
    {
        return $this->belongsTo('App\Model\Category', 'category_id');
    }

    public function subcategory(){
        return $this->belongsTo('App\Model\SubCategory', 'sub_category_id');
    }
    public function subsubcategory(){
        return $this->belongsTo('App\Model\SubSubCategory', 'sub_sub_category_id');
    }
    public function subsubchildcategory(){
        return $this->belongsTo('App\Model\SubSubChildCategory', 'sub_sub_child_category_id');
    }
    public function subsubchildchildcategory()
    {
        return $this->belongsTo('App\Model\SubSubChildChildCategory', 'sub_sub_child_child_category_id');
    }
    public function categorySix()
    {
        return $this->belongsTo('App\Model\CategorySix', 'category_six_id');
    }
    public function categorySeven()
    {
        return $this->belongsTo('App\Model\CategorySeven', 'category_seven_id');
    }
    public function categoryEight()
    {
        return $this->belongsTo('App\Model\CategoryEight', 'category_eight_id');
    }
    public function categoryNine()
    {
        return $this->belongsTo('App\Model\CategoryNine', 'category_nine_id');
    }
    public function categoryTen()
    {
        return $this->belongsTo('App\Model\CategoryTen', 'category_ten_id');
    }
    public function unit()
    {
        return $this->belongsTo('App\Model\Unit', 'unit_id');
    }
    public function currency()
    {
        return $this->belongsTo('App\Model\Currency', 'currency_id');
    }
    public function sizingProduct()
    {
        return $this->hasOne('App\Model\SizingProduct', 'product_id');
    }
    public function dyingProduct()
    {
        return $this->hasOne('App\Model\DyingProduct', 'product_id');
    }
    public static function ajaxSellerProductTest(){
        //$query = Product::query()->where('user_type','seller')->latest();

        $query = Product::join('users','products.user_id','users.id')->select('products.*','users.phone')->where('products.user_type','seller')->orderBy('products.id','desc')->get();

//        $query = DB::table('products')
//            ->join('users','products.user_id','users.id')
//            ->select('products.*','users.phone')
//            ->where('products.user_type','seller')
//            ->orderBy('products.id','desc')
//            ->get();

        return DataTables::of($query)
            ->editColumn('created_at', function (Product $model) {
                return date('dS F, Y',strtotime($model->created_at));
            })
            ->editColumn('user_name', function (Product $model) {
                return $model->user->name;
            })
//            ->addColumn('user_phone', function (Product $model) {
//                return @$model->user->phone;
//            })
            ->editColumn('thumbnail_img', function (Product $model) {
                $html = '<img src="' . url($model->thumbnail_img) . '" width="50" height="50" > ';
                return $html;
            })
            ->editColumn('quantity', function (Product $model) {
                if ($model->unit){
                    return $model->quantity .' '. $model->unit->name;
                }else{
                    return $model->quantity.' Meter/Yards';
                }

            })
            ->addColumn('verification_status', function (Product $model) {
                if ($model->verification_status == 1){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $html = '
               <div class="form-group col-md-2">
                                            <label class="switch" style="margin-top:40px;">
                                                <input onchange="update_status1(this)" value="' . $model->id . '"  type="checkbox" '.$checked.'>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                ';
                return $html;
            })
            ->addColumn('featured_status', function (Product $model) {
                if ($model->featured_product == 1){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $html = '
               <div class="form-group col-md-2">
                                            <label class="switch" style="margin-top:40px;">
                                                <input type="checkbox" onchange="update_featured(this)" value="' . $model->id . '" '.$checked.'>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                ';
                return $html;
            })
            ->addColumn('actions', function (Product $model) {
                if ($model->category_id == 9 && $model->sizingProduct){
                    $url ='admin.sizing-products.edit';
                }elseif ($model->category_id == 7 && $model->dyingProduct){
                    $url ='admin.dying-products.edit';
                }else{
                    $url ='admin.seller-product.edit';
                }

                $html = '
                <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                    <div class="dropdown-menu">
                    <a class="dropdown-item" href="' . route($url, $model->id) . '" id="edit" data-id="' . $model->id . '" />
                        <i class="fa fa-edit text-info" ></i> Edit
                        </a>
                         <a class="dropdown-item" href="' . route('admin.product.delete', $model->id) . '">
                                                    <i class="fa fa-trash text-danger"></i> Delete
                                                </a>
                        <a class="dropdown-item" href="' . route('admin.seller.profile.show', encrypt($model->user_id)) . '" target="_blank" />
                            <i class="fa fa-users text-primary"></i> Seller Profile
                        </a>

                    </div>
                </div>
                ';
                return $html;
            })
            ->rawColumns([
                'thumbnail_img', 'checkbox',
                'verification_status', 'checkbox',
                'featured_status', 'checkbox',
                'actions', 'checkbox','user_phone'
            ])
            ->toJson();
    }
    public static function ajaxBuyerProduct()
    {

//        $query = Product::query()->where('user_type','buyer')->latest();
        $query = Product::join('users','products.user_id','users.id')->select('products.*','users.phone')->where('products.user_type','buyer')->orderBy('products.id','desc')->get();
        return DataTables::of($query)


            ->editColumn('created_at', function (Product $model) {
                return date('dS F, Y',strtotime($model->created_at));
            })
            ->editColumn('user_name', function (Product $model) {
                return $model->user->name;
            })
            ->editColumn('thumbnail_img', function (Product $model) {
                $html = '<img src="' . url($model->thumbnail_img) . '" width="50" height="50" > ';
                return $html;
            })
            ->editColumn('quantity', function (Product $model) {
                if ($model->unit){
                    return $model->quantity .' '. $model->unit->name;
                }else{
                    return $model->quantity.' Meter/Yards';
                }

            })
            ->addColumn('verification_status', function (Product $model) {
                if ($model->verification_status == 1){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $html = '
               <div class="form-group col-md-2">
                                            <label class="switch" style="margin-top:40px;">
                                                <input onchange="update_status1(this)" value="' . $model->id . '"  type="checkbox" '.$checked.'>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                ';
                return $html;
            })
            ->addColumn('featured_status', function (Product $model) {
                if ($model->featured_product == 1){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $html = '
               <div class="form-group col-md-2">
                                            <label class="switch" style="margin-top:40px;">
                                                <input type="checkbox" onchange="update_featured(this)" value="' . $model->id . '" '.$checked.'>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                ';
                return $html;
            })
            ->addColumn('actions', function (Product $model) {
                if ($model->category_id == 9 && $model->sizingProduct){
                    $url ='admin.sizing-products.edit';
                }elseif ($model->category_id == 7 && $model->dyingProduct){
                    $url ='admin.dying-products.edit';
                }else{
                    $url ='admin.buyer-requested-product.edit';
                }

                $html = '
                <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                    <div class="dropdown-menu">
                    <a class="dropdown-item" href="' . route($url, $model->id) . '" id="edit" data-id="' . $model->id . '" />
                        <i class="fa fa-edit text-info" ></i> Edit
                        </a>
                         <a class="dropdown-item" href="' . route('admin.product.delete', $model->id) . '">
                                                    <i class="fa fa-trash text-danger"></i> Delete
                                                </a>
                        <a class="dropdown-item" href="' . route('admin.buyer-profile', $model->user_id) . '" target="_blank" />
                            <i class="fa fa-users text-primary"></i> Buyer Profile
                        </a>

                    </div>
                </div>
                ';
                return $html;
            })
            ->rawColumns([
                'thumbnail_img', 'checkbox',
                'verification_status', 'checkbox',
                'featured_status', 'checkbox',
                'actions', 'checkbox',
            ])
            ->toJson();
    }
    public static function ajaxBuyerUnapprovedProduct()
    {

        $query = Product::query()->where('user_type','buyer')->whereverification_status(0)->latest();
        return DataTables::of($query)
            ->editColumn('created_at', function (Product $model) {
                return date('dS F, Y',strtotime($model->created_at));
            })
            ->editColumn('user_type', function (Product $model) {
                return $model->user->name;
            })
            ->editColumn('thumbnail_img', function (Product $model) {
                $html = '<img src="' . url($model->thumbnail_img) . '" width="50" height="50" > ';
                return $html;
            })
            ->editColumn('quantity', function (Product $model) {
                if ($model->unit){
                    return $model->quantity .' '. $model->unit->name;
                }else{
                    return $model->quantity.' Meter/Yards';
                }

            })
            ->addColumn('verification_status', function (Product $model) {
                if ($model->verification_status == 1){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $html = '
               <div class="form-group col-md-2">
                                            <label class="switch" style="margin-top:40px;">
                                                <input onchange="update_status1(this)" value="' . $model->id . '"  type="checkbox" '.$checked.'>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                ';
                return $html;
            })
            ->addColumn('featured_status', function (Product $model) {
                if ($model->featured_product == 1){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $html = '
               <div class="form-group col-md-2">
                                            <label class="switch" style="margin-top:40px;">
                                                <input type="checkbox" onchange="update_featured(this)" value="' . $model->id . '" '.$checked.'>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                ';
                return $html;
            })
            ->addColumn('actions', function (Product $model) {
                if ($model->category_id == 9 && $model->sizingProduct){
                    $url ='admin.sizing-products.edit';
                }elseif ($model->category_id == 7 && $model->dyingProduct){
                    $url ='admin.dying-products.edit';
                }else{
                    $url ='admin.buyer-requested-product.edit';
                }

                $html = '
                <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                    <div class="dropdown-menu">
                    <a class="dropdown-item" href="' . route($url, $model->id) . '" id="edit" data-id="' . $model->id . '" />
                        <i class="fa fa-edit text-info" ></i> Edit
                        </a>
                         <a class="dropdown-item" href="' . route('admin.product.delete', $model->id) . '">
                                                    <i class="fa fa-trash text-danger"></i> Delete
                                                </a>
                        <a class="dropdown-item" href="' . route('admin.buyer-profile', $model->user_id) . '" target="_blank" />
                            <i class="fa fa-users text-primary"></i> Buyer Profile
                        </a>

                    </div>
                </div>
                ';
                return $html;
            })
            ->rawColumns([
                'thumbnail_img', 'checkbox',
                'verification_status', 'checkbox',
                'featured_status', 'checkbox',
                'actions', 'checkbox',
            ])
            ->toJson();
    }
    public static function ajaxSellerProduct(){
        //$query = Product::query()->where('user_type','seller')->latest();

        $query = Product::join('users','products.user_id','users.id')->select('products.*','users.phone')->where('products.user_type','seller')->orderBy('products.id','desc')->get();

//        $query = DB::table('products')
//            ->join('users','products.user_id','users.id')
//            ->select('products.*','users.phone')
//            ->where('products.user_type','seller')
//            ->orderBy('products.id','desc')
//            ->get();

        return DataTables::of($query)
            ->editColumn('created_at', function (Product $model) {
                return date('dS F, Y',strtotime($model->created_at));
            })
            ->editColumn('user_name', function (Product $model) {
                return $model->user->name;
            })
//            ->addColumn('user_phone', function (Product $model) {
//                return @$model->user->phone;
//            })
            ->editColumn('thumbnail_img', function (Product $model) {
                $html = '<img src="' . url($model->thumbnail_img) . '" width="50" height="50" > ';
                return $html;
            })
            ->editColumn('quantity', function (Product $model) {
                if ($model->unit){
                    return $model->quantity .' '. $model->unit->name;
                }else{
                    return $model->quantity.' Meter/Yards';
                }

            })
            ->addColumn('verification_status', function (Product $model) {
                if ($model->verification_status == 1){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $html = '
               <div class="form-group col-md-2">
                                            <label class="switch" style="margin-top:40px;">
                                                <input onchange="update_status1(this)" value="' . $model->id . '"  type="checkbox" '.$checked.'>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                ';
                return $html;
            })
            ->addColumn('featured_status', function (Product $model) {
                if ($model->featured_product == 1){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $html = '
               <div class="form-group col-md-2">
                                            <label class="switch" style="margin-top:40px;">
                                                <input type="checkbox" onchange="update_featured(this)" value="' . $model->id . '" '.$checked.'>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                ';
                return $html;
            })
            ->addColumn('actions', function (Product $model) {
                if ($model->category_id == 9 && $model->sizingProduct){
                    $url ='admin.sizing-products.edit';
                }elseif ($model->category_id == 7 && $model->dyingProduct){
                    $url ='admin.dying-products.edit';
                }else{
                    $url ='admin.seller-product.edit';
                }

                $html = '
                <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                    <div class="dropdown-menu">
                    <a class="dropdown-item" href="' . route($url, $model->id) . '" id="edit" data-id="' . $model->id . '" />
                        <i class="fa fa-edit text-info" ></i> Edit
                        </a>
                         <a class="dropdown-item" href="' . route('admin.product.delete', $model->id) . '">
                                                    <i class="fa fa-trash text-danger"></i> Delete
                                                </a>
                        <a class="dropdown-item" href="' . route('admin.seller.profile.show', encrypt($model->user_id)) . '" target="_blank" />
                            <i class="fa fa-users text-primary"></i> Seller Profile
                        </a>

                    </div>
                </div>
                ';
                return $html;
            })
            ->rawColumns([
                'thumbnail_img', 'checkbox',
                'verification_status', 'checkbox',
                'featured_status', 'checkbox',
                'actions', 'checkbox','user_phone'
            ])
            ->toJson();
    }

    public static function ajaxUnapprovedSellerProduct(){
        $query = Product::query()->whereverification_status(0)->where('user_type','seller')->latest();
        return DataTables::of($query)
            ->editColumn('created_at', function (Product $model) {
                return date('dS F, Y',strtotime($model->created_at));
            })
            ->editColumn('user_type', function (Product $model) {
                return $model->user->name;
            })
            ->editColumn('thumbnail_img', function (Product $model) {
                $html = '<img src="' . url($model->thumbnail_img) . '" width="50" height="50" > ';
                return $html;
            })
            ->editColumn('quantity', function (Product $model) {
                if ($model->unit){
                    return $model->quantity .' '. $model->unit->name;
                }else{
                    return $model->quantity.' Meter/Yards';
                }

            })
            ->addColumn('verification_status', function (Product $model) {
                if ($model->verification_status == 1){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $html = '
               <div class="form-group col-md-2">
                                            <label class="switch" style="margin-top:40px;">
                                                <input onchange="update_status1(this)" value="' . $model->id . '"  type="checkbox" '.$checked.'>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                ';
                return $html;
            })
            ->addColumn('featured_status', function (Product $model) {
                if ($model->featured_product == 1){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $html = '
               <div class="form-group col-md-2">
                                            <label class="switch" style="margin-top:40px;">
                                                <input type="checkbox" onchange="update_featured(this)" value="' . $model->id . '" '.$checked.'>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                ';
                return $html;
            })
            ->addColumn('actions', function (Product $model) {
                if ($model->category_id == 9 && $model->sizingProduct){
                    $url ='admin.sizing-products.edit';
                }elseif ($model->category_id == 7 && $model->dyingProduct){
                    $url ='admin.dying-products.edit';
                }else{
                    $url ='admin.seller-product.edit';
                }

                $html = '
                <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                    <div class="dropdown-menu">
                    <a class="dropdown-item" href="' . route($url, $model->id) . '" id="edit" data-id="' . $model->id . '" />
                        <i class="fa fa-edit text-info" ></i> Edit
                        </a>
                         <a class="dropdown-item" href="' . route('admin.product.delete', $model->id) . '">
                                                    <i class="fa fa-trash text-danger"></i> Delete
                                                </a>
                        <a class="dropdown-item" href="' . route('admin.seller.profile.show', encrypt($model->user_id)) . '" target="_blank" />
                            <i class="fa fa-users text-primary"></i> Seller Profile
                        </a>

                    </div>
                </div>
                ';
                return $html;
            })
            ->rawColumns([
                'thumbnail_img', 'checkbox',
                'verification_status', 'checkbox',
                'featured_status', 'checkbox',
                'actions', 'checkbox',
            ])
            ->toJson();
    }


}
