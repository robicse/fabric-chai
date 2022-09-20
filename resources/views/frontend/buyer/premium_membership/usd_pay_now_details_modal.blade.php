<style>
    .btn_red{
        background-color: #ab0e0e;
    }
    .p_t_20{
        padding-top: 20px;
    }
</style>
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
                    $vat = vat(ceil(convert_to_usd($amount)));
                @endphp
                <div class="col-4">
                    <label class="col-form-label">@lang('website.Package Amount'):</label>
                </div>
                <div class="col-8">
                    ${{getNumberToBangla(ceil(convert_to_usd($amount)))}}
                </div>
                <div class="col-4">
                    <label class="col-form-label">@lang('website.VAT') ({{getNumberToBangla(vat_percentage())}}%):</label>
                </div>
                <div class="col-8">
                    ${{getNumberToBangla($vat)}}
                </div>
                <div class="col-4">
                    <label class="col-form-label">@lang('website.Total Amount'):</label>
                </div>
                <div class="col-8">
                    ${{getNumberToBangla(ceil(convert_to_usd($amount)) + $vat)}}
                </div>
                <div class="col-4">
                    <label class="col-form-label">@lang('website.Are You Agree?')</label>
                </div>
                <div class="col-8">
                    <a href="{{route('buyer.buy-now-stripe',$membershipPackage->id)}}" class="btn btn-success" >@lang('website.Pay Now')</a>
                    <button type="button" class="btn btn-success btn_red" data-bs-dismiss="modal" >@lang('website.Close')</button>
                </div>
            </div>

        </div>
        <br/>

        <div class="row p_t_20" >
            <div class="col-md-6">

            </div>
            <div class="col-md-6">

            </div>
        </div>
    </form>
</div>

