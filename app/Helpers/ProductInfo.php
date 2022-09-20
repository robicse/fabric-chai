<?php
/**
 * Created by PhpStorm.
 * User: Ashiqur Rahman
 * Date: 11/11/2021
 * Time: 3:08 PM
 */

use App\Model\ProductBid;
use Illuminate\Support\Facades\Auth;
use App\Model\Category;
use App\Model\SubCategory;
use App\Model\SubSubCategory;
use Illuminate\Support\Facades\DB;

use \App\Model\Review;
use \App\Model\WorkOrderReview;




function sliders(){
    $sliders = \App\Model\Slider::where('date_duration','>=',date('Y-m-d'))->get();
    return $sliders;
}

if (!function_exists('productsComponent')) {
    function productsComponent($product) {
        return view('frontend.products_partials.productsComponent', compact('product'));
    }
}

if (!function_exists('frontendProductsComponent')) {
    function frontendProductsComponent($product) {
        return view('frontend.products_partials.frontendProductsComponent', compact('product'));
    }
}
if (!function_exists('viewAllProductsComponent')) {
    function viewAllProductsComponent($product) {
        return view('frontend.products_partials.viewAllProductsComponent', compact('product'));
    }
}



if (!function_exists('workOrderProductComponent')) {
    function workOrderProductComponent($product) {
        return view('frontend.products_partials.workOrderComponent', compact('product'));
    }
}

if (!function_exists('recentProductsComponent')) {
    function recentProductsComponent($product) {
        return view('frontend.products_partials.recentProductsComponent', compact('product'));
    }
}

if (!function_exists('featuredProductsComponent')) {
    function featuredProductsComponent($product) {
        return view('frontend.products_partials.featuredProductsComponent', compact('product'));
    }
}

if (!function_exists('sizingProductDetails')) {
    function sizingProductDetails($detailedProduct) {
        return view('frontend.products_partials.sizingProductDetails', compact('detailedProduct'));
    }
}
if (!function_exists('dyingProductDetails')) {
    function dyingProductDetails($detailedProduct) {
        return view('frontend.products_partials.dyingProductDetails', compact('detailedProduct'));
    }
}

function categories(){
    $categories = \App\Model\Category::where('type','product')->get();
    return $categories;
}
function homeCategories(){
    $home_categories = \App\Model\HomeCategory::all();
    return $home_categories;
}

function productList(){
    $products = \App\Model\Product::latest()->get();
    return $products;
}
function sellerProductList(){
    $products = \App\Model\Product::where('user_type','seller')->latest()->get();
    return $products;
}

function buyerRequestedProducts(){
    $products = \App\Model\Product::where('user_id',Auth::id())->latest()->get();
    return $products;
}
function allRequestedProducts(){
    $products = \App\Model\Product::where('user_type','buyer')->latest()->get();
    return $products;
}
function productBids(){
    $product_bids = ProductBid::where('receiver_user_id',Auth::id())->latest()->get();
    return $product_bids;
}
function MyBids(){
    $product_bids = ProductBid::where('sender_user_id',Auth::id())->latest()->get();
    return $product_bids;
}



//price related function start from here......................................


//price related function End here..............................................

//Ratting dynamic...............
if(! function_exists('renderStarRating')){
    function renderStarRating($rating,$maxRating=5) {
        $fullStar = "<i class = 'fa fa-star active'></i>";
        $halfStar = "<i class = 'fa fa-star half'></i>";
        $emptyStar = "<i class = 'fa fa-star'></i>";
        $rating = $rating <= $maxRating?$rating:$maxRating;

        $fullStarCount = (int)$rating;
        $halfStarCount = ceil($rating)-$fullStarCount;
        $emptyStarCount = $maxRating -$fullStarCount-$halfStarCount;

        $html = str_repeat($fullStar,$fullStarCount);
        $html .= str_repeat($halfStar,$halfStarCount);
        $html .= str_repeat($emptyStar,$emptyStarCount);
        echo $html;
    }

    //filter products published
    if (! function_exists('filter_products')) {
        function filter_products($products) {
            return $products->where('published', '1');
        }
    }
}
if(! function_exists('userRating')) {
    function userRating($id)
    {
        $user = \App\User::find($id);
        $fiveStarRev = Review::where('receiver_user_id', $user->id)->where('rating', 5)->where('status', 1)->sum('rating');
        $fourStarRev = Review::where('receiver_user_id', $user->id)->where('rating', 4)->where('status', 1)->sum('rating');
        $threeStarRev = Review::where('receiver_user_id', $user->id)->where('rating', 3)->where('status', 1)->sum('rating');
        $twoStarRev = Review::where('receiver_user_id', $user->id)->where('rating', 2)->where('status', 1)->sum('rating');
        $oneStarRev = Review::where('receiver_user_id', $user->id)->where('rating', 1)->where('status', 1)->sum('rating');
        $totalRating = Review::where('receiver_user_id', $user->id)->sum('rating');

        //dd($fiveStarRev);
        if ($totalRating > 0) {
            $rating = (5 * $fiveStarRev + 4 * $fourStarRev + 3 * $threeStarRev + 2 * $twoStarRev + 1 * $oneStarRev) / ($totalRating);
            $totalRatingCount = number_format((float)$rating, 1, '.', '');
        } else {
            $totalRatingCount = number_format((float)0, 1, '.', '');
        }
        if (!empty($totalRatingCount)) {
            return $totalRatingCount;
        } else {
            return 'Something went wrong!';
        }
    }
}

if(! function_exists('userWorkOrderRating')) {
    function userWorkOrderRating($id)
    {
        $user = \App\User::find($id);
        $fiveStarRev = WorkOrderReview::where('receiver_user_id', $user->id)->where('rating', 5)->where('status', 1)->sum('rating');
        $fourStarRev = WorkOrderReview::where('receiver_user_id', $user->id)->where('rating', 4)->where('status', 1)->sum('rating');
        $threeStarRev = WorkOrderReview::where('receiver_user_id', $user->id)->where('rating', 3)->where('status', 1)->sum('rating');
        $twoStarRev = WorkOrderReview::where('receiver_user_id', $user->id)->where('rating', 2)->where('status', 1)->sum('rating');
        $oneStarRev = WorkOrderReview::where('receiver_user_id', $user->id)->where('rating', 1)->where('status', 1)->sum('rating');
        $totalRating = WorkOrderReview::where('receiver_user_id', $user->id)->sum('rating');

        //dd($fiveStarRev);
        if ($totalRating > 0) {
            $rating = (5 * $fiveStarRev + 4 * $fourStarRev + 3 * $threeStarRev + 2 * $twoStarRev + 1 * $oneStarRev) / ($totalRating);
            $totalRatingCount = number_format((float)$rating, 1, '.', '');
        } else {
            $totalRatingCount = number_format((float)0, 1, '.', '');
        }
        if (!empty($totalRatingCount)) {
            return $totalRatingCount;
        } else {
            return 'Something went wrong!';
        }
    }
}

if(! function_exists('productRating')) {
    function productRating($id)
    {

        $fiveStarRev = Review::where('product_id', $id)->where('rating', 5)->where('status', 1)->sum('rating');
        $fourStarRev = Review::where('product_id', $id)->where('rating', 4)->where('status', 1)->sum('rating');
        $threeStarRev = Review::where('product_id', $id)->where('rating', 3)->where('status', 1)->sum('rating');
        $twoStarRev = Review::where('product_id', $id)->where('rating', 2)->where('status', 1)->sum('rating');
        $oneStarRev = Review::where('product_id', $id)->where('rating', 1)->where('status', 1)->sum('rating');
        $totalRating = Review::where('product_id', $id)->sum('rating');

        //dd($fiveStarRev);
        if ($totalRating > 0) {
            $rating = (5 * $fiveStarRev + 4 * $fourStarRev + 3 * $threeStarRev + 2 * $twoStarRev + 1 * $oneStarRev) / ($totalRating);
            $totalRatingCount = number_format((float)$rating, 1, '.', '');
        } else {
            $totalRatingCount = number_format((float)0, 1, '.', '');
        }
        if (!empty($totalRatingCount)) {
            return $totalRatingCount;
        } else {
            return 'Something went wrong!';
        }
    }
}

if (! function_exists('productOwnerInfo')) {
    function productOwnerInfo($product_id) {
        return DB::table('users')
            ->join('products','users.id','products.user_id')
            ->where('users.id',Auth::user()->id)
            ->where('products.id',$product_id)
            ->select('users.id','users.name')
            ->first();
    }
}

if (! function_exists('homeCategories')) {
    function homeCategories() {
        return Category::all();
    }
}

if (! function_exists('CategoryWiseSubCategories')) {
    function CategoryWiseSubCategories($category_id) {
        return SubCategory::where('category_id',$category_id)->get();
    }
}

if (! function_exists('SubCategoryWiseSubSubCategories')) {
    function SubCategoryWiseSubSubCategories($sub_category_id) {
        return SubSubCategory::where('sub_category_id',$sub_category_id)->get();
    }
}

if (! function_exists('advertisements')) {
    function advertisements()
    {
        $advertisements = \App\Model\Advertisement::where('position',1)->latest()->get();
        return $advertisements;
    }
}



