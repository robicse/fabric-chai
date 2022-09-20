<!DOCTYPE html>
<html>
<head>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }
    </style>
</head>
<body>
<div style="text-align: center!important;">
    <h2 > Total Sales Report</h2>

    <table class="table table-bordered">
        <tr>
            <th>#SL</th>
            <th>Name</th>
            @if( $sale_type == 'buy' || $sale_type == 'sell')
                <th>Product Name</th>
            @endif
            <th>Sale Amount</th>
            <th>Date</th>
        </tr>
        @foreach($totalSales as $key=> $totalSale)
            <tr>
                <td>{{$key + 1}}</td>
                @if($sale_type == 'buy')
                    @php
                        $user = \App\User::find($totalSale->buyer_user_id);
                    @endphp
                    <td>{{$user ? $user->name :''}}</td>
                @elseif($sale_type == 'mp')
                    @php
                        $user = \App\User::find($totalSale->user_id);
                    @endphp
                    <td>{{$user->name}}</td>
                @else
                    @php
                        $user = \App\User::find($totalSale->seller_user_id);
                    @endphp
                    <td>{{$user->name}}</td>
                @endif
                @if( $sale_type == 'buy' || $sale_type == 'sell')
                    @php
                        $product = \App\Model\Product::find($totalSale->product_id);
                    @endphp
                    <td>{{$product->name}}</td>
                @endif
                <td>
                    {{$totalSale->amount}}
                </td>
                <td>{{date('dS M, Y',strtotime($totalSale->created_at))}}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="{{$sale_type == 'buy' || $sale_type == 'sell' ? 4 : 3}}" style="text-align: right!important;"><strong>Total Sell</strong></td>
            <td><strong>{{$totalSales->count()}}</strong></td>
        </tr>
        <tr>
            <td colspan="{{$sale_type == 'buy' || $sale_type == 'sell' ? 4 : 3}}" style="text-align: right!important;"><strong>Total Amount</strong></td>
            <td><strong>{{$totalSales->sum('amount')}}</strong></td>
        </tr>
    </table>
</div>
</body>
</html>
