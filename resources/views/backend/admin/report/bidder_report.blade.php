@extends('backend.layouts.master')
@section("title","Bidder  Report")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Bidder List Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Bidder List Report</li>
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
                        <form role="form" action="{{route('admin.bidder-list-report')}}" method="get">
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
                                <a href="{{route('admin.bidder-list-report')}}" type="reset" class="btn btn-secondary">Cancel</a>
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
                        <h3 class="card-title float-left">Bidder Report</h3>
                        <div class="float-right">
                            <div>
                                @if(Auth::User()->user_type == 'admin')

                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        @if($bidders->isNotEmpty())


                        <table id="example1" class="table table-bordered table-striped">
                            <thead style="background-color: #3eb7ba;">
                            <tr>
                                <th>#SL</th>
                                <th>Bidder Name</th>
                                <th>Bidder Phone</th>
                                <th>Bidder Email</th>
                                <th>Receiver Name</th>
                                <th>Receiver Phone</th>
                                <th>Receiver Email</th>
                                <th>Product Name</th>
                                <th>Unit Bid Price</th>
                                <th>Total Bid Price</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bidders as  $bidder)
                            <tr>
                                <td>{{$loop->index + 1}}</td>
                                <td>{{$bidder->sender->name}}</td>
                                <td>{{$bidder->sender->country_code}}{{$bidder->sender->phone}}</td>
                                <td>{{$bidder->sender->email}}</td>
                                <td>{{$bidder->receiver->name}}</td>
                                <td>{{$bidder->receiver->country_code}}{{$bidder->receiver->phone}}</td>
                                <td>{{$bidder->receiver->email}}</td>
                                <td>{{$bidder->product->name}}</td>
                                <td>{{$bidder->unit_bid_price}}</td>
                                <td>{{$bidder->total_bid_price}}</td>
                                <td>{{date('dS M, Y H:i:s a',strtotime($bidder->updated_at))}}</td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#SL</th>
                                <th>Bidder Name</th>
                                <th>Bidder Phone</th>
                                <th>Bidder Email</th>
                                <th>Receiver Name</th>
                                <th>Receiver Phone</th>
                                <th>Receiver Email</th>
                                <th>Product Name</th>
                                <th>Unit Bid Price</th>
                                <th>Total Bid Price</th>
                                <th>Date</th>
                            </tr>
                            </tfoot>
                        </table>
                        @else
                        <div>
                            <h2 class="text-center">No Bidder found</h2>
                        </div>
                        @endif
                    </div>

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
