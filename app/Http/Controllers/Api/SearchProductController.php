<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Model\Category;
use App\Model\CategorySeven;
use App\Model\CategorySix;
use App\Model\Product;
use App\Model\SubCategory;
use App\Model\SubSubCategory;
use App\Model\SubSubChildCategory;
use App\Model\SubSubChildChildCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchProductController extends Controller
{
    public function getSellerRecentProducts(Request $request){

        $conditions = ['published' => 1,'verification_status' => 1, 'user_type' => 'buyer','bid_status' =>'Applied'];

        if($request->category_id != null){
            $conditions = array_merge($conditions, ['category_id' => $request->category_id]);
        }
        if($request->sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_category_id' => $request->sub_category_id]);
        }
        if($request->sub_sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_category_id' => $request->sub_sub_category_id]);
        }
        if($request->sub_sub_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_category_id' => $request->sub_sub_child_category_id]);
        }

        if($request->sub_sub_child_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_child_category_id' => $request->sub_sub_child_child_category_id]);
        }
        if($request->category_six_id != null){
            $conditions = array_merge($conditions, ['category_six_id' => $request->category_six_id]);
        }
        if( $request->category_seven_id != null){
            $conditions = array_merge($conditions, ['category_seven_id' =>  $request->category_seven_id]);
        }

        $products = Product::where($conditions)->latest()->get();
        //return $products;

        return new ProductCollection($products);
    }
    public function getSellerRecentProductsPagination(Request $request,$page_size){

        $conditions = ['published' => 1,'verification_status' => 1, 'user_type' => 'buyer','bid_status' =>'Applied'];

        if($request->category_id != null){
            $conditions = array_merge($conditions, ['category_id' => $request->category_id]);
        }
        if($request->sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_category_id' => $request->sub_category_id]);
        }
        if($request->sub_sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_category_id' => $request->sub_sub_category_id]);
        }
        if($request->sub_sub_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_category_id' => $request->sub_sub_child_category_id]);
        }

        if($request->sub_sub_child_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_child_category_id' => $request->sub_sub_child_child_category_id]);
        }
        if($request->category_six_id != null){
            $conditions = array_merge($conditions, ['category_six_id' => $request->category_six_id]);
        }
        if( $request->category_seven_id != null){
            $conditions = array_merge($conditions, ['category_seven_id' =>  $request->category_seven_id]);
        }

        $products = Product::where($conditions)->latest()->paginate($page_size);
        //return $products;

        return new ProductCollection($products);
    }

    public function getSellerRecentProductsPaginationV2(Request $request,$page_size){

        $conditions = ['published' => 1,'verification_status' => 1, 'user_type' => 'buyer','bid_status' =>'Applied'];

        if($request->category_id != null){
            $conditions = array_merge($conditions, ['category_id' => $request->category_id]);
        }
        if($request->sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_category_id' => $request->sub_category_id]);
        }
        if($request->sub_sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_category_id' => $request->sub_sub_category_id]);
        }
        if($request->sub_sub_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_category_id' => $request->sub_sub_child_category_id]);
        }

        if($request->sub_sub_child_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_child_category_id' => $request->sub_sub_child_child_category_id]);
        }
        if($request->category_six_id != null){
            $conditions = array_merge($conditions, ['category_six_id' => $request->category_six_id]);
        }
        if( $request->category_seven_id != null){
            $conditions = array_merge($conditions, ['category_seven_id' =>  $request->category_seven_id]);
        }

        if( $request->name != null){
            $name = $request->name;
            $products = Product::where($conditions)
                ->where(function($query) use ($name){
                    $query->where('name', 'like', '%'.$name.'%')
                        ->orWhere('name_bn', 'like', '%'.$name.'%');
                })
                ->latest()->paginate($page_size);
        }else{
            $products = Product::where($conditions)->latest()->paginate($page_size);
        }

        return new ProductCollection($products);
    }

    public function getSellerFeaturedProducts(Request $request){
        $conditions = ['published' => 1,'featured_product' => 1,'verification_status' => 1, 'user_type' => 'buyer','bid_status' =>'Applied'];

        if($request->category_id != null){
            $conditions = array_merge($conditions, ['category_id' => $request->category_id]);
        }
        if($request->sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_category_id' => $request->sub_category_id]);
        }
        if($request->sub_sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_category_id' => $request->sub_sub_category_id]);
        }
        if($request->sub_sub_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_category_id' => $request->sub_sub_child_category_id]);
        }

        if($request->sub_sub_child_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_child_category_id' => $request->sub_sub_child_child_category_id]);
        }
        if($request->category_six_id != null){
            $conditions = array_merge($conditions, ['category_six_id' => $request->category_six_id]);
        }
        if( $request->category_seven_id != null){
            $conditions = array_merge($conditions, ['category_seven_id' =>  $request->category_seven_id]);
        }

        $products = Product::where($conditions)->latest()->get();
        //return $products;

        return new ProductCollection($products);
    }
    public function getSellerFeaturedProductsPagination(Request $request,$page_size){
        $conditions = ['published' => 1,'featured_product' => 1,'verification_status' => 1, 'user_type' => 'buyer','bid_status' =>'Applied'];

        if($request->category_id != null){
            $conditions = array_merge($conditions, ['category_id' => $request->category_id]);
        }
        if($request->sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_category_id' => $request->sub_category_id]);
        }
        if($request->sub_sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_category_id' => $request->sub_sub_category_id]);
        }
        if($request->sub_sub_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_category_id' => $request->sub_sub_child_category_id]);
        }

        if($request->sub_sub_child_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_child_category_id' => $request->sub_sub_child_child_category_id]);
        }
        if($request->category_six_id != null){
            $conditions = array_merge($conditions, ['category_six_id' => $request->category_six_id]);
        }
        if( $request->category_seven_id != null){
            $conditions = array_merge($conditions, ['category_seven_id' =>  $request->category_seven_id]);
        }

        $products = Product::where($conditions)->latest()->paginate($page_size);
        //return $products;

        return new ProductCollection($products);
    }

    public function getSellerFeaturedProductsPaginationV2(Request $request,$page_size){
        $conditions = ['published' => 1,'featured_product' => 1,'verification_status' => 1, 'user_type' => 'buyer','bid_status' =>'Applied'];

        if($request->category_id != null){
            $conditions = array_merge($conditions, ['category_id' => $request->category_id]);
        }
        if($request->sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_category_id' => $request->sub_category_id]);
        }
        if($request->sub_sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_category_id' => $request->sub_sub_category_id]);
        }
        if($request->sub_sub_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_category_id' => $request->sub_sub_child_category_id]);
        }

        if($request->sub_sub_child_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_child_category_id' => $request->sub_sub_child_child_category_id]);
        }
        if($request->category_six_id != null){
            $conditions = array_merge($conditions, ['category_six_id' => $request->category_six_id]);
        }
        if( $request->category_seven_id != null){
            $conditions = array_merge($conditions, ['category_seven_id' =>  $request->category_seven_id]);
        }

        if( $request->name != null){
            $name = $request->name;
            $products = Product::where($conditions)
                ->where(function($query) use ($name){
                    $query->where('name', 'like', '%'.$name.'%')
                        ->orWhere('name_bn', 'like', '%'.$name.'%');
                })
                ->latest()->paginate($page_size);
        }
        else{
            $products = Product::where($conditions)->latest()->paginate($page_size);
        }

        return new ProductCollection($products);
    }

    public function getBuyerRecentProducts(Request $request){

        $conditions = ['published' => 1,'verification_status' => 1, 'user_type' => 'seller','bid_status' =>'Applied'];

        if($request->category_id != null){
            $conditions = array_merge($conditions, ['category_id' => $request->category_id]);
        }
        if($request->sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_category_id' => $request->sub_category_id]);
        }
        if($request->sub_sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_category_id' => $request->sub_sub_category_id]);
        }
        if($request->sub_sub_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_category_id' => $request->sub_sub_child_category_id]);
        }

        if($request->sub_sub_child_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_child_category_id' => $request->sub_sub_child_child_category_id]);
        }
        if($request->category_six_id != null){
            $conditions = array_merge($conditions, ['category_six_id' => $request->category_six_id]);
        }
        if( $request->category_seven_id != null){
            $conditions = array_merge($conditions, ['category_seven_id' =>  $request->category_seven_id]);
        }

        $products = Product::where($conditions)->latest()->get();

        return new ProductCollection($products);
    }
    public function getBuyerRecentProductsPagination(Request $request,$page_size){
        $conditions = ['published' => 1,'verification_status' => 1, 'user_type' => 'seller','bid_status' =>'Applied'];

        if($request->category_id != null){
            $conditions = array_merge($conditions, ['category_id' => $request->category_id]);
        }
        if($request->sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_category_id' => $request->sub_category_id]);
        }
        if($request->sub_sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_category_id' => $request->sub_sub_category_id]);
        }
        if($request->sub_sub_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_category_id' => $request->sub_sub_child_category_id]);
        }

        if($request->sub_sub_child_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_child_category_id' => $request->sub_sub_child_child_category_id]);
        }
        if($request->category_six_id != null){
            $conditions = array_merge($conditions, ['category_six_id' => $request->category_six_id]);
        }
        if( $request->category_seven_id != null){
            $conditions = array_merge($conditions, ['category_seven_id' =>  $request->category_seven_id]);
        }
        $products = Product::where($conditions)->latest()->paginate($page_size);

        return new ProductCollection($products);
    }

    public function getBuyerRecentProductsPaginationV2(Request $request,$page_size){
        $conditions = ['published' => 1,'verification_status' => 1, 'user_type' => 'seller','bid_status' =>'Applied'];

        if($request->category_id != null){
            $conditions = array_merge($conditions, ['category_id' => $request->category_id]);
        }
        if($request->sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_category_id' => $request->sub_category_id]);
        }
        if($request->sub_sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_category_id' => $request->sub_sub_category_id]);
        }
        if($request->sub_sub_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_category_id' => $request->sub_sub_child_category_id]);
        }

        if($request->sub_sub_child_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_child_category_id' => $request->sub_sub_child_child_category_id]);
        }
        if($request->category_six_id != null){
            $conditions = array_merge($conditions, ['category_six_id' => $request->category_six_id]);
        }
        if( $request->category_seven_id != null){
            $conditions = array_merge($conditions, ['category_seven_id' =>  $request->category_seven_id]);
        }
        if( $request->name != null){
            $name = $request->name;
            $products = Product::where($conditions)
                ->where(function($query) use ($name){
                    $query->where('name', 'like', '%'.$name.'%')
                        ->orWhere('name_bn', 'like', '%'.$name.'%');
                })
                ->latest()->paginate($page_size);
        }else{
            $products = Product::where($conditions)->latest()->paginate($page_size);
        }

        return new ProductCollection($products);
    }

    public function getBuyerFeaturedProducts(Request $request){
        $conditions = ['published' => 1,'featured_product' => 1,'verification_status' => 1, 'user_type' => 'seller', 'bid_status' =>'Applied'];

        if($request->category_id != null){
            $conditions = array_merge($conditions, ['category_id' => $request->category_id]);
        }
        if($request->sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_category_id' => $request->sub_category_id]);
        }
        if($request->sub_sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_category_id' => $request->sub_sub_category_id]);
        }
        if($request->sub_sub_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_category_id' => $request->sub_sub_child_category_id]);
        }

        if($request->sub_sub_child_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_child_category_id' => $request->sub_sub_child_child_category_id]);
        }
        if($request->category_six_id != null){
            $conditions = array_merge($conditions, ['category_six_id' => $request->category_six_id]);
        }
        if( $request->category_seven_id != null){
            $conditions = array_merge($conditions, ['category_seven_id' =>  $request->category_seven_id]);
        }

        $products = Product::where($conditions)->latest()->get();

        return new ProductCollection($products);
    }
    public function getBuyerFeaturedProductsPagination(Request $request,$page_size){
        $conditions = ['published' => 1,'featured_product' => 1,'verification_status' => 1, 'user_type' => 'seller', 'bid_status' =>'Applied'];

        if($request->category_id != null){
            $conditions = array_merge($conditions, ['category_id' => $request->category_id]);
        }
        if($request->sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_category_id' => $request->sub_category_id]);
        }
        if($request->sub_sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_category_id' => $request->sub_sub_category_id]);
        }
        if($request->sub_sub_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_category_id' => $request->sub_sub_child_category_id]);
        }

        if($request->sub_sub_child_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_child_category_id' => $request->sub_sub_child_child_category_id]);
        }
        if($request->category_six_id != null){
            $conditions = array_merge($conditions, ['category_six_id' => $request->category_six_id]);
        }
        if( $request->category_seven_id != null){
            $conditions = array_merge($conditions, ['category_seven_id' =>  $request->category_seven_id]);
        }
        $products = Product::where($conditions)->latest()->paginate($page_size);

        return new ProductCollection($products);
    }

    public function getBuyerFeaturedProductsPaginationV2(Request $request,$page_size){
        $conditions = ['published' => 1,'featured_product' => 1,'verification_status' => 1, 'user_type' => 'seller', 'bid_status' =>'Applied'];

        if($request->category_id != null){
            $conditions = array_merge($conditions, ['category_id' => $request->category_id]);
        }
        if($request->sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_category_id' => $request->sub_category_id]);
        }
        if($request->sub_sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_category_id' => $request->sub_sub_category_id]);
        }
        if($request->sub_sub_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_category_id' => $request->sub_sub_child_category_id]);
        }

        if($request->sub_sub_child_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_child_category_id' => $request->sub_sub_child_child_category_id]);
        }
        if($request->category_six_id != null){
            $conditions = array_merge($conditions, ['category_six_id' => $request->category_six_id]);
        }
        if( $request->category_seven_id != null){
            $conditions = array_merge($conditions, ['category_seven_id' =>  $request->category_seven_id]);
        }
        if( $request->name != null){
            $name = $request->name;
            $products = Product::where($conditions)
                ->where(function($query) use ($name){
                    $query->where('name', 'like', '%'.$name.'%')
                        ->orWhere('name_bn', 'like', '%'.$name.'%');
                })
                ->latest()->paginate($page_size);
        }
        else{
            $products = Product::where($conditions)->latest()->paginate($page_size);
        }

        return new ProductCollection($products);
    }

    public function getSearchProducts(Request $request){
        $conditions = ['published' => 1,'verification_status' => 1, 'bid_status' =>'Applied'];
        if($request->category_id != null){
            $conditions = array_merge($conditions, ['category_id' => $request->category_id]);
        }
        if($request->sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_category_id' => $request->sub_category_id]);
        }
        if($request->sub_sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_category_id' => $request->sub_sub_category_id]);
        }
        if($request->sub_sub_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_category_id' => $request->sub_sub_child_category_id]);
        }

        if($request->sub_sub_child_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_child_category_id' => $request->sub_sub_child_child_category_id]);
        }
        if($request->category_six_id != null){
            $conditions = array_merge($conditions, ['category_six_id' => $request->category_six_id]);
        }
        if( $request->category_seven_id != null){
            $conditions = array_merge($conditions, ['category_seven_id' =>  $request->category_seven_id]);
        }

        $products = Product::where($conditions)->latest()->paginate(20);
        //return $products;

        return new ProductCollection($products);
    }

    public function getSearchProductsPagination(Request $request,$page_size){
        $conditions = ['published' => 1,'verification_status' => 1, 'bid_status' =>'Applied'];

        if($request->category_id != null){
            $conditions = array_merge($conditions, ['category_id' => $request->category_id]);
        }
        if($request->sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_category_id' => $request->sub_category_id]);
        }
        if($request->sub_sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_category_id' => $request->sub_sub_category_id]);
        }
        if($request->sub_sub_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_category_id' => $request->sub_sub_child_category_id]);
        }

        if($request->sub_sub_child_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_child_category_id' => $request->sub_sub_child_child_category_id]);
        }
        if($request->category_six_id != null){
            $conditions = array_merge($conditions, ['category_six_id' => $request->category_six_id]);
        }
        if( $request->category_seven_id != null){
            $conditions = array_merge($conditions, ['category_seven_id' =>  $request->category_seven_id]);
        }
        if( $request->category_eight_id != null){
            $conditions = array_merge($conditions, ['category_eight_id' =>  $request->category_eight_id]);
        }
        if( $request->category_nine_id != null){
            $conditions = array_merge($conditions, ['category_nine_id' =>  $request->category_nine_id]);
        }
        if( $request->category_ten_id != null){
            $conditions = array_merge($conditions, ['category_ten_id' =>  $request->category_ten_id]);
        }

        $products = Product::where($conditions)->latest()->paginate($page_size);

        return new ProductCollection($products);
    }

    public function getSearchProductsPaginationV2(Request $request,$page_size){
        $conditions = ['published' => 1,'verification_status' => 1, 'bid_status' =>'Applied'];

        if($request->category_id != null){
            $conditions = array_merge($conditions, ['category_id' => $request->category_id]);
        }
        if($request->sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_category_id' => $request->sub_category_id]);
        }
        if($request->sub_sub_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_category_id' => $request->sub_sub_category_id]);
        }
        if($request->sub_sub_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_category_id' => $request->sub_sub_child_category_id]);
        }

        if($request->sub_sub_child_child_category_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_child_category_id' => $request->sub_sub_child_child_category_id]);
        }
        if($request->category_six_id != null){
            $conditions = array_merge($conditions, ['category_six_id' => $request->category_six_id]);
        }
        if( $request->category_seven_id != null){
            $conditions = array_merge($conditions, ['category_seven_id' =>  $request->category_seven_id]);
        }
        if( $request->category_eight_id != null){
            $conditions = array_merge($conditions, ['category_eight_id' =>  $request->category_eight_id]);
        }
        if( $request->category_nine_id != null){
            $conditions = array_merge($conditions, ['category_nine_id' =>  $request->category_nine_id]);
        }
        if( $request->category_ten_id != null){
            $conditions = array_merge($conditions, ['category_ten_id' =>  $request->category_ten_id]);
        }

        if( $request->name != null){
            $name = $request->name;
            $products = Product::where($conditions)
                ->where(function($query) use ($name){
                    $query->where('name', 'like', '%'.$name.'%')
                    ->orWhere('name_bn', 'like', '%'.$name.'%');
                })
                ->latest()->paginate($page_size);
        }
        else{
            $products = Product::where($conditions)->latest()->paginate($page_size);
        }

        return new ProductCollection($products);
    }


}
