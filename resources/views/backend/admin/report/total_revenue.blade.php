@extends('backend.layouts.master')
@section("title","Total Revenue/Commission ")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Total Revenue/Commission </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Total Revenue/Commission</li>
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
                        <form role="form" action="{{route('admin.total-revenue')}}" method="get">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Sale Type</label>
                                            <select name="sale_type" class="form-control">
                                                <option value="buy" {{$sale_type == 'buy' ? 'selected':''}}>Buy</option>
                                                <option value="sell" {{$sale_type == 'sell' ? 'selected':''}}>Sell</option>
                                                <option value="wo" {{$sale_type == 'wo' ? 'selected':''}}>Work Order</option>
                                                {{-- <option value="mp" {{$sale_type == 'mp' ? 'selected':''}}>Membership Package</option> --}}
                                            </select>
                                        </div>

                                    </div>
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
                                <a href="{{route('admin.total-revenue')}}" type="reset" class="btn btn-secondary">Cancel</a>
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
                        <h3 class="card-title float-left">Total Revenue</h3>
                        <div class="float-right">
                            <div>
                                @if(Auth::User()->user_type == 'admin')
                                    {{--                                    <a href="{{URL('admin/total-revenue-export/'.$start_date.'/'.$end_date.'/'.$sale_type)}}" target="_blank">--}}
                                    {{--                                        <button class="btn btn-info text-center" style="">Excel</button>--}}
                                    {{--                                    </a>--}}
                                    {{--                                    <a href="{{URL('admin/total-revenue-pdf/'.$start_date.'/'.$end_date.'/'.$sale_type)}}" target="_blank">--}}
                                    {{--                                        <button class="btn btn-primary text-center" style="">PDF</button>--}}
                                    {{--                                    </a>--}}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead style="background-color: #3eb7ba;">
                        <tr>
                            <th>#SL</th>
                            <th>Name</th>
                            @if( $sale_type == 'buy' || $sale_type == 'sell')
                            <th>Company Name</th>
                            @endif
                            <th>Phone</th>
                            @if( $sale_type == 'buy' || $sale_type == 'sell')
                                <th>Product Name</th>
                            @endif
                            <th>Commission Amount</th>
                            <th>Commission Status</th>
                            <th>Date</th>
                            @if( $sale_type == 'buy' || $sale_type == 'sell')
                                <th>Invoice</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($totalSales as $key=> $totalSale)
                            <tr>
                                <td>{{$key + 1}}</td>
                                @if($sale_type == 'buy')
                                    @php
                                        $user = \App\User::find($totalSale->buyer_user_id);
                                    @endphp
                                    <td>{{$user ? $user->name :''}}</td>
                                    <td>{{$user->seller? $user->seller->company_name :''}}</td>
                                    <td>{{$user ? $user->country_code.$user->phone :''}}</td>
                                @elseif($sale_type == 'mp')
                                    @php
                                        $user = \App\User::find($totalSale->user_id);
                                    @endphp
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->country_code.$user->phone}}</td>
                                @else
                                    @php
                                        $user = \App\User::find($totalSale->seller_user_id);
                                    @endphp
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->seller->company_name}}</td>
                                    <td>{{$user->country_code.$user->phone}}</td>
                                @endif
                                @if( $sale_type == 'buy' || $sale_type == 'sell')
                                    @php
                                        $product = \App\Model\Product::find($totalSale->product_id);
                                    @endphp
                                    <td>
                                        @if( $sale_type == 'buy')
                                            <a href="{{url('admin/buyer-product-individual/'.$product->user_id.'/'.$product->id)}}" target="_blank">
                                                {{$product->name}}
                                            </a>
                                        @else
                                            <a href="{{url('admin/seller-product-individual/'.$product->user_id.'/'.$product->id)}}" target="_blank">
                                                {{$product->name}}
                                            </a>
                                        @endif
                                    </td>
                                @endif
                                <td>
                                    @if($sale_type == 'mp')
                                        {{$totalSale->amount_after_getaway_fee}}
                                    @else
                                        {{$totalSale->commission}}
                                    @endif
                                </td>
                                <td>
                                    {{$totalSale->payment_status}}
                                </td>
                                <td>{{date('dS M, Y H:i:s a',strtotime($totalSale->updated_at))}}</td>
                                @if( $sale_type == 'buy' || $sale_type == 'sell')
                                    <td>
                                        <a class="btn btn-success waves-effect" href="{{route('admin.sale_invoice',['id'=>encrypt($totalSale->id),'sale_type'=>$sale_type] )}}" target="_blank">
                                            <i class="fa fa-print"></i>
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>#SL</th>
                            <th>Name</th>
                            @if( $sale_type == 'buy' || $sale_type == 'sell')
                                <th>Company Name</th>
                            @endif
                            <th>Phone</th>
                            @if( $sale_type == 'buy' || $sale_type == 'sell')
                                <th>Product Name</th>
                            @endif
                            <th>Commission Amount</th>
                            <th>Commission Status</th>
                            <th>Date</th>
                            @if( $sale_type == 'buy' || $sale_type == 'sell')
                                <th>Invoice</th>
                            @endif
                        </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="tile-footer text-right">

                    @if($sale_type == 'mp')
                        @php
                            $paid = $totalSales->where('payment_status','Paid')->sum('amount_after_getaway_fee');
                            $due = $totalSales->where('payment_status','!=','Paid')->sum('amount_after_getaway_fee');
                            $total = $totalSales->sum('amount_after_getaway_fee');
                        @endphp
                    @else
                        @php
                            $paid = $totalSales->where('payment_status','Paid')->sum('commission');
                            $due = $totalSales->where('payment_status','!=','Paid')->sum('commission');
                            $total = $totalSales->sum('commission');
                        @endphp

                    @endif
                    <h4><strong><span style="margin-right: 50px;">Total Revenue Number: {{$totalSales->count()}}</span></strong></h4>
                    <h4><strong><span style="margin-right: 50px;">Total Revenue Paid Amount: ৳{{ceil($paid)}}</span></strong></h4>
                    <h4><strong><span style="margin-right: 50px;">Total Revenue Due Amount: ৳{{ceil($due)}}</span></strong></h4>
                    <h4><strong><span style="margin-right: 50px;">Total Revenue Amount: ৳{{ceil($total)}}</span></strong></h4>
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
