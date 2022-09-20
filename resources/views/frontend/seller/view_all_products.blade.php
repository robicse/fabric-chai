@extends('frontend.layouts.master')
@section('title', 'All Products')

@push('css')

@endpush
@section('content')
    <div class="full-row" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                @include('frontend.seller.seller_breadcrumb')
                @include('frontend.seller.seller_sidebar')
                <div class="col-lg-9" style="background-color: #fff;">
                    <div class="full-row pt-0">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="products-header d-flex justify-content-between align-items-center py-10 px-20 bg-light md-mt-30">
                                        <div class="products-header-left d-flex align-items-center">
                                            <h4 class="woocommerce-products-header__title page-title">All {{$title}}</h4>
                                            <div class="woocommerce-result-count">({{$products->count()}})</div>
                                        </div>
                                    </div>
                                    @if($products->count() > 0)
                                        <div class="showing-products pt-30 pb-50 border-2 border-bottom border-light">
                                            <div class="row row-cols-xl-3 row-cols-md-3 row-cols-sm-3 row-cols-1 e-hover-image-zoom e-image-bg-light e-btn-set-two cart-slide-up g-4">
                                                @foreach($products as $product)
                                                    {{viewAllProductsComponent($product)}}
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-center">
                                            <img src="{{asset('frontend/no-data.jpg')}}">
                                            <p style="margin-top: -100px;">{{$title}} will be added soon</p>
                                        </div>
                                    @endif
                                    {{--                                    <div class="d-flex justify-content-between align-items-center pt-3">--}}
                                    {{--                                        <div class="showing-result">Showing 1 – 28 of 23945 results</div>--}}
                                    {{--                                        <div class="pagination-style-one">--}}
                                    {{--                                            <nav aria-label="Page navigation example">--}}
                                    {{--                                                <ul class="pagination">--}}
                                    {{--                                                    <li class="page-item">--}}
                                    {{--                                                        <a class="page-link" href="#" aria-label="Previous">--}}
                                    {{--                                                            <span aria-hidden="true">&laquo;</span>--}}
                                    {{--                                                        </a>--}}
                                    {{--                                                    </li>--}}
                                    {{--                                                    <li class="page-item"><a class="page-link" href="#">1</a></li>--}}
                                    {{--                                                    <li class="page-item"><a class="page-link" href="#">2</a></li>--}}
                                    {{--                                                    <li class="page-item"><a class="page-link" href="#">3</a></li>--}}
                                    {{--                                                    <li class="page-item">--}}
                                    {{--                                                        <a class="page-link" href="#" aria-label="Next">--}}
                                    {{--                                                            <span aria-hidden="true">&raquo;</span>--}}
                                    {{--                                                        </a>--}}
                                    {{--                                                    </li>--}}
                                    {{--                                                </ul>--}}
                                    {{--                                            </nav>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}

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

