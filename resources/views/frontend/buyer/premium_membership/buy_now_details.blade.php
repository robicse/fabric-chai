@extends('frontend.layouts.master')
@section('title', 'Membership Packages')
@push('css')
    <style>
        .btn-1 {
            padding: 0 10px;
            background-color: purple;
        }
    </style>
    {{--    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>--}}
    {{--    <script src="https://scripts.sandbox.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout-sandbox.js"></script>--}}
@endpush
@section('content')
    <!-- /.breadcrumb -->
    <div class="full-row" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                @if(Request::segment(2) == 'work-order')
                    <div class="col-lg-12 pt-3">
                        <h3 class="mb-2 text-secondary">@lang('website.Buyer Work Order')</h3>
                    </div>
                    @include('frontend.buyer.work_order_sidebar')
                @else
                    @include('frontend.buyer.buyer_breadcrumb')
                    @include('frontend.buyer.buyer_sidebar')
                @endif
                <div class="col-lg-9">
                    <h4>@lang('website.Membership Packages')</h4>

                    {{--                    <form action="{{route('seller.pay-now')}}" method="POST">--}}
                    {{--                        @csrf--}}
                    <div>
                        <div class="row">
                            @php
                                $amount = getMembershipPackageAmount($membershipPackage->id);
                                $vat = vat($amount);
                            @endphp
                            <div class="col-4">
                                <label class="col-form-label">@lang('website.Package Amount'):</label>
                            </div>
                            <div class="col-8">
                                ৳{{getNumberToBangla($amount)}}
                            </div>
                            <div class="col-4">
                                <label class="col-form-label">@lang('website.VAT') ({{getNumberToBangla(vat_percentage())}}%):</label>
                            </div>
                            <div class="col-8">
                                ৳{{getNumberToBangla($vat)}}
                            </div>
                            <div class="col-4">
                                <label class="col-form-label">@lang('website.Total Amount'):</label>
                            </div>
                            <div class="col-8">
                                ৳{{getNumberToBangla($amount + $vat)}}
                                <input type="hidden" id="amount" value="{{$amount + $vat}}">
                            </div>
                            <div class="col-4">
                                <label class="col-form-label">@lang('website.Are You Agree?')</label>
                            </div>
                            <div class="col-md-8 row">
                                <div class="col-md-4">
                                    <a href="{{route('seller.buy-now',$membershipPackage->id)}}" class="btn btn-success" >Pay With SSL</a>
                                </div>

                                <div class="col-md-4">
                                    <a href="{{url('buyer/memberships-package-list')}}"><button type="button" class="btn btn-success" style="background-color: #ab0e0e;">@lang('website.Close')</button></a>
{{--                                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" style="background-color: #ab0e0e;">@lang('website.Close')</button>--}}
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-info" id="bKash_button">
                                        Pay with bKash
                                    </button>
                                </div>

                            </div>
                        </div>

                    </div>
                    <br/>

                    <div class="row" style="padding-top: 20px;">

                    </div>
                    {{--                    </form>--}}

                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="price" name="price" value="{{$bkashAmount}}"><br><br>
    {{--    <input type="hidden" id="price" name="price" value="1"><br><br>--}}

@endsection
@push('js')

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    </script>
    <script id="myScript" src="https://scripts.pay.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout.js"></script>

    <script>
        var price = document.getElementById('price').value;
        console.log(price);
        var paymentID = '';
        bKash.init({
            paymentMode: 'checkout', //fixed value ‘checkout’
            //paymentRequest format: {amount: AMOUNT, intent: INTENT}
            //intent options
            //1) ‘sale’ – immediate transaction (2 API calls)
            //2) ‘authorization’ – deferred transaction (3 API calls)
            paymentRequest: {
                amount: price, //max two decimal points allowed
                intent: 'sale'
            },
            createRequest: function(request) { //request object is basically the paymentRequest object, automatically pushed by the script in createRequest method
                console.log("create working !!")
                $.ajax({
                    url: '/bkash/create',
                    type: 'POST',
                    data: JSON.stringify(request),
                    contentType: 'application/json',
                    success: function(data) {

                        console.log(data)
                        var bkashData =JSON.parse(data);
                        if (bkashData && bkashData.paymentID != null) {
                            paymentID = bkashData.paymentID;
                            bKash.create().onSuccess(bkashData); //pass the whole response data in bKash.create().onSucess() method as a parameter
                        } else {
                            bKash.create().onError();
                        }
                    },
                    error: function() {
                        bKash.create().onError();
                    }
                });
            },
            executeRequestOnAuthorization: function() {
                console.log("execute working !!")
                $.ajax({
                    url: '/bkash/execute',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        "paymentID": paymentID
                    }),
                    success: function(data) {

                        console.log("execution response" , data)
                        var bkashData =JSON.parse(data);
                        if (bkashData && bkashData.paymentID != null) {
                            console.log("success")
                            console.log("trxID: ",bkashData.trxID)
                            //window.location.href = `success.html?trxID=${data.trxID}`;//Merchant’s success page
                            window.location.href = '/bkash/success'; // Your redirect route when successful payment
                        } else {
                            console.log("error ");
                            window.location.href = '/bkash/fail'; // Your redirect route when fail payment
                            bKash.execute().onError();
                        }
                    },
                    error: function() {
                        bKash.execute().onError();
                    }
                });
            },
            onClose: function(){
                window.location.href='/buyer/buy_now_details/'+'{{$membershipPackage->id}}';  // Your redirect route when cancel payment
            },
        });

        function clickPayButton() {
            $("#bKash_button").trigger('click');
        }
    </script>
@endpush
