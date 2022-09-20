@extends('backend.layouts.master')
@section("title","Edit Membership Package Other Benefits")
@push('css')

@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Membership Package Other Benefits</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Edit Membership Package Other Benefits</li>
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
                        <h3 class="card-title float-left">Edit Membership Package Detail</h3>
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
                    <form role="form" action="{{route('admin.membership-package-other-benefit.update',$membership_packages_other_benefit->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="membership_package_id">Package Name</label>
                                <select name="membership_package_id" id="membership_package_id" class="form-control select2">
                                    @foreach($membership_packages as $membership_package)
                                        <option value="{{$membership_package->id}}"{{$membership_package->id == $membership_packages_other_benefit->membership_package_id? 'selected' : ''}}>{{$membership_package->package_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="buy">Market Strategic Info. (@lang('website.Optional'))</label>
                                <input type="text" class="form-control" name="market_strategic" id="market_strategic" value="{{$membership_packages_other_benefit->market_strategic}}" required>
                            </div>
                            <div class="form-group">
                                <label for="sell">R&D facilities (@lang('website.Optional'))</label>
                                <input type="text" class="form-control" name="rd_facilities" id="rd_facilities" value="{{$membership_packages_other_benefit->rd_facilities}}" required>
                            </div>
                            <div class="form-group">
                                <label for="commission">Costing facilities (@lang('website.Optional'))</label>
                                <input type="text" class="form-control" name="costing_facilities" id="costing_facilities" value="{{$membership_packages_other_benefit->costing_facilities}}" required>
                            </div>
                            <div class="form-group">
                                <label for="job">Promotion facilities (@lang('website.Optional'))</label>
                                <input type="text" class="form-control" name="promotion_facilities" id="promotion_facilities" value="{{$membership_packages_other_benefit->promotion_facilities}}" required>
                            </div>
                            <div class="form-group">
                                <label for="free_sms">Bank loan facilities (@lang('website.Optional'))</label>
                                <input type="text" class="form-control" name="bank_loan_facilities" id="bank_loan_facilities" value="{{$membership_packages_other_benefit->bank_loan_facilities}}" required>
                            </div>
                            <div class="form-group">
                                <label for="work_order">Customer acquisition opportunity (@lang('website.Optional'))</label>
                                <input type="text" class="form-control" name="customer_acquisition_facilities" id="customer_acquisition_facilities" value="{{$membership_packages_other_benefit->customer_acquisition_facilities}}" required>
                            </div>
                            <div class="form-group">
                                <label for="work_order">Discount offers (@lang('website.Optional'))</label>
                                <input type="text" class="form-control" name="discount_offers" id="discount_offers" value="{{$membership_packages_other_benefit->discount_offers}}" required>
                            </div>

                            <div class="form-group">
                                <label for="work_order">Training facilities (@lang('website.Optional'))</label>
                                <input type="text" class="form-control" name="training_facility" id="training_facility" value="{{$membership_packages_other_benefit->training_facility}}" required>
                            </div>
                            <div class="form-group">
                                <label for="work_order">Ad discounts</label>
                                <input type="text" class="form-control" name="ad_discounts" id="ad_discounts" value="{{$membership_packages_other_benefit->ad_discounts}}" required>
                            </div>
                            <div class="form-group">
                                <label for="work_order">Credit facilities (@lang('website.Optional'))</label>
                                <input type="text" class="form-control" name="credit_facilities" id="credit_facilities" value="{{$membership_packages_other_benefit->credit_facilities}}" required>
                            </div>
                            <div class="form-group">
                                <label for="work_order">Loyalty Program (@lang('website.Optional'))</label>
                                <input type="text" class="form-control" name="loyalty_program" id="loyalty_program" value="{{$membership_packages_other_benefit->loyalty_program}}" required>
                            </div>
                            <div class="form-group">
                                <label for="work_order">Yarn price update (@lang('website.Optional'))</label>
                                <input type="text" class="form-control" name="yarn_price_update" id="yarn_price_update" value="{{$membership_packages_other_benefit->yarn_price_update}}" required>
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

@endpush
