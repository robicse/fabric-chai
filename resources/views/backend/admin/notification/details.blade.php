@extends('backend.layouts.master')
@section("title","Notification Detail")
@push('css')

@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Notification Detail</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Notification Detail</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-8 offset-2">
                <!-- general form elements -->
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title float-left">Notification Detail</h3>
                        <div class="float-right">
                            <a href="{{route('admin.notification')}}">
                                <button class="btn btn-success">
                                    <i class="fa fa-backward"> </i>
                                    Back
                                </button>
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Sender</th>
                                <td>{{$notification->sender->name}}</td>
                            </tr>
                            <tr>
                                <th>Receiver</th>
                                <td>{{$notification->receiver->name}}</td>
                            </tr>
                            <tr>
                                <th>Title</th>
                                <td>{{$notification->title}}</td>
                            </tr>
                            <tr>
                                <th>Message</th>
                                <td>{{$notification->message}}</td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td>{{date('j M Y h:i A',strtotime($notification->created_at))}}</td>
                            </tr>
                            @if($notification->title == 'Seller Registration')
                                @if(checkSellerApproved($notification->sender_user_id) == 0)
                                    <tr>
                                        <th>For Approval</th>
                                        <td>
                                            <a class="btn btn-success" href="{{route('admin.individual-seller',$notification->sender_user_id)}}">
                                                Go Seller Approved
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            @elseif($notification->title == 'Buyer Registration')
                                @if(checkBuyerApproved($notification->sender_user_id) == 0)
                                    <tr>
                                        <th>For Approval</th>
                                        <td>
                                            <a class="btn btn-success" href="{{route('admin.individual-buyer',$notification->sender_user_id)}}">
                                                Go Buyer Approved
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            @elseif($notification->title == 'Seller Product Entry')
                                @if(checkProductApproved($notification->product_id) == 0)
                                    <tr>
                                        <th>For Approval</th>
                                        <td>
                                            <a class="btn btn-success" href="{{url('admin/seller-product-individual/'.$notification->sender_user_id.'/'.$notification->product_id)}}">
                                                Go Seller Product Approved
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            @elseif($notification->title == 'Buyer Product Entry')
                                @if(checkProductApproved($notification->product_id) == 0)
                                    <tr>
                                        <th>For Approval</th>
                                        <td>
                                            <a class="btn btn-success" href="{{url('admin/buyer-product-individual/'.$notification->sender_user_id.'/'.$notification->product_id)}}">
                                                Go Buyer Product Approved
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            @else

                            @endif
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </section>

@stop
@push('js')

@endpush
