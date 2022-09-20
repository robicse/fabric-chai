<!-- Modal -->
<div class="modal-header">
    <h5 class="modal-title text-center" id="staticBackdropLabel_{{$saleRecord->id}}">@lang('website.Pay Now')</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
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
                <div class="col-md-6">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="background-color: #ab0e0e;">@lang('website.Close')</button>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-success" style="background-color: #4ce43a;">@lang('website.Submit')</button>
                </div>
            </div>
        </div>
    </form>
</div>

