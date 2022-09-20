@extends('frontend.layouts.master')
@section('title', 'Manufacturer Work Order Dashboard')
@push('css')
@endpush
@section('content')
    <div class="full-row" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-3">
                    <h3 class="mb-2 text-secondary">@lang('website.Manufacturer Work Order')</h3>
                </div>
                @include('frontend.seller.work_order_sidebar')
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
{{--                    @if($products->count() > 0)--}}
{{--                        <div class="row" style="padding: 30px 0;">--}}
{{--                            <div class="container">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col">--}}
{{--                                        <div class="bg-white border-light border-start">--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="col-12">--}}
{{--                                                    <div class="section-head d-flex align-items-center p-20 border border-light border-start-0">--}}
{{--                                                        <h4 class="font-500 text-dark mb-0 mr-auto">Featured Companies</h4>--}}
{{--                                                        <a href="#" class="btn btn-success">View All</a>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="row e-bg-white e-hover-shadow-one e-border-one" style="min-height: 358px!important;">--}}
{{--                                                @foreach($products as $product)--}}
{{--                                                    {{productsComponent($product)}}--}}
{{--                                                @endforeach--}}

{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endif--}}
                    @if($recent_work_orders->count() > 0)
                        <div class="row" style="padding: 30px 0;">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <div class="bg-white border-light border-start">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="section-head d-flex align-items-center p-20 border border-light border-start-0">
                                                        <h4 class="font-500 text-dark mb-0 mr-auto">@lang('website.My Production Capacity Post')</h4>
                                                        <a href="{{route('seller.work-order.all-products')}}" class="btn btn-success">@lang('website.View All')</a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row e-bg-white e-hover-shadow-one e-border-one" style="min-height: 358px!important;">
                                                @foreach($recent_work_orders as $recent_work_order)
                                                    {{workOrderProductComponent($recent_work_order)}}
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

