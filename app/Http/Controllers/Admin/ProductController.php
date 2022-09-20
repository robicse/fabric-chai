<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UserInfo;
use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Currency;
use App\Model\DyingProduct;
use App\Model\Notification;
use App\Model\Product;
use App\Model\ProductBid;
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
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    function __construct(Request $request)
    {
        if ($request->segment(2) == 'seller-product-list') {
            $this->middleware('permission:seller-product-list|seller-product-verification-status|seller-product-featured-status|seller-product-edit|seller-product-delete', ['only' => ['sellerProductList']]);
            $this->middleware('permission:seller-product-verification-status', ['only' => ['sellerProductUpdateStatus']]);
            $this->middleware('permission:seller-product-featured-status', ['only' => ['featuredStatusUpdate']]);
            $this->middleware('permission:seller-product-edit', ['only' => ['sellerProductEdit', 'SellerProductUpdate', 'dyingProductEdit', 'dyingProductUpdate', 'sizingProductEdit', 'sizingProductUpdate']]);
            $this->middleware('permission:seller-product-delete', ['only' => ['productDelete']]);
        }else{
            $this->middleware('permission:buyer-product-list|buyer-product-verification-status|buyer-product-featured-status|buyer-product-edit|buyer-product-delete', ['only' => ['buyerProductList']]);
            $this->middleware('permission:buyer-product-verification-status', ['only' => ['sellerProductUpdateStatus']]);
            $this->middleware('permission:buyer-product-featured-status', ['only' => ['featuredStatusUpdate']]);
            $this->middleware('permission:buyer-product-edit', ['only' => ['buyerProductEdit', 'buyerProductUpdate', 'dyingProductEdit', 'dyingProductUpdate', 'sizingProductEdit', 'sizingProductUpdate']]);
            $this->middleware('permission:buyer-product-delete', ['only' => ['productDelete']]);
        }
    }
    public function sellerProductList()
    {
        $sellerProductInfos = Product::where('user_type','seller')->latest()->get();
        return view('backend.admin.seller.seller_product',compact('sellerProductInfos'));
    }
    public function sellerProductListAjax(){
        return Product::ajaxSellerProduct();
    }

    public function sellerProductIndividual($seller_id, $product_id)
    {
        $sellerProductInfos = Product::where('user_type','seller')->where('user_id',$seller_id)->where('id',$product_id)->latest()->get();
        return view('backend.admin.seller.seller_product_old',compact('sellerProductInfos'));
    }

    public function sellerProductEdit($id){
        $product = Product::find($id);
        $categories = Category::all();
        $units = Unit::all();
        $currencies = Currency::all();
        return view('backend.admin.seller.seller_product_edit',compact('product','categories','units','currencies'));

    }
    public function dyingProductEdit($id){
        $product = Product::find($id);
        $dyingProduct = DyingProduct::where('product_id',$id)->first();
        return view('backend.partials.dying_product_edit',compact('product','dyingProduct'));
    }
    public function dyingProductUpdate(Request $request, $id){

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
        $product->unit_price = $request->unit_price;
        $product->expected_price = $request->unit_price * $request->quantity;
        $product->quantity = $request->quantity;
        $product->price_validity = $request->price_validity;
        $product->made_in = $request->made_in;
        $product->description = $request->description;
        $product->slug = $request->name.'-'.Str::random(5);
        $product->save();
        $insert_id = $product->id;

        if ($insert_id){
            if(currency()->code == 'BDT'){
                $unit_price = $request->price;
                $total_price = $request->price * $request->total_length;
            }else{
                $unit_price = convert_to_bdt($request->price);
                $total_price = convert_to_bdt($request->price * $request->total_length);
            }

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
            $dyingProduct->rubbing = $request->rubbing;
            $dyingProduct->tearing_strange = $request->tearing_strange;
            $dyingProduct->shining_receive = $request->shining_receive;
            $dyingProduct->save();
        }

        Toastr::success("Product Updated Successfully","Success");

        if ($product->user_type == 'seller'){
            return redirect()->route('admin.seller-product-list');
        }else{
            return redirect()->route('admin.buyer-product-list');
        }
    }
    public function sizingProductEdit($id){
        $product = Product::find($id);
        $sizingProduct = SizingProduct::where('product_id',$id)->first();
        return view('backend.partials.sizing_product_edit',compact('product','sizingProduct'));
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
        $product->quantity = $request->total_length;
        $product->price_validity = $request->price_validity;
        $product->made_in = $request->made_in;
        $product->description = $request->description;
        $product->slug = $request->name.'-'.Str::random(5);
        $product->save();
        $insert_id = $product->id;

        if ($insert_id){
            if(currency()->code == 'BDT'){
                $unit_price = $request->price;
                $total_price = $request->price * $request->total_length;
            }else{
                $unit_price = convert_to_bdt($request->price);
                $total_price = convert_to_bdt($request->price * $request->total_length);
            }
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
        Toastr::success("Product Updated Successfully.","Success");
        if ($product->user_type == 'seller'){
            return redirect()->route('admin.seller-product-list');
        }else{
            return redirect()->route('admin.buyer-product-list');
        }

    }
    public function SellerProductUpdate(Request $request, $id){

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

        $product->quantity = $request->quantity;
        $product->unit_id = $request->unit_id;
        $product->unit_price = $request->unit_price;
        $product->expected_price = $request->expected_price;
        $product->featured_product = $request->featured_product;
        $product->price_validity = $request->price_validity;
        $product->made_in = $request->made_in;
        $product->description = $request->description;
        $product->slug = $request->slug.'-'.Str::random(5);
        $product->save();

        Toastr::success("Product Updated Successfully","Success");
        return redirect()->route('admin.seller-product-list');

    }


    public function sellerProductUpdateStatus(Request $request){
        $product = Product::findOrFail($request->id);
        $product->verification_status = $request->verification_status;
        if($product->save()){
            if ($product->verification_status == 1){
                $user = User::where('id',$product->user_id)->first();
                // current user notification
                $title = 'Approved Product';
                $message = 'Dear '. $user->name .' Your Product "'.$product->name.'" has been Approved by fabriclagbe.com';
                createNotification($product->user_id,$title,$message);
                if($user->country_code == '+880') {
                    UserInfo::smsAPI('880'.$user->phone, $message);
                    SmsNotification($user->id,$title,$message);
                }
            }


            // get notification others users
//            if($product->user_type == 'seller'){
//                $users = User::where('user_type','buyer')->get();
//            }else{
//                $users = User::where('user_type','seller')->get();
//            }
//            if(count($users) > 0){
//                foreach($users as $data){
//                    // other user notification
//                    $title = 'New Approved Product';
//                    $message = 'Mr./Mrs '. $user->name .' A New Product '. $product->name .' Come, You Can See It.';
//                    createNotification($data->id,$title,$message);
//                    if($data->country_code == '880') {
//                        UserInfo::smsAPI($data->country_code . $data->phone, $message);
//                    }
//                }
//            }
            return 1;
        }
        return 0;
    }
    public function featuredStatusUpdate(Request $request){
        $product = Product::findOrFail($request->id);
        $product->featured_product = $request->featured_status;
        if($product->save()){
            return 1;
        }
        return 0;
    }
    public function buyerProductList() {
        $buyerProductInfos = Product::where('user_type','buyer')->latest()->get();
        return view('backend.admin.buyer.buyer_product',compact('buyerProductInfos'));
    }
    public function buyerProductListAjax(){
        return Product::ajaxBuyerProduct();
    }
    public function buyerUnapprovedProductList() {
        $buyerProductInfos = Product::where('user_type','buyer')->latest()->get();
        return view('backend.admin.buyer.buyer_unapproved_product',compact('buyerProductInfos'));
    }
     public function buyerUnapprovedProductListAjax(){
        return Product::ajaxBuyerUnapprovedProduct();
    }

    public function buyerProductIndividual($seller_id, $product_id) {
        $buyerProductInfos = Product::where('user_type','buyer')->where('user_id',$seller_id)->where('id',$product_id)->latest()->get();
        return view('backend.admin.buyer.buyer_product_old',compact('buyerProductInfos'));
    }
    public function buyerProductEdit($id){
        $product = Product::find($id);
        $categories = Category::all();
        $units = Unit::all();
        $currencies = Currency::all();
        return view('backend.admin.buyer.buyer_product_edit',compact('product','categories','units','currencies'));

    }
    public function buyerProductUpdate(Request $request, $id){

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

        $product->quantity = $request->quantity;
        $product->unit_id = $request->unit_id;
        $product->unit_price = $request->unit_price;
        $product->expected_price = $request->expected_price;
        $product->featured_product = $request->featured_product;
        $product->price_validity = $request->price_validity;
        $product->made_in = $request->made_in;
        $product->description = $request->description;
        $product->slug = $request->slug.'-'.Str::random(5);
        $product->save();

        Toastr::success("Product Updated Successfully","Success");
        return redirect()->route('admin.buyer-product-list');

    }

    public function ajaxSlugMake($name)
    {
        $data = Str::slug($name);
        return response()->json(['success'=> true, 'response'=>$data]);
    }
    public function ajaxSubCat (Request $request)
    {
        $subcategories = SubCategory::where('category_id', $request->category_id)->get();
        return $subcategories;
    }
    public function ajaxSubSubCat(Request $request)
    {
        $subsubcategories = SubSubCategory::where('sub_category_id', $request->sub_category_id)->get();
        return $subsubcategories;
    }
    public function ajaxSubSubChldCat(Request $request)
    {
        $subsubchildcategories = SubSubChildCategory::where('sub_sub_category_id', $request->sub_sub_category_id)->get();
        return $subsubchildcategories;
    }
    public function ajaxSubSubChldChildCat(Request $request)
    {
        $subsubchildchildcategories = SubSubChildChildCategory::where('sub_sub_child_cat_id', $request->sub_sub_child_category_id)->get();
        return $subsubchildchildcategories;
    }

    public function productDelete($id){
        $product = Product::find($id);
        $bidCheck = ProductBid::where('product_id',$product->id)->first();
        if ($bidCheck){
            Toastr::warning('You can not delete this product');
            return back();
        }else{
            $notifications = Notification::where('product_id',$product->id)->get();
            foreach ($notifications as $notification){
                $notification->delete();
            }
            $product->delete();
            Toastr::success('Product deleted successfully');
            return back();
        }
    }


    public function sellerUnApprovedProductList()
    {
        
        return view('backend.admin.seller.unapproved_seller_product');
    }


    public function sellerUnapprovedProductListAjax(){
        return Product::ajaxUnapprovedSellerProduct();
    }

}
