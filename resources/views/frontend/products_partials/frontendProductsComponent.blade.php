<div class="col">
    <div class="product type-product">
        <div class="product-wrapper">
            <div class="product-image">
                <a href="{{route('frontend-product-details',$product->slug)}}" class="woocommerce-LoopProduct-link"><img class="lazyload" src="{{ asset('frontend/assets/images/placeholder.jpg') }}" data-src="{{url($product->thumbnail_img)}}" alt="{{$product->name}}" width="231" height="231"></a>
                <div class="wishlist-view">
                </div>
            </div>
            <div class="product-info">
                <h3 class="product-title"><a href="{{route('frontend-product-details',$product->slug)}}">{{getNameByBnEn(@$product)}}</a></h3>
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
                            <a href="#"><span> {{ renderStarRating($product->rating) }}</span></a>
                        </div>
                        <div class="rating-counts-wrap">
                            <a href="#">({{$product->rating > 0 ? getNumberToBangla($product->rating) : getNumberToBangla(0)}} of {{getNumberToBangla(5)}})</a>
                        </div>
                    </div>

                    <div class="sold-items">
                        @if($product->category_id == 9 && $product->sizingProduct)
                            <span>{{$product->sizingProduct->total_length}}</span> <span>@lang('website.Yards/Meter') </span>
                        @else
                            @php
                                $qty = is_int($product->quantity) ;
                            @endphp
                            <span>{{$qty != false ? getNumberToBangla($qty) : ''}}</span>
                            <span>{{$product->unit ? getNameByBnEn($product->unit) : ''}}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
