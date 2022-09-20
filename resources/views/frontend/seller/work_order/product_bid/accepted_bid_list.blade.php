@extends('frontend.layouts.master')
@section("title","Accepted Bid")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <!-- Main content -->
    <div class="full-row" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-3">
                    <h3 class="mb-2 text-secondary">Manufacturer Work Order</h3>
                </div>
                @include('frontend.seller.work_order_sidebar')
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <h3 class="card-title float-left">Accepted Bid</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Work Order Image</th>
                                            <th>Work Order Name</th>
                                            <th>Quantity</th>
                                            <th>Date</th>
                                            <th>My Bids</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($woAcceptedBidLists as $key => $woBid)
                                            <tr>
                                                <td>{{$key + 1}}</td>
                                                <td>
                                                    <a href="#"> <img src="{{url($woBid->workorderproduct->thumbnail_img)}}" width="50" height="50" alt=""></a>
                                                </td>
                                                <td>
                                                    <a href="#" style="color: black">{{$woBid->workorderproduct->name}}</a>
                                                </td>
                                                <td>
                                                    {{$woBid->workorderproduct->quantity}} {{$woBid->workorderproduct->unit->name}}
                                                </td>
                                                <td>{{date('j M Y h:i A',strtotime($woBid->created_at))}}</td>
                                                <td>
                                                    {{two_digit_single_price($woBid->total_price)}}
                                                </td>
                                                <td>
                                                    <span class="bg-success">Accepted</span>
                                                </td>
                                                <td>
                                                    <a class="btn btn-primary" href="{{route('seller.work-order.accepted-buyer-details',$woBid->id)}}">Details</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>SL</th>
                                            <th>Work Order Image</th>
                                            <th>Work Order Name</th>
                                            <th>Quantity</th>
                                            <th>Date</th>
                                            <th>My Bids</th>
                                            <th>Status</th>
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
