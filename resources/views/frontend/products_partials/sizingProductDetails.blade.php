<style>
    strong{
        font-size: 18px;
    }
</style>
<div class="row">
    <div class="col-md-6">
        <div>
            @lang('website.Total Lengths'):
            <span class="stock-availability in-stock text-success font-500">
                <strong class="">{{getNumberToBangla($detailedProduct->sizingProduct->total_length)  }} @lang('website.Meter/Yards') </strong>
            </span>
        </div>
        <div>
            @lang('website.Yarn Count'):
            <span class="stock-availability in-stock text-success font-500">
                <strong class="">{{ getNumberToBangla($detailedProduct->sizingProduct->yarn_count) }}</strong>
            </span>
        </div>
        <div>
            @lang('website.Yarn CSP'):
            <span class="stock-availability in-stock text-success font-500">
                <strong class="">{{ $detailedProduct->sizingProduct->yarn_csp }}</strong>
            </span>
        </div>
        <div>
            @lang('website.IPI'):
            <span class="stock-availability in-stock text-success font-500">
                <strong class="">{{ $detailedProduct->sizingProduct->ipi }}</strong>
            </span>
        </div>

        <div class="">
            @lang('website.Unit Price'):
            <span>
                <span class="text-danger text-bold font-500">
                    @if(currency()->code == 'BDT')
                        <strong class="text-danger">{{ getNumberWithCurrencyByBnEn($detailedProduct->sizingProduct->price) }}</strong>
                    @else
                        <strong class="text-danger">{{ getNumberWithCurrencyByBnEn($detailedProduct->sizingProduct->price) }}</strong>
                    @endif
                </span>
            </span>
        </div>

        <div class="">
            @lang('website.Total Price'):
            <span>
                <span class="text-danger text-bold font-500">
                    @if(currency()->code == 'BDT')
                        <strong class="text-danger">{{ getNumberWithCurrencyByBnEn($detailedProduct->sizingProduct->total_price) }}</strong>
                    @else
                        <strong class="text-danger">{{ getNumberWithCurrencyByBnEn($detailedProduct->sizingProduct->total_price) }}</strong>
                    @endif
                </span>
            </span>
        </div>
    </div>
    <div class="col-md-6">
        <div>
            @lang('website.Lengths Of'):
            <span class="stock-availability in-stock text-success font-500">
                <strong class="">{{ $detailedProduct->sizingProduct->lengths_of }}</strong>
            </span>
        </div>
        <div>
            @lang('website.Warping Lengths Meter/Yards'):
            <span class="stock-availability in-stock text-success font-500">
                <strong class="">{{ $detailedProduct->sizingProduct->warping_lengths }}</strong>
            </span>
        </div>
        <div>
            @lang('website.Sizing Lengths Meter/Yards'):
            <span class="stock-availability in-stock text-success font-500">
                <strong class="">{{ $detailedProduct->sizingProduct->sizing_lengths }}</strong>
            </span>
        </div>
        <div>
            @lang('website.Wastage Percentage'):
            <span class="stock-availability in-stock text-success font-500">
                <strong class="">{{ $detailedProduct->sizingProduct->wastage_percentage }}</strong>
            </span>
        </div>
        <div>
            @lang('website.Gera'):
            <span class="stock-availability in-stock text-success font-500">
                <strong class="">{{ $detailedProduct->sizingProduct->gera }}</strong>
            </span>
        </div>
        <div>
            @lang('website.Sizing Time'):
            <span class="stock-availability in-stock text-success font-500">
                <strong class="">{{ $detailedProduct->sizingProduct->sizing_time }}</strong>
            </span>
        </div>

    </div>
</div>
