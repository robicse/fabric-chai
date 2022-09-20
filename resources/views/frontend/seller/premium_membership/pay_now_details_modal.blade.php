<!-- Modal -->
<div class="modal-header">
    <h5 class="modal-title text-center" id="staticBackdropLabel_{{$membershipPackage->id}}">@lang('website.Upgrade Membership')</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form action="{{route('seller.pay-now')}}" method="POST">
        @csrf
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
                </div>
                <div class="col-4">
                    <label class="col-form-label">@lang('website.Are You Agree?')</label>
                </div>
                <div class="col-8">
                    <a href="{{route('seller.buy-now',$membershipPackage->id)}}" class="btn btn-success" >@lang('website.Pay Now')</a>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" style="background-color: #ab0e0e;">@lang('website.Close')</button>
                </div>
            </div>

            </div>
            <br/>

            <div class="row" style="padding-top: 20px;">
                <div class="col-md-6">
{{--                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" style="background-color: #ab0e0e;">Close</button>--}}
                </div>
                <div class="col-md-6">
{{--                    <button type="submit" class="btn btn-success" style="background-color: #4ce43a;">Submit</button>--}}
                </div>
            </div>
    </form>
</div>

