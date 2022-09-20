<div class="col">
    <div class="product type-product">
        <div class="product-wrapper">
            <div class="product-image">
                <a href="{{route('product-details',$product->slug)}}" class="woocommerce-LoopProduct-link"><img class="lazyload" src="{{ asset('frontend/assets/images/placeholder.jpg') }}" data-src="{{url($product->thumbnail_img)}}" alt="{{$product->name}}" width="269" height="269"></a>
            </div>
            <div class="product-info">
                <h3 class="product-title"><a href="{{route('product-details',$product->slug)}}">{{getNameByBnEn($product)}}</a></h3>
                <div class="product-price">
                    <div class="price">
                        @if($product->category_id == 9 && $product->sizingProduct)
                            <ins>
                                @if(currency()->code == 'BDT')
                                    {{getNumberWithCurrencyByBnEn($product->sizingProduct->price)}}
                                @else
                                    {{getNumberWithCurrencyByBnEn($product->sizingProduct->price)}}
                                @endif
                            </ins>
                        @else
                            <ins>
                                @if(currency()->code == 'BDT')
                                    {{getNumberWithCurrencyByBnEn($product->unit_price)}}
                                @else
                                    {{getNumberWithCurrencyByBnEn($product->unit_price)}}
                                @endif
                            </ins>
                        @endif
                    </div>
                </div>
                <div class="shipping-feed-back">
                    <div class="star-rating">
                        <div class="rating-wrap">
                            <a href="#"><span> {{ renderStarRating($product->rating) }}</a>
                        </div>
                        <div class="rating-counts-wrap">
                            <a href="#">({{$product->rating > 0 ? getNumberToBangla($product->rating) : getNumberToBangla(0)}} of {{getNumberToBangla(5)}})</a>
                        </div>
                    </div>
                    <div class="sold-items">
                        @if($product->category_id == 9 && $product->sizingProduct)
                            <span>{{$product->sizingProduct->total_length}}</span> <span>@lang('website.Yards/Meter')</span>
                        @else
                            <span>{{getNumberToBangla($product->quantity)}}</span> <span>{{getNameByBnEn($product->unit)}}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
