@extends('frontend.layouts.master')
@section("title","Notification List")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
    <style>
        .btn-1 {
            padding: 0 5px;
        }
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
                                                <td>
                                                    @if($notification->title == 'Bid Rejected')
                                                        @lang('website.Bid Rejected')
                                                    @elseif($notification->title == 'Placed Bid')
                                                        @lang('website.Placed Bid')
                                                    @elseif($notification->title == 'Accepted Bid')
                                                        @lang('website.Accepted Bid')
                                                    @elseif($notification->title == 'Approved Product')
                                                        @lang('website.Approved Product')
                                                    @else

                                                    @endif
                                                </td>
                                                <td>{{getDateConvertByBnEn($notification->created_at)}}</td>
                                                <td>
                                                    <span class="btn btn-{{$notification->receiver_view_status == 0 ? 'info' : 'success'}} btn-1">
                                                        @if($notification->receiver_view_status == 0)
                                                            @lang('website.Unseen')
                                                        @else
                                                            @lang('website.Seen')
                                                        @endif
                                                    </span>
                                                    @if($notification->title == 'Placed Bid')
                                                        <a class="btn btn-warning btn-1 mt-2 p-0" href="{{route('buyer.bidder-list',$notification->product->slug)}}">@lang('website.Bidder List')</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="btn btn-success btn-1" href="{{route('buyer.notification.detail',$notification->id)}}">
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
