@extends('frontend.layouts.master')
@section('title', 'Buyer Edit Profile')
@push('css')
@endpush
@section('content')
    <div class="full-row" style="background-color: #ffffff;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-3">
                    <h3 class="mb-2 text-secondary">Buyer Work Order</h3>
                </div>
                @include('frontend.buyer.work_order_sidebar')
                <div class="col-lg-9" style="background: #fff">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="card-title float-left">
                                        Edit Profile
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="woocommerce-form-login" action="{{route('buyer.work-order.profile-update')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <p class="col-lg-6 col-md-6 col-12">
                                        <label for="name">Name <span class="required">*</span></label>
                                        <input type="text" class="form-control" name="name" value="{{Auth::User()->name}}" id="name"/>
                                    </p>
                                    <p class="col-lg-6 col-md-6 col-12">
                                        <label for="email"> Email address&nbsp;</label>
                                        <input type="email" class="form-control" name="email" value="{{Auth::User()->email}}" id="" />
                                    </p>
                                    <p class="col-lg-6 col-md-6 col-12">
                                        <label for="phone">Address</label>
                                        <input type="text" class="form-control" name="address" value="{{Auth::User()->address}}" id="address" style="color: black;" >
                                    </p>
                                    <div class="col-lg-6 col-md-6 col-12 mb-5" style="margin-top: 6px">
                                        <div class="form-group">
                                            <label>Profile Image </label>
                                            <input type="file"  name="avatar_original" class="form-control"  >
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="woocommerce-form-login__submit btn btn-primary rounded-0" >Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')

@endpush

