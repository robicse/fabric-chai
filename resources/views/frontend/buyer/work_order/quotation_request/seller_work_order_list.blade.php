@extends('frontend.layouts.master')
@section("title","Seller Work Order List")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <!-- Main content -->
    <div class="full-row" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-3">
                    <h3 class="mb-2 text-secondary">@lang('website.Buyer Work Order')</h3>
                </div>
                @include('frontend.buyer.work_order_sidebar')
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <h3 class="card-title float-left">@lang('website.Seller Work Order List')</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>@lang('website.SL')</th>
                                            <th>@lang('website.Work Order Image')</th>
                                            <th>@lang('website.Work Order Name')</th>
                                            <th>@lang('website.Unit Price')</th>
                                            <th>@lang('website.Date')</th>
                                            <th>@lang('website.Status')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($workOrderProducts as $key => $workOrderProduct)
                                            <tr>
                                                <td>{{getNumberToBangla($key + 1)}}</td>
                                                <td>
                                                    <a href="{{route('buyer.work-order-product-details',$workOrderProduct->slug)}}"> <img src="{{url($workOrderProduct->thumbnail_img)}}" width="50" height="50" alt=""></a>
                                                </td>
                                                <td><a href="{{route('buyer.work-order-product-details',$workOrderProduct->slug)}}" style="color: black">{{$workOrderProduct->wish_to_work}}</a></td>
                                                <td>{{getNumberWithCurrencyByBnEn($workOrderProduct->unit_price)}} </td>
{{--                                                <td>{{$workOrderProduct->quantity}} {{$workOrderProduct->unit->name}}</td>--}}
{{--                                                <td>{{$workOrderProduct->delivery_time}} Days</td>--}}
                                                <td>{{getDateConvertByBnEn($workOrderProduct->created_at)}}</td>
                                                <td>
                                                    @php
                                                        $quotationCheck = \App\Model\WorkOrderQuotationRequest::where('buyer_user_id',Auth::id())->where('work_order_product_id',$workOrderProduct->id)->first();
                                                    @endphp
                                                    @if(empty($quotationCheck))
                                                        <a class="btn btn-info waves-effect" href="{{route('buyer.work-order-product-details',$workOrderProduct->slug)}}">
                                                            @lang('website.Open')
                                                        </a>
                                                    @elseif($quotationCheck->status == 1)
                                                        <span class="bg-success" >@lang('website.Sold')</span>
                                                    @else
                                                        <span class="bg-success">@lang('website.Applied')</span>
                                                    @endif
                                                </td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>@lang('website.SL')</th>
                                            <th>@lang('website.Work Order Image')</th>
                                            <th>@lang('website.Work Order Name')</th>
                                            <th>@lang('website.Unit Price')</th>
                                            <th>@lang('website.Date')</th>
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
