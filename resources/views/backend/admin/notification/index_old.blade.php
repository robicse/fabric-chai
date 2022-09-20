@extends('backend.layouts.master')
@section("title","Notification List")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Notification List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Notification List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title float-left">Notification Lists</h3>
                        <div class="float-right">
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Sender</th>
                                <th>Receiver</th>
                                <th>Title</th>
                                {{--                                <th>Message</th>--}}
                                <th>Date</th>
                                <th>Seen Status</th>
                                <th>Details</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($notifications as $key => $notification)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$notification->sender ? $notification->sender->name: 'Deleted' }}</td>
                                    <td>{{$notification->receiver ? $notification->receiver->name : 'Deleted'}}</td>
                                    <td>{{$notification->title}}</td>
                                    {{--                                    <td>{{$notification->message}}</td>--}}
                                    <td>{{date('j M Y h:i A',strtotime($notification->created_at))}}</td>
                                    <td>
                                        @php
                                            $seller = \App\Model\Seller::where('user_id',$notification->sender_user_id)->first();
                                            $buyer = \App\Model\Buyer::where('user_id',$notification->sender_user_id)->first();
                                        @endphp
                                        <span class="btn btn-{{$notification->admin_view_status == 0 ? 'info' : 'success'}}">{{$notification->admin_view_status == 0 ? 'Unseen' : 'Seen'}}</span>
                                        @if($notification->title == 'Seller Registration')
                                            @if(checkSellerApproved($notification->sender_user_id) == 0 && $notification->sender)

                                                <a class="btn btn-warning" href="{{route('admin.individual-seller',$seller->id)}}">
                                                    Approve Seller
                                                </a>
                                            @endif
                                        @elseif($notification->title == 'Buyer Registration')
                                            @if(checkBuyerApproved($notification->sender_user_id) == 0 && $notification->sender)
                                                <a class="btn btn-warning" href="{{route('admin.individual-buyer',$buyer->id)}}">
                                                    Approve Buyer
                                                </a>
                                            @endif
                                        @elseif($notification->title == 'Applied for Seller')
                                            @if(checkProductApproved($notification->sender_user_id) == 0 && $notification->sender)
                                                <a class="btn btn-warning" href="{{route('admin.individual-seller',$seller->id)}}">
                                                    Approve Seller
                                                </a>
                                            @endif
                                        @elseif($notification->title == 'Seller Product Entry')
                                            @if(checkProductApproved($notification->product_id) == 0)
                                                <a class="btn btn-warning" href="{{url('admin/seller-product-individual/'.$notification->sender_user_id.'/'.$notification->product_id)}}">
                                                    Approve Product
                                                </a>
                                            @endif
                                        @elseif($notification->title == 'Buyer Product Entry')
                                            @if(checkProductApproved($notification->product_id) == 0)
                                                <a class="btn btn-warning" href="{{url('admin/buyer-product-individual/'.$notification->sender_user_id.'/'.$notification->product_id)}}">
                                                    Approve Product
                                                </a>
                                            @endif
                                        @elseif($notification->title == 'Seller Work Order Create')
                                            @if(checkWOProductApproved($notification->work_order_product_id) == 0)
                                                <a class="btn btn-warning" href="{{url('admin/seller-work-order-individual/'.$notification->sender_user_id.'/'.$notification->work_order_product_id)}}">
                                                    Approve WO
                                                </a>
                                            @endif
                                        @elseif($notification->title == 'Buyer Work Order Create')
                                            @if(checkWOProductApproved($notification->work_order_product_id) == 0)
                                                <a class="btn btn-warning" href="{{url('admin/buyer-product-individual/'.$notification->sender_user_id.'/'.$notification->work_order_product_id)}}">
                                                    Approve WO
                                                </a>
                                            @endif
                                        @else

                                        @endif
                                    </td>
                                    <td>
                                        @if($notification->sender && $notification->receiver)
                                            <a class="bg-info dropdown-item" href="{{route('admin.notification.detail',$notification->id)}}">
                                                Details
                                            </a>
                                        @else
                                            <span class="badge badge-danger">Deleted</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>SL</th>
                                <th>Sender</th>
                                <th>Receiver</th>
                                <th>Title</th>
                                {{--                                <th>Message</th>--}}
                                <th>Date</th>
                                <th>Seen Status</th>
                                <th>Details</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal html start--}}
        <div class="modal fade" id="payment_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" id="modal-content">

                </div>
            </div>
        </div>
    </section>

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
