@extends('frontend.layouts.master')
@section('title', 'Buyer Work Order Dashboard')
@push('css')
@endpush
@section('content')
    <div class="full-row" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-3">
                    <h3 class="mb-2 text-secondary">@lang('website.Buyer Work Order')</h3>
                </div>
                @include('frontend.buyer.work_order_sidebar')
                <div class="col-lg-9 col-sm-9">
                    <div class="row">
                        <div class="col-12">
                            <div id="slider" style="width:1200px; margin:0 auto;margin-bottom: 0px;">
                                <!-- Slide 1-->
                                @foreach(sliders() as $slider)
                                    <div class="ls-slide" data-ls="duration:5000; transition2d:4; kenburnsscale:1.2;">
                                        <img width="1920" height="1080" src="{{asset('uploads/sliders/'.$slider->image)}}" class="ls-l" alt="" style="top:50%; left:50%; text-align:initial; font-weight:400; font-style:normal; text-decoration:none; mix-blend-mode:normal; width:100%;" data-ls="showinfo:1; durationin:2000; easingin:easeOutExpo; scalexin:1.5; scaleyin:1.5; position:fixed;">
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    @if($featured_companies->count() > 0)
                        <div class="row" style="padding: 30px 0;">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <div class="bg-white border-light border-start">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="section-head d-flex align-items-center p-20 border border-light border-start-0">
                                                        <h4 class="font-500 text-dark mb-0 mr-auto">@lang('website.Featured Companies')</h4>
                                                        <a href="{{route('buyer.work-order.companies')}}" class="btn btn-success">@lang('website.View All')</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row e-bg-white e-hover-shadow-one e-border-one" style="min-height: 358px!important;">
                                                @foreach($featured_companies as $featured_company)
                                                    @php
                                                        $user = \App\User::find($featured_company->user_id);

                                                    $factory = \App\Model\WorkorderFactory::where('user_id',$user->id)->first();
                                                    $seller = \App\Model\Seller::where('user_id',$user->id)->first();
                                                    @endphp
                                                    <div class="col-lg-4 col-md-4 col-sm-6 col-6 mb-2" style="margin-top: 10px; ">
                                                        <div class="product type-product">
                                                            <div class="product-wrapper">
                                                                <div class="product-image">
                                                                    @if($factory->factory_image)
                                                                    <a href="{{route('buyer.work-order.company-details',encrypt($user->id))}}" class="woocommerce-LoopProduct-link"><img src="{{url($factory->factory_image)}}" width="231" height="231"></a>
                                                                    @else
                                                                        <a href="{{route('buyer.work-order.company-details',encrypt($user->id))}}"> <img src="{{ asset('frontend/assets/images/placeholder.jpg') }}"  width="231" height="231"></a>
                                                                    @endif
                                                                    <div class="wishlist-view">
                                                                    </div>
                                                                </div>
                                                                <div class="product-info">
                                                                    <h3 class="product-title"><a href="{{route('buyer.work-order.company-details',encrypt($user->id))}}">{{$seller->company_name}}</a></h3>
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
                        </div>
                    @endif
                    @if($featured_products->count() > 0)
                        <div class="row" style="padding: 30px 0; margin-top: -50px;">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <div class="bg-white border-light border-start">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="section-head d-flex align-items-center p-20 border border-light border-start-0">
                                                        <h4 class="font-500 text-dark mb-0 mr-auto">@lang('website.All Work Orders')</h4>
                                                        <a href="{{route('buyer.work-order.featured-products')}}" class="btn btn-success">@lang('website.View All')</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row e-bg-white e-hover-shadow-one e-border-one" style="min-height: 358px!important;">
                                                @foreach($featured_products as $featured_product)
                                                    {{workOrderProductComponent($featured_product)}}
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')

@endpush

