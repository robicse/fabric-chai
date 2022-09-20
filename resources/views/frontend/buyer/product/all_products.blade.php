@extends('frontend.layouts.master')
@section("title","All Products")
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
                                    <h3 class="card-title float-left">@lang('website.All Products')</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>#@lang('website.SL')</th>
                                            <th>@lang('website.Product Image')</th>
                                            <th>@lang('website.Product Name')</th>
                                            <th>@lang('website.Unit Price')</th>
                                            <th>@lang('website.Total Price')</th>
                                            <th>@lang('website.Action')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($products as $key => $product)
                                            <tr>
                                                <td>{{getNumberToBangla($key + 1)}}</td>
                                                <td>
                                                   <a href="{{route('product-details',$product->slug)}}" ><img src="{{url($product->thumbnail_img)}}" width="32" height="32" alt=""></a>
                                                </td>
                                                <td><a href="{{route('product-details',$product->slug)}}" style="color: black">{{getNameByBnEn($product)}}</a></td>
                                                @if($product->category_id == 9 && $product->sizingProduct)
                                                    <td>{{getNumberWithCurrencyByBnEn($product->sizingProduct->price)}}</td>
                                                    <td>{{getNumberWithCurrencyByBnEn($product->sizingProduct->total_price)}}</td>
                                                @else
                                                    <td>{{getNumberWithCurrencyByBnEn($product->unit_price)}}</td>
                                                    <td>{{getNumberWithCurrencyByBnEn($product->expected_price)}}</td>
                                                @endif

                                                @php
                                                $product_bid = \App\Model\ProductBid::where('product_id',$product->id)->where('sender_user_id',Auth::id())->first();
                                                @endphp
                                                <td>
                                                    @if(!empty($product_bid))
                                                        <button class="bg-success">
                                                            @lang('website.Applied')
                                                        </button>
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
                                            <th>#@lang('website.SL')</th>
                                            <th>@lang('website.Product Image')</th>
                                            <th>@lang('website.Product Name')</th>
                                            <th>@lang('website.Unit Price')</th>
                                            <th>@lang('website.Total Price')</th>
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
