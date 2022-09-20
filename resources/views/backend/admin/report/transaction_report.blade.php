@extends('backend.layouts.master')
@section("title","Transaction Report")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Transaction Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Transaction Report</li>
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
                            <h3 class="card-title">Transaction Report</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{route('admin.transaction-report.value')}}" method="POST">
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
                            <a href="{{URL('admin/transaction-report-export/'.$from_date.'/'.$to_date)}}">
                                <button class="btn btn-info text-center" style="">Excel</button>
                            </a>
                            <a href="{{URL('admin/transaction-report-pdf/'.$from_date.'/'.$to_date)}}">
                                <button class="btn btn-info text-center" style="">PDF</button>
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead style="background-color: #3eb7ba;">
                            <tr>
                                <th>#SL</th>
                                <th>Invoice NO</th>
                                <th>Seller Name</th>
                                <th>Transaction ID</th>
                                <th>Transaction Method</th>
                                <th>Currency</th>
                                <th>Commission Amount</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Payment Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($transaction_reports != null)
                                @foreach($transaction_reports as $key => $transaction_report)

                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$transaction_report->invoice_code}}</td>
                                        <td>{{$transaction_report->seller->name}}</td>
                                        <td>{{$transaction_report->transaction_id}}</td>
                                        <td>{{$transaction_report->payment_type}}</td>
                                        <td>{{$transaction_report->currency}}</td>
                                        <td>{{$transaction_report->amount}}</td>
                                        <td>{{$transaction_report->description}}</td>
                                        <td>{{date('j M Y h:i A',strtotime($transaction_report->updated_at))}}</td>
                                        <td>
                                            {{$transaction_report->payment_status}}
                                            @if($transaction_report->payment_status == 'Pending')
                                                <select class="form-control" name="payment_status" data-id="{{$transaction_report->id}}" onchange="payment_status(this,{{$transaction_report->id}})">
                                                    <option value="Pending">Pending</option>
                                                    <option value="Paid">Paid</option>
                                                </select>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#Id</th>
                                <th>Invoice NO</th>
                                <th>Seller Name</th>
                                <th>Transaction ID</th>
                                <th>Transaction Method</th>
                                <th>Currency</th>
                                <th>Commission Amount</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Payment Status</th>
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

        function payment_status(el,id){
            console.log(el.value);
            console.log(id);
            $.post('{{ route('admin.seller.payment.status') }}', {_token:'{{ csrf_token() }}', payment_status:el.value, id:id}, function(data){
                if(data == 1){
                    toastr.success('success', 'Payment Status updated successfully');
                }
                else{
                    //toastr.danger('danger', 'Something went wrong');
                }
            });
        }
    </script>

@endpush
