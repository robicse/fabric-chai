<div class="col-lg-4 col-md-4 col-sm-6 col-6 mb-2" style="margin-top: 10px; ">
    <div class="product type-product">
        <div class="product-wrapper">
            <div class="product-image">
                @if(Auth::User()->user_type == 'seller')
                <a href="{{route('seller.my-work-order.details',$product->slug)}}" class="woocommerce-LoopProduct-link"><img class="lazyload" src="{{ asset('frontend/assets/images/placeholder.jpg') }}" data-src="{{url($product->thumbnail_img)}}" alt="{{$product->wish_to_work}}" width="231" height="231"></a>
                @else
                    <a href="{{route('buyer.work-order-product-details',$product->slug)}}" class="woocommerce-LoopProduct-link"><img class="lazyload" src="{{ asset('frontend/assets/images/placeholder.jpg') }}" data-src="{{url($product->thumbnail_img)}}" alt="{{$product->wish_to_work}}" width="231" height="231"></a>
                @endif
                <div class="wishlist-view">
                </div>
            </div>
            <div class="product-info">
                @if(Auth::User()->user_type == 'seller')
                <h3 class="product-title "><a class="text-center" href="{{route('seller.my-work-order.details',$product->slug)}}" style="font-size: 18px; text-align: center!important;">{{$product->wish_to_work}}</a></h3>
                @else
                <h3 class="product-title "><a class="text-center" href="{{route('buyer.work-order-product-details',$product->slug)}}" style="font-size: 18px; text-align: center!important;">{{$product->wish_to_work}}</a></h3>
                @endif
            </div>
        </div>
    </div>
</div>

