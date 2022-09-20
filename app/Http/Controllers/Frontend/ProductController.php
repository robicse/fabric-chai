<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\UserInfo;
use App\Http\Controllers\Controller;
use App\Model\AdminProduct;
use App\Model\Category;
use App\Model\HomeCategory;
use App\Model\Product;
use App\Model\ProductBid;
use App\Model\Subcategory;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{

    public function productDetails($slug){
        try {
            $detailedProduct = Product::where('slug',$slug)->first();
            $photos=json_decode($detailedProduct->photos);
            $relatedProducts = Product::where('category_id',$detailedProduct->category_id)->where('published',1)->latest()->take(10)->get();
            return view('frontend.pages.product_details',compact('detailedProduct','photos','relatedProducts'));
        }catch (\Exception $e){
            Toastr::error('No Data Found!!!');
            return redirect()->route('index');
        }

    }

    public function frontendProductDetails($slug){
        try {
            $detailedProduct = Product::where('slug',$slug)->first();
            $photos=json_decode($detailedProduct->photos);
            $relatedProducts = Product::where('category_id',$detailedProduct->category_id)->where('published',1)->latest()->take(10)->get();
            return view('frontend.pages.frontend_product_details',compact('detailedProduct','photos','relatedProducts'));
        }catch (\Exception $e) {
            Toastr::error('No Data Found!!!');
            return redirect()->route('index');
        }

    }

    public function productBidStore(Request $request){
        if(Auth::check()){
            $membership_package_id = checkMembershipStatus(Auth::id());
            $user_type = checkUserType(Auth::id());
            if($user_type == 'seller' && $membership_package_id == 1){
                Toastr::warning('Upgrade your membership package!');
                return redirect()->back();
            }

            if(currency()->code != 'BDT'){
                $bid_price = convert_to_bdt($request->bid_price);
            }else{
                //$bid_price = single_price_without_symbol($request->bid_price);
                $bid_price = $request->bid_price;
            }
            $product = Product::where('id',$request->product_id)->first();
            if ($user_type == 'buyer' && $bid_price > $product->unit_price){
                Toastr::error('Bid unit price must be lesser than Seller unit price');
                return redirect()->back();
            }
            if ($user_type == 'seller' && $bid_price < $product->unit_price){
                Toastr::error('Bid unit price must be greater than Buyer unit price');
                return redirect()->back();
            }
            $product_bid = new ProductBid();
            $product_bid->sender_user_id = Auth::id();
            $product_bid->receiver_user_id = $product->user_id;
            $product_bid->product_id = $request->product_id;
            $product_bid->unit_bid_price = $bid_price;
            $product_bid->total_bid_price = $bid_price * $product->quantity;
            $product_bid->bid_status = 0;
            $product_bid->save();
            $bidder = User::where('id',$product_bid->sender_user_id )->first();

            $user = User::where('id',$product_bid->receiver_user_id )->first();

            $title = 'Placed Bid';
//            $message = 'Dear'.$user->name.' placed bid of '. $user->name .' product.';
            $message = 'Dear '.$user->name.', your product "'.$product->name.'" has been bidden by '.$bidder->name.' with '.$product_bid->unit_bid_price.currency()->symbol.' unit bid amount';
            placedBidNotification($product->id,$product->user->id,$title,$message);
            if($user->country_code == '+880') {
                UserInfo::smsAPI('880' . $user->phone, $message);
                SmsNotification($user->id,$title,$message);
            }

            if (Auth::user()->user_type == 'seller'){
                Toastr::success('Your bid placed successfully');
                return redirect()->route('seller.dashboard');
            }elseif (Auth::user()->user_type == 'buyer'){
                Toastr::success('Your bid placed successfully');
                return redirect()->route('buyer.dashboard');
            }

        }else{
            Toastr::warning('You need to login first');
        }
        return redirect()->route('login');
    }


    public function ourProducts(){
        $category = null;
        $products = AdminProduct::all();
        return view('frontend.pages.our_products',compact('products','category'));
    }
    public function ourProductByCategory($slug){
        $category = Category::where('slug',$slug)->first();
        $homeCategory = HomeCategory::where('category_id',$category->id)->first();
        $products = AdminProduct::where('home_category_id',$homeCategory->id)->get();
        return view('frontend.pages.our_products',compact('products','category'));
    }
    public function ourProductDetails($slug){
        $product = AdminProduct::where('slug',$slug)->first();
        return view('frontend.pages.our_product_details',compact('product'));

    }

    public function productBySubcategory($slug){
        $subcategory = Subcategory::where('slug',$slug)->first();
        $SubCatProducts = Product::where('subcategory_id',$subcategory->id)->where('published',1)->latest()->paginate(36);
        return view('frontend.pages.product.products_by_subcategory',compact('subcategory','SubCatProducts'));
    }
    public function todaysDealProducts(){
        $products = Product::where('published',1)->where('todays_deal',1)->latest()->get();
        $title = "Today's Deal Products";
        return view('frontend.pages.product.product_list',compact('products','title'));
    }
    public function featuredProduct(){
        $products = Product::where('published',1)->where('featured',1)->latest()->get();
        $title = "Featured Products";
        return view('frontend.pages.product.product_list',compact('products','title'));
    }
    public function allProducts(){
        $products = Product::where('published',1)->latest()->get();
        $title = "All Products";
        return view('frontend.pages.product.product_list',compact('products','title'));
    }
    public function bestSaleProducts(){
        $products = Product::where('published',1)->where('num_of_sale','>',1)->latest()->get();
        $title = "Best Sale Products";
        return view('frontend.pages.product.product_list',compact('products','title'));
    }

    public function categoryProduct($slug){
        $category = Category::where('slug',$slug)->first();
        $products = Product::where('published',1)->where('category_id',$category->id)->latest()->get();
        $title = $category->name;
        return view('frontend.pages.product.product_list',compact('products','title'));

    }
    public function allCategories(){
        return view('frontend.pages.product.all_categories');
    }


    public function sellerProductShow(){
        $recentProducts = Product::where('user_type','buyer')->where('verification_status',1)->where('bid_status','Applied')->latest()->take(12)->get();
        $featuredProducts = Product::where('user_type','buyer')->where('verification_status',1)->where('featured_product',1)->where('bid_status','Applied')->latest()->take(12)->get();
//        $recentProducts = Product::where('user_type','buyer')->where('verification_status',1)->where('bid_status','Applied')->where('price_validity','>=',date('Y-m-d'))->latest()->get();
//        $featuredProducts = Product::where('user_type','buyer')->where('verification_status',1)->where('featured_product',1)->where('bid_status','Applied')->where('price_validity','>=',date('Y-m-d'))->latest()->get();
        Session::put('type', 'seller-product-show');
        return view('frontend.pages.frontend_product',compact('recentProducts','featuredProducts'));
    }

    public function buyerProductShow(){
        $recentProducts = Product::where('user_type','seller')->where('verification_status',1)->where('bid_status','Applied')->latest()->take(12)->get();
        $featuredProducts = Product::where('user_type','seller')->where('verification_status',1)->where('featured_product',1)->where('bid_status','Applied')->latest()->take(12)->get();
//        $recentProducts = Product::where('user_type','seller')->where('verification_status',1)->where('bid_status','Applied')->where('price_validity','>=',date('Y-m-d'))->latest()->get();
//        $featuredProducts = Product::where('user_type','seller')->where('verification_status',1)->where('featured_product',1)->where('bid_status','Applied')->where('price_validity','>=',date('Y-m-d'))->latest()->get();
        Session::put('type', 'buyer-product-show');
        return view('frontend.pages.frontend_product',compact('recentProducts','featuredProducts'));
    }
    public function allFeaturedProduct(Request $request){
        $type = Session::get('type');
        if($type == 'seller-product-show'){
            $products = Product::where('user_type','buyer')->where('verification_status',1)->where('featured_product',1)->where('bid_status','Applied')->latest()->paginate(20);
        }else{
            $products = Product::where('user_type','seller')->where('verification_status',1)->where('featured_product',1)->where('bid_status','Applied')->latest()->paginate(20);
        }
        return view('frontend.pages.frontend_all_products',compact('products'));
    }
    public function allRecentProduct(Request $request){
        $type = Session::get('type');
        if($type == 'seller-product-show'){
            $products = Product::where('user_type','buyer')->where('verification_status',1)->where('bid_status','Applied')->latest()->paginate(20);
        }else{
            $products = Product::where('user_type','seller')->where('verification_status',1)->where('bid_status','Applied')->latest()->paginate(20);
        }
        return view('frontend.pages.frontend_all_products',compact('products'));
    }

    public function bidPriceConvert(Request $request){
        $qty = $request->qty;
        $bid_price = $request->bid_price;
        $currency_code = currency()->code;
        if($currency_code == 'BDT'){
            $converted_price = convert_to_usd($bid_price);
        }else{
            $converted_price = convert_to_bdt($bid_price);
        }
        return [
            'bid_total_price' => $qty*$bid_price,
            'bid_convert_unit_price' => $converted_price,
            'bid_convert_total_price' => $qty*$converted_price,
        ];
    }
}
