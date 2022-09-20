@extends('frontend.layouts.master')
@section('title', 'Buyer Profile')
@push('css')
@endpush
@section('content')
    <div class="full-row" style="background-color: #ffffff;">
        <div class="container">
            <div class="row">
                @include('frontend.buyer.buyer_breadcrumb')
                @include('frontend.buyer.buyer_sidebar')
                <div class="col-lg-9">
                    <h4 class="text-center">@lang('website.Profile')</h4>
                    @php
                        $days = \Carbon\Carbon::parse(Auth::User()->created_at)->diffInDays(\Carbon\Carbon::now());
                     $complete_bids = \App\Model\ProductBid::where('sender_user_id',Auth::User()->id)->where('bid_status',1)->count();
                     $reviews = \App\Model\Review::where('receiver_user_id',Auth::User()->id)->count();
                    @endphp
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-6 pb-2">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{getNumberToBangla($days)}}</h5>
                                    <p>@lang('website.Experience') (@lang('website.Days'))</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-6 pb-2">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{getNumberToBangla($complete_bids)}}</h5>
                                    <p>@lang('website.Completed Bids')</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-6 pb-2">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{getNumberToBangla($reviews)}}</h5>
                                    <p>@lang('website.Reviews')</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-6 pb-2">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{getNumberToBangla(userRating(Auth::User()->id))}}</h5>
                                    <p>@lang('website.Ratings')</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="" style="padding-top: 20px; padding-left: 10px;">
                        <div class="row">
                            <div class="card col-lg-6 col-md-6 col-12">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>@lang('website.Name'):</td>
                                        <td>{{getNameByBnEn(Auth::User())}}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('website.Email'):</td>
                                        <td>{{Auth::User()->email}}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('website.Phone'):</td>
                                        <td>{{getNumberToBangla(Auth::User()->country_code.Auth::User()->phone)}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="padding-top: 40px;">
                        <div class="col-lg-4 col-md-4 col-5">
                            <a class="btn btn-primary" href="{{route('buyer.edit-profile')}}">@lang('website.Edit Profile') </a>
                        </div>
                        <div class="col-lg-4 col-md-4 col-7">
                            <form action="{{route('password-update.otp-send')}}" method="POST">
                                @csrf
                                <input type="hidden" name="phone" value="{{Auth::User()->phone}}">
                                <button type="submit" class="woocommerce-form-login__submit btn btn-primary rounded-0" style="background-color: purple" >
                                    @lang('website.Change Password')
                                </button>
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

