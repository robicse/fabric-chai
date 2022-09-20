@extends('backend.layouts.master')
@section("title","Seller Commission Due")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Seller Commission Due</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Seller Commission Due</li>

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
                        <h3 class="card-title float-left">Commission Due List</h3>
                        <div class="float-right">
{{--                            <div>--}}
{{--                                <a href="{{route('admin.commission-report-export')}}">--}}
{{--                                    <button class="btn btn-info text-center" style="">Excel</button>--}}
{{--                                </a>--}}
{{--                                <a href="{{route('admin.commission-report-pdf')}}">--}}
{{--                                    <button class="btn btn-info text-center" style="">PDF</button>--}}
{{--                                </a>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead style="background-color: #3eb7ba;">
                            <tr>
                                <th>#SL</th>
                                <th>Seller Name</th>
                                <th>Seller Phone</th>
                                <th>Invoice No.</th>
                                <th>Total Sale</th>
                                <th>Commission</th>
                                <th>Vat</th>
                                <th>Total Commission</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($seller_commission_due_lists as $key => $seller_commission_due_list)
                                @php
                                    $seller = \App\User::where('id',$seller_commission_due_list->seller_user_id)->first();
                                $paymentHistory = \App\Model\PaymentHistory::where('sale_record_id',$seller_commission_due_list->id)->first();
                                @endphp

                                @if(empty($paymentHistory) || $paymentHistory->payment_status != 'Paid')
                                <tr>
                                    <td>
                                        {{$key + 1}}
                                    </td>
                                    <td>{{$seller->name}}</td>
                                    <td>{{0 .$seller->phone}}</td>
                                    <td>{{$seller_commission_due_list->invoice_code}}</td>
                                    <td>{{$seller_commission_due_list->amount}}</td>
                                    <td>{{$seller_commission_due_list->commission}}</td>
                                    <td>{{$seller_commission_due_list->vat}}</td>
                                    <td>{{$seller_commission_due_list->admin_commission}}</td>
                                    <td>
                                        <a class="btn btn-success" onclick="show_payment_modal('{{$seller_commission_due_list->seller_user_id}}','{{$seller_commission_due_list->invoice_code}}')" data-toggle="modal" data-target="#exampleModal">Pay Manually</a>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#SL</th>
                                <th>Seller Name</th>
                                <th>Seller Phone</th>
                                <th>Invoice No.</th>
                                <th>Total Sale</th>
                                <th>Commission</th>
                                <th>Vat</th>
                                <th>Total Commission</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="payment_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="modal-content">

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
    <script>
        function show_payment_modal(id,invoice_code){
            $.post('{{ route('admin.commission-report-modal') }}',{_token:'{{ @csrf_token() }}', id:id, invoice_code:invoice_code}, function(data){

                $('#payment_modal #modal-content').html(data);
                $('#payment_modal').modal('show', {backdrop: 'static'});
            });
        }
    </script>


@endpush
