@extends('frontend.layouts.master')
@section("title","Work Order Reviews")
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
                                    <h3 class="card-title float-left">@lang('website.Review Lists')</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>@lang('website.SL')</th>
                                            <th>@lang('website.Reviewer Name')</th>
                                            <th>@lang('website.Work Order Image')</th>
                                            <th>@lang('website.Work Order Name')</th>
                                            <th>@lang('website.Ratings')</th>
                                            <th>@lang('website.Comments')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($wo_reviews as $key => $review)
                                            <tr>
                                                <td>{{getNumberToBangla($key + 1)}}</td>
                                                <td>{{getNameByBnEn($review->sender)}}</td>
                                                <td>
                                                    <img src="{{url($review->workOrderProduct->thumbnail_img)}}" width="50" height="50" alt="">
                                                </td>
                                                <td>{{ $review->workOrderProduct->wish_to_work }}</td>
                                                <td>{{getNumberToBangla($review->rating)}}</td>
                                                <td>{{ $review->comment }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>@lang('website.SL')</th>
                                            <th>@lang('website.Reviewer Name')</th>
                                            <th>@lang('website.Work Order Image')</th>
                                            <th>@lang('website.Work Order Name')</th>
                                            <th>@lang('website.Ratings')</th>
                                            <th>@lang('website.Comments')</th>
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
