@extends('frontend.layouts.master')
@section('title', 'Work Order Companies')
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
                    @if($featured_companies->count() > 0)
                        <div class="row">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <div class="bg-white border-light border-start">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="section-head d-flex align-items-center p-20 border border-light border-start-0">
                                                        <h4 class="font-500 text-dark mb-0 mr-auto">@lang('website.All Companies')</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row e-bg-white e-hover-shadow-one e-border-one" style="min-height: 358px!important;">
                                                @foreach($featured_companies as $featured_company)
                                                    @php
                                                        $user = \App\User::find($featured_company->user_id);

                                                    $factory = \App\Model\WorkorderFactory::where('user_id',$user->id)->first();
                                                    @endphp
                                                    <div class="col-lg-4 col-md-4 col-sm-6 col-6 mb-2" style="margin-top: 10px; ">
                                                        <div class="product type-product">
                                                            <div class="product-wrapper">
                                                                <div class="product-image">
                                                                    <a href="{{route('buyer.work-order.company-details',encrypt($user->id))}}" class="woocommerce-LoopProduct-link"><img class="lazyload" src="{{ asset('frontend/assets/images/placeholder.jpg') }}" data-src="{{url($factory->factory_image)}}" width="231" height="231"></a>
                                                                    <div class="wishlist-view">
                                                                    </div>
                                                                </div>
                                                                <div class="product-info">
                                                                    <h3 class="product-title"><a href="{{route('buyer.work-order.company-details',encrypt($user->id))}}">{{getCompanyNameByBnEn($factory->seller)}}</a></h3>
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
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')

@endpush

