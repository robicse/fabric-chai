@extends('backend.layouts.master')
@section("title","Add Membership Package Detail")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/select2/select2.min.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Membership Package Detail</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Add Membership Package Detail</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-8 offset-2">
            <!-- general form elements -->
                <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title float-left">Add Membership Package Detail</h3>
                    <div class="float-right">
                        <a href="{{route('admin.membership-package-details.index')}}">
                            <button class="btn btn-success">
                                <i class="fa fa-backward"> </i>
                                Back
                            </button>
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" action="{{route('admin.membership-package-details.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="membership_package_id">Package Name</label>
                            <select name="membership_package_id" id="membership_package_id" class="form-control select2">
                                @foreach($membership_packages as $membership_package)
                                    <option value="{{$membership_package->id}}">{{$membership_package->package_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="buy">Buy</label>
                            <input type="text" class="form-control" name="buy" id="buy" required>
                        </div>
                        <div class="form-group">
                            <label for="sell">Sell</label>
                            <input type="text" class="form-control" name="sell" id="sell" required>
                        </div>
                        <div class="form-group">
                            <label for="commission">Commission%</label>
                            <input type="text" class="form-control" name="commission" id="commission" required>
                        </div>
                        <div class="form-group">
                            <label for="job">Job</label>
                            <input type="text" class="form-control" name="job" id="job" required>
                        </div>
                        <div class="form-group">
                            <label for="free_sms">Free SMS</label>
                            <input type="text" class="form-control" name="free_sms" id="free_sms" required>
                        </div>
                        <div class="form-group">
                            <label for="work_order">Work Order</label>
                            <input type="text" class="form-control" name="work_order" id="work_order" required>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </section>

@stop
@push('js')
    <script src="{{asset('backend/plugins/select2/select2.full.min.js')}}"></script>
    <script>
        //Initialize Select2 Elements
        $('.select2').select2();
        /*$('.textarea').wysihtml5({
            toolbar: { fa: true }
        })*/
    </script>
@endpush
