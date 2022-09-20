@extends('frontend.layouts.master')
@section("title","Work Order Recorded Transaction")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <!-- Main content -->
    <div class="full-row" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-3">
                    <h3 class="mb-2 text-secondary">Buyer Work Order</h3>
                </div>
                @include('frontend.buyer.work_order_sidebar')
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <h3 class="card-title float-left">Recorded Transaction</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Product Image</th>
                                            <th>Product Name</th>
                                            <th>Bid Amount</th>
                                            <th>Date</th>
                                            <th>Ratings</th>
                                            <th>Print</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($wo_sale_records as $key => $wo_sale_record)

                                            <tr>
                                                <td>{{$key + 1}}</td>
                                                <td>
                                                    <img src="{{url($wo_sale_record->workOrderProduct->thumbnail_img)}}" width="50" height="50" alt="">
                                                </td>
                                                <td>{{$wo_sale_record->workOrderProduct->wish_to_work}}</td>
                                                <td>{{two_digit_single_price($wo_sale_record->amount)}}</td>
                                                <td>{{date('j M Y h:i A',strtotime($wo_sale_record->created_at))}}</td>
                                                <td>{{userWorkOrderRating($wo_sale_record->seller_user_id)}}</td>
                                                <td>
                                                    <a class="btn btn-info" href="{{route('buyer.work-order.recorded-transaction.print',encrypt($wo_sale_record->id))}}"><i class="fa fa-print"></i></a>
                                                </td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>SL</th>
                                            <th>Product Image</th>
                                            <th>Product Name</th>
                                            <th>Bid Amount</th>
                                            <th>Date</th>
                                            <th>Ratings</th>
                                            <th>Print</th>
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
