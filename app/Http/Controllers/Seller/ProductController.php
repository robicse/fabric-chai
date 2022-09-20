<?php

namespace App\Http\Controllers\Seller;

use App\Helpers\UserInfo;
use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\ColorStainingInfo;
use App\Model\Currency;
use App\Model\DyingProduct;
use App\Model\Product;
use App\Model\Seller;
use App\Model\SizingProduct;
use App\Model\SubCategory;
use App\Model\SubSubCategory;
use App\Model\SubSubChildCategory;
use App\Model\SubSubChildChildCategory;
use App\Model\Unit;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function allRequestedProduct(){
//        if(checkCurrentMembershipName(Auth::user()->id) != 'Platinum'){
//            Toastr::warning('You are not go buyer requested product, Please first pay your commission due','Warning');
//            return redirect()->route('seller.accounts');
//        }

        $products = Product::where('user_type','buyer')
            ->where('user_id','!=',Auth::id())
            ->where('published',1)
            ->where('verification_status',1)
            ->where('bid_status','Applied')
//            ->where('price_validity','>=',date('Y-m-d'))
            ->latest()->get();
        return view('frontend.seller.product.all_requested_products',compact('products'));
    }
    public function index()
    {
        $products = Product::where('user_id',Auth::id())->where('user_type','seller')->latest()->get();
        return view('frontend.seller.product.index',compact('products'));
    }

    public function create()
    {
        $checkSellerApprovalStatus = Seller::where('user_id',Auth::id())->pluck('verification_status')->first();
        if($checkSellerApprovalStatus == 0){
            Toastr::warning('You are not approved by administrator, Please contact with administrator','Warning');
            return redirect()->back();
        }

        $categories = Category::where('type','product')->get();
        $units = Unit::all();
        $currencies = Currency::where('status',1)->get();
        return view('frontend.seller.product.create',compact('categories','units','currencies'));
    }

    public function ajaxSlugMake($name)
    {
        $data = Str::slug($name);
        return response()->json(['success'=> true, 'response'=>$data]);
    }

    public function store(Request $request)
    {
        if(count(checkSellerCurrentCommissionDueStatus(Auth::user()->id)) > 0){
            Toastr::warning('Your previous commission not paid yet! Please Pay your commission first. ','Warning');
            return redirect()->route('seller.accounts');
        }

//        if(empty($request->hasFile('photos'))){
//            Toastr::warning('You can not submit without product image! You can try again.','Warning');
//            return redirect()->back();
//        }
        if($request->sub_category_id && ($request->sub_category_id == 'Select Product')){
            $sub_category_id = NULL;
        }else{
            $sub_category_id = $request->sub_category_id;
        }

        if($request->sub_sub_category_id && ($request->sub_sub_category_id == 'Select Product')){
            $sub_sub_category_id = NULL;
        }else{
            $sub_sub_category_id = $request->sub_sub_category_id;
        }

        if($request->sub_sub_child_category_id && ($request->sub_sub_child_category_id == 'Select Product')){
            $sub_sub_child_category_id = NULL;
        }else{
            $sub_sub_child_category_id = $request->sub_sub_child_category_id;
        }

        if($request->sub_sub_child_child_category_id && ($request->sub_sub_child_child_category_id == 'Select Product')){
            $sub_sub_child_child_category_id = NULL;
        }else{
            $sub_sub_child_child_category_id = $request->sub_sub_child_child_category_id;
        }
        if($request->category_six_id && ($request->category_six_id == 'Select Product')){
            $category_six_id = NULL;
        }else{
            $category_six_id = $request->category_six_id;
        }
        if($request->category_seven_id && ($request->category_seven_id == 'Select Product')){
            $category_seven_id = NULL;
        }else{
            $category_seven_id = $request->category_seven_id;
        }
        if($request->category_eight_id && ($request->category_eight_id == 'Select Product')){
            $category_eight_id = NULL;
        }else{
            $category_eight_id = $request->category_eight_id;
        }
        if($request->category_nine_id && ($request->category_nine_id == 'Select Product')){
            $category_nine_id = NULL;
        }else{
            $category_nine_id = $request->category_nine_id;
        }
        if($request->category_ten_id && ($request->category_ten_id == 'Select Product')){
            $category_ten_id = NULL;
        }else{
            $category_ten_id = $request->category_ten_id;
        }

        $product = new Product();
        $product->name = $request->name;
        $product->name_bn = $request->name_bn;
        $product->user_id = Auth::id();
        $product->user_type = 'seller';
        $product->category_id = $request->category_id;
        $product->sub_category_id = $sub_category_id;
        $product->sub_sub_category_id = $sub_sub_category_id;
        $product->sub_sub_child_category_id = $sub_sub_child_category_id;
        $product->sub_sub_child_child_category_id = $sub_sub_child_child_category_id;
        $product->category_six_id = $category_six_id;
        $product->category_seven_id = $category_seven_id;
        $product->category_eight_id = $category_eight_id;
        $product->category_nine_id = $category_nine_id;
        $product->category_ten_id = $category_ten_id;

        $photos = array();
        if($request->hasFile('photos')){
            $thumbnail_img = $request->photos[0];
            $product->thumbnail_img = $thumbnail_img->store('uploads/products/thumbnail');

            foreach ($request->photos as $key => $photo) {
                $path = $photo->store('uploads/products/photos');
                array_push($photos, $path);
            }
            $product->photos = json_encode($photos);
        }


        if(currency()->code == 'BDT'){
            $unit_price = $request->unit_price;
            $expected_price = $request->expected_price;
        }else{
            $unit_price = convert_to_bdt($request->unit_price);
            $expected_price = convert_to_bdt($request->expected_price);
        }

        $product->quantity = $request->quantity;
        $product->unit_id = $request->unit_id;
        $product->unit_price = $unit_price;
        $product->expected_price = $expected_price;
        $product->currency_id = 27;
        $product->price_validity = $request->price_validity;
        $product->made_in = $request->made_in;
        $product->description = $request->description;
        $product->description_bn = $request->description_bn;
        $product->published = 1;
        $product->featured_product = 0;
        $product->delivery_status = 'pending';
        $product->slug = $request->slug.'-'.Str::random(5);
        $product->verification_status = 0;
        $product->save();
        $insert_id = $product->id;
        if($insert_id){
            $user = User::where('id',Auth::id())->first();
            $title = 'Seller Product Entry';
            $message = $user->name .' Added A New Product "'.$product->name.'" .';
            //createNotification($user->id,$title,$message);
            createNotificationWithProductId(9,$title,$message,$insert_id);
            // admin sms
//            UserInfo::smsAPI('8801725930131', $message);
        }
        Toastr::success("Product Inserted Successfully. Now Waiting For Approval.","Success");
        return redirect()->route('seller.products.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $product = Product::find(decrypt($id));
        $categories = Category::where('type','product')->get();
        $units = Unit::all();
        $currencies = Currency::where('status',1)->get();
        return view('frontend.seller.product.edit',compact('product','categories','units','currencies'));
    }

    public function update(Request $request, $id)
    {
        if($request->sub_category_id && ($request->sub_category_id == 'Select Product')){
            $sub_category_id = NULL;
        }else{
            $sub_category_id = $request->sub_category_id;
        }

        if($request->sub_sub_category_id && ($request->sub_sub_category_id == 'Select Product')){
            $sub_sub_category_id = NULL;
        }else{
            $sub_sub_category_id = $request->sub_sub_category_id;
        }

        if($request->sub_sub_child_category_id && ($request->sub_sub_child_category_id == 'Select Product')){
            $sub_sub_child_category_id = NULL;
        }else{
            $sub_sub_child_category_id = $request->sub_sub_child_category_id;
        }

        if($request->sub_sub_child_child_category_id && ($request->sub_sub_child_child_category_id == 'Select Product')){
            $sub_sub_child_child_category_id = NULL;
        }else{
            $sub_sub_child_child_category_id = $request->sub_sub_child_child_category_id;
        }
        if($request->category_six_id && ($request->category_six_id == 'Select Product')){
            $category_six_id = NULL;
        }else{
            $category_six_id = $request->category_six_id;
        }
        if($request->category_seven_id && ($request->category_seven_id == 'Select Product')){
            $category_seven_id = NULL;
        }else{
            $category_seven_id = $request->category_seven_id;
        }
        if($request->category_eight_id && ($request->category_eight_id == 'Select Product')){
            $category_eight_id = NULL;
        }else{
            $category_eight_id = $request->category_eight_id;
        }
        if($request->category_nine_id && ($request->category_nine_id == 'Select Product')){
            $category_nine_id = NULL;
        }else{
            $category_nine_id = $request->category_nine_id;
        }
        if($request->category_ten_id && ($request->category_ten_id == 'Select Product')){
            $category_ten_id = NULL;
        }else{
            $category_ten_id = $request->category_ten_id;
        }

        $product = Product::find($id);
        $product->name = $request->name;
        $product->name_bn = $request->name_bn;
        $product->category_id = $request->category_id;
        $product->sub_category_id = $sub_category_id;
        $product->sub_sub_category_id = $sub_sub_category_id;
        $product->sub_sub_child_category_id = $sub_sub_child_category_id;
        $product->sub_sub_child_child_category_id = $sub_sub_child_child_category_id;
        $product->category_six_id = $category_six_id;
        $product->category_seven_id = $category_seven_id;
        $product->category_eight_id = $category_eight_id;
        $product->category_nine_id = $category_nine_id;
        $product->category_ten_id = $category_ten_id;

        if($request->has('previous_photos')){
            $photos = $request->previous_photos;
        }
        else{
            $photos = array();
        }
        if($request->hasFile('photos')){

            $thumbnail_img = $request->photos[0];
            $product->thumbnail_img = $thumbnail_img->store('uploads/products/thumbnail');

            foreach ($request->photos as $key => $photo) {
                $path = $photo->store('uploads/products/photos');
                array_push($photos, $path);
            }
        }
        $product->photos = json_encode($photos);

        if(currency()->code == 'BDT'){
            $unit_price = $request->unit_price;
            $expected_price = $request->expected_price;
        }else{
            $unit_price = convert_to_bdt($request->unit_price);
            $expected_price = convert_to_bdt($request->expected_price);
            $unit_price = number_format((float)$unit_price, 5, '.', '');
            $expected_price = number_format((float)$expected_price, 5, '.', '');
        }

        $product->quantity = $request->quantity;
        $product->unit_id = $request->unit_id;
        $product->unit_price = $unit_price;
        $product->expected_price = $expected_price;
        $product->currency_id = 27;
        $product->price_validity = $request->price_validity;
        $product->made_in = $request->made_in;
        $product->description = $request->description;
        $product->description_bn = $request->description_bn;
        $product->slug = $request->slug.'-'.Str::random(5);
        $product->save();

        Toastr::success("Product Updated Successfully","Success");
        return redirect()->route('seller.products.index');
    }

    public function destroy($id)
    {
        //
    }
    public function dyingProductCreate(){
        return view('frontend.seller.product.dying_product_create');
    }
    public function dyingProductStore(Request $request){
        //        if(count(checkSellerCurrentCommissionDueStatus(Auth::user()->id)) > 0){
//            Toastr::warning('Your previous commission not paid yet! Please Pay your commission first. ','Warning');
//            return redirect()->route('seller.accounts');
//        }


        $row_count_1 = count($request->test_parameter_id);
        $data_1 = array();
        for($i=0; $i<$row_count_1;$i++){
            $info_1['test_parameter_id'] = $request->test_parameter_id[$i];
            $info_1['method_id'] = $request->test_method_id[$i];
            $info_1['req'] = $request->test_req[$i];
            $info_1['result'] = $request->test_result[$i];
            $info_1['remark'] = $request->test_remark[$i];
            array_push($data_1,$info_1);
        }
        $row_count_2 = count($request->color_fastness_id);
        $data_2 = array();
        for($i=0; $i<$row_count_2;$i++){
            $info_2['color_fastness_id'] = $request->color_fastness_id[$i];
            $info_2['method_id'] = $request->fastness_method_id[$i];
            $info_2['req'] = $request->shade_req[$i];
            $info_2['result'] = $request->shade_result[$i];
            $info_2['remark'] = $request->shade_remark[0];
            array_push($data_2,$info_2);
        }
        $row_count_3 = count($request->color_fastness_id);
//        dd($row_count_3);
        $data_3 = array();
        for($i=0; $i<$row_count_3;$i++){
            $info_3['color_fastness_id'] = $request->color_fastness_id[$i];
            $info_3['req'] = $request->cross_req[$i];
            $info_3['result'] = $request->cross_result[$i];
            $info_3['remark'] = $request->cross_remark[0];
            array_push($data_3,$info_3);
        }

        $product = new Product();
        $product->name = $request->name;
        $product->user_id = Auth::id();
        $product->user_type = 'seller';
        $product->category_id = 7;

        $photos = array();
        if($request->hasFile('photos')){
            $thumbnail_img = $request->photos[0];
            $product->thumbnail_img = $thumbnail_img->store('uploads/products/thumbnail');

            foreach ($request->photos as $key => $photo) {
                $path = $photo->store('uploads/products/photos');
                array_push($photos, $path);
            }
            $product->photos = json_encode($photos);
        }

        if(currency()->code == 'BDT'){
            $unit_price = $request->unit_price;
            $expected_price = $request->unit_price * $request->quantity;
        }else{
            $unit_price = convert_to_bdt($request->unit_price);
            $expected_price = convert_to_bdt($request->unit_price * $request->quantity);
        }

        $product->quantity = $request->quantity;
        $product->unit_id = $request->unit_id;
        $product->unit_price = $unit_price;
        $product->expected_price = $expected_price;
        $product->currency_id = 27;
        $product->price_validity = $request->price_validity;
        $product->made_in = $request->made_in;
        $product->description = $request->description;
        $product->published = 1;
        $product->featured_product = 0;
        $product->delivery_status = 'pending';
        $product->slug = $request->name.'-'.Str::random(5);
        $product->verification_status = 0;
        $product->save();
        $insert_id = $product->id;

        if ($insert_id){
            $dyingProduct = new DyingProduct();
            $dyingProduct->product_id = $insert_id;
            $dyingProduct->dying_category_id = $request->dying_category_id;
            $dyingProduct->dying_sub_category_id = $request->dying_sub_category_id;
            $dyingProduct->product_of_fabric = $request->product_of_fabric;
            $dyingProduct->quantity = $request->quantity;
            $dyingProduct->color = $request->color;
            $dyingProduct->fabrics_construction = $request->fabrics_construction;
            $dyingProduct->fabrics_composition = $request->fabrics_composition;
            $dyingProduct->grey_width = $request->grey_width;
            $dyingProduct->grey_unit = $request->grey_unit;
            $dyingProduct->finished_width = $request->finished_width;
            $dyingProduct->finished_unit = $request->finished_unit;
//            $dyingProduct->color_test_parameter = $request->color_test_parameter;
//            $dyingProduct->color_test_parameter_bn = $request->color_test_parameter_bn;
//            $dyingProduct->rubbing = $request->rubbing;
//            $dyingProduct->rubbing_bn = $request->rubbing_bn;
//            $dyingProduct->tearing_strange = $request->tearing_strange;
//            $dyingProduct->tearing_strange_bn = $request->tearing_strange_bn;
//            $dyingProduct->shining_receive = $request->shining_receive;
//            $dyingProduct->shining_receive_bn = $request->shining_receive_bn;
            $dyingProduct->test_parameter_info = json_encode($data_1);
            $dyingProduct->color_fastness_info = json_encode($data_2);
            $dyingProduct->cross_staining_info = json_encode($data_3);
            $dyingProduct->save();
            $row_count_4 = count($request->color_stain_id);
            $data_4 = array();
            $new_row_count =count($request->color_stain_id1);

//            for($i=0; $i<$row_count_4;$i++){
            for($k=0; $k<$new_row_count;$k++){
                $colorStainingInfo = new ColorStainingInfo();
                $colorStainingInfo->dying_product_id = $dyingProduct->id;
                $colorStainingInfo->color_stain_id = $request->color_stain_id1[$k];
                $colorStainingInfo->color_fastness_id = $request->color_fast_id1[$k];
                $colorStainingInfo->req = $request->staining_req[$k];
                $colorStainingInfo->result = $request->staining_result[$k];
                if ($request->color_stain_id1[$k] == $k+1){
                    $colorStainingInfo->remark = $request->staining_remark[$k];
                }

                $colorStainingInfo->save();
            }
//            }

        }
        if($insert_id){
            $user = User::where('id',Auth::id())->first();
            $title = 'Seller Dying Product Entry';
            $message = $user->name .' Added A New Product "'.$product->name.'" .';
            createNotificationWithProductId(9,$title,$message,$insert_id);
        }
        Toastr::success("Product Inserted Successfully. Now Waiting For Approval.","Success");
        return redirect()->route('seller.products.index');
    }

    public function dyingProductEdit($id){
        $product = Product::find(decrypt($id));
        $dyingProduct = DyingProduct::where('product_id',decrypt($id))->first();
        return view('frontend.seller.product.dying_product_edit',compact('product','dyingProduct'));
    }
    public function dyingProductUpdate(Request $request, $id){

        $row_count_1 = count($request->test_parameter_id);
        $data_1 = array();
        for($i=0; $i<$row_count_1;$i++){
            $info_1['test_parameter_id'] = $request->test_parameter_id[$i];
            $info_1['method_id'] = $request->test_method_id[$i];
            $info_1['req'] = $request->test_req[$i];
            $info_1['result'] = $request->test_result[$i];
            $info_1['remark'] = $request->test_remark[$i];
            array_push($data_1,$info_1);
        }
        $row_count_2 = count($request->color_fastness_id);
        $data_2 = array();
        for($i=0; $i<$row_count_2;$i++){
            $info_2['color_fastness_id'] = $request->color_fastness_id[$i];
            $info_2['method_id'] = $request->fastness_method_id[$i];
            $info_2['req'] = $request->shade_req[$i];
            $info_2['result'] = $request->shade_result[$i];
            $info_2['remark'] = $request->shade_remark[0];
            array_push($data_2,$info_2);
        }
        $row_count_3 = count($request->color_fastness_id);
        $data_3 = array();
        for($i=0; $i<$row_count_3;$i++){
            $info_3['color_fastness_id'] = $request->color_fastness_id[$i];
            $info_3['req'] = $request->cross_req[$i];
            $info_3['result'] = $request->cross_result[$i];
            $info_3['remark'] = $request->cross_remark[0];
            array_push($data_3,$info_3);
        }
        $product = Product::find($id);
        $product->name = $request->name;
        $photos = array();
        if($request->hasFile('photos')){
            $thumbnail_img = $request->photos[0];
            $product->thumbnail_img = $thumbnail_img->store('uploads/products/thumbnail');

            foreach ($request->photos as $key => $photo) {
                $path = $photo->store('uploads/products/photos');
                array_push($photos, $path);
            }
            $product->photos = json_encode($photos);
        }

        if(currency()->code == 'BDT'){
            $unit_price = $request->unit_price;
            $expected_price = $request->unit_price * $request->quantity;
        }else{
            $unit_price = convert_to_bdt($request->unit_price);
            $expected_price = convert_to_bdt($request->unit_price * $request->quantity);
        }
        $product->quantity = $request->quantity;
        $product->unit_id = $request->unit_id;
        $product->unit_price = $unit_price;
        $product->expected_price = $expected_price;
        $product->price_validity = $request->price_validity;
        $product->made_in = $request->made_in;
        $product->description = $request->description;
        $product->description_bn = $request->description_bn;
        $product->slug = $request->name.'-'.Str::random(5);
        $product->save();
        $insert_id = $product->id;

        if ($insert_id){

            $dyingProduct = DyingProduct::where('product_id',$id)->first();
            $dyingProduct->dying_category_id = $request->dying_category_id;
            $dyingProduct->dying_sub_category_id = $request->dying_sub_category_id;
            $dyingProduct->product_of_fabric = $request->product_of_fabric;
            $dyingProduct->quantity = $request->quantity;
            $dyingProduct->color = $request->color;
            $dyingProduct->fabrics_construction = $request->fabrics_construction;
            $dyingProduct->fabrics_composition = $request->fabrics_composition;
            $dyingProduct->grey_width = $request->grey_width;
            $dyingProduct->grey_unit = $request->grey_unit;
            $dyingProduct->finished_width = $request->finished_width;
            $dyingProduct->finished_unit = $request->finished_unit;
            $dyingProduct->color_test_parameter = $request->color_test_parameter;
            $dyingProduct->color_test_parameter_bn = $request->color_test_parameter_bn;
            $dyingProduct->rubbing = $request->rubbing;
            $dyingProduct->rubbing_bn = $request->rubbing_bn;
            $dyingProduct->tearing_strange = $request->tearing_strange;
            $dyingProduct->tearing_strange_bn = $request->tearing_strange_bn;
            $dyingProduct->shining_receive = $request->shining_receive;

            $dyingProduct->shining_receive_bn = $request->shining_receive_bn;
            $dyingProduct->test_parameter_info = json_encode($data_1);
            $dyingProduct->color_fastness_info = json_encode($data_2);
            $dyingProduct->cross_staining_info = json_encode($data_3);

            $dyingProduct->save();

            $row_count_4 = count($request->color_stain_id);
            $data_4 = array();
            for($i=0; $i<$row_count_4;$i++){
                if ($request->color_staining_info_id == null){
                    $colorStainingInfo =new ColorStainingInfo();
                    $colorStainingInfo->dying_product_id = $dyingProduct->id;
                    $colorStainingInfo->color_stain_id = $request->color_stain_id[$i];
                    $data_5 = array();
                    for($k=0; $k<$row_count_3;$k++){
                        $info_4['color_fastness_id'] = $request->color_fastness_id[$k];
                        $info_4['req'] = $request->staining_req[$k];
                        $info_4['result'] = $request->staining_result[$k];
                        array_push($data_5,$info_4);
                    }
                    $colorStainingInfo->color_staining_info =  json_encode($data_5);
                }else{
                    $colorStainingInfo =ColorStainingInfo::find($request->color_staining_info_id[$i]);
                    $colorStainingInfo->dying_product_id = $dyingProduct->id;
                    $colorStainingInfo->color_stain_id = $request->color_stain_id[$i];
                    for($k=0; $k<$row_count_3;$k++){
                        $info_4['color_fastness_id'] = $request->color_fastness_id[$k];
                        $info_4['req'] = $request->staining_req[$k];
                        $info_4['result'] = $request->staining_result[$k];
                        array_push($data_4,$info_4);
                    }
                    $colorStainingInfo->color_staining_info =  json_encode($data_4);
                }
                $colorStainingInfo->save();
            }
        }
        if($insert_id){
            $user = User::where('id',Auth::id())->first();
            $title = 'Seller Dying Product Edit';
            $message = $user->name .' Added A New Product "'.$product->name.'" .';
            createNotificationWithProductId(9,$title,$message,$insert_id);
        }
        Toastr::success("Product Inserted Successfully. Now Waiting For Approval.","Success");
//        return redirect()->route('seller.products.index');
        return back();
    }

    public function sizingProductCreate(){
        return view('frontend.seller.product.sizing_product_create');
    }
    public function sizingProductStore(Request $request){
//        if(count(checkSellerCurrentCommissionDueStatus(Auth::user()->id)) > 0){
//            Toastr::warning('Your previous commission not paid yet! Please Pay your commission first. ','Warning');
//            return redirect()->route('seller.accounts');
//        }

        $product = new Product();
        $product->name = $request->name;
        $product->user_id = Auth::id();
        $product->user_type = 'seller';
        $product->category_id = 9;

        $photos = array();
        if($request->hasFile('photos')){
            $thumbnail_img = $request->photos[0];
            $product->thumbnail_img = $thumbnail_img->store('uploads/products/thumbnail');

            foreach ($request->photos as $key => $photo) {
                $path = $photo->store('uploads/products/photos');
                array_push($photos, $path);
            }
            $product->photos = json_encode($photos);
        }

        if(currency()->code == 'BDT'){
            $unit_price = $request->price;
            $total_price = $request->price * $request->total_length;
        }else{
            $unit_price = convert_to_bdt($request->price);
            $total_price = convert_to_bdt($request->price * $request->total_length);
        }

        $product->quantity = $request->total_length;
        $product->currency_id = 27;
        $product->unit_price = $unit_price;
        $product->expected_price = $total_price;
        $product->price_validity = $request->price_validity;
        $product->made_in = $request->made_in;
        $product->description = $request->description;
        $product->published = 1;
        $product->featured_product = 0;
        $product->delivery_status = 'pending';
        $product->slug = $request->name.'-'.Str::random(5);
        $product->verification_status = 0;
        $product->save();
        $insert_id = $product->id;

        if ($insert_id){

            $sizingProduct = new SizingProduct();
            $sizingProduct->product_id = $insert_id;
            $sizingProduct->total_length = $request->total_length;
            $sizingProduct->yarn_count = $request->yarn_count;
            $sizingProduct->yarn_csp = $request->yarn_csp;
            $sizingProduct->ipi = $request->ipi;
            $sizingProduct->lengths_of = $request->lengths_of;
            $sizingProduct->price = $unit_price;
            $sizingProduct->total_price = $total_price;
            $sizingProduct->warping_lengths = $request->warping_lengths;
            $sizingProduct->sizing_lengths = $request->sizing_lengths;
            $sizingProduct->wastage_percentage = $request->wastage_percentage;
            $sizingProduct->gera = $request->gera;
            $sizingProduct->sizing_time = $request->sizing_time;
            $sizingProduct->save();
        }
        if($insert_id){
            $user = User::where('id',Auth::id())->first();
            $title = 'Seller Sizing Product Entry';
            $message = $user->name .' Added A New Product "'.$product->name.'" .';
            createNotificationWithProductId(9,$title,$message,$insert_id);
        }
        Toastr::success("Product Inserted Successfully. Now Waiting For Approval.","Success");
        return redirect()->route('seller.products.index');
    }
    public function sizingProductEdit($id){
        $product = Product::find(decrypt($id));
        $sizingProduct = SizingProduct::where('product_id',decrypt($id))->first();
        return view('frontend.seller.product.sizing_product_edit',compact('product','sizingProduct'));
    }
    public function sizingProductUpdate(Request $request, $id){

        $product = Product::find($id);
        $product->name = $request->name;
        $photos = array();
        if($request->hasFile('photos')){
            $thumbnail_img = $request->photos[0];
            $product->thumbnail_img = $thumbnail_img->store('uploads/products/thumbnail');

            foreach ($request->photos as $key => $photo) {
                $path = $photo->store('uploads/products/photos');
                array_push($photos, $path);
            }
            $product->photos = json_encode($photos);
        }
        if(currency()->code == 'BDT'){
            $unit_price = $request->price;
            $total_price = $request->price * $request->total_length;
        }else{
            $unit_price = convert_to_bdt($request->price);
            $total_price = convert_to_bdt($request->price * $request->total_length);
        }

        $product->quantity = $request->total_length;
        $product->unit_price = $unit_price;
        $product->expected_price = $total_price;
        $product->price_validity = $request->price_validity;
        $product->made_in = $request->made_in;
        $product->description = $request->description;
        $product->slug = $request->name.'-'.Str::random(5);
        $product->save();
        $insert_id = $product->id;

        if ($insert_id){

            $sizingProduct = SizingProduct::where('product_id',$id)->first();
            $sizingProduct->total_length = $request->total_length;
            $sizingProduct->yarn_count = $request->yarn_count;
            $sizingProduct->yarn_csp = $request->yarn_csp;
            $sizingProduct->ipi = $request->ipi;
            $sizingProduct->lengths_of = $request->lengths_of;
            $sizingProduct->price = $unit_price;
            $sizingProduct->total_price = $total_price;
            $sizingProduct->warping_lengths = $request->warping_lengths;
            $sizingProduct->sizing_lengths = $request->sizing_lengths;
            $sizingProduct->wastage_percentage = $request->wastage_percentage;
            $sizingProduct->gera = $request->gera;
            $sizingProduct->sizing_time = $request->sizing_time;
            $sizingProduct->save();
        }
        if($insert_id){
            $user = User::where('id',Auth::id())->first();
            $title = 'Seller Sizing Product Edit';
            $message = $user->name .' Added A New Product "'.$product->name.'" .';
            createNotificationWithProductId(9,$title,$message,$insert_id);
        }
        Toastr::success("Product Inserted Successfully. Now Waiting For Approval.","Success");
        return redirect()->route('seller.products.index');
    }
}
