@extends('frontend.layouts.master')
@section('title')
    @if($category && $category->meta_title)
        {{$category->meta_title}}
    @else
       Our Products
    @endif
@endsection
@section('meta')
    @if($category && $category->meta_title)
        <meta name="meta_title" content="{{$category->meta_title}}"/>
    @endif
    @if($category && $category->meta_description)
        <meta name="meta_description" content="{{ $category->meta_description }}"/>
    @endif
@endsection

@section('content')
    <!-- breadcrumb -->
    <div class="full-row bg-light overlay-dark py-5">
        <div class="container">
            <div class="row text-center text-white">
                <div class="col-12">
                    <h3 class="mb-2 text-primary">@lang('website.Our Products')</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
    <div class="full-row">
        <div class="container">
            <div class="row row-cols-md-3 row-cols-1 g-4">
                @forelse($products as $product)
                <div class="col-md-6">
                    <div class="thumb-blog-simple transation hover-img-zoom mb-3">
                        <div class="post-image overflow-hidden">
                           <a href="{{route('our-product-details',$product->slug)}}"> <img src="{{url($product->image)}}" width="596" height="350" alt="Image not found!"> </a>
                        </div>
                        <div class="post-content py-3">
                            <div class="post-meta font-mini text-uppercase list-color-light">
                                <a href="#"><span>{{getNameByBnEn($product->homeCategory->category)}}</span></a>
                            </div>
                            <h5><a href="{{route('our-product-details',$product->slug)}}" class="transation text-dark hover-text-primary d-block mb-4">{{getNameByBnEn($product)}}</a></h5>
                            <p>{!! Str::limit(getShortDescriptionByBnEn($product), 250) !!}</p>
                            <div class="date text-primary font-small text-uppercase"><span><a href="{{route('our-product-details',$product->slug)}}">@lang('website.Read More')</a></span></div>
                        </div>
                    </div>
                </div>
                @empty
                    <div class="text-center m-0" >
                        <img src="https://qatar.jazp.com/qa-en/assets/commonfiles/images/nosearch.svg" alt="">
                    </div>
                @endforelse
            </div>
        </div>
    </div>

@endsection
