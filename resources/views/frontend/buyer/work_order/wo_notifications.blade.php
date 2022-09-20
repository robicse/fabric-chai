@extends('frontend.layouts.master')
@section("title","Notification List")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
    <style>
        .btn-new {
            padding: 0 5px;
        }
    </style>
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
                                    <h3 class="card-title float-left">@lang('website.Notification Lists')</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>@lang('website.SL')</th>
                                            <th>@lang('website.Sender')</th>
                                            <th>@lang('website.Title')</th>
                                            <th>@lang('website.Date')</th>
                                            <th>@lang('website.Seen Status')</th>
                                            <th>@lang('website.Details')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($notifications as $key => $notification)
                                            <tr>
                                                <td>{{getNumberToBangla($key + 1)}}</td>
                                                <td>{{getNameByBnEn($notification->sender)}}</td>
                                                <td>{{$notification->title}}</td>
                                                <td>{{getDateConvertByBnEn($notification->created_at)}}</td>
                                                <td>
                                                    <span class="btn btn-new btn-{{$notification->receiver_view_status == 0 ? 'info' : 'success'}}">{{$notification->receiver_view_status == 0 ? 'Unseen' : 'Seen'}}</span>
                                                    @if($notification->title == 'Placed Work Order Bid')
                                                        <a class="btn btn-new btn-warning mt-2 p-0" href="{{route('buyer.my-work-order.bidder-list',encrypt($notification->work_order_product_id))}}">@lang('website.Bidder List')</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="btn btn-new btn-success" href="{{route('buyer.work-order.notification.detail',encrypt($notification->id))}}">
                                                        @lang('website.Details')
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>@lang('website.SL')</th>
                                            <th>@lang('website.Sender')</th>
                                            <th>@lang('website.Title')</th>
                                            <th>@lang('website.Date')</th>
                                            <th>@lang('website.Seen Status')</th>
                                            <th>@lang('website.Details')</th>
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
