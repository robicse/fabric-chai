<style>
    strong{
        font-size: 18px;
    }
</style>
<div class="row">
    <div class="col-md-6">
        <div>
            @lang('website.Product Of Fabric'):
            <span class="stock-availability in-stock text-success font-500">
                <strong class="">@lang('website.'.$detailedProduct->dyingProduct->product_of_fabric) @lang('website.Meter/Yards') </strong>
            </span>
        </div>
        <div>
            @lang('website.Types Of Fabrics'):
            <span class="stock-availability in-stock text-success font-500">
                <strong class="">
                    {{ $detailedProduct->dyingProduct->dyingCategory ? getNameByBnEn($detailedProduct->dyingProduct->dyingCategory) : '' }}
                    -
                    {{ $detailedProduct->dyingProduct->dyingSubcategory ? getNameByBnEn($detailedProduct->dyingProduct->dyingSubcategory) : '' }}
                </strong>
            </span>
        </div>
        <div>
            @lang('website.Quantity of Fabric'):
            <span class="stock-availability in-stock text-success font-500">
                <strong class="">{{ getNumberToBangla($detailedProduct->quantity) }}</strong>
            </span>
        </div>
        <div>
            @lang('website.Colors of Fabric'):
            <span class="stock-availability in-stock text-success font-500">
                <strong class="">{{ $detailedProduct->dyingProduct->color }}</strong>
            </span>
        </div>
        <div>
            @lang('website.Fabrics Construction'):
            <span class="stock-availability in-stock text-success font-500">
                <strong class="">{{ $detailedProduct->dyingProduct->fabrics_construction }}</strong>
            </span>
        </div>
        <div>
           @lang('website.Fabrics Composition') :
            <span class="stock-availability in-stock text-success font-500">
                <strong class="">{{ $detailedProduct->dyingProduct->fabrics_composition }}</strong>
            </span>
        </div>
        <div class="">
            @lang('website.Unit Price'):
            <span>
                <span class="text-danger text-bold font-500">
                    @if(currency()->code == 'BDT')
                        <strong class="text-danger">{{ getNumberWithCurrencyByBnEn($detailedProduct->unit_price) }}</strong>
                    @else
                        <strong class="text-danger">{{ getNumberWithCurrencyByBnEn($detailedProduct->unit_price) }}</strong>
                    @endif
                </span>
            </span>
        </div>

        <div class="">
            @lang('website.Total Price'):
            <span>
                <span class="text-danger text-bold font-500">
                    @if(currency()->code == 'BDT')
                        <strong class="text-danger">{{ getNumberWithCurrencyByBnEn($detailedProduct->expected_price) }}</strong>
                    @else
                        <strong class="text-danger">{{ getNumberWithCurrencyByBnEn($detailedProduct->expected_price) }}</strong>
                    @endif
                </span>
            </span>
        </div>
    </div>
    <div class="col-md-6">

        <div>
            @lang('website.Grey Width'):
            <span class="stock-availability in-stock text-success font-500">
                <strong class="">{{getNumberToBangla($detailedProduct->dyingProduct->grey_width)  }} {{$detailedProduct->dyingProduct->grey_unit}}</strong>
            </span>
        </div>
        <div>
            @lang('website.Finished Width'):
            <span class="stock-availability in-stock text-success font-500">
                <strong class="">{{ getNumberToBangla($detailedProduct->dyingProduct->finished_width) }} {{$detailedProduct->dyingProduct->finished_unit}}</strong>
            </span>
        </div>
        <div>
            @lang('website.Color Test Parameter'):
            <span class="stock-availability in-stock text-success font-500">
                <strong class="">{{ $detailedProduct->dyingProduct->color_test_parameter }} </strong>
            </span>
        </div>
        <div>
             @lang('website.Rubbing'):
            <span class="stock-availability in-stock text-success font-500">
                <strong class="">{{ $detailedProduct->dyingProduct->rubbing }}</strong>
            </span>
        </div>
        <div>
            @lang('website.Tearing Strange'):
            <span class="stock-availability in-stock text-success font-500">
                <strong class="">{{ $detailedProduct->dyingProduct->tearing_strange }}</strong>
            </span>
        </div>
        <div>
            @lang('website.Shining Receive'):
            <span class="stock-availability in-stock text-success font-500">
                <strong class="">{{ $detailedProduct->dyingProduct->shining_receive }}</strong>
            </span>
        </div>

    </div>
</div>
