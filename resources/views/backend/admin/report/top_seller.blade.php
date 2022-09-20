@extends('backend.layouts.master')
@section("title","Seller Report")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Best Seller Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Best Seller Report</li>
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
                        <h3 class="card-title float-left">Top Seller</h3>
                        <div class="float-right">
                            <div>
                                <a href="{{route('admin.top-seller-export')}}">
                                    <button class="btn btn-info text-center" style="">Excel</button>
                                </a>
                                <a href="{{route('admin.top-seller-pdf')}}">
                                    <button class="btn btn-info text-center" style="">PDF</button>
                                </a>
                            </div>
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
                                @foreach($reports as $key => $report)
                                    @php
                                        $seller = \App\User::where('id',$report->seller_user_id)->first();

                                    @endphp
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$seller->name}}</td>
                                        <td>{{$report->total_product_sold}}</td>
                                        <td>{{getTotalCommissionAmount($seller->id)}}</td>
                                        <td>{{getTotalCommissionPaidAmount($seller->id)}}</td>
                                    </tr>
                                @endforeach
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
