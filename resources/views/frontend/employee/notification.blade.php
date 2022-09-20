@extends('frontend.layouts.master')
@section("title","Notification List")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
    <style>
        .btn {
            padding: 0 5px;
        }
    </style>
@endpush
@section('content')
    <!-- Main content -->
    <div class="full-row" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                @include('frontend.employee.employee_breadcrumb')
                @include('frontend.employee.employee_sidebar')
                <div class="col-lg-9">
                    <h4>@lang('website.Notification Lists')</h4>
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <h5 class="card-title float-left">@lang('website.Notification Lists')</h5>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>@lang('website.SL')</th>
                                            <th>@lang('website.Sender')</th>
                                            <th>@lang('website.Title')</th>
                                            <th>@lang('website.Message')</th>
                                            <th>@lang('website.Date')</th>
                                            <th>@lang('website.Seen Status')</th>
                                            <th>@lang('website.Details')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($notifications as $key => $notification)
                                            <tr>
                                                <td>{{getNumberToBangla($key + 1)}}</td>
                                                <td>{{$notification->sender->name}}</td>
                                                <td>{{$notification->title}}</td>
                                                <td>{{$notification->message}}</td>
                                                <td>{{getDateConvertByBnEn($notification->created_at)}}</td>
                                                <td>
                                                    <span class="btn btn-{{$notification->receiver_view_status == 0 ? 'info' : 'success'}}">{{$notification->receiver_view_status == 0 ? 'Unseen' : 'Seen'}}</span>
                                                </td>
                                                <td>
                                                    <a class="btn btn-success" href="{{route('employee.notification.detail',$notification->id)}}">
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
                                            <th>@lang('website.Message')</th>
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
