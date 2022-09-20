@extends('frontend.layouts.master')
@section("title","Bidder Details")
@push('css')
    <style>
        .p{
            color: black;
        }
    </style>
@endpush
@section('content')
    <!-- Main content -->
    <div class="full-row" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                @include('frontend.seller.seller_breadcrumb')
                @include('frontend.seller.seller_sidebar')
                <div class="col-lg-9">
                    <h4>@lang('website.Bidder Details')</h4>
                    @php
                        $days = \Carbon\Carbon::parse($bidder->created_at)->diffInDays(\Carbon\Carbon::now());
                     $complete_bids = \App\Model\ProductBid::where('sender_user_id',$bidder->id)->where('bid_status',1)->count();
                     $reviews = \App\Model\Review::where('receiver_user_id',$bidder->id)->count();
                    @endphp
                    <div>
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-6 mb-1">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{getNumberToBangla($days)}}</h5>
                                        <p>@lang('website.Experience') (@lang('website.Days'))</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-6 mb-1">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{getNumberToBangla($complete_bids)}}</h5>
                                        <p>@lang('website.Completed Bids')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-6 mb-1">
                                <a href="{{route('seller.bidders-review',$bidder->id)}}">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{getNumberToBangla($reviews)}}</h5>
                                        <p>@lang('website.Reviews')</p>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-6 mb-1">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{getNumberToBangla(userRating($bidder->id))}}</h5>
                                        <p>@lang('website.Ratings')</p>
                                    </div>
                                </div>
                            </div>
                        </div>

{{--                        <div class="" style="padding-top: 20px;">--}}
{{--                            <h4>@lang('website.Bidder Information')</h4>--}}
{{--                            <div class="row">--}}
{{--                                <div class="card col-6">--}}
{{--                                    <table class="table">--}}
{{--                                        <tbody>--}}
{{--                                        <tr>--}}
{{--                                            <td>@lang('website.Name'):</td>--}}
{{--                                            <td>{{getNameByBnEn($bidder)}}</td>--}}
{{--                                        </tr>--}}
{{--                                        </tbody>--}}
{{--                                    </table>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="" style="padding-top: 20px;">
                            <h4>@lang('website.Bid Information')</h4>
                            <div class="row">
                                <div class="card col-6">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td>@lang('website.Bid Amount')</td>
                                            <td>{{getNumberWithCurrencyByBnEn($product_bid->total_bid_price)}}</td>
                                        </tr>
                                        <tr>
                                            <td>@lang('website.Date and Time')</td>
                                            <td>{{getDateConvertByBnEn($product_bid->created_at)}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding-top: 20px;">
                            <div class="col-md-4 col-6">
                                <a class="btn btn-info" href="{{route('seller.bidders-review',$bidder->id)}}"> @lang('website.See Reviews')</a>
                            </div>
                            @php
                                $bid_check = \App\Model\ProductBid::where('product_id',$product_bid->product_id)->where('bid_status',1)->first();
                            @endphp

                            @if($product_bid->bid_status == 0 && empty($bid_check))
                                <div class="col-md-4 col-6">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                        @lang('website.Accept Bid')
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="staticBackdropLabel">@lang('website.Are you sure?')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <p>@lang('website.Are you sure you want to accept the following bid?')</p>
                    </div>
                    <div>
                        <p><span class="text-black ">@lang('website.Name'):</span> {{$bidder->name}}<br>
                        <span class="text-black ">@lang('website.Bid Amount'):</span> {{two_digit_format_price($product_bid->total_bid_price)}}<br>
                        <span class="text-black ">@lang('website.Product Name'):</span> {{$product_bid->product->name}}
                        </p>
                    </div>
                    <div style="display: {{currency()->code == 'BDT' ? 'block' : 'none'}}">
                        <div style="font-size: 20px">
                            <p>
                                ১. বিড  একবার কনফার্ম হওয়ার পর অন্য কোন বিড গ্রহণ করা যাবে না। আপনার বিড গৃহীত পণ্যটিতে অন্য কেউ বিড করতে পারবে না এবং  এই পণ্যটি FLL ড্যাশবোর্ড এ আর প্রদর্শন হবে না।
                            </p>
                            <p>
                                ২. অ্যাপ কর্তৃপক্ষ  কোন লেনদেন বা পণ্য সম্পর্কিত সমস্যার জন্য কোন দায় নিবে না। এই পণ্যটির মূল্য প্রদান, বিতরণ, গুণগতমান, পরিমান, পরিমাপ, পরীক্ষার প্যারামিটার ক্রেতা এবং বিক্রেতা ম্যানুয়ালি পরিচানলা করবে। Fabric Lagbe কর্তৃপক্ষ উপরোক্ত বিষয়গুলির জন্য দায়বদ্ধ থাকবে না।
                            </p>
                            <p>
                                ৩. লেনদেন সম্পূর্ণ হওয়ার ৩০ দিনের মধ্যে পাওনা কমিশন পরিশোধ করতে ব্যার্থ হলে, FLL কর্তৃপক্ষ আইনগত ব্যবস্থা নেয়ার অধিকার রাখে।
                            </p>
                            <p>
                                ৪. আমি বাংলাদেশ সরকার এর প্রচলিত আইন অনুযায়ী উল্লেখিত মোট দামের ১% কমিশন, প্রয়োজনীয় সার্ভিস চার্জ এবং ৫% সরকারি ভ্যাট প্রদান করতে দায়বদ্ধ।
                            </p>
                        </div>
                        <div style="font-size: 14px">
                            <p>
                                1. Once the bid is confirmed no other bid can be accepted. No one else will be able to bid on your
                                accepted product and this product will no longer be displayed on the FLL Dashboard.
                            </p>
                            <p>
                                2. App Authority will not take any responsibility for any transaction or product related issues. The
                                price, delivery, quality, quantity, measurement, test parameters of this product will be manually
                                guided by the buyer and seller. The Fabric Lagbe Authority shall not be liable for any of the
                                above.
                            </p>
                            <p>
                                3. In case of failure to pay the due commission within 30 days of completion of the transaction, the
                                FLL Authority reserves the right to take legal action.
                            </p>
                            <p>
                                4. I am responsible for paying 1% commission, required service charge and 5% government VAT
                                on the total price as per the prevailing law of the Government of Bangladesh.
                            </p>
                        </div>
                    </div>
                    <div style="display: {{currency()->code == 'USD' ? 'block' : 'none'}}">
                        <div style="font-size: 20px">
                            <p>
                                1. Once the bid is confirmed no other bid can be accepted. No one else will be able to bid on your
                                accepted product and this product will no longer be displayed on the FLL Dashboard.
                            </p>
                            <p>
                                2. App Authority will not take any responsibility for any transaction or product related issues. The
                                price, delivery, quality, quantity, measurement, test parameters of this product will be manually
                                guided by the buyer and seller. The Fabric Lagbe Authority shall not be liable for any of the
                                above.
                            </p>
                            <p>
                                3. In case of failure to pay the due commission within 30 days of completion of the transaction, the
                                FLL Authority reserves the right to take legal action.

                            </p>
                            <p>
                                4. I am responsible for paying 1% commission, required service charge and 5% government VAT
                                on the total price as per the prevailing law of the Government of Bangladesh.
                            </p>
                        </div>
                        <div style="font-size: 14px">
                            <p>
                                ১. বিড  একবার কনফার্ম হওয়ার পর অন্য কোন বিড গ্রহণ করা যাবে না। আপনার বিড গৃহীত পণ্যটিতে অন্য কেউ বিড করতে পারবে না এবং  এই পণ্যটি FLL ড্যাশবোর্ড এ আর প্রদর্শন হবে না।
                            </p>
                            <p>
                                ২. অ্যাপ কর্তৃপক্ষ  কোন লেনদেন বা পণ্য সম্পর্কিত সমস্যার জন্য কোন দায় নিবে না। এই পণ্যটির মূল্য প্রদান, বিতরণ, গুণগতমান, পরিমান, পরিমাপ, পরীক্ষার প্যারামিটার ক্রেতা এবং বিক্রেতা ম্যানুয়ালি পরিচানলা করবে। Fabric Lagbe কর্তৃপক্ষ উপরোক্ত বিষয়গুলির জন্য দায়বদ্ধ থাকবে না।
                            </p>
                            <p>
                                ৩. লেনদেন সম্পূর্ণ হওয়ার ৩০ দিনের মধ্যে পাওনা কমিশন পরিশোধ করতে ব্যার্থ হলে, FLL কর্তৃপক্ষ আইনগত ব্যবস্থা নেয়ার অধিকার রাখে।
                            </p>
                            <p>
                                ৪. আমি বাংলাদেশ সরকার এর প্রচলিত আইন অনুযায়ী উল্লেখিত মোট দামের ১% কমিশন, প্রয়োজনীয় সার্ভিস চার্জ এবং ৫% সরকারি ভ্যাট প্রদান করতে দায়বদ্ধ।
                            </p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">@lang('website.Close')</button>
                    <button type="button" class="btn btn-success"><a href="{{route('seller.bid.accept',$product_bid->id)}}">@lang('website.Accept Bid')</a></button>
                </div>
            </div>
        </div>
    </div>

@stop
@push('js')

@endpush
