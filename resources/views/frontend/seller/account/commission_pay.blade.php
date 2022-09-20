@extends('frontend.layouts.master')
@section('title', 'Commission Pay')
@push('css')
@endpush
@section('content')
    <div class="full-row" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                @include('frontend.seller.seller_breadcrumb')
                @include('frontend.seller.seller_sidebar')
                <div class="col-lg-9 col-sm-9">
                    <form action="{{route('seller.pay-now')}}" method="POST">
                        @csrf
                        <div>
                            <div class="row">
                                <div class="col-4">
                                    <label class="col-form-label">@lang('website.Commission Due Amount')</label>
                                </div>
                                <div class="col-8">
                                    <input type="hidden" name="invoice_code" value="{{$saleRecord->invoice_code}}" class="form-control">
                                    <input type="text"  value="{{getNumberToBangla(two_digit_single_price(getInvoiceWiseCommissionAmount($saleRecord->invoice_code)))}}"  style="border: 1px solid #dddddd" class="form-control" readonly>
                                    <input type="hidden" name="amount" value="{{convert_price(getInvoiceWiseCommissionAmount($saleRecord->invoice_code))}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-4">
                                            <input type="radio" name="payment_with" value="Pay Online" id="payOnline" class="shipping_method" onclick="ShowHidePaymentWith()" checked>
                                            <label for="payOnline">@lang('website.Pay Online')</label>
                                        </div>
                                        <div class="col-4">
                                            <input type="radio" name="payment_with" value="Pay Manually" id="PayManually" class="shipping_method" onclick="ShowHidePaymentWith()">
                                            <label for="PayManually">@lang('website.Pay Manually')</label>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <div id="div_pay_online">
                                                    <div class="col-12">
                                                        <input type="radio" name="payment_type" value="SSL Commerz" id="SSLCommerz" class="shipping_method" @if(currency()->code == 'BDT') checked @endif>
                                                        <label for="SSLCommerz">@lang('website.SSL Commerz')</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="radio" name="payment_type" value="Stripe" id="Stripe" class="shipping_method" @if(currency()->code == 'USD') checked @endif>
                                                        <label for="Stripe">@lang('website.Stripe')</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div id="div_pay_manually" style="display: none;">
                                                    <div class="col-4">
                                                        <input type="radio" name="payment_type" value="Cash" id="Cash" class="shipping_method" onclick="ShowHidePaymentType()">
                                                        <label for="Cash">@lang('website.Cash')</label>
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="radio" name="payment_type" value="LC" id="LC" class="shipping_method" onclick="ShowHidePaymentType()">
                                                        <label for="LC">@lang('website.LC')</label>
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="radio" name="payment_type" value="Check" id="Check" class="shipping_method" onclick="ShowHidePaymentType()">
                                                        <label for="Check">@lang('website.Cheque')</label>
                                                    </div>
                                                    <div id="div_check_number" style="display: none;">
                                                        <div class="col-4">
                                                            @lang('website.Bank Name'):
                                                            <input type="text" name="bank_name" id="txtBankName" />
                                                        </div>
                                                        <div class="col-4">
                                                            @lang('website.Cheque Number'):
                                                            <input type="text" name="check_number" id="txtEmail" />
                                                        </div>
                                                        <div class="col-4">
                                                            @lang('website.Dispatch Date'):
                                                            <input type="text" name="dispatch_date" id="txtDispatchDate" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <br/>
                            <div class="col-12">&nbsp;</div>
                            <div class="row" id="div_description" style="display: none;">
                                <div class="col-4">
                                    <label>@lang('website.Description') <span>*</span></label>
                                </div>
                                <div class="col-8">
                                    <textarea name="description" id="meta_desc" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="col-4 mt-3">
                                    <label>@lang('website.Account Name'): </label>
                                </div>
                                <div class="col-8 mt-3">@lang('website.Fabric Lagbe Limited')</div>

                                <div class="col-4">
                                    <label>@lang('website.A/c No').: </label>
                                </div>
                                <div class="col-8">{{getNumberToBangla(1301010010590)}}</div>
                                <div class="col-4">
                                    <label>@lang('website.Bank Name'): </label>
                                </div>
                                <div class="col-8">@lang('website.Mutual Trust Bank Limited')</div>
                                <div class="col-4">
                                    <label>@lang('website.Branch Name'): </label>
                                </div>
                                <div class="col-8">@lang('website.Gulshan Branch')</div>
                                <div class="col-4">
                                    <label>@lang('website.Branch Code'): </label>
                                </div>
                                <div class="col-8">{{getNumberToBangla(175261840)}}</div>
                                <div class="col-4">
                                    <label>@lang('website.Swift Code'): </label>
                                </div>
                                <div class="col-8">MTBLBDDHGUL</div>
                                <div class="col-4">
                                    <label>@lang('website.Routing Number'): </label>
                                </div>
                                <div class="col-8">{{getNumberToBangla(145261720)}}</div>
                            </div>

                            <div class="row" style="padding-top: 20px;">
{{--                                <div class="col-md-6">--}}
{{--                                    <button type="button" class="btn" data-bs-dismiss="modal" style="background-color: #ab0e0e;">@lang('website.Close')</button>--}}
{{--                                </div>--}}
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-success" style="background-color: #4ce43a;">@lang('website.Submit')</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="col-md-6" style="margin-left: 227px; margin-top: -46px;">
                        <button class="btn btn-info " id="bKash_button">
                            Pay with bKash
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="price" name="price" value="{{getInvoiceWiseCommissionAmount($saleRecord->invoice_code)}}"><br><br>
@endsection
@push('js')
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
                window.location.href='/seller/commission_pay/'+'{{$saleRecord->id}}';  // Your redirect route when cancel payment
            },
        });

        function clickPayButton() {
            $("#bKash_button").trigger('click');
        }
    </script>
@endpush

