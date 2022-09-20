@extends('frontend.layouts.master')
@section('title', 'All Work Order Products')
@push('css')
@endpush
@section('content')
    <div class="full-row" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-3">
                    <h3 class="mb-2 text-secondary">Manufacturer Work Order</h3>
                </div>
                @include('frontend.seller.work_order_sidebar')
                <div class="col-lg-9 col-sm-9">
                    @if($all_work_order_products->count() > 0)
                        <div class="row">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <div class="bg-white border-light border-start">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="section-head d-flex align-items-center p-20 border border-light border-start-0">
                                                        <h4 class="font-500 text-dark mb-0 mr-auto">All Work Order Products</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row e-bg-white e-hover-shadow-one e-border-one" style="min-height: 358px!important;">
                                                @foreach($all_work_order_products as $all_work_order_product)
                                                    {{workOrderProductComponent($all_work_order_product)}}
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

