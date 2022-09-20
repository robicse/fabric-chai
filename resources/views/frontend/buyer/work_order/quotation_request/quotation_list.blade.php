@extends('frontend.layouts.master')
@section("title","Submitted Quotations")
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
                                    <h3 class="card-title float-left">@lang('website.Submitted Quotations')</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>@lang('website.SL')</th>
                                            <th>@lang('website.Work Order Image')</th>
                                            <th>@lang('website.Work Order Name')</th>
                                            <th>@lang('website.Quantity')</th>
                                            <th>@lang('website.Total Amount')</th>
                                            <th>@lang('website.Date')</th>
                                            <th>@lang('website.Status')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($quotations as $key => $quotation)
                                            <tr>
                                                <td>{{getNumberToBangla($key + 1)}}</td>
                                                <td>
                                                    <a href="{{route('buyer.work-order-product-details',$quotation->workorderproduct->slug)}}"> <img src="{{url($quotation->workorderproduct->thumbnail_img)}}" width="50" height="50" alt=""></a>
                                                </td>
                                                <td>
                                                    <a href="{{route('buyer.work-order-product-details',$quotation->workorderproduct->slug)}}" style="color: black">{{$quotation->workorderproduct->wish_to_work}}</a>
                                                </td>
                                                <td>
                                                    {{getNumberToBangla($quotation->quantity)}} {{getNameByBnEn($quotation->workorderproduct->unit)}}
                                                </td>
                                                <td>
                                                    {{getNumberWithCurrencyByBnEn($quotation->total_price)}}
                                                </td>
                                                <td>{{getDateConvertByBnEn($quotation->created_at)}}</td>
                                                <td>
                                                    @if($quotation->status == 1)
                                                        <span class="bg-success">@lang('website.Accepted')</span>
                                                    @else
                                                        <span class="bg-info">@lang('website.Pending')</span>
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
                                            <th>@lang('website.Quantity')</th>
                                            <th>@lang('website.Total Amount')</th>
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
