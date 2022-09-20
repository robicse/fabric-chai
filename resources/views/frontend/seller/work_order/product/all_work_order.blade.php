@extends('frontend.layouts.master')
@section("title","All Work Orders")
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
                                    <h3 class="card-title float-left">All Work Order List</h3>
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
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($workOrderProducts as $key => $workOrderProduct)
                                            @php
                                                $bidCheck = \App\Model\WorkOrderBid::where('sender_user_id',Auth::id())->where('work_order_product_id',$workOrderProduct->id)->first();
                                            @endphp
                                            <tr>
                                                <td>{{$key + 1}}</td>
                                                <td>
                                                    <a href="{{route('product-details',$workOrderProduct->slug)}}"> <img src="{{url($workOrderProduct->thumbnail_img)}}" width="50" height="50" alt=""></a>
                                                </td>
                                                <td><a href="{{route('product-details',$workOrderProduct->slug)}}" style="color: black">{{$workOrderProduct->name}}</a></td>
                                                <td>{{$workOrderProduct->quantity}} {{$workOrderProduct->unit->name}}</td>
                                                <td>{{date('j M Y h:i A',strtotime($workOrderProduct->created_at))}}</td>
                                                <td>
                                                    @if(!empty($bidCheck))
                                                        {{single_price($bidCheck->total_price)}}
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="btn btn-primary" href="{{route('seller.work-order-product-details',$workOrderProduct->slug)}}">Details</a>
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
