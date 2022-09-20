@extends('backend.layouts.master')
@section("title","Sales Report")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sales Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Sales Report</li>

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
                        <h3 class="card-title float-left">Sales Report</h3>
                        <div class="float-right">
                            <div>
                                <a href="{{route('admin.sale-report-export')}}">
                                    <button class="btn btn-info text-center" style="">Excel</button>
                                </a>
                                <a href="{{route('admin.sale-report-pdf')}}">
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
                                <th>#SL</th>
                                <th>Product Name</th>
                                <th>Seller Name</th>
                                <th>Buyer Name</th>
                                <th>Buyer Amount</th>
                                <th>Buyer Rating</th>
                                <th>Buyer Status</th>
                                <th>Seller Rating</th>
                                <th>Action</th>
                                <th>Invoice</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sale_records as $key => $sale_record)
                                @php
                                $seller = \App\User::where('id',$sale_record->seller_user_id)->first();
                                $buyer = \App\User::where('id',$sale_record->buyer_user_id)->first();
                                @endphp

                                <tr>
                                    <td>
                                        {{$key + 1}}
                                    </td>
                                    <td>
                                        {{$sale_record->product->name}}
                                    </td>
                                    <td>{{$seller->name}}</td>
                                    <td>{{$buyer->name}}</td>
                                    <td>{{$sale_record->amount}}</td>
                                    <td>{{getProductRatingSellerGiven($sale_record->buyer_user_id,$sale_record->product_id) ? getProductRatingSellerGiven($sale_record->buyer_user_id,$sale_record->product_id) : 0}}</td>
                                    <td>
                                        @if(getProductRatingSellerGiven($sale_record->buyer_user_id,$sale_record->product_id) >= 1)
                                            <button class="btn btn-success">Complete</button>
                                        @else
                                            <button class="btn btn-warning">In-Complete</button>
                                        @endif

                                    </td>
                                    <td>
{{--                                        {{userRating($sale_record->seller_user_id)}}--}}
                                        {{getProductRatingSellerGiven($sale_record->seller_user_id,$sale_record->product_id) ? getProductRatingSellerGiven($sale_record->seller_user_id,$sale_record->product_id) : 0}}
                                    </td>
                                    <td>
                                        <a class="btn btn-info" onclick="show_details_modal('{{$sale_record->id}}');" data-toggle="modal" data-target="#exampleModal">Details</a>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary" title="Print" href="{{route('admin.sale-record.print',encrypt($sale_record->id))}}"><i class="fa fa-print"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#SL</th>
                                <th>Product Name</th>
                                <th>Seller Name</th>
                                <th>Buyer Name</th>
                                <th>Buyer Amount</th>
                                <th>Buyer Rating</th>
                                <th>Buyer Status</th>
                                <th>Seller Rating</th>
                                <th>Action</th>
                                <th>Invoice</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="details_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
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

        function show_details_modal(id){
            $.post('{{ route('admin.sale-report.details') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
                $('#details_modal #modal-content').html(data);
                $('#details_modal').modal('show', {backdrop: 'static'});
            });
        }
    </script>
@endpush
