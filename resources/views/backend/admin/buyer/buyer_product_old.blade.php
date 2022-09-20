@extends('backend.layouts.master')
@section("title","Buyer Requested Product List")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Buyer Requested Product List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Buyer Requested Product List</li>
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
                        <h3 class="card-title float-left">Buyer Requested Product Lists</h3>
                        <div class="float-right">
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#Id</th>
                                <th>Date Time</th>
                                <th>Buyer Name</th>
                                <th>Product Name</th>
                                <th>Product Image</th>
                                <th>Qty</th>
                                <th>Currency</th>
                                <th>Expected Price</th>
                                <th>Bid Status</th>
                                <th>Verification Status</th>
                                <th>Featured Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($buyerProductInfos as $key => $buyerProductInfo)

                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$buyerProductInfo->created_at}}</td>
                                    <td><a href="{{route('admin.buyer-profile',$buyerProductInfo->user_id)}}">{{$buyerProductInfo->user->name}}</a></td>
                                    <td>{{$buyerProductInfo->name}}</td>
                                    <td><img src="{{url($buyerProductInfo->thumbnail_img)}}" width="50" height="50"></td>
                                    @if($buyerProductInfo->category_id == 9 && $buyerProductInfo->sizingProduct)
                                        <td>{{$buyerProductInfo->sizingProduct->total_length}} Meter/Yards</td>
                                        <td>{{$buyerProductInfo->currency->name}}</td>
                                        <td>{{$buyerProductInfo->sizingProduct->total_price}}</td>
                                    @else
                                        <td>{{$buyerProductInfo->quantity}} {{$buyerProductInfo->unit ? $buyerProductInfo->unit->name : ''}}</td>
                                        <td>{{$buyerProductInfo->currency->name}}</td>
                                        <td>{{$buyerProductInfo->expected_price}}</td>
                                    @endif
                                    <td>{{$buyerProductInfo->bid_status}}</td>
                                    <td>
                                        <div class="form-group col-md-2">
                                            <label class="switch" style="margin-top:40px;">
                                                <input onchange="update_status1(this)" value="{{ $buyerProductInfo->id }}" {{$buyerProductInfo->verification_status == 1? 'checked':''}} type="checkbox" >
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group col-md-2">
                                            <label class="switch" style="margin-top:40px;">
                                                <input onchange="update_featured(this)" value="{{ $buyerProductInfo->id }}" {{$buyerProductInfo->featured_product == 1? 'checked':''}} type="checkbox" >
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @if($buyerProductInfo->category_id == 9 && $buyerProductInfo->sizingProduct)
                                                    <a class="bg-info dropdown-item" href="{{route('admin.sizing-products.edit',$buyerProductInfo->id)}}">
                                                        <i class="fa fa-edit "></i> Edit
                                                    </a>
                                                @elseif($buyerProductInfo->category_id == 7 && $buyerProductInfo->dyingProduct)
                                                    <a class="bg-info dropdown-item" href="{{route('admin.dying-products.edit',$buyerProductInfo->id)}}">
                                                        <i class="fa fa-edit "></i> Edit
                                                    </a>
                                                @else
                                                    <a class="bg-info dropdown-item" href="{{route('admin.buyer-requested-product.edit',$buyerProductInfo->id)}}">
                                                        <i class="fa fa-edit "></i> Edit
                                                    </a>
                                                @endif
                                                <a class="bg-info dropdown-item" href="{{route('admin.product.delete',$buyerProductInfo->id)}}">
                                                    <i class="fa fa-trash "></i> Delete
                                                </a>
                                                <a class="bg-info dropdown-item" href="{{route('admin.buyer-profile',$buyerProductInfo->user_id)}}">
                                                    <i class="fa fa-user"></i> Buyer Profile
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#Id</th>
                                <th>Date Time</th>
                                <th>Buyer Name</th>
                                <th>Product Name</th>
                                <th>Product Image</th>
                                <th>Qty</th>
                                <th>Currency</th>
                                <th>Expected Price</th>
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

        {{-- Modal html start--}}
        <div class="modal fade" id="payment_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" id="modal-content">

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
