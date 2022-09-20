@extends('frontend.layouts.master')
@section('title', 'All Products')
@push('css')
    <style>
        .row_st{
            margin-top: -30px;
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
    <div class="full-row bg-light pb-0 p_row" >
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="bg-white border-light border-start">
                        <div class="row">
                            <div class="col-12">
                                <div class="section-head d-flex align-items-center p-20 border border-light border-start-0">
                                    <h4 class="font-500 text-dark mb-0 mr-auto">@lang('website.All Products')</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row g-0 row-cols-xl-4 row-cols-lg-3 row-cols-md-3 row-cols-sm-2 row-cols-1 e-bg-white e-hover-shadow-one e-hover-wrapper-absolute e-border-one p_component" >
                            @foreach($products as $product)
                                {{frontendProductsComponent($product)}}
                            @endforeach

                        </div>
                    </div>
                </div>
                <div class="m-4 text-center">
                    {{ $products->links() }}
                </div>

            </div>
        </div>
    </div>

@endsection
@push('js')

@endpush

