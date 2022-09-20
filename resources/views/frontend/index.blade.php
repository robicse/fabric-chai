@extends('frontend.layouts.master')
@section('title','Fabric Lagbe | Readymade garments factory in Bangladesh')


@push('css')

    <style>
        .mobile_view_carousel{
            display: none;
        }
        h1{
            font-size: 24px;
        }
        .ready_made{
            font-size: 36px;
        }
        .text-black{
            color: black!important;
        }
        h1 h2 h3 {
            color: black!important;
        }
        p {
            font-family: Arial, Helvetica, sans-serif;
            color: black;
            text-align: justify;
        }
        .slider_st{
            width:1200px;
            margin:0 auto;
            margin-bottom: 0px;
            height: 150px !important;
        }
        .s_img{
            top:50%;
            left:50%;
            text-align:initial;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            mix-blend-mode:normal;
            width:100%;
        }
        .sell_card{
            max-width: 18rem;
            color: #e70909;
            font-size: 24px;
        }
        .buy_card{
            max-width: 18rem;
            color: green;
            font-size: 24px;
        }
        .job_card{
            max-width: 18rem;
            color: purple;
            font-size: 24px;
        }
        .work_order_card{
            max-width: 18rem;
            color: #16CCF1;
            font-size: 24px;
        }
        @media only screen and (max-width: 700px) {
            .our_story{
                display: none;
            }
            .span_details{
                display: none;
            }
            .card_height{
                height: 186px;
            }
            .mobile_view_carousel{
                display: flex;
            }
            .web_view_carousel{
                display: none;
            }
        }
    </style>
@endpush

@section('content')
    <div class="full-row bg-light p-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div id="slider" class="" style="   width:1200px;margin:0 auto;margin-bottom: 0px;height: 150px !important;">
                        @foreach(sliders() as $slider)
                            <div class="ls-slide" data-ls="duration:5000; transition2d:4; kenburnsscale:1.2;" >
                                <img width="1920" height="100" src="{{asset('uploads/sliders/'.$slider->image)}}" class="ls-l " style="top:50%; left:50%; text-align:initial; font-weight:400; font-style:normal; text-decoration:none; mix-blend-mode:normal; width:100%;" alt="" data-ls="showinfo:1; durationin:2000; easingin:easeOutExpo; scalexin:1.5; scaleyin:1.5; position:fixed;">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="full-row bg-light pt-10 pb-0">
        <div class="container">
            <div class="row ">
                <div class="col-lg-3 col-md-3 col-sm-6 col-6" >
                    <a href="{{route('seller.product.show')}}">
                        <div class="card border-primary mb-3 sell_card">
                            <div class="card-body card_height">
                                <p class="text-center sell_card"> <i class="fa fa-cart-plus"></i> </p>
                                <div class="text-center">
                                    <h4 class="sell_card">SELL</h4> <hr>
                                    <h4 class="sell_card">বিক্রি</h4>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                    <a href="{{route('buyer.product.show')}}">
                        <div class="card border-success mb-3 buy_card">
                            <div class="card-body text-success card_height">
                                <p class="text-center buy_card"> <i class="fa fa-cart-plus"></i> </p>
                                <div class="text-center">
                                    <h4 class="buy_card">BUY</h4> <hr>
                                    <h4 class="buy_card" >ক্রয়</h4>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                    <a href="{{route('job.registration')}}">
                        <div class="card border-secondary mb-3 job_card">
                            <div class="card-body text-secondary card_height">
                                <p class="text-center job_card"> <i class="fa fa-user"></i> </p>
                                <div class="text-center">
                                    <h4 class="job_card">JOB</h4> <hr>
                                    <h4 class="job_card">চাকুরী</h4>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-6" >
                    <a href="{{route('work-order.registration')}}">
                        <div class="card border-info mb-3 work_order_card">
                            <div class="card-body text-info card_height">
                                <p class="text-center work_order_card"> <i class="fa fa-file-alt"></i> </p>
                                <div class="text-center">
                                    <h4 class="work_order_card">WORK ORDER</h4> <hr>
                                    <h4 class="work_order_card">কাজের আদেশ</h4>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="full-row bg-light pt-0 pb-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="font-large text-dark mb-2"> @lang('website.Advertisements')</h4>
                        </div>
                    </div>
                </div>
                <div class="col-12 web_view_carousel">
                    <div class="owl-carousel four-carousel dot-disable nav-arrow-middle-show owl-mx-20 e-title-dark e-title-hover-primary e-image-bg-light e-image-pill bg-white short-info p-30">
                        @foreach(advertisements() as $advertisement)
                            <div class="item">
                                <div class="row row-cols-1">
                                    <div class="col">
                                        <div class="product type-product">
                                            <div class="product-wrapper">
                                                <div class="product-image">
                                                    <a href="{{$advertisement->link}}" target="_blank"><img src="{{asset($advertisement->image)}}" alt="Advertisement image" width="228" height="227"></a>
                                                </div>
                                                <div class="product-info text-center">
                                                    <h6 class="product-title"><a href="{{$advertisement->link}}" target="_blank">{{getAddressByBnEn($advertisement)}}</a></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-12 mobile_view_carousel">
                    <div class="owl-carousel auto-single-carousel dot-disable nav-arrow-middle-show owl-mx-20 e-title-dark e-title-hover-primary e-image-bg-light e-image-pill bg-white short-info p-30">
                        @foreach(advertisements() as $advertisement)
                            <div class="item">
                                <div class="row row-cols-1">
                                    <div class="col">
                                        <div class="product type-product">
                                            <div class="product-wrapper">
                                                <div class="product-image">
                                                    <a href="{{$advertisement->link}}" ><img src="{{asset($advertisement->image)}}" alt="Advertisement image" width="228" height="227"></a>
                                                </div>
                                                <div class="product-info text-center">
                                                    <h6 class="product-title"><a href="{{$advertisement->link}}">{{$advertisement->title}}</a></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="full-row bg-light pt-40 pb-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-10">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="font-large text-dark mb-0">@lang('website.Our Products')</h4>
                            <span class="font-500 font-fifteen ms-3 span_details">@lang('website.We have Colorful fabric, Yarn , Cotton, Full garments, Textile machinery and Accessories')</span>

                        </div>
                        <a href="{{route('our-products')}}" class="btn-link higlight-font text-general hover-text-primary transation-this">@lang('website.View All Products')</a>
                    </div>
                </div>
                <div class="col-12 web_view_carousel">
                    <div class="owl-carousel six-carousel dot-disable nav-arrow-middle-show owl-mx-20 e-title-dark e-title-hover-primary e-image-bg-light e-image-pill border border-light bg-white short-info p-30">
                        @foreach(homeCategories() as $homeCategory)
                            <div class="item">
                                <div class="row row-cols-1">
                                    <div class="col">
                                        <div class="product type-product">
                                            <div class="product-wrapper">
                                                <div class="product-image">
                                                    <a href="{{route('our-products-by-category',$homeCategory->category->slug)}}"><img src="{{asset('uploads/categories/'.$homeCategory->category->icon)}}" alt="Product image"></a>
                                                </div>
                                                <div class="product-info text-center">
                                                    <h6 class="product-title"><a href="{{route('our-products-by-category',$homeCategory->category->slug)}}">{{getNameByBnEn($homeCategory->category)}}</a></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-12 mobile_view_carousel">
                    <div class="owl-carousel two-carousel dot-disable nav-arrow-middle-show owl-mx-20 e-title-dark e-title-hover-primary e-image-bg-light e-image-pill border border-light bg-white short-info p-30">
                        @foreach(homeCategories() as $homeCategory)
                            <div class="item">
                                <div class="row row-cols-1">
                                    <div class="col">
                                        <div class="product type-product">
                                            <div class="product-wrapper">
                                                <div class="product-image">
                                                    <a href="{{route('our-products-by-category',$homeCategory->category->slug)}}"><img src="{{asset('uploads/categories/'.$homeCategory->category->icon)}}" alt="Product image" width="100" height="100"></a>
                                                </div>
                                                <div class="product-info text-center">
                                                    <h6 class="product-title"><a href="{{route('our-products-by-category',$homeCategory->category->slug)}}">{{$homeCategory->category->name}}</a></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="full-row bg-light pt-30 pb-0 our_story">
        <div class="container">
            <div class="row g-0">
                <div class="col">
                    <div class="custom-class-115 bg-white">
                        <div class="content">
                            <div class="text-uppercase text-black">@lang('website.Our Story')</div>
                            <h4 class="text-black my-4 text-uppercase">@lang('website.Supply The Best')</h4>
                            <div class="font-sixteen text-justify text-black">
                                <p>@lang('website.our_story_content') </p>
                            </div>
                            <a href="{{route('our-products')}}" class="btn btn-dark mt-4">@lang('website.Read More')</a>
                        </div>
                    </div>
                </div>
                <div class="col d-none d-lg-block">
                    <img class="w-100" src="{{asset('frontend/banner-1.png')}}" alt="">
                </div>
            </div>
        </div>
    </div>
    <div class="full-row bg-light pt-30 pb-0">
        <div class="container pt-3" >
            <div class="row g-0" >
                <div class="col p-2">
                    <div class="p-40 d-flex flex-column bg-white">
                        <div>
                            @php
                                $shortContent = \App\Model\DynamicPage::where('slug','home-page-short-content')->first();
                                $longContent = \App\Model\DynamicPage::where('slug','home-page-long-content')->first();
                            @endphp
                            {!! getDescriptionByBnEn($shortContent) !!}
                            <a id="content_button" class="btn btn-sm btn-dark mt-4 text-center" onclick="getContent()">@lang('website.Read More')</a>
                            <div id="content">
                                {!! getDescriptionByBnEn($longContent) !!}<br>
                                <a id="content_button_less" class="btn btn-sm btn-dark mt-4 text-center" >@lang('website.Read Less')</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="full-row bg-light pt-30 pb-0">
        <div class="container">
            <h3 class="font-large text-dark mb-0">@lang('website.WHY FABRIC LAGBE ?')</h3>
            <div class="row row-cols-lg-3 row-cols-sm-2 row-cols-2 gy-3 gx-0 g-lg-0">
                <div class="col p-2">
                    <div class="p-40 d-flex flex-column text-center bg-white">
                        <i class="flaticon-user flat-medium text-extra1"></i>
                        <div class="mt-10">
                            <h5 class="mb-1"><a href="#" class="text-dark hover-text-primary transation-this">@lang('website.Easy To Find Buyer')</a></h5>
                            <div class="font-500">
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col p-2">
                    <div class="p-40 d-flex flex-column text-center bg-white">
                        <i class="flaticon-user-1 flat-medium text-extra1"></i>
                        <div class="mt-10">
                            <h5 class="mb-1"><a href="#" class="text-dark hover-text-primary transation-this">@lang('website.Easy To Find Seller')</a></h5>
                        </div>
                    </div>
                </div>
                <div class="col p-2">
                    <div class="p-40 d-flex flex-column text-center bg-white">
                        <i class="flaticon-money flat-medium text-extra1"></i>
                        <div class="mt-10">
                            <h5 class="mb-1"><a href="#" class="text-dark hover-text-primary transation-this">@lang('website.Cash And No Credit Sale')</a></h5>
                        </div>
                    </div>
                </div>
                <div class="col p-2">
                    <div class="p-40 d-flex flex-column text-center bg-white">
                        <i class="flaticon-shop flat-medium text-extra1"></i>
                        <div class="mt-10">
                            <h5 class="mb-1"><a href="#" class="text-dark hover-text-primary transation-this">@lang('website.Easy To Grab The Market')</a></h5>
                        </div>
                    </div>
                </div>
                <div class="col p-2">
                    <div class="gray-right-line-one p-40 d-flex flex-column text-center bg-white">
                        <i class="flaticon-financial flat-medium text-extra1"></i>
                        <div class="mt-10">
                            <h5 class="mb-1"><a href="#" class="text-dark hover-text-primary transation-this">@lang('website.Stress Free Business')</a></h5>
                        </div>
                    </div>
                </div>
                <div class="col p-2">
                    <div class="p-40 d-flex flex-column text-center bg-white">
                        <i class="flaticon-bar-chart flat-medium text-extra1"></i>
                        <div class="mt-10">
                            <h5 class="mb-1"><a href="#" class="text-dark hover-text-primary transation-this">@lang('website.Optimism Rate')</a></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="full-row bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-head d-flex justify-content-between align-items-center mb-20">
                        <h2 class="text-dark mb-0">@lang('website.Our Priority Buyers')</h2>
                    </div>
                </div>
                <div class="col-12">
                    <div class="owl-carousel six-carousel nav-arrow-middle-show dot-disable px-30 py-20 owl-mx-one border border-light bg-white">
                        @foreach($priority_buyers as $priority_buyer)
                            <div class="item bg-white">
                                <a href="#"></a><img src="{{url($priority_buyer->image)}}" alt="" width="157" height="157">
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $( document ).ready( function() {
            $('#content').hide();
        });
        function getContent(){
            $('#content_button').hide();
            $('#content').show();
        }
        $('#content_button_less').on('click', function (){
            showLess();
        })
        function showLess(){
            $('#content_button').show();
            $('#content').hide(null);
        }
        document.addEventListener('contextmenu', event => event.preventDefault());
    </script>
@endpush
