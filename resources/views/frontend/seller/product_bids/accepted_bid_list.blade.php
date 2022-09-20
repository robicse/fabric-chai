@extends('frontend.layouts.master')
@section("title","Accepted Requests")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <!-- Main content -->
    <div class="full-row" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                @include('frontend.seller.seller_breadcrumb')
                @include('frontend.seller.seller_sidebar')
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <h3 class="card-title float-left">@lang('website.Accepted Requests')</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>@lang('website.SL')</th>
                                            <th>@lang('website.Buyer Image')</th>
                                            <th>@lang('website.Buyer Name')</th>
                                            <th>@lang('website.Product Name')</th>
                                            <th>@lang('website.Bid Price') (@lang('website.Unit'))</th>
                                            <th>@lang('website.Bid Price') (@lang('website.Total'))</th>
                                            <th>@lang('website.Status')</th>
                                            <th>@lang('website.Action')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($product_bids as $key => $product_bid)
                                            @php
                                                $buyer = \App\User::where('id',$product_bid->receiver_user_id)->first();
                                            @endphp
                                            <tr>
                                                <td>{{getNumberToBangla($key + 1)}}</td>
                                                <td>
                                                    <img src="{{url($buyer->avatar_original)}}" width="80" height="80" alt="">
                                                </td>
                                                <td>{{getNameByBnEn($buyer)}}</td>
                                                <td>{{getNameByBnEn($product_bid->product)}}</td>
                                                <td>{{getNumberWithCurrencyByBnEn($product_bid->unit_bid_price)}}</td>
                                                <td>{{getNumberWithCurrencyByBnEn($product_bid->total_bid_price)}}</td>
                                                <td>
                                                    <span class="bg-success">@lang('website.Accepted')</span>
                                                </td>
                                                <td>
                                                    <a class="btn btn-primary" href="{{route('seller.requested-buyer-details',$product_bid->id)}}">@lang('website.Details')</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>@lang('website.SL')</th>
                                            <th>@lang('website.Buyer Image')</th>
                                            <th>@lang('website.Buyer Name')</th>
                                            <th>@lang('website.Product Name')</th>
                                            <th>@lang('website.Bid Price') (@lang('website.Unit'))</th>
                                            <th>@lang('website.Bid Price') (@lang('website.Total'))</th>
                                            <th>@lang('website.Status')</th>
                                            <th>@lang('website.Action')</th>
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
