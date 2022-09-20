@extends('frontend.layouts.master')
@section("title","My Work Orders")
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
                    {{--                    <div class="row">--}}
                    {{--                        <div class="col-12">--}}
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title float-left">My Work Order List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Work Order Image</th>
                                    <th>Work Order Name</th>
                                    <th>Required Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                    <th>Delivery Time</th>
{{--                                    <th>Date</th>--}}
                                    <th>Bids Count</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($workOrderProducts as $key => $workOrderProduct)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>
                                            <a href="{{route('buyer.my-work-order.details',$workOrderProduct->slug)}}"> <img src="{{url($workOrderProduct->thumbnail_img)}}" width="50" height="50" alt=""></a>
                                        </td>
                                        <td><a href="{{route('buyer.my-work-order.details',$workOrderProduct->slug)}}" style="color: black">{{$workOrderProduct->wish_to_work}}</a></td>
                                        <td>{{$workOrderProduct->max_oq}} {{$workOrderProduct->unit->name}}</td>
                                        <td>{{two_digit_single_price($workOrderProduct->unit_price)}}</td>
                                        <td>{{two_digit_single_price($workOrderProduct->unit_price * $workOrderProduct->max_oq)}}</td>
                                        <td>{{$workOrderProduct->delivery_time}} Days</td>
{{--                                        <td>{{date('j M Y h:i A',strtotime($workOrderProduct->created_at))}}</td>--}}
                                        <td>{{workOrderBidCount($workOrderProduct->id)}}</td>
                                        <td>
                                            @php
                                                $bidCheck = \App\Model\WorkOrderBid::where('receiver_user_id',Auth::id())->where('work_order_product_id',$workOrderProduct->id)->first();
                                            @endphp
                                            @if(empty($bidCheck))
                                                <a class="btn btn-primary waves-effect" href="{{route('buyer.work-order.edit',encrypt($workOrderProduct->id))}}">
                                                    Edit
                                                </a>
                                            @else
                                                <a class="btn btn-info waves-effect" href="{{route('buyer.my-work-order.details',$workOrderProduct->slug)}}">
                                                    Open
                                                </a>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>SL</th>
                                    <th>Work Order Image</th>
                                    <th>Work Order Name</th>
                                    <th>Required Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                    <th>Delivery Time</th>
{{--                                    <th>Date</th>--}}
                                    <th>Bids Count</th>
                                    <th>Status</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    {{--                        </div>--}}
                    {{--                    </div>--}}
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
