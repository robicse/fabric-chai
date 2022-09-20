@extends('frontend.layouts.master')
@section('title',"Category")
@push('css')
    <link rel="stylesheet" href="{{asset('frontend/assets/css/filterstyle.css')}}">
    <script src="https://kit.fontawesome.com/624bf423b0.js" crossorigin="anonymous"></script>
    <style>
        .active {
            color: #3ba82a;
        }
        .child {
            margin-left: 10px !important;
        }
        .border_st{
            border: 1px solid #ddd;
        }
    </style>
@endpush



@section('content')
    <div class="full-row">
        <div class="container">
            <form class="" id="search-form" action="{{ route('category.search') }}" method="GET">
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <div id="sidebar" class="widget-title-bordered-full">
                            <div id="woocommerce_product_categories-4" class="widget woocommerce widget_product_categories widget-toggle">
                                <h2 class="widget-title">@lang('website.All Categories')</h2>
                                <ul class="category-filter">
                                    @if(!isset($category_id) && !isset($category_id) && !isset($subcategory_id) && !isset($subsubcategory_id) && !isset($subsubchildcategory_id) && !isset($subsubchildchildcategory_id) && !isset($category_six_id) && !isset($category_seven_id) && !isset($category_eight_id) && !isset($category_nine_id) && !isset($category_ten_id))
                                        @foreach(\App\Model\Category::all() as $category)
                                            <li class=""><a href="{{ route('products.category', $category->slug) }}">{{  __(getNameByBnEn($category)) }}</a></li>
                                        @endforeach
                                    @endif
                                    @if(isset($category_id))
                                        <li class="active"><a href="{{ route('products') }}">@lang('website.All Categories')</a></li>
                                        <li class="active"><a href="{{ route('products.category',
                                        \App\Model\Category::find($category_id)->slug) }}">{{  __(getNameByBnEn(\App\Model\Category::find($category_id)) ) }}</a></li>
                                        @foreach (\App\Model\Category::find($category_id)->subcategories as $key2 => $subcategory)
                                            <li class="child"><a href="{{ route('products.subcategory',
                                            $subcategory->slug) }}">{{  __(getNameByBnEn($subcategory)) }}</a></li>
                                        @endforeach
                                    @endif
                                    @if(isset($subcategory_id))

                                        <li class="active"><a href="{{ route('products') }}">@lang('website.All Categories')</a></li>
                                        <li class="active"><a href="{{ route('products.category',
                                        \App\Model\SubCategory::find($subcategory_id)->category->slug) }}">{{getNameByBnEn(\App\Model\SubCategory::find($subcategory_id)->category)}}</a></li>
                                        <li class="active"><a href="{{ route('products.subcategory',
                                        \App\Model\SubCategory::find($subcategory_id)->slug) }}">{{ getNameByBnEn(\App\Model\SubCategory::find($subcategory_id)) }}</a></li>
                                        @foreach (\App\Model\SubCategory::find($subcategory_id)->subsubcategories as $key3 => $subsubcategory)
                                            <li class="child"><a href="{{ route('products.subsubcategory',
                                            $subsubcategory->slug) }}">{{getNameByBnEn($subsubcategory)}}</a></li>
                                        @endforeach
                                    @endif
                                    @if(isset($subsubcategory_id))
                                        <li class="active"><a href="{{ route('products') }}">@lang('website.All Categories')</a></li>
                                        <li class="active"><a href="{{ route('products.category',
                                        \App\Model\SubSubCategory::find($subsubcategory_id)
                                        ->subcategory->category->slug) }}">{{  getNameByBnEn(\App\Model\SubSubCategory::find
                                        ($subsubcategory_id)->subcategory->category) }}</a></li>
                                        <li class="active"><a href="{{ route('products.subcategory', \App\Model\SubSubCategory::find($subsubcategory_id)->subcategory->slug) }}">{{  getNameByBnEn(\App\Model\SubSubCategory::find($subsubcategory_id)->subcategory) }}</a></li>
{{--                                        <li class="current"><a href="{{ route('products.subsubcategory', \App\Model\SubSubCategory::find($subsubcategory_id)->slug) }}">{{  __(\App\Model\SubSubCategory::find($subsubcategory_id)->name) }}</a></li>--}}
                                        <li class="active"><a href="{{ route('products.subsubcategory', \App\Model\SubSubCategory::find($subsubcategory_id)->slug) }}">{{  getNameByBnEn(\App\Model\SubSubCategory::find($subsubcategory_id)) }}</a></li>
                                        @foreach (\App\Model\SubSubCategory::find($subsubcategory_id)->subsubchildcategories as $key3 => $subsubchildcategory)
                                            <li class="child"><a href="{{ route('products.subsubchildcategory', $subsubchildcategory->slug) }}">{{  getNameByBnEn($subsubchildcategory) }}</a></li>
                                        @endforeach
                                    @endif
                                    @if(isset($subsubchildcategory_id))
                                        <li class="active"><a href="{{ route('products') }}">@lang('website.All Categories')</a></li>
                                        <li class="active"><a href="{{ route('products.category', \App\Model\SubSubChildCategory::find($subsubchildcategory_id)->subsubcategory->subcategory->category->slug) }}">{{  getNameByBnEn(\App\Model\SubSubChildCategory::find($subsubchildcategory_id)->subsubcategory->subcategory->category) }}</a></li>
                                        <li class="active"><a href="{{ route('products.subcategory', \App\Model\SubSubChildCategory::find($subsubchildcategory_id)->subsubcategory->subcategory->slug) }}">{{  getNameByBnEn(\App\Model\SubSubChildCategory::find($subsubchildcategory_id)->subsubcategory->subcategory) }}</a></li>
                                        <li class="active"><a href="{{ route('products.subsubcategory', \App\Model\SubSubChildCategory::find($subsubchildcategory_id)->subsubcategory->slug) }}">{{  getNameByBnEn(\App\Model\SubSubChildCategory::find($subsubchildcategory_id)->subsubcategory) }}</a></li>
                                        <li class="active"><a href="{{ route('products.subsubchildcategory', \App\Model\SubSubChildCategory::find($subsubchildcategory_id)->slug) }}">{{  getNameByBnEn(\App\Model\SubSubChildCategory::find($subsubchildcategory_id)) }}</a></li>
                                        @foreach (\App\Model\SubSubChildCategory::find($subsubchildcategory_id)->subsubchildchildcategories as $key3 => $subsubchildchildcategory)
                                            <li class="child"><a href="{{ route('products.subsubchildchildcategory', $subsubchildchildcategory->slug) }}">{{  getNameByBnEn($subsubchildchildcategory) }}</a></li>
                                        @endforeach
                                    @endif
                                    @if(isset($subsubchildchildcategory_id))
                                        <li class="active"><a href="{{ route('products') }}">@lang('website.All Categories')</a></li>
                                        <li class="active"><a href="{{ route('products.category', \App\Model\SubSubChildChildCategory::find($subsubchildchildcategory_id)->subsubchildcategory->subsubcategory->subcategory->category->slug) }}">{{  getNameByBnEn(\App\Model\SubSubChildChildCategory::find($subsubchildchildcategory_id)->subsubchildcategory->subsubcategory->subcategory->category) }}</a></li>
                                        <li class="active"><a href="{{ route('products.subcategory', \App\Model\SubSubChildChildCategory::find($subsubchildchildcategory_id)->subsubchildcategory->subsubcategory->subcategory->slug) }}">{{  getNameByBnEn(\App\Model\SubSubChildChildCategory::find($subsubchildchildcategory_id)->subsubchildcategory->subsubcategory->subcategory) }}</a></li>
                                        <li class="active"><a href="{{ route('products.subsubcategory', \App\Model\SubSubChildChildCategory::find($subsubchildchildcategory_id)->subsubchildcategory->subsubcategory->slug) }}">{{  getNameByBnEn(\App\Model\SubSubChildChildCategory::find($subsubchildchildcategory_id)->subsubchildcategory->subsubcategory) }}</a></li>
                                        <li class="active"><a href="{{ route('products.subsubchildcategory', \App\Model\SubSubChildChildCategory::find($subsubchildchildcategory_id)->subsubchildcategory->slug) }}">{{  getNameByBnEn(\App\Model\SubSubChildChildCategory::find($subsubchildchildcategory_id)->subsubchildcategory) }}</a></li>
                                        <li class="active"><a href="{{ route('products.subsubchildchildcategory', \App\Model\SubSubChildChildCategory::find($subsubchildchildcategory_id)->slug) }}">{{  getNameByBnEn(\App\Model\SubSubChildChildCategory::find($subsubchildchildcategory_id)) }}</a></li>
                                            @foreach (\App\Model\SubSubChildChildCategory::find($subsubchildchildcategory_id)->categorysixes as $key3 => $categorysix)
                                                <li class="child"><a href="{{ route('products.categorysix', $categorysix->slug) }}">{{  getNameByBnEn($categorysix) }}</a></li>
                                            @endforeach
                                    @endif
                                    @if(isset($category_six_id))
                                        <li class="active"><a href="{{ route('products') }}">@lang('website.All Categories')</a></li>
                                        <li class="active"><a href="{{ route('products.category', \App\Model\CategorySix::find($category_six_id)->categoryFive->subsubchildcategory->subsubcategory->subcategory->category->slug) }}">{{  getNameByBnEn(\App\Model\CategorySix::find($category_six_id)->categoryFive->subsubchildcategory->subsubcategory->subcategory->category) }}</a></li>
                                        <li class="active"><a href="{{ route('products.subcategory', \App\Model\CategorySix::find($category_six_id)->categoryFive->subsubchildcategory->subsubcategory->subcategory->slug) }}">{{  getNameByBnEn(\App\Model\CategorySix::find($category_six_id)->categoryFive->subsubchildcategory->subsubcategory->subcategory) }}</a></li>
                                        <li class="active"><a href="{{ route('products.subsubcategory', \App\Model\CategorySix::find($category_six_id)->categoryFive->subsubchildcategory->subsubcategory->slug) }}">{{  getNameByBnEn(\App\Model\CategorySix::find($category_six_id)->categoryFive->subsubchildcategory->subsubcategory) }}</a></li>
                                        <li class="active"><a href="{{ route('products.subsubchildcategory', \App\Model\CategorySix::find($category_six_id)->categoryFive->subsubchildcategory->slug) }}">{{  getNameByBnEn(\App\Model\CategorySix::find($category_six_id)->categoryFive->subsubchildcategory) }}</a></li>
                                        <li class="active"><a href="{{ route('products.subsubchildchildcategory', \App\Model\CategorySix::find($category_six_id)->categoryFive->slug) }}">{{  getNameByBnEn(\App\Model\CategorySix::find($category_six_id)->categoryFive) }}</a></li>
                                        <li class="active"><a href="{{ route('products.categorysix', \App\Model\CategorySix::find($category_six_id)->slug) }}">{{  getNameByBnEn(\App\Model\CategorySix::find($category_six_id)) }}</a></li>
                                        @foreach (\App\Model\CategorySix::find($category_six_id)->categorysevens as $key3 => $categoryseven)
                                            <li class="child"><a href="{{ route('products.categoryseven', $categoryseven->slug) }}">{{  getNameByBnEn($categoryseven) }}</a></li>
                                        @endforeach
                                    @endif
                                    @if(isset($category_seven_id))
                                        <li class="active"><a href="{{ route('products') }}">@lang('website.All Categories')</a></li>
                                        <li class="active"><a href="{{ route('products.category', \App\Model\CategorySeven::find($category_seven_id)->categorySix->categoryFive->subsubchildcategory->subsubcategory->subcategory->category->slug) }}">{{  getNameByBnEn(\App\Model\CategorySeven::find($category_seven_id)->categorySix->categoryFive->subsubchildcategory->subsubcategory->subcategory->category) }}</a></li>
                                        <li class="active"><a href="{{ route('products.subcategory', \App\Model\CategorySeven::find($category_seven_id)->categorySix->categoryFive->subsubchildcategory->subsubcategory->subcategory->slug) }}">{{  getNameByBnEn(\App\Model\CategorySeven::find($category_seven_id)->categorySix->categoryFive->subsubchildcategory->subsubcategory->subcategory) }}</a></li>
                                        <li class="active"><a href="{{ route('products.subsubcategory', \App\Model\CategorySeven::find($category_seven_id)->categorySix->categoryFive->subsubchildcategory->subsubcategory->slug) }}">{{  getNameByBnEn(\App\Model\CategorySeven::find($category_seven_id)->categorySix->categoryFive->subsubchildcategory->subsubcategory) }}</a></li>
                                        <li class="active"><a href="{{ route('products.subsubchildcategory', \App\Model\CategorySeven::find($category_seven_id)->categorySix->categoryFive->subsubchildcategory->slug) }}">{{  getNameByBnEn(\App\Model\CategorySeven::find($category_seven_id)->categorySix->categoryFive->subsubchildcategory) }}</a></li>
                                        <li class="active"><a href="{{ route('products.subsubchildchildcategory', \App\Model\CategorySeven::find($category_seven_id)->categorySix->categoryFive->slug) }}">{{  getNameByBnEn(\App\Model\CategorySeven::find($category_seven_id)->categorySix->categoryFive) }}</a></li>
                                        <li class="active"><a href="{{ route('products.categorysix', \App\Model\CategorySeven::find($category_seven_id)->categorySix->slug) }}">{{  getNameByBnEn(\App\Model\CategorySeven::find($category_seven_id)->categorySix) }}</a></li>
                                        <li class="active"><a href="{{ route('products.categoryseven', \App\Model\CategorySeven::find($category_seven_id)->slug) }}">{{  getNameByBnEn(\App\Model\CategorySeven::find($category_seven_id)) }}</a></li>
                                        @foreach (\App\Model\CategorySeven::find($category_seven_id)->categoryeights as $key3 => $categoryeight)
                                            <li class="child"><a href="{{ route('products.categoryeight', $categoryeight->slug) }}">{{  getNameByBnEn($categoryeight) }}</a></li>
                                        @endforeach
                                    @endif
                                    @if(isset($category_eight_id))
                                        <li class="active"><a href="{{ route('products') }}">@lang('website.All Categories')</a></li>
                                        <li class="active"><a href="{{ route('products.category', \App\Model\CategoryEight::find($category_eight_id)->categorySeven->categorySix->categoryFive->subsubchildcategory->subsubcategory->subcategory->category->slug) }}">{{  getNameByBnEn(\App\Model\CategoryEight::find($category_eight_id)->categorySeven->categorySix->categoryFive->subsubchildcategory->subsubcategory->subcategory->category) }}</a></li>
                                        <li class="active"><a href="{{ route('products.subcategory', \App\Model\CategoryEight::find($category_eight_id)->categorySeven->categorySix->categoryFive->subsubchildcategory->subsubcategory->subcategory->slug) }}">{{  getNameByBnEn(\App\Model\CategoryEight::find($category_eight_id)->categorySeven->categorySix->categoryFive->subsubchildcategory->subsubcategory->subcategory) }}</a></li>
                                        <li class="active"><a href="{{ route('products.subsubcategory', \App\Model\CategoryEight::find($category_eight_id)->categorySeven->categorySix->categoryFive->subsubchildcategory->subsubcategory->slug) }}">{{  getNameByBnEn(\App\Model\CategoryEight::find($category_eight_id)->categorySeven->categorySix->categoryFive->subsubchildcategory->subsubcategory) }}</a></li>
                                        <li class="active"><a href="{{ route('products.subsubchildcategory', \App\Model\CategoryEight::find($category_eight_id)->categorySeven->categorySix->categoryFive->subsubchildcategory->slug) }}">{{  getNameByBnEn(\App\Model\CategoryEight::find($category_eight_id)->categorySeven->categorySix->categoryFive->subsubchildcategory) }}</a></li>
                                        <li class="active"><a href="{{ route('products.subsubchildchildcategory', \App\Model\CategoryEight::find($category_eight_id)->categorySeven->categorySix->categoryFive->slug) }}">{{  getNameByBnEn(\App\Model\CategoryEight::find($category_eight_id)->categorySeven->categorySix->categoryFive) }}</a></li>
                                        <li class="active"><a href="{{ route('products.categorysix', \App\Model\CategoryEight::find($category_eight_id)->categorySeven->categorySix->slug) }}">{{  getNameByBnEn(\App\Model\CategoryEight::find($category_eight_id)->categorySeven->categorySix) }}</a></li>
                                        <li class="active"><a href="{{ route('products.categoryseven', \App\Model\CategoryEight::find($category_eight_id)->categorySeven->slug) }}">{{  getNameByBnEn(\App\Model\CategoryEight::find($category_eight_id)->categorySeven) }}</a></li>
                                        <li class="active"><a href="{{ route('products.categoryeight', \App\Model\CategoryEight::find($category_eight_id)->slug) }}">{{  getNameByBnEn(\App\Model\CategoryEight::find($category_eight_id)) }}</a></li>
                                        @foreach (\App\Model\CategoryEight::find($category_eight_id)->categorynines as $key3 => $categorynine)
                                            <li class="child"><a href="{{ route('products.categorynine', $categorynine->slug) }}">{{  getNameByBnEn($categorynine) }}</a></li>
                                        @endforeach
                                    @endif
                                    @if(isset($category_nine_id))
                                        <li class="active"><a href="{{ route('products') }}">@lang('website.All Categories')</a></li>
                                        <li class="active"><a href="{{ route('products.category', \App\Model\CategoryNine::find($category_nine_id)->categoryEight->categorySeven->categorySix->categoryFive->subsubchildcategory->subsubcategory->subcategory->category->slug) }}">{{  getNameByBnEn(\App\Model\CategoryNine::find($category_nine_id)->categoryEight->categorySeven->categorySix->categoryFive->subsubchildcategory->subsubcategory->subcategory->category) }}</a></li>
                                        <li class="active"><a href="{{ route('products.subcategory', \App\Model\CategoryNine::find($category_nine_id)->categoryEight->categorySeven->categorySix->categoryFive->subsubchildcategory->subsubcategory->subcategory->slug) }}">{{  getNameByBnEn(\App\Model\CategoryNine::find($category_nine_id)->categoryEight->categorySeven->categorySix->categoryFive->subsubchildcategory->subsubcategory->subcategory) }}</a></li>
                                        <li class="active"><a href="{{ route('products.subsubcategory', \App\Model\CategoryNine::find($category_nine_id)->categoryEight->categorySeven->categorySix->categoryFive->subsubchildcategory->subsubcategory->slug) }}">{{  getNameByBnEn(\App\Model\CategoryNine::find($category_nine_id)->categoryEight->categorySeven->categorySix->categoryFive->subsubchildcategory->subsubcategory) }}</a></li>
                                        <li class="active"><a href="{{ route('products.subsubchildcategory', \App\Model\CategoryNine::find($category_nine_id)->categoryEight->categorySeven->categorySix->categoryFive->subsubchildcategory->slug) }}">{{  getNameByBnEn(\App\Model\CategoryNine::find($category_nine_id)->categoryEight->categorySeven->categorySix->categoryFive->subsubchildcategory) }}</a></li>
                                        <li class="active"><a href="{{ route('products.subsubchildchildcategory', \App\Model\CategoryNine::find($category_nine_id)->categoryEight->categorySeven->categorySix->categoryFive->slug) }}">{{  getNameByBnEn(\App\Model\CategoryNine::find($category_nine_id)->categoryEight->categorySeven->categorySix->categoryFive) }}</a></li>
                                        <li class="active"><a href="{{ route('products.categorysix', \App\Model\CategoryNine::find($category_nine_id)->categoryEight->categorySeven->categorySix->slug) }}">{{  getNameByBnEn(\App\Model\CategoryNine::find($category_nine_id)->categoryEight->categorySeven->categorySix) }}</a></li>
                                        <li class="active"><a href="{{ route('products.categoryseven', \App\Model\CategoryNine::find($category_nine_id)->categoryEight->categorySeven->slug) }}">{{  getNameByBnEn(\App\Model\CategoryNine::find($category_nine_id)->categoryEight->categorySeven) }}</a></li>
                                        <li class="active"><a href="{{ route('products.categoryeight', \App\Model\CategoryNine::find($category_nine_id)->categoryEight->slug) }}">{{  getNameByBnEn(\App\Model\CategoryNine::find($category_nine_id)->categoryEight) }}</a></li>
                                        <li class="active"><a href="{{ route('products.categorynine', \App\Model\CategoryNine::find($category_nine_id)->slug) }}">{{  getNameByBnEn(\App\Model\CategoryNine::find($category_nine_id)) }}</a></li>
                                        @foreach (\App\Model\CategoryNine::find($category_nine_id)->categorytens as $key3 => $categoryten)
                                            <li class="child"><a href="{{ route('products.categoryten', $categoryten->slug) }}">{{  getNameByBnEn($categoryten) }}</a></li>
                                        @endforeach
                                    @endif
                                    @if(isset($category_ten_id))
                                        <li class="active"><a href="{{ route('products') }}">@lang('website.All Categories')</a></li>
                                        <li class="active"><a href="{{ route('products.category', \App\Model\CategoryTen::find($category_ten_id)->categoryNine->categoryEight->categorySeven->categorySix->categoryFive->subsubchildcategory->subsubcategory->subcategory->category->slug) }}">{{  getNameByBnEn(\App\Model\CategoryTen::find($category_ten_id)->categoryNine->categoryEight->categorySeven->categorySix->categoryFive->subsubchildcategory->subsubcategory->subcategory->category) }}</a></li>
                                        <li class="active"><a href="{{ route('products.subcategory', \App\Model\CategoryTen::find($category_ten_id)->categoryNine->categoryEight->categorySeven->categorySix->categoryFive->subsubchildcategory->subsubcategory->subcategory->slug) }}">{{  getNameByBnEn(\App\Model\CategoryTen::find($category_ten_id)->categoryNine->categoryEight->categorySeven->categorySix->categoryFive->subsubchildcategory->subsubcategory->subcategory) }}</a></li>
                                        <li class="active"><a href="{{ route('products.subsubcategory', \App\Model\CategoryTen::find($category_ten_id)->categoryNine->categoryEight->categorySeven->categorySix->categoryFive->subsubchildcategory->subsubcategory->slug) }}">{{  getNameByBnEn(\App\Model\CategoryTen::find($category_ten_id)->categoryNine->categoryEight->categorySeven->categorySix->categoryFive->subsubchildcategory->subsubcategory) }}</a></li>
                                        <li class="active"><a href="{{ route('products.subsubchildcategory', \App\Model\CategoryTen::find($category_ten_id)->categoryNine->categoryEight->categorySeven->categorySix->categoryFive->subsubchildcategory->slug) }}">{{  getNameByBnEn(\App\Model\CategoryTen::find($category_ten_id)->categoryNine->categoryEight->categorySeven->categorySix->categoryFive->subsubchildcategory) }}</a></li>
                                        <li class="active"><a href="{{ route('products.subsubchildchildcategory', \App\Model\CategoryTen::find($category_ten_id)->categoryNine->categoryEight->categorySeven->categorySix->categoryFive->slug) }}">{{  getNameByBnEn(\App\Model\CategoryTen::find($category_ten_id)->categoryNine->categoryEight->categorySeven->categorySix->categoryFive) }}</a></li>
                                        <li class="active"><a href="{{ route('products.categorysix', \App\Model\CategoryTen::find($category_ten_id)->categoryNine->categoryEight->categorySeven->categorySix->slug) }}">{{  getNameByBnEn(\App\Model\CategoryTen::find($category_ten_id)->categoryNine->categoryEight->categorySeven->categorySix) }}</a></li>
                                        <li class="active"><a href="{{ route('products.categoryseven', \App\Model\CategoryTen::find($category_ten_id)->categoryNine->categoryEight->categorySeven->slug) }}">{{  getNameByBnEn(\App\Model\CategoryTen::find($category_ten_id)->categoryNine->categoryEight->categorySeven) }}</a></li>
                                        <li class="active"><a href="{{ route('products.categoryeight', \App\Model\CategoryTen::find($category_ten_id)->categoryNine->categoryEight->slug) }}">{{  getNameByBnEn(\App\Model\CategoryTen::find($category_ten_id)->categoryNine->categoryEight) }}</a></li>
                                        <li class="active"><a href="{{ route('products.categorynine', \App\Model\CategoryTen::find($category_ten_id)->categoryNine->slug) }}">{{  getNameByBnEn(\App\Model\CategoryTen::find($category_ten_id)->categoryNine) }}</a></li>
                                        <li class="active"><a href="{{ route('products.categoryten', \App\Model\CategoryTen::find($category_ten_id)->slug) }}">{{  getNameByBnEn(\App\Model\CategoryTen::find($category_ten_id)) }}</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        @isset($category_id)
                            <input type="hidden" name="category" value="{{ \App\Model\Category::find($category_id)->slug }}">
                        @endisset
                        @isset($subcategory_id)
                            <input type="hidden" name="subcategory" value="{{ \App\Model\SubCategory::find($subcategory_id)->slug }}">
                        @endisset
                        @isset($subsubcategory_id)
                            <input type="hidden" name="subsubcategory" value="{{ \App\Model\SubSubCategory::find($subsubcategory_id)->slug }}">
                        @endisset
                        <input type="hidden" name="min_price" value="">
                        <input type="hidden" name="max_price" value="">
                        <div class="sort-by-bar row no-gutters bg-white2 pb-3 px-3 pt-2 border_st">
                            <div class="col-xl-4 d-flex d-xl-block justify-content-between align-items-end ">
                                <div class="sort-by-box flex-grow-1">
                                    <div class="form-group">
                                        <label>@lang('website.Search')</label>
                                        <div class="search-widget">
                                            <input class="form-control input-lg" type="text" name="q"
                                                   placeholder="@lang('website.Search Products')" @isset($query) value="{{ $query }}" @endisset>
                                            <button type="submit" class="btn-inner">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-xl-none ml-3 form-group orderby">
                                    <button type="button" class="btn p-1 btn-sm" id="side-filter">
                                        <i class="la la-filter la-2x"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-xl-7 offset-xl-1">
                                <div class="row no-gutters">
                                    <div class="col-6">
                                        <div class="sort-by-box px-1">
                                            <div class="form-group">
                                                <label>@lang('website.Sort By')</label>
                                                <select class="form-control sortSelect bg-white" data-minimum-results-for-search="Infinity" name="sort_by" onchange="filter()" >
                                                    <option value="1" @isset($sort_by) @if ($sort_by == '1') selected
                                                        @endif @endisset>@lang('website.Newest')</option>
                                                    <option value="2" @isset($sort_by) @if ($sort_by == '2') selected
                                                        @endif @endisset>@lang('website.Oldest')</option>
                                                    <option value="3" @isset($sort_by) @if ($sort_by == '3') selected
                                                        @endif @endisset>@lang('website.Price low to high') </option>
                                                    <option value="4" @isset($sort_by) @if ($sort_by == '4') selected
                                                        @endif @endisset>@lang('website.Price high to low')</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="showing-products pt-30 pb-50 border-2 border-bottom border-light">
                            <div class="row row-cols-xxl-2 row-cols-md-2 row-cols-1 g-3 shop-list product-list e-bg-light e-title-hover-primary e-hover-image-zoom e-btn-set-four cart-slide-left">
                                @forelse(@$products as $product)
                                    {{frontendProductsComponent(@$product)}}
                                @empty
                                    <div class="text-center m-0">
                                        <img src="https://qatar.jazp.com/qa-en/assets/commonfiles/images/nosearch.svg" alt="">
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-3">
                            <div class="pagination-style-one">
                                <nav aria-label="Page navigation example">
                                    {{$products->links()}}
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{asset('frontend/assets/js/select2.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/nouislider.min.js')}}"></script>
    <script>
        // NoUI Slider
        if ($(".input-slider-container")[0]) {
            $(".input-slider-container").each(function () {
                var slider = $(this).find(".input-slider");
                var sliderId = slider.attr("id");
                var minValue = slider.data("range-value-min");
                var maxValue = slider.data("range-value-max");

                var sliderValue = $(this).find(".range-slider-value");
                var sliderValueId = sliderValue.attr("id");
                var startValue = sliderValue.data("range-value-low");

                var c = document.getElementById(sliderId),
                    d = document.getElementById(sliderValueId);

                noUiSlider.create(c, {
                    start: [parseInt(startValue)],
                    //step: 1000,
                    range: {
                        min: [parseInt(minValue)],
                        max: [parseInt(maxValue)],
                    },
                });

                c.noUiSlider.on("update", function (a, b) {
                    //alert(b)
                    d.textContent = a[b];
                });
            });
        }

        if ($("#input-slider-range")[0]) {
            var c = document.getElementById("input-slider-range"),
                d = document.getElementById("input-slider-range-value-low"),
                e = document.getElementById("input-slider-range-value-high"),
                f = [d, e];

            noUiSlider.create(c, {
                start: [
                    parseInt(d.getAttribute("data-range-value-low")),
                    parseInt(e.getAttribute("data-range-value-high")),
                ],
                connect: !0,
                range: {
                    min: parseInt(c.getAttribute("data-range-value-min")),
                    max: parseInt(c.getAttribute("data-range-value-max")),
                },
            }),
                c.noUiSlider.on("update", function (a, b) {
                    f[b].textContent = a[b];
                }),
                c.noUiSlider.on("change", function (a, b) {
                    rangefilter(a);
                });
        }
        function filter(){
            $('#search-form').submit();
        }
        function rangefilter(arg){
            $('input[name=min_price]').val(arg[0]);
            $('input[name=max_price]').val(arg[1]);
            filter();
        }
      /*  $(".sortSelect").each(function (index, element) {
            $(".sortSelect").select2({
                theme: "default sortSelectCustom",
            });
        });*/
    </script>
@endpush
