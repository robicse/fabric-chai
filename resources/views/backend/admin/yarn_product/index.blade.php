@extends('backend.layouts.master')
@section("title","Yarn Product List")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Yarn Product List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Yarn Product List</li>
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
                        <h3 class="card-title float-left">Yarn Product Lists</h3>
                        <div class="float-right">
                            <a href="{{route('admin.yarn-product.create')}}">
                                <button class="btn btn-success">
                                    <i class="fa fa-plus-circle"></i>
                                    Add
                                </button>
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#SL</th>
                                <th>Date Time</th>
                                <th>Seller Name</th>
                                <th>Product Name</th>
                                <th>Product Image</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>Currency</th>
                                <th>Expected Bid</th>
                                <th>Bid Status</th>
                                <th>Verification Status</th>
                                <th>Featured Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $key => $product)

                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$product->created_at}}</td>
                                    <td>{{$product->user->name}}</td>
                                    <td>{{$product->name}}</td>
                                    <td><img src="{{url($product->thumbnail_img)}}" width="50" height="50"></td>
                                    <td>{{$product->quantity}}</td>
                                    <td>{{$product->unit->name}}</td>
                                    <td>{{$product->currency->name}}</td>
                                    <td>{{$product->expected_price}}</td>
                                    <td>{{$product->bid_status}}</td>
                                    <td>
                                        <div class="form-group col-md-2">
                                            <label class="switch" style="margin-top:40px;">
                                                <input onchange="update_status1(this)" value="{{ $product->id }}" {{$product->verification_status == 1? 'checked':''}} type="checkbox" >
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group col-md-2">
                                            <label class="switch" style="margin-top:40px;">
                                                <input onchange="update_featured(this)" value="{{ $product->id }}" {{$product->featured_product == 1? 'checked':''}} type="checkbox" >
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <a class="bg-info dropdown-item" href="{{route('admin.yarn-product.edit',$product->id)}}">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        {{--                                        <a class="bg-info dropdown-item" href="#">--}}
                                        {{--                                            <i class="fa fa-edit"></i> Edit--}}
                                        {{--                                        </a>--}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#SL</th>
                                <th>Date Time</th>
                                <th>Seller Name</th>
                                <th>Product Name</th>
                                <th>Product Image</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>Currency</th>
                                <th>Expected Bid</th>
                                <th>Bid Status</th>
                                <th>Verification Status</th>
                                <th>Featured Status</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
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

        //update status
        function update_status1(el){
            if(el.checked){
                var verification_status = 1;
            }
            else{
                var verification_status = 0;
            }
            $.post('{{ route('admin.seller-product.status') }}', {_token:'{{ csrf_token() }}', id:el.value, verification_status:verification_status}, function(data){
                if(data == 1){
                    toastr.success('success', 'Product verification Status updated successfully');
                }
                else{
                    toastr.danger('danger', 'Something went wrong');
                }
                location.reload();
            });
        }
        function update_featured(el){
            if(el.checked){
                var featured_status = 1;
            }
            else{
                var featured_status = 0;
            }
            $.post('{{ route('admin.featured-product.status') }}', {_token:'{{ csrf_token() }}', id:el.value, featured_status:featured_status}, function(data){
                if(data == 1){
                    toastr.success('success', 'Product featured Status updated successfully');
                }
                else{
                    toastr.danger('danger', 'Something went wrong');
                }
                location.reload();
            });
        }
    </script>
@endpush
