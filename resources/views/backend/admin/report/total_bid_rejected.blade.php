@extends('backend.layouts.master')
@section("title","Total Bid Rejected")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Total Bid Rejected</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Total Bid Rejected</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Report</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{route('admin.total-bid-rejected')}}" method="get">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="">From Date</label>
                                            <div class="">
                                                <input type="date" name="start_date" value="{{$start_date}}" class="form-control" id="inputEmail3">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="inputPassword3" class="">To Date</label>
                                            <input type="date" name="end_date" value="{{$end_date}}" class="form-control" id="inputPassword3">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a  href="{{route('admin.total-bid-rejected')}}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
                <!-- right column -->
                <div class="col-md-6">

                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title float-left">Total Rejected Bids</h3>
                        <div class="float-right">
                            <div>
                                @if(Auth::User()->user_type == 'admin')
                                    {{--                                    <a href="{{URL('admin/total-bid-accepted-export/'.$start_date.'/'.$end_date)}}" target="_blank">--}}
                                    {{--                                        <button class="btn btn-info text-center" style="">Excel</button>--}}
                                    {{--                                    </a>--}}
                                    {{--                                    <a href="{{URL('admin/total-bid-accepted-pdf/'.$start_date.'/'.$end_date)}}" target="_blank">--}}
                                    {{--                                        <button class="btn btn-primary text-center" style="">PDF</button>--}}
                                    {{--                                    </a>--}}
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead style="background-color: #3eb7ba;">
                            <tr>
                                <th>#SL</th>
                                <th>Bidder Name</th>
                                <th>Product Name</th>
                                <th>Bid Sender Name</th>
                                <th>Bid Sender Phone</th>
                                <th>Bid Receiver Name</th>
                                <th>Bid Receiver Phone</th>
                                <th>Bid Unit Price</th>
                                <th>Bid Total Price</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($totalRejectedBids as $key=> $totalRejectedBid)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$totalRejectedBid->sender->name}}</td>
                                    <td>
                                        @if($totalRejectedBid->product && $totalRejectedBid->product->user_type == 'seller')
                                            <a href="{{url('admin/seller-product-individual/'.$totalRejectedBid->product->user_id.'/'.$totalRejectedBid->product_id)}}" target="_blank">{{$totalRejectedBid->product->name}}</a>
                                        @elseif($totalRejectedBid->product && $totalRejectedBid->product->user_type == 'buyer')
                                            <a href="{{url('admin/buyer-product-individual/'.$totalRejectedBid->product->user_id.'/'.$totalRejectedBid->product_id)}}" target="_blank">{{$totalRejectedBid->product->name}}</a>
                                        @endif
                                    </td>
                                    <td>{{$totalRejectedBid->sender->name}}</td>
                                    <td>{{$totalRejectedBid->sender->country_code}}{{$totalRejectedBid->sender->phone}}</td>
                                    <td>{{$totalRejectedBid->receiver->name}}</td>
                                    <td>{{$totalRejectedBid->receiver->country_code}}{{$totalRejectedBid->receiver->phone}}</td>
                                    <td>{{$totalRejectedBid->unit_bid_price}}</td>
                                    <td>{{$totalRejectedBid->total_bid_price}}</td>
                                    <td>{{date('dS M, Y H:i:s a',strtotime($totalRejectedBid->updated_at))}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#SL</th>
                                <th>Bidder Name</th>
                                <th>Product Name</th>
                                <th>Bid Sender Name</th>
                                <th>Bid Sender Phone</th>
                                <th>Bid Receiver Name</th>
                                <th>Bid Receiver Phone</th>
                                <th>Bid Unit Price</th>
                                <th>Bid Total Price</th>
                                <th>Date</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="tile-footer text-right">
                        <h3><strong><span style="margin-right: 50px;">Total Bids: {{$totalRejectedBids->count()}}</span></strong></h3>
                    </div>
                    <!-- /.card-body -->
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
