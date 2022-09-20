@extends('frontend.layouts.master')
@section("title","My Bids")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
    <style>
        .m_t_30{
            margin-top: -30px;
        }
    </style>
@endpush
@section('content')
    <!-- Main content -->
    <div class="full-row m_t_30">
        <div class="container">
            <div class="row">
                @include('frontend.buyer.buyer_breadcrumb')
                @include('frontend.buyer.buyer_sidebar')
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <h3 class="card-title float-left">@lang('website.My Bids')</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>@lang('website.SL')</th>
                                            <th>@lang('website.Product Image')</th>
                                            <th>@lang('website.Product Name')</th>
                                            <th>@lang('website.Quantity')</th>
                                            <th>@lang('website.Bid Price') (@lang('website.Unit'))</th>
                                            <th>@lang('website.Bid Price') (@lang('website.Total'))</th>
                                            <th>@lang('website.Date')</th>
                                            <th>@lang('website.Ratings')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach(MyBids() as $key => $product_bid)
                                            <tr>
                                                <td>{{getNumberToBangla($key + 1)}}</td>
                                                <td>
                                                    <a href="{{route('product-details',$product_bid->product->slug)}}"><img src="{{url($product_bid->product->thumbnail_img)}}" width="50" height="50" alt=""></a>
                                                </td>
                                                <td><a class="text-dark" href="{{route('product-details',$product_bid->product->slug)}}">{{ getNameByBnEn($product_bid->product) }}</a></td>
                                                <td>{{$product_bid->product->quantity ? getNumberToBangla($product_bid->product->quantity) :''}} {{$product_bid->product->unit ? getNameByBnEn($product_bid->product->unit) :''}} </td>
                                                <td>{{getNumberWithCurrencyByBnEn($product_bid->unit_bid_price)}}</td>
                                                <td>{{getNumberWithCurrencyByBnEn($product_bid->total_bid_price)}}</td>
                                                <td>{{ getDateConvertByBnEn($product_bid->created_at)}}</td>
                                                <td>{{getNumberToBangla(userRating($product_bid->product->user_id))}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>@lang('website.SL')</th>
                                            <th>@lang('website.Product Image')</th>
                                            <th>@lang('website.Product Name')</th>
                                            <th>@lang('website.Quantity')</th>
                                            <th>@lang('website.Bid Price') (@lang('website.Unit'))</th>
                                            <th>@lang('website.Bid Price') (@lang('website.Total'))</th>
                                            <th>@lang('website.Date')</th>
                                            <th>@lang('website.Ratings')</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@push('js')
    <script src="{{asset('backend/plugins/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables/dataTables.bootstrap4.js')}}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script>
        $(function () {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });

    </script>
@endpush
