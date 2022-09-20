@extends('frontend.layouts.master')
@section("title","Notification Details")
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
                    <h3>@lang('website.Notification Details')</h3>

                    <div class="row">
                        <div class="col-12">
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <h5 class="card-title float-left">@lang('website.Notification Details')</h5>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th>@lang('website.Sender')</th>
                                            <td>{{getNameByBnEn($notification->sender)}}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('website.Receiver')</th>
                                            <td>{{getNameByBnEn($notification->receiver)}}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('website.Title')</th>
                                            <td>{{$notification->title}}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('website.Message')</th>
                                            <td>{{$notification->message}}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('website.Date')</th>
                                            <td>{{getDateConvertByBnEn($notification->created_at)}}</td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
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
