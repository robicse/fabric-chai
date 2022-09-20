@extends('frontend.layouts.master')
@section('title', 'Buyer Edit Profile')
@push('css')
@endpush
@section('content')
    <div class="full-row" style="background-color: #ffffff;">
        <div class="container">
            <div class="row">
                @include('frontend.buyer.buyer_breadcrumb')
                @include('frontend.buyer.buyer_sidebar')
                <div class="col-lg-9">
                    <h4>@lang('website.Edit Profile')</h4>
                    <form class="woocommerce-form-login" action="{{route('buyer.profile-update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <p class="col-lg-6 col-md-6 col-12">
                                <label for="name">@lang('website.Name') <span class="required">*</span></label>
                                <input type="text" class="form-control" name="name" value="{{Auth::User()->name}}" id="name" style="background-color: #f3f3f3"/>
                            </p>
                            <p class="col-lg-6 col-md-6 col-12">
                                <label for="email"> @lang('website.Email Address')&nbsp;</label>
                                <input type="email" class="form-control" name="email" value="{{Auth::User()->email}}" id="" style="background-color: #f3f3f3"/>
                            </p>
                            <div class="col-lg-6 col-md-6 col-12 mb-5">
                                <div class="form-group">
                                    <label>@lang('website.Profile Image') </label>
                                    <input type="file"  name="avatar_original" class="form-control"  >
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="woocommerce-form-login__submit btn btn-primary rounded-0" >@lang('website.Update')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')

@endpush

