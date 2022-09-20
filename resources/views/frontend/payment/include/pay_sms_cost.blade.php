<form role="form" action="{{ route('stripe3.post') }}" method="post" class="require-validation"
      data-cc-on-file="false"
{{--                                      data-stripe-publishable-key="pk_test_c6VvBEbwHFdulFZ62q1IQrar"--}}
      data-stripe-publishable-key="pk_live_51JLgFGIxrFVU5M1yCTX5jGNc66lhd9JKcj4Lh04yHRo43vwIm07ZU5YOUA0VqPF7RtJn0Sg4kz1FxHSiIXVAzrfF002bryJ2dF"
      id="payment-form">
    @csrf

    <div class='form-row'>
        <div class='col-12 form-group required'>
            <label class='control-label'>Name on Card</label>
            <input class='form-control' size='4' type='text'>
        </div>
    </div>

    <div class='form-row'>
        <div class='col-12 form-group required'>
            <label class='control-label'>Card Number</label>
            <input autocomplete='off' class='form-control card-number' size='20' type='text'>
        </div>
    </div>

    <div class='form-row'>
        <div class='col-12 col-md-4 form-group cvc required'>
            <label class='control-label'>CVC</label>
            <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text'>
        </div>
        <div class='col-12 col-md-4 form-group expiration required'>
            <label class='control-label'>Expiration Month</label>
            <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
        </div>
        <div class='col-12 col-md-4 form-group expiration required'>
            <label class='control-label'>Expiration Year</label>
            <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>
        </div>
    </div>

    <div class='form-row'>
        <div class='col-12 error form-group d-none'>
            <div class='alert-danger alert'>Please correct the errors and try again.</div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">&nbsp;</div>
    </div>

    <div class="row">
        <div class="col-12">
            @php
                $amount = \App\Model\SmsCostPaymentHistory::where('id',Session::get('sms_cost_payment_history_id'))->pluck('amount')->first();
            @endphp
            <button class="btn btn-success btn-block" type="submit">Pay Now (${{number_format($amount), 2}})</button>
        </div>
    </div>

</form>
