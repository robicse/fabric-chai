@extends('frontend.layouts.master')
@section("title","My Requested Products")
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
                                    <h3 class="card-title float-left">@lang('website.My Requested Products')</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped table-responsive">
                                        <thead>
                                        <tr>
                                            <th>@lang('website.SL')</th>
                                            <th>@lang('website.Product Image')</th>
                                            <th>@lang('website.Product Name')</th>
                                            <th>@lang('website.Quantity')</th>
                                            <th>@lang('website.Unit Price')</th>
                                            <th>@lang('website.Total Price')</th>
                                            <th>@lang('website.Date')</th>
                                            <th>@lang('website.Bids Count')</th>
                                            <th>@lang('website.Status')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($products as $key => $product)
                                            <tr>
                                                <td>
                                                    {{getNumberToBangla($key + 1)}}<br>
                                                    @if($product->price_validity <= date('Y-m-d'))
                                                        <span class="text-danger">@lang('website.Date Expired')</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{route('product-details',$product->slug)}}"> <img src="{{url($product->thumbnail_img)}}" width="50" height="50" alt=""></a>
                                                </td>
                                                <td><a class="text-dark" href="{{route('product-details',$product->slug)}}">{{getNameByBnEn($product)}}</a></td>
                                                @if($product->category_id == 9 && $product->sizingProduct)
                                                    <td>{{getNumberToBangla($product->sizingProduct->total_length)}} @lang('website.Meter/Yards')</td>
                                                    <td>{{getNumberWithCurrencyByBnEn($product->sizingProduct->price)}}</td>
                                                    <td>{{getNumberWithCurrencyByBnEn($product->sizingProduct->total_price)}}</td>

                                                @else
                                                    <td>{{getNumberToBangla($product->quantity)}} {{$product->unit_id ? getNameByBnEn($product->unit) : ''}}</td>
                                                    <td>{{getNumberWithCurrencyByBnEn($product->unit_price)}}</td>
                                                    <td>{{getNumberWithCurrencyByBnEn($product->expected_price)}}</td>

                                                @endif
                                                <td>{{getDateConvertByBnEn($product->created_at)}}</td>
                                                <td>{{getNumberToBangla(bidCount($product->id))}}</td>
                                                @php
                                                    $productBid = \App\Model\ProductBid::where('product_id',$product->id)->where('bid_status',1)->first();;
                                                @endphp
                                                <td>
                                                    @if(!empty($productBid))
                                                        <a class="btn btn-success waves-effect" href="{{route('product-details',$product->slug)}}">
                                                            @lang('website.Sold')
                                                        </a>
                                                    @elseif(bidCount($product->id) == 0)
                                                        @if($product->category_id == 9)
                                                            <a class="btn btn-primary waves-effect" href="{{route('buyer.sizing-products.edit',encrypt($product->id))}}">
                                                                @lang('website.Edit')
                                                            </a>
                                                        @elseif($product->category_id == 7)
                                                            <a class="btn btn-primary waves-effect" href="{{route('buyer.dying-products.edit',encrypt($product->id))}}">
                                                                @lang('website.Edit')
                                                            </a>
                                                        @else
                                                            <a class="btn btn-primary waves-effect" href="{{route('buyer.my-request.edit',encrypt($product->id))}}">
                                                                @lang('website.Edit')
                                                            </a>
                                                        @endif
                                                    @else
                                                        <a class="btn btn-info waves-effect" href="{{route('product-details',$product->slug)}}">
                                                            @lang('website.Open')
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>@lang('website.SL')</th>
                                            <th>@lang('website.Product Image')</th>
                                            <th>@lang('website.Product Name')</th>
                                            <th>@lang('website.Quantity')</th>
                                            <th>@lang('website.Unit Price')</th>
                                            <th>@lang('website.Total Price')</th>
                                            <th>@lang('website.Date')</th>
                                            <th>@lang('website.Bids Count')</th>
                                            <th>@lang('website.Status')</th>
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
