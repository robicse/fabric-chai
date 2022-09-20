<?php

namespace App\Http\Controllers\Api;


use App\Http\Resources\AllRequestedProductCollection;
use App\Http\Resources\CountryCollection;
use App\Http\Resources\DyingCategoryCollection;
use App\Http\Resources\DyingProductDetailCollection;
use App\Http\Resources\DyingSubCategoryCollection;
use App\Http\Resources\OurProductCollection;
use App\Http\Resources\ProductAndServicesCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductDetailCollection;
use App\Http\Controllers\Controller;
use App\Http\Resources\SizingProductDetailCollection;
use App\Http\Resources\UnitCollection;
use App\Model\AdminProduct;
use App\Model\Color;
use App\Model\Countries;
use App\Model\Currency;
use App\Model\DyingCategory;
use App\Model\DyingProduct;
use App\Model\DyingSubcategory;
use App\Model\Product;
use App\Model\SizingProduct;
use App\Model\Unit;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\ProductsListCollection;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function ourProduct(){
        $products = AdminProduct::all();
        if (!empty($products)){
            return response()->json(['success'=>true,'response'=> $products], 200);
        }else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function productAndServices(){
        return new ProductAndServicesCollection($products = AdminProduct::all());
    }
    public function productAndServicesDetails($slug){
        return new ProductAndServicesCollection($products = AdminProduct::where('slug',$slug)->get());
    }

    public function ourProductV2(){
        $products = AdminProduct::all();
        return new OurProductCollection($products);
    }

    public function buyerRecentProduct()
    {
        $products = Product::where('user_id','!=',Auth::id())
            ->where('user_type','seller')
            ->where('published',1)
            ->where('verification_status',1)
            ->where('bid_status','Applied')
//            ->where('price_validity','>=',date('Y-m-d'))
            ->latest()->get();
        return new ProductCollection($products);
    }
    public function buyerRecentProductPaginate($page_size){
        $products = Product::where('user_id','!=',Auth::id())
            ->where('user_type','seller')
            ->where('published',1)
            ->where('verification_status',1)
            ->where('bid_status','Applied')
//            ->where('price_validity','>=',date('Y-m-d'))
            ->latest()->paginate($page_size);
        return new ProductCollection($products);
    }

    public function buyerRecentProductPaginateV2(Request $request,$page_size){
        if( $request->name != null){
            $name = $request->name;
            $products = Product::where('user_id','!=',Auth::id())
                ->where('user_type','seller')
                ->where('published',1)
                ->where('verification_status',1)
                ->where('bid_status','Applied')
                ->where(function($query) use ($name){
                    $query->where('name', 'like', '%'.$name.'%')
                        ->orWhere('name_bn', 'like', '%'.$name.'%');
                })
                ->latest()->paginate($page_size);
        }
        else{
            $products = Product::where('user_id','!=',Auth::id())
                ->where('user_type','seller')
                ->where('published',1)
                ->where('verification_status',1)
                ->where('bid_status','Applied')
//            ->where('price_validity','>=',date('Y-m-d'))
                ->latest()->paginate($page_size);
        }

        return new ProductCollection($products);
    }

    public function show($id)
    {
        return new ProductDetailCollection(Product::where('id', $id)->get());
    }

    public function related($id)
    {
        $product = Product::find($id);
        return new ProductCollection(Product::where('subcategory_id', $product->subcategory_id)->where('id', '!=', $id)->limit(10)->get());
    }

    public function buyerFeaturedProduct()
    {
        $featured_products = Product::where('user_id','!=',Auth::id())
            ->where('user_type','seller')
            ->where('published',1)
            ->where('verification_status',1)
            ->where('featured_product',1)
            ->where('bid_status','Applied')
//            ->where('price_validity','>=',date('Y-m-d'))
            ->latest()->get();
        return new ProductCollection($featured_products);
    }
    public function  buyerFeaturedProductPaginate($page_size){
        $featured_products = Product::where('user_id','!=',Auth::id())
            ->where('user_type','seller')
            ->where('published',1)
            ->where('verification_status',1)
            ->where('featured_product',1)
            ->where('bid_status','Applied')
//            ->where('price_validity','>=',date('Y-m-d'))
            ->latest()->paginate($page_size);
        return new ProductCollection($featured_products);
    }

    public function  buyerFeaturedProductPaginateV2(Request $request,$page_size){
        if( $request->name != null){
            $name = $request->name;
            $featured_products = Product::where('user_id','!=',Auth::id())
                ->where('user_type','seller')
                ->where('published',1)
                ->where('verification_status',1)
                ->where('featured_product',1)
                ->where('bid_status','Applied')
                ->where(function($query) use ($name){
                    $query->where('name', 'like', '%'.$name.'%')
                        ->orWhere('name_bn', 'like', '%'.$name.'%');
                })
                ->latest()->paginate($page_size);
        }
        else{
            $featured_products = Product::where('user_id','!=',Auth::id())
                ->where('user_type','seller')
                ->where('published',1)
                ->where('verification_status',1)
                ->where('featured_product',1)
                ->where('bid_status','Applied')
//            ->where('price_validity','>=',date('Y-m-d'))
                ->latest()->paginate($page_size);
        }

        return new ProductCollection($featured_products);
    }

    public function  sellerRecentProduct(){
        $products = Product::where('user_id','!=',Auth::id())
            ->where('user_type','buyer')
            ->where('published',1)
            ->where('verification_status',1)
            ->where('bid_status','Applied')
//            ->where('price_validity','>=',date('Y-m-d'))
            ->latest()->get();
        return new ProductCollection($products);
    }
    public function  sellerRecentProductPagination($page_size){
        $products = Product::where('user_id','!=',Auth::id())
            ->where('user_type','buyer')
            ->where('published',1)
            ->where('verification_status',1)
            ->where('bid_status','Applied')
//            ->where('price_validity','>=',date('Y-m-d'))
            ->latest()->paginate($page_size);
        return new ProductCollection($products);
    }

    public function  sellerRecentProductPaginationV2(Request $request,$page_size){
        if( $request->name != null){
            $name = $request->name;
            $products = Product::where('user_id','!=',Auth::id())
                ->where('user_type','buyer')
                ->where('published',1)
                ->where('verification_status',1)
                ->where('bid_status','Applied')
                ->where(function($query) use ($name){
                    $query->where('name', 'like', '%'.$name.'%')
                        ->orWhere('name_bn', 'like', '%'.$name.'%');
                })
                ->latest()->paginate($page_size);
        }
        else{
            $products = Product::where('user_id','!=',Auth::id())
                ->where('user_type','buyer')
                ->where('published',1)
                ->where('verification_status',1)
                ->where('bid_status','Applied')
//            ->where('price_validity','>=',date('Y-m-d'))
                ->latest()->paginate($page_size);
        }

        return new ProductCollection($products);
    }

    public function sellerFeaturedProduct()
    {
        $featured_products = Product::where('user_id','!=',Auth::id())
            ->where('user_type','buyer')
            ->where('published',1)
            ->where('verification_status',1)
            ->where('featured_product',1)
            ->where('bid_status','Applied')
//            ->where('price_validity','>=',date('Y-m-d'))
            ->latest()->get();
        return new ProductCollection($featured_products);
    }
    public function  sellerFeaturedProductPagination($page_size){
        $featured_products = Product::where('user_id','!=',Auth::id())
            ->where('user_type','buyer')
            ->where('published',1)
            ->where('verification_status',1)
            ->where('featured_product',1)
            ->where('bid_status','Applied')
//            ->where('price_validity','>=',date('Y-m-d'))
            ->latest()->paginate($page_size);
        return new ProductCollection($featured_products);
    }

    public function  sellerFeaturedProductPaginationV2(Request $request,$page_size){

        if( $request->name != null){
            $name = $request->name;
            $featured_products = Product::where('user_id','!=',Auth::id())
                ->where('user_type','buyer')
                ->where('published',1)
                ->where('verification_status',1)
                ->where('featured_product',1)
                ->where('bid_status','Applied')
                ->where(function($query) use ($name){
                    $query->where('name', 'like', '%'.$name.'%')
                        ->orWhere('name_bn', 'like', '%'.$name.'%');
                })
                ->latest()->paginate($page_size);
        }
        else{
            $featured_products = Product::where('user_id','!=',Auth::id())
                ->where('user_type','buyer')
                ->where('published',1)
                ->where('verification_status',1)
                ->where('featured_product',1)
                ->where('bid_status','Applied')
//            ->where('price_validity','>=',date('Y-m-d'))
                ->latest()->paginate($page_size);
        }
        return new ProductCollection($featured_products);
    }

    public function getUnit(){
        return new UnitCollection(Unit::all());
    }
    public function getCurrency(){
        $currencies = Currency::where('status',1)->get();
        if (!empty($currencies))
        {
            return response()->json(['success'=>true,'response'=> $currencies], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function getCountries(){
//        return new CountryCollection(Countries::all());
        $countries = Countries::all();
        $nestedData = [];
        foreach ($countries as $country){
            $data['id']=$country->id;
            $data['name']=getCountryNameByBnEn($country);
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
    public function getColors(){
        $colors = Color::select('name','code')->get();
        if (!empty($colors))
        {
            return response()->json(['success'=>true,'response'=> $colors], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function getDyningCategories(){
        $dyingCategories = DyingCategory::select('id','name','name_bn')->orderBy('id','ASC')->get();
        return new DyingCategoryCollection($dyingCategories);
    }
    public function getDyningSubcategories($id){
        $dyingSubcategories = DyingSubcategory::where('dying_category_id',$id)->select('id','name','name_bn')->get();
        return new DyingSubCategoryCollection($dyingSubcategories);
    }

    public function productStore(Request $request){

        $this->validate($request, [
//            'name'=> 'required',
            'unit_price'=> 'required',
            'unit_id'=> 'required',
            'currency_id'=> 'required',
        ]);

        if(empty($request->photos)){
            return response()->json(['success'=>false,'response'=> 'You can not submit without product image! You can try again.'], 401);
        }

        if(!empty($request->photos) && ($request->category_id === 4)){
            return response()->json(['success'=>false,'response'=> 'Yarn Category No Selected, Please Contact With Administrator!'], 401);
        }

        $user = User::find(Auth::id());
        $product = new Product();
        $product->name = $request->name;
        $product->name_bn = $request->name_bn;
        $product->user_id = Auth::id();
        $product->user_type = $user->user_type;
        $product->category_id = $request->category_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->sub_sub_category_id = $request->sub_sub_category_id;
        $product->sub_sub_child_category_id = $request->sub_sub_child_category_id;
        $product->sub_sub_child_child_category_id = $request->sub_sub_child_child_category_id;
        $product->category_six_id = $request->category_six_id;
        $product->category_seven_id = $request->category_seven_id;
        $product->category_eight_id = $request->category_eight_id;
        $product->category_nine_id = $request->category_nine_id;
        $product->category_ten_id = $request->category_ten_id;

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

        if($request->currency_id == 27){
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
        $product->description_bn = $request->description_bn;
        $product->published = 1;
        $product->featured_product = 0;
        $product->delivery_status = 'pending';
        $product->slug = Str::slug($request->name).'-'.Str::random(5);
        $product->verification_status = 0;
        $product->save();
        $insert_id = $product->id;
        if($insert_id){
            $user = User::where('id',Auth::id())->first();
            if ($user->user_type == 'seller'){
                $title = 'Seller Product Entry';
            }
            if ($user->user_type == 'buyer'){
                $title = 'Buyer Product Entry';
            }
            $message = $user->name .' Added A New Product "'.$product->name.'" .';
            createNotificationWithProductId(9,$title,$message,$insert_id);
        }
        if (!empty($product))
        {
            return response()->json(['success'=>true,'response'=> $product], 201);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 401);
        }
    }

    public function productUpdate(Request $request, $id){

        $product = Product::find($id);
        $product->name = $request->name;
        $product->name_bn = $request->name_bn;
        $product->category_id = $request->category_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->sub_sub_category_id = $request->sub_sub_category_id;
        $product->sub_sub_child_category_id = $request->sub_sub_child_category_id;
        $product->sub_sub_child_child_category_id = $request->sub_sub_child_child_category_id;
        $product->category_six_id = $request->category_six_id;
        $product->category_seven_id = $request->category_seven_id;
        $product->category_eight_id = $request->category_eight_id;
        $product->category_nine_id = $request->category_nine_id;
        $product->category_ten_id = $request->category_ten_id;


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

        if($request->currency_id == 27){
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
        $product->description_bn = $request->description_bn;
        $product->slug = Str::slug($request->name).'-'.Str::random(5);
        $product->save();
        $insert_id = $product->id;

        if (!empty($product))
        {
            $user = User::where('id',Auth::id())->first();
            if ($user->user_type == 'seller'){
                $title = 'Seller Product Update';
            }
            if ($user->user_type == 'buyer'){
                $title = 'Buyer Product Update';
            }
            $message = $user->name .' Updated their product "'.$product->name.'".';
            createNotificationWithProductId(9,$title,$message,$insert_id);

            return response()->json(['success'=>true,'response'=> $product], 201);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 401);
        }

    }
    public function sellerMyProducts(){
        $products = Product::where('user_id',Auth::id())->where('user_type','seller')->latest()->get();
        return new ProductsListCollection($products);
    }
    public function buyerMyProducts(){
        $products = Product::where('user_id',Auth::id())->where('user_type','buyer')->latest()->get();
        return new ProductsListCollection($products);
    }

    public function getProductDetails($id){
        $product = Product::find($id);
        if ($product->category_id == 9 && $product->sizingProduct){
            return new SizingProductDetailCollection(Product::where('id', $id)->get());
        }elseif ($product->category_id == 7 && $product->dyingProduct){
            return new DyingProductDetailCollection(Product::where('id', $id)->get());
        }
        else{
            return new ProductDetailCollection(Product::where('id', $id)->get());
        }

    }

    public function buyerAllProducts(){
        $products = Product::where('user_type','seller')
            ->where('user_id','!=',Auth::id())
            ->where('published',1)
            ->where('verification_status',1)
            ->where('bid_status','Applied')
            ->latest()->take(50)->get();
        return new AllRequestedProductCollection($products);
    }
    public function buyerAllProductsPagination($page_size){
        $products = Product::where('user_type','seller')
            ->where('user_id','!=',Auth::id())
            ->where('published',1)
            ->where('verification_status',1)
            ->where('bid_status','Applied')
            ->latest()->paginate($page_size);
        return new AllRequestedProductCollection($products);
    }
    public function sellerAllRequests(){
        $products = Product::where('user_type','buyer')
            ->where('user_id','!=',Auth::id())
            ->where('published',1)
            ->where('verification_status',1)
            ->where('bid_status','Applied')
            ->latest()->get();
        return new AllRequestedProductCollection($products);
    }
    public function sellerAllRequestsPaginate($page_size){
        $products = Product::where('user_type','buyer')
            ->where('user_id','!=',Auth::id())
            ->where('published',1)
            ->where('verification_status',1)
            ->where('bid_status','Applied')
            ->latest()->paginate($page_size);
        return new AllRequestedProductCollection($products);
    }

    public function checkSellerCurrentCommissionDueStatus(){
        if(count(checkSellerCurrentCommissionDueStatus(Auth::user()->id)) > 0){
            $due_status = 1;
        }else{
            $due_status = 0;
        }
        return response()->json(['success'=>true,'response'=> $due_status], 201);
    }

    public function dyingProductStore(Request $request){
        $product = new Product();
        $product->name = $request->name;
        $product->user_id = Auth::id();
        $product->user_type = Auth::user()->user_type;
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

        if($request->currency_id  == 27){
            $unit_price = $request->unit_price;
            $expected_price = $request->unit_price * $request->quantity;
        }else{
            $unit_price = convert_to_bdt($request->unit_price);
            $expected_price = convert_to_bdt($request->unit_price * $request->quantity);
        }

        $product->quantity = $request->quantity;
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
            $dyingProduct->color_test_parameter = $request->color_test_parameter;
            $dyingProduct->rubbing = $request->rubbing;
            $dyingProduct->tearing_strange = $request->tearing_strange;
            $dyingProduct->shining_receive = $request->shining_receive;
            $dyingProduct->save();

        }
        if($insert_id){
            $user = User::where('id',Auth::id())->first();
            if ($user->user_type == 'seller'){
                $title = 'Seller Dying Product Entry';
            }
            if ($user->user_type == 'buyer'){
                $title = 'Buyer Dying Product Entry';
            }
            $message = $user->name .' Added a New Product "'.$product->name.'" .';
            createNotificationWithProductId(9,$title,$message,$insert_id);
        }
        $data['status'] = 'Dying product created successfully';
        $data['product_id'] = $product->id;
        if (!empty($product))
        {
            return response()->json(['success'=>true,'response'=> $data], 201);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 401);
        }
    }
    public function dyingProductUpdate(Request $request,$id){
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

        if($request->currency_id  == 27){
            $unit_price = $request->unit_price;
            $expected_price = $request->unit_price * $request->quantity;
        }else{
            $unit_price = convert_to_bdt($request->unit_price);
            $expected_price = convert_to_bdt($request->unit_price * $request->quantity);
        }

        $product->quantity = $request->quantity;
        $product->unit_price = $unit_price;
        $product->expected_price = $expected_price;
        $product->currency_id = 27;
        $product->price_validity = $request->price_validity;
        $product->made_in = $request->made_in;
        $product->description = $request->description;
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
            $dyingProduct->rubbing = $request->rubbing;
            $dyingProduct->tearing_strange = $request->tearing_strange;
            $dyingProduct->shining_receive = $request->shining_receive;
            $dyingProduct->save();

        }
        if($insert_id){
            $user = User::where('id',Auth::id())->first();
            if ($user->user_type == 'seller'){
                $title = 'Seller Dying Product Edit';
            }
            if ($user->user_type == 'buyer'){
                $title = 'Buyer Dying Product Edit';
            }
            $message = $user->name .' Edited a Product "'.$product->name.'" .';
            createNotificationWithProductId(9,$title,$message,$insert_id);
        }
        $data['status'] = 'Dying product edited successfully';
        $data['product_id'] = $product->id;
        if (!empty($product))
        {
            return response()->json(['success'=>true,'response'=> $data], 201);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 401);
        }
    }

    public function sizingProductStore(Request $request){
        $product = new Product();
        $product->name = $request->name;
        $product->user_id = Auth::id();
        $product->user_type = Auth::user()->user_type;
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
        if($request->currency_id  == 27){
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
            if ($user->user_type == 'seller'){
                $title = 'Seller Sizing Product Entry';
            }
            if ($user->user_type == 'buyer'){
                $title = 'Buyer Sizing Product Entry';
            }
            $message = $user->name .' Added a New Product "'.$product->name.'" .';
            createNotificationWithProductId(9,$title,$message,$insert_id);
        }
        $data['status'] = 'Sizing product created successfully';
        $data['product_id'] = $product->id;
        if (!empty($product))
        {
            return response()->json(['success'=>true,'response'=> $data], 201);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 401);
        }
    }
    public function sizingProductUpdate(Request $request,$id){

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
        if($request->currency_id  == 27){
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
            if ($user->user_type == 'seller'){
                $title = 'Seller Sizing Product Edit';
            }
            if ($user->user_type == 'buyer'){
                $title = 'Buyer Sizing Product Edit';
            }
            $message = $user->name .' Edited a Product "'.$product->name.'" .';
            createNotificationWithProductId(9,$title,$message,$insert_id);
        }
        $data['status'] = 'Sizing product updated successfully';
        $data['product_id'] = $product->id;
        if (!empty($product))
        {
            return response()->json(['success'=>true,'response'=> $data], 201);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 401);
        }
    }










}
