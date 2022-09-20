@extends('frontend.layouts.master')
@section('title', 'Employee Edit Password')
@push('css')
@endpush
@section('content')
    <div class="full-row" style="background-color: #ffffff;">
        <div class="container">
            <div class="row">
                @include('frontend.employee.employee_breadcrumb')
                @include('frontend.employee.employee_sidebar')
                <div class="col-lg-9">
                    <h4>@lang('website.Edit Password')</h4>
                    <form class="woocommerce-form-login" action="{{route('employee.password-update')}}" method="POST" >
                        @csrf
                        <div class="row">
                            <p class="col-lg-6 col-md-6 col-12">
                                <label for="old_password">@lang('website.Old Password') <span class="required">*</span></label>
                                <input type="password" class="form-control" name="old_password" placeholder="@lang('website.Enter Old password')" style="background-color: #f3f3f3"/>
                            </p>
                        </div>
                        <div class="row">
                            <p class="col-lg-6 col-md-6 col-12">
                                <label for="password">@lang('website.New Password') <span class="required">*</span></label>
                                <input type="password" class="form-control" name="password" placeholder="@lang('website.Enter New Password')" minlength="8" style="background-color: #f3f3f3"/>
                            </p>
                        </div>
                        <div class="row">
                            <p class="col-lg-6 col-md-6 col-12">
                                <label for="confirm_password">@lang('website.Confirm New Password') <span class="required">*</span></label>
                                <input type="password" class="form-control" name="confirm_password" placeholder="@lang('website.Confirm New Password') " minlength="8" style="background-color: #f3f3f3"/>
                            </p>
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
