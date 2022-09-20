@extends('frontend.layouts.master')
@section("title","Accepted Quotation list")
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
                                    <h3 class="card-title float-left">@lang('website.Accepted Quotation list')</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>@lang('website.SL')</th>
                                            <th>@lang('website.Seller Image')</th>
                                            <th>@lang('website.Seller Name')</th>
                                            <th>@lang('website.Production Capability')</th>
                                            <th>@lang('website.Quotation Quantity')</th>
                                            <th>@lang('website.Quotation Amount')</th>
                                            <th>@lang('website.Date')</th>
                                            <th>@lang('website.Ratings')</th>
                                            <th>@lang('website.Action')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($wo_quotations as $key => $wo_quotation)

                                            <tr>
                                                <td>{{getNumberToBangla($key + 1)}}</td>
                                                <td>
                                                    <img src="{{url($wo_quotation->sellerUser->avatar_original)}}" width="50" height="50" alt="">
                                                </td>
                                                <td>{{getNameByBnEn($wo_quotation->sellerUser)}}</td>
                                                <td>{{$wo_quotation->workOrderProduct->wish_to_work}}</td>
                                                <td>{{getNumberToBangla($wo_quotation->quantity)}} {{getNameByBnEn($wo_quotation->workOrderProduct->unit)}}</td>
                                                <td>{{getNumberToBangla($wo_quotation->total_price)}}</td>
                                                <td>{{getDateConvertByBnEn($wo_quotation->created_at)}}</td>
                                                <td>{{getNumberToBangla(userWorkOrderRating($wo_quotation->seller_user_id))}}</td>
                                                <td>
                                                    <a class="btn btn-info" href="{{route('buyer.accepted-quotation-details',encrypt($wo_quotation->id))}}">@lang('website.Details')</a>
                                                </td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>@lang('website.SL')</th>
                                            <th>@lang('website.Seller Image')</th>
                                            <th>@lang('website.Seller Name')</th>
                                            <th>@lang('website.Production Capability')</th>
                                            <th>@lang('website.Quotation Quantity')</th>
                                            <th>@lang('website.Quotation Amount')</th>
                                            <th>@lang('website.Date')</th>
                                            <th>@lang('website.Ratings')</th>
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
