@extends('backend.layouts.master')
@section("title","Monthly Earning Report")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Monthly Earning Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Monthly Earning Report</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
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
                        <form role="form" action="{{route('admin.monthly_report.value')}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">From Date</label>
                                    <div class="col-8">
                                        <input type="date" name="from_date" value="{{$from_date}}" class="form-control" id="inputEmail3">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">To Date</label>
                                    <div class="col-8">
                                        <input type="date" name="to_date" value="{{$to_date}}" class="form-control" id="inputPassword3">
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-secondary">Cancel</button>
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
    <!-- /.content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <div class="">
                            <a href="{{URL('admin/monthly-earning-report-export/'.$from_date.'/'.$to_date)}}">
                                <button class="btn btn-info text-center" style="">Excel</button>
                            </a>
                            <a href="{{URL('admin/monthly-earning-report-pdf/'.$from_date.'/'.$to_date)}}">
                                <button class="btn btn-info text-center" style="">PDF</button>
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead style="background-color: #3eb7ba;">
                            <tr>
                                <th>#Id</th>
                                <th>Name</th>
                                <th>Total Product Sold</th>
                                <th>Total Commission</th>
                                <th>Total Earning</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($monthly_reports != null)
                                @foreach($monthly_reports as $key => $monthly_report)
                                    @php
                                        $seller = \App\User::where('id',$monthly_report->seller_user_id)->first();

                                    @endphp
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$seller->name}}</td>
                                        <td>{{$monthly_report->total_product_sold}}</td>
                                        <td>{{getTotalCommissionAmountDateBetween($seller->id,$from_date, $to_date)}}</td>
                                        <td>{{getTotalCommissionPaidAmountDateBetween($seller->id,$from_date, $to_date)}}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#Id</th>
                                <th>Name</th>
                                <th>Total Product Sold</th>
                                <th>Total Commission</th>
                                <th>Total Earning</th>
                            </tr>
                            </tfoot>
                        </table>
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
