@extends('backend.layouts.master')
@section("title","Seller Profile")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">

@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Seller Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Seller Profile</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                @if(!empty($sellerInfo->avatar_original))
                                    <img class="profile-user-img img-fluid img-circle"
                                         src="{{url($sellerInfo->avatar_original)}}" alt="User profile picture">
                                @else
                                    <img class="profile-user-img img-fluid img-circle"
                                         src="{{asset('uploads/profile/default.png')}}" alt="User profile picture">
                                @endif
                            </div>

                            <h3 class="profile-username text-center">{{$sellerInfo->name}}</h3>

                            <p class="text-muted text-center">{{$sellerInfo->user_type}}</p>
                            @php
                                $userChainInformation = userChainInformation($sellerInfo->id);
                                 //dd($userChainInformation);
                            @endphp

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Total Products</b> <a class="float-right">{{$userChainInformation['totalSellerProductCount']}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Total Sold Amount</b> <a class="float-right">{{$userChainInformation['sumSellerProductAmount']}}</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#seller_info" data-toggle="tab">Seller
                                        Info</a></li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('admin.seller-profile-edit',encrypt($sellerInfo->id))}}">Edit
                                        Profile
                                    </a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#change_pass" data-toggle="tab">Change Password</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="seller_info">
                                    <form class="form-horizontal">
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{$sellerInfo->name}}" class="form-control" id="inputName" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Phone</label>
                                            <div class="col-sm-10">
                                                <input type="email" value="{{$sellerInfo->phone}}" class="form-control" id="inputEmail" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" value="{{$sellerInfo->email}}" class="form-control" id="inputEmail" readonly>
                                            </div>
                                        </div>
                                        {{--                                        <div class="form-group row">--}}
                                        {{--                                            <label for="inputEmail" class="col-sm-2 col-form-label">Shop Name</label>--}}
                                        {{--                                            <div class="col-sm-10">--}}
                                        {{--                                                <input type="email" value="{{$shopInfo->name}}" class="form-control" id="inputEmail" readonly>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}

                                        <div class="form-group row">
                                            <label for="address" class="col-sm-2 col-form-label">Seller Address</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{$sellerInfo->address}}" class="form-control" id="address" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="address" class="col-sm-2 col-form-label">Company Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{$sellerInfo->seller->company_name}}" class="form-control" id="address" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="address" class="col-sm-2 col-form-label">Company Phone</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{$sellerInfo->seller->company_phone}}" class="form-control" id="address" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="address" class="col-sm-2 col-form-label">Company Email</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{$sellerInfo->seller->company_email}}" class="form-control" id="address" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="address" class="col-sm-2 col-form-label">Company Address</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{$sellerInfo->seller->company_address}}" class="form-control" id="address" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label ml-3">Trade Licence Image</label>
                                            <div class="col-sm-10">
                                                <div class="row" id="trade_licence" style="background-color: #fff;">
                                                    @if ($sellerInfo->seller->trade_licence)
                                                        <div class="col-md-4 col-sm-4 col-xs-6">
                                                            <div class="img-upload-preview">
                                                                <a href="{{ url($sellerInfo->seller->trade_licence) }}"> <img loading="lazy"  src="{{ url($sellerInfo->seller->trade_licence) }}" alt="" class="img-responsive"> </a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <p>Image not found</p>
                                                    @endif
                                                </div>
                                                <div class="row" id="trade_licence_alt"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row" style="background-color: #fff;">
                                            <label class="control-label ml-3">National ID Image (Front)</label>
                                            <div class="col-sm-10">
                                                <div class="row" id="nid_front">
                                                    @if ($sellerInfo->seller->nid_front != null)
                                                        <div class="col-md-4 col-sm-4 col-xs-6">
                                                            <div class="img-upload-preview">
                                                                <a href="{{ url($sellerInfo->seller->nid_front) }}"> <img loading="lazy"  src="{{ url($sellerInfo->seller->nid_front) }}" alt="" class="img-responsive"></a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <p>Image not found</p>
                                                    @endif
                                                </div>
                                                <div class="row" id="nid_alt"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row" style="background-color: #fff;">
                                            <label class="control-label ml-3">National ID Image (Back)</label>
                                            <div class="col-sm-10">
                                                <div class="row" id="nid_back">
                                                    @if ($sellerInfo->seller->nid_back != null)
                                                        <div class="col-md-4 col-sm-4 col-xs-6">
                                                            <div class="img-upload-preview">
                                                                <a href="{{ url($sellerInfo->seller->nid_back) }}"> <img loading="lazy"  src="{{ url($sellerInfo->seller->nid_back) }}" alt="" class="img-responsive"></a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <p>Image not found</p>
                                                    @endif
                                                </div>
                                                <div class="row" id="nid_alt"></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>


                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="change_pass">
                                    <form class="form-horizontal" action="{{route('admin.seller.password.update',$sellerInfo->id)}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">New Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" name="password" class="form-control" id="inputName">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="confirm_password" class="col-sm-2 col-form-label">Confirm Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" name="confirm_password" class="form-control" id="confirm_password">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@stop
@push('js')
    <script src="{{asset('backend/plugins/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables/dataTables.bootstrap4.js')}}"></script>
    <script src="{{asset('backend/dist/js/spartan-multi-image-picker-min.js')}}"></script>

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
