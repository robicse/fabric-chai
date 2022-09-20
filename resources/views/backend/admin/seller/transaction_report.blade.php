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
                    <h1>Partial Paid Transaction Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Partial Paid Transaction Report</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- /.content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <div class="">
{{--                            <a href="">--}}
{{--                                <button class="btn btn-info text-center" style="">Excel</button>--}}
{{--                            </a>--}}
{{--                            <a href="">--}}
{{--                                <button class="btn btn-info text-center" style="">PDF</button>--}}
{{--                            </a>--}}
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
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
                                        <td>{{date('j M Y h:i A',strtotime($transaction_report->created_at))}}</td>
                                        <td>
                                            {{$transaction_report->payment_status}}
                                            @if($transaction_report->payment_status == 'Partial Paid')
                                                <select class="form-control" name="payment_status" data-id="{{$transaction_report->id}}" onchange="payment_status(this,{{$transaction_report->id}})">
                                                    <option value="Partial Paid">Partial Paid</option>
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
                    location.reload();
                }
                else{
                    //toastr.danger('danger', 'Something went wrong');
                }
            });
        }
    </script>

@endpush
