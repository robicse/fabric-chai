<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Product;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class YarnProductController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:yarn-product-list|yarn-product-create|yarn-product-edit', ['only' => ['index','store']]);
        $this->middleware('permission:yarn-product-create', ['only' => ['create','store']]);
        $this->middleware('permission:yarn-product-edit', ['only' => ['edit','update']]);
    }
    public function index()
    {
        $products = Product::where('admin_status',1)->latest()->get();
        return view('backend.admin.yarn_product.index',compact('products'));
    }

    public function create()
    {
        return view('backend.admin.yarn_product.create');
    }

    public function store(Request $request)
    {
        $user = User::find($request->user_id);
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
        $product->user_id = $user->id;
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
        $unit_price = $request->unit_price;
        $expected_price = $request->expected_price;

        //dd($expected_price);

        $product->quantity = $request->quantity;
        $product->unit_id = $request->unit_id;
        $product->unit_price = $unit_price;
        $product->expected_price = $expected_price;
        $product->currency_id = 27;
        $product->price_validity = $request->price_validity;
        $product->made_in = $request->made_in;
        $product->description = $request->description;
        $product->published = 1;
        $product->featured_product = $request->featured_product;
        $product->delivery_status = 'pending';
        $product->slug = $request->slug.'-'.Str::random(5);
        $product->verification_status = 1;
        $product->admin_status = 1;
        $product->save();
        $insert_id = $product->id;
        if($insert_id){
            $title = 'Seller Product Entry';
            $message = $user->name .' Added A New Product "'.$product->name.'" .';
            //createNotification($user->id,$title,$message);
            createNotificationWithProductId(9,$title,$message,$insert_id);
            // admin sms
//            UserInfo::smsAPI('8801725930131', $message);
        }
        Toastr::success("Product Inserted Successfully","Success");
        return redirect()->route('admin.yarn-product.index');

    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $product = Product::find($id);
        return view('backend.admin.yarn_product.edit',compact('product'));

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

//        $product->thumbnail_img = $request->previous_thumbnail_img;
//        if($request->hasFile('thumbnail_img')){
//            $product->thumbnail_img = $request->thumbnail_img->store('uploads/products/thumbnail');
//        }

        $unit_price = $request->unit_price;
        $expected_price = $request->expected_price;
        $product->quantity = $request->quantity;
        $product->unit_id = $request->unit_id;
        $product->unit_price = $unit_price;
        $product->expected_price = $expected_price;
        $product->currency_id = 27;
        $product->price_validity = $request->price_validity;
        $product->made_in = $request->made_in;
        $product->description = $request->description;
        $product->slug = $request->slug.'-'.Str::random(5);
        $product->save();

        Toastr::success("Yarn Product Updated Successfully","Success");
        return redirect()->route('admin.yarn-product.index');
    }

    public function destroy($id)
    {
        //
    }
    public function phoneVerification($phone){
        $phone_number = (integer) $phone;
        $user = User::where('phone',$phone_number)->first();
        if ($user){
            return $user->id;
        }else{
            return 0;
        }
    }
}
