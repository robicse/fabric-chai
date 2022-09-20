@extends('frontend.layouts.master')
@section('title', 'Buyer Edit Password')
@push('css')
@endpush
@section('content')
    <div class="full-row" style="background-color: #ffffff;">
        <div class="container">
            <div class="row">
                @include('frontend.buyer.buyer_breadcrumb')
                @include('frontend.buyer.buyer_sidebar')
                <div class="col-lg-9">
                    <h4>@lang('website.Edit Password')</h4>
                    <form class="woocommerce-form-login" action="{{route('buyer.password-update')}}" method="POST" >
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <label for="old_password">@lang('website.Old Password') <span class="required">*</span></label>
                                <div class="form-group input-group mb-3 ">
                                    <input id="password-field1" type="password" placeholder="@lang('website.Enter Old password')" minlength="8" class="form-control" name="old_password" style="background-color: #f3f3f3" required >
                                    <span toggle="#password-field1" class="input-group-text toggle-password1" id="basic-addon2"><i id="test1" class="fa fa-eye"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <label for="old_password">@lang('website.New Password') <span class="required">*</span></label>
                                <div class="form-group input-group mb-3 ">
                                    <input id="password-field2" type="password" minlength="8" placeholder="@lang('website.Enter New Password')" class="form-control" name="password" style="background-color: #f3f3f3" required>
                                    <span toggle="#password-field2" class="input-group-text toggle-password2" id="basic-addon2"><i id="test2" class="fa fa-eye"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <label for="old_password">@lang('website.Confirm Password') <span class="required">*</span></label>
                                <div class="form-group input-group mb-3 ">
                                    <input id="password-field3" type="password" minlength="8" placeholder="@lang('website.Confirm New Password')" class="form-control" name="confirm_password" style="background-color: #f3f3f3" required>
                                    <span toggle="#password-field3" class="input-group-text toggle-password3" id="basic-addon2"><i id="test3" class="fa fa-eye"></i></span>
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
    <script>
        $(".toggle-password1").click(function() {
            $('#test1').toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $(".toggle-password2").click(function() {
            $('#test2').toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $(".toggle-password3").click(function() {
            $('#test3').toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>
@endpush
