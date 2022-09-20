<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Details</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    @php
    $product = \App\Model\Product::where('id',$sale_record->product_id)->first();
    @endphp
    <table class="table" id="data">
        <tr>
            <th colspan="2">
                <h5>Product Details</h5>
            </th>
        </tr>
        <tr>
            <td>Product Name</td>
            <th>{{$product->name}}</th>
        </tr>
        <tr>
            <td>Category Name</td>
            <th>{{$product->category->name}}</th>
        </tr>
        <tr>
            <td>Product Price</td>
            <th>৳ {{$sale_record->amount}}</th>
        </tr>
        <tr>
            <td>Unit Type</td>
            <th>{{$product->unit->name}}</th>
        </tr>
        <tr>
            <td>Quantity</td>
            <th>{{$product->quantity}}</th>
        </tr>
        <tr>
            <td>Description</td>
            <th>{!! $product->description  !!}</th>
        </tr>
        @php
        $product_bid = \App\Model\ProductBid::where('id',$sale_record->product_bid_id)->first();
        @endphp
        <tr>
            <th colspan="2">
                <h5>Bid Information</h5>
            </th>
        </tr>
        <tr>
            <td>Bid Date</td>
            <th>{{date('j/m/Y',strtotime($product_bid->updated_at))}}</th>
        </tr>
        <tr>
            <td>Bid Amount</td>
            <th>৳ {{$product_bid->unit_bid_price}}</th>
        </tr>
        <tr>
            <td>Bid Status</td>
            <th>
                <button class="btn btn-success">Accepted</button>
            </th>
        </tr>
        <tr>
            <td>Final Amount</td>
            <th>৳ {{$sale_record->amount}}</th>
        </tr>
        @php
            $seller = \App\User::where('id',$sale_record->seller_user_id)->first();
            $buyer = \App\User::where('id',$sale_record->buyer_user_id)->first();
        @endphp
        <tr>
            <td>
                <table class="table">
                    <tbody>
                    <tr>
                        <th colspan="2">
                            <h5>Buyer Details</h5>
                        </th>
                    </tr>
                    <tr>
                        <td>Buyer Name</td>
                        <th>{{$buyer->name}}</th>
                    </tr>
                    <tr>
                        <td>Buyer Status</td>
                        <th>
                            @if(getProductRatingSellerGiven($sale_record->buyer_user_id,$sale_record->product_id) >= 1)
                                <button class="btn btn-success">Complete</button>
                            @else
                                <button class="btn btn-warning">In-Complete</button>
                            @endif
                        </th>
                    </tr>
                    <tr>
                        <td>Buyer Rating</td>
                        <th>{{getProductRatingSellerGiven($sale_record->buyer_user_id,$sale_record->product_id) ? getProductRatingSellerGiven($sale_record->buyer_user_id,$sale_record->product_id) : 0}}</th>
                    </tr>
                    <tr>
                        <td>Buyer Phone</td>
                        <th>{{$buyer->country_code.$buyer->phone}}</th>
                    </tr>
                    <tr>
                        <td>Buyer Email</td>
                        <th>{{$buyer->email}}</th>
                    </tr>
                    </tbody>
                </table>
            </td>
            <th>
                <table class="table">
                    <tbody>
                    <tr>
                        <th colspan="2">
                            <h5>Seller Details</h5>
                        </th>
                    </tr>
                    <tr>
                        <td>Seller Name</td>
                        <th>{{$seller->name}}</th>
                    </tr>
                    <tr>
                        <td>Seller Status</td>
                        <th>
                            @if(getProductRatingSellerGiven($sale_record->seller_user_id,$sale_record->product_id) >= 1)
                                <button class="btn btn-success">Complete</button>
                            @else
                                <button class="btn btn-warning">In-Complete</button>
                            @endif
                        </th>
                    </tr>
                    <tr>
                        <td>Seller Rating</td>
                        <th>{{getProductRatingSellerGiven($sale_record->seller_user_id,$sale_record->product_id) ? getProductRatingSellerGiven($sale_record->seller_user_id,$sale_record->product_id) : 0}}</th>
                    </tr>
                    <tr>
                        <td>Seller Phone</td>
                        <th>{{$seller->country_code.$seller->phone}}</th>
                    </tr>
                    <tr>
                        <td>Seller Email</td>
                        <th>{{$seller->email}}</th>
                    </tr>
                    </tbody>
                </table>
            </th>
        </tr>

    </table>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

</div>
