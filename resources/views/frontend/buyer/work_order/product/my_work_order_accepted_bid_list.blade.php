@extends('frontend.layouts.master')
@section("title","My Work Order Accepted Bidder list")
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
                                    <h3 class="card-title float-left">Accepted Bidder List</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Seller Image</th>
                                            <th>Seller Name</th>
                                            <th>Product Name</th>
                                            <th>Bid Amount</th>
                                            <th>Date</th>
                                            <th>Ratings</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($wo_bids as $key => $wo_bid)

                                            <tr>
                                                <td>{{$key + 1}}</td>
                                                <td>
                                                    <img src="{{url($wo_bid->sender->avatar_original)}}" width="50" height="50" alt="">
                                                </td>
                                                <td>{{$wo_bid->sender->name}}</td>
                                                <td>{{$wo_bid->workOrderProduct->wish_to_work}}</td>
                                                <td>{{two_digit_single_price($wo_bid->total_price)}}</td>
                                                <td>{{date('j M Y h:i A',strtotime($wo_bid->created_at))}}</td>
                                                <td>{{userWorkOrderRating($wo_bid->sender_user_id)}}</td>
                                                <td>
                                                    <a class="btn btn-info" href="{{route('buyer.my-work-order.bidder-details',encrypt($wo_bid->id))}}">Details</a>
                                                </td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>SL</th>
                                            <th>Seller Image</th>
                                            <th>Seller Name</th>
                                            <th>Seller Address</th>
                                            <th>Bid Amount</th>
                                            <th>Date</th>
                                            <th>Ratings</th>
                                            <th>Action</th>
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
