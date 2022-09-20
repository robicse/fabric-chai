<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Brand;
use App\Model\Category;
use App\Model\CategoryEight;
use App\Model\CategoryNine;
use App\Model\CategorySeven;
use App\Model\CategorySix;
use App\Model\CategoryTen;
use App\Model\Product;
use App\Model\SubCategory;
use App\Model\SubSubCategory;
use App\Model\SubSubChildCategory;
use App\Model\SubSubChildChildCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function ajax_search(Request $request)
    {
        $keywords = array();
        $products = Product::where('published', 1)->where('tags', 'like', '%'.$request->search.'%')
//            ->where('price_validity','>=',date('Y-m-d'))
            ->get();
        foreach ($products as $key => $product) {
            foreach (explode(',',$product->tags) as $key => $tag) {
                if(stripos($tag, $request->search) !== false){
                    if(sizeof($keywords) > 5){
                        break;
                    }
                    else{
                        if(!in_array(strtolower($tag), $keywords)){
                            array_push($keywords, strtolower($tag));
                        }
                    }
                }
            }
        }

        $products = filter_products(Product::where('published', 1)->where('name', 'like', '%'.$request->search.'%')
//            ->where('price_validity','>=',date('Y-m-d'))
        )->get()->take(3);

        $subsubcategories = SubSubCategory::where('name', 'like', '%'.$request->search.'%')->get()->take(3);

        if(sizeof($keywords)>0 || sizeof($subsubcategories)>0 || sizeof($products)>0 ){
            return view('frontend.products_partials.search_content', compact('products', 'subsubcategories', 'keywords'));
        }
        return '0';
    }

    public function search(Request $request)
    {
        //dd($request->all());

        $query = $request->q;
        $sort_by = $request->sort_by;
        $category_id = (Category::where('slug', $request->category)->first() != null) ? Category::where('slug', $request->category)->first()->id : null;
        $subcategory_id = (SubCategory::where('slug', $request->subcategory)->first() != null) ? SubCategory::where('slug', $request->subcategory)->first()->id : null;
        $subsubcategory_id = (SubSubCategory::where('slug', $request->subsubcategory)->first() != null) ? SubSubCategory::where('slug', $request->subsubcategory)->first()->id : null;
        $subsubchildcategory_id = (SubSubChildCategory::where('slug', $request->subsubchildcategory)->first() != null) ? SubSubChildCategory::where('slug', $request->subsubchildcategory)->first()->id : null;
        $subsubchildchildcategory_id = (SubSubChildChildCategory::where('slug', $request->subsubchildchildcategory)->first() != null) ? SubSubChildChildCategory::where('slug', $request->subsubchildchildcategory)->first()->id : null;
        $category_six_id = (CategorySix::where('slug', $request->categorysix)->first() != null) ? CategorySix::where('slug', $request->categorysix)->first()->id : null;
        $category_seven_id = (CategorySeven::where('slug', $request->categoryseven)->first() != null) ? CategorySeven::where('slug', $request->categoryseven)->first()->id : null;
        $category_eight_id = (CategoryEight::where('slug', $request->categoryeight)->first() != null) ? CategoryEight::where('slug', $request->categoryeight)->first()->id : null;
        $category_nine_id = (CategoryNine::where('slug', $request->categorynine)->first() != null) ? CategoryNine::where('slug', $request->categorynine)->first()->id : null;
        $category_ten_id = (CategoryTen::where('slug', $request->categoryten)->first() != null) ? CategoryTen::where('slug', $request->categoryten)->first()->id : null;
        $min_price = $request->min_price;
        $max_price = $request->max_price;

        $conditions = ['published' => 1,'verification_status' => 1,'bid_status' =>'Applied'];

        if($category_id != null){
            $conditions = array_merge($conditions, ['category_id' => $category_id]);
        }
        if($subcategory_id != null){
            $conditions = array_merge($conditions, ['sub_category_id' => $subcategory_id]);
        }
        if($subsubcategory_id != null){
            $conditions = array_merge($conditions, ['sub_sub_category_id' => $subsubcategory_id]);
        }
        if($subsubchildcategory_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_category_id' => $subsubchildcategory_id]);
        }
        if($subsubchildchildcategory_id != null){
            $conditions = array_merge($conditions, ['sub_sub_child_child_category_id' => $subsubchildchildcategory_id]);
        }

        if($category_six_id != null){
            $conditions = array_merge($conditions, ['category_six_id' => $category_six_id]);
        }

        if($category_seven_id != null){
            $conditions = array_merge($conditions, ['category_seven_id' => $category_seven_id]);
        }

        if($category_eight_id != null){
            $conditions = array_merge($conditions, ['category_eight_id' => $category_eight_id]);
        }

        if($category_nine_id != null){
            $conditions = array_merge($conditions, ['category_nine_id' => $category_nine_id]);
        }

        if($category_ten_id != null){
            $conditions = array_merge($conditions, ['category_ten_id' => $category_ten_id]);
        }

        $products = Product::where($conditions);

        if(Auth::user()){
            $products = $products->where('user_id', '!=', Auth::user()->id);
        }

        if($min_price != null && $max_price != null){
            $products = $products->where('unit_price', '>=', $min_price)->where('unit_price', '<=', $max_price);
        }

        if($query != null){
            $products = $products->where('name', 'like', '%'.$query.'%');
        }

        if($sort_by != null){
            switch ($sort_by) {
                case '1':
                    $products->orderBy('created_at', 'desc');
                    break;
                case '2':
                    $products->orderBy('created_at', 'asc');
                    break;
                case '3':
                    $products->orderBy('unit_price', 'asc');
                    break;
                case '4':
                    $products->orderBy('unit_price', 'desc');
                    break;
                default:
                    // code...
                    break;
            }
        }



        $products = filter_products($products)->latest()->paginate(12)->appends(request()->query());
        //dd($products);

        return view('frontend.pages.product.product_list', compact('products', 'query', 'category_id', 'subcategory_id', 'subsubcategory_id', 'subsubchildcategory_id', 'subsubchildchildcategory_id', 'category_six_id', 'category_seven_id', 'category_eight_id', 'category_nine_id', 'category_ten_id', 'sort_by', 'min_price', 'max_price'));
    }
    public function product(Request $request, $slug)
    {
        $detailedProduct  = Product::where('slug', $slug)->first();
        //dd($detailedProduct->slug);
        if($detailedProduct!=null && $detailedProduct->published){
            return view('frontend.pages.product.product_details', compact('detailedProduct'));
            // return view('frontend.product_details', compact('detailedProduct'));
        }
        abort(404);
    }

    public function listing(Request $request)
    {
        // $products = filter_products(Product::orderBy('created_at', 'desc'))->paginate(12);
        // return view('frontend.product_listing', compact('products'));
        return $this->search($request);
    }

}
