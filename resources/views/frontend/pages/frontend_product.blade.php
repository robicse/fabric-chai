@extends('frontend.layouts.master')
@section('title', 'Frontend Product')
@push('css')
    <style>
        .row_st{
            margin-top: -30px;
        }
        .slider_st{
            width:1200px; margin:0 auto;margin-bottom: 0px; height: 200px !important;
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
        .p_row{
            padding: 30px 0;
        }
        .p_component{
            min-height: 358px!important;
        }
    </style>
@endpush
@section('content')
    <!-- breadcrumb -->
    <div class="full-row row_st">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-3">
                </div>
                <div class="col-lg-12">
                    <div class="full-row bg-light p-0">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div id="slider" style=" width:1200px; margin:0 auto;margin-bottom: 0px; height: 200px !important;">
                                        <!-- Slide 1-->
                                        @foreach(sliders() as $slider)
                                            <div class="ls-slide" data-ls="duration:5000; transition2d:4; kenburnsscale:1.2;">
                                                <img width="1920" height="1080" src="{{asset('uploads/sliders/'.$slider->image)}}" class="ls-l" style="top:50%; left:50%; text-align:initial; font-weight:400; font-style:normal; text-decoration:none; mix-blend-mode:normal; width:100%;" alt="" data-ls="showinfo:1; durationin:2000; easingin:easeOutExpo; scalexin:1.5; scaleyin:1.5; position:fixed;">
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="full-row bg-light pb-0 p_row" >
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="bg-white border-light border-start">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="section-head d-flex align-items-center p-20 border border-light border-start-0">
                                                    @if(Request::segment(1) == 'seller-product-show')
                                                    <h4 class="font-500 text-dark mb-0 mr-auto">@lang('website.Buyer Requested Featured') @lang('website.Products')</h4>
                                                    @else
                                                        <h4 class="font-500 text-dark mb-0 mr-auto">@lang('website.Seller Featured') @lang('website.Products')</h4>
                                                    @endif
                                                    <a href="{{route('frontend-all-featured-products')}}" class="btn-link higlight-font transation-this">@lang('website.View All')</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-0 row-cols-xl-4 row-cols-lg-3 row-cols-md-3 row-cols-sm-2 row-cols-1 e-bg-white e-hover-shadow-one e-hover-wrapper-absolute e-border-one p_component" >
                                            @foreach($featuredProducts as $featuredProduct)
                                                {{frontendProductsComponent($featuredProduct)}}
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="full-row bg-light pb-0 p_row">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="bg-white border-light border-start">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="section-head d-flex align-items-center p-20 border border-light border-start-0">
                                                    @if(Request::segment(1) == 'seller-product-show')
                                                    <h4 class="font-500 text-dark mb-0 mr-auto">@lang('website.Buyer Requested Recent') @lang('website.Products')</h4>
                                                    @else
                                                        <h4 class="font-500 text-dark mb-0 mr-auto">@lang('website.Seller Recent') @lang('website.Products')</h4>
                                                    @endif
                                                    <a href="{{route('frontend-all-recent-products')}}" class="btn-link higlight-font transation-this">@lang('website.View All')</a>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-0 row-cols-xl-4 row-cols-lg-3 row-cols-md-3 row-cols-sm-2 row-cols-1 e-bg-white e-hover-shadow-one e-hover-wrapper-absolute e-border-one p_component" >
                                            @foreach($recentProducts as $recentProduct)
                                                {{frontendProductsComponent($recentProduct)}}
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')

@endpush

