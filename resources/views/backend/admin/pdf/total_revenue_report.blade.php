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
    <h2 > Total Revenue Report</h2>

    <table class="table table-bordered">
        <tr>
            <th>#SL</th>
            <th>Name</th>
            @if( $sale_type == 'buy' || $sale_type == 'sell')
                <th>Product Name</th>
            @endif
            <th>Commission Amount</th>
            <th>Commission Status</th>
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
                    @if($sale_type == 'mp')
                        {{$totalSale->amount_after_getaway_fee}}
                    @else
                        {{$totalSale->commission}}
                    @endif
                </td>
                <td>{{$totalSale->payment_status}}</td>
                <td>{{date('dS M, Y',strtotime($totalSale->created_at))}}</td>
            </tr>

        @endforeach
        @if($sale_type == 'mp')
            @php
                $paid = $totalSales->where('payment_status','Paid')->sum('amount_after_getaway_fee');
                $due = $totalSales->where('payment_status','!=','Paid')->sum('amount_after_getaway_fee');
                $total = $totalSales->sum('amount_after_getaway_fee');
            @endphp
        @else
            @php
                $paid = $totalSales->where('payment_status','Paid')->sum('commission');
                $due = $totalSales->where('payment_status','!=','Paid')->sum('commission');
                $total = $totalSales->sum('commission');
            @endphp
        @endif
        <tr>
            <td colspan="{{$sale_type == 'buy' || $sale_type == 'sell' ? 5 : 4}}" style="text-align: right!important;"><strong>Total Revenue Number</strong></td>
            <td><strong>{{$totalSales->count()}}</strong></td>
        </tr>
        <tr>
            <td colspan="{{$sale_type == 'buy' || $sale_type == 'sell' ? 5 : 4}}" style="text-align: right!important;"><strong>Total Revenue Paid Amount</strong></td>
            <td><strong>{{ceil($paid)}}</strong></td>
        </tr>
        <tr>
            <td colspan="{{$sale_type == 'buy' || $sale_type == 'sell' ? 5 : 4}}" style="text-align: right!important;"><strong>Total Revenue Due Amount</strong></td>
            <td><strong>{{ceil($due)}}</strong></td>
        </tr>
        <tr>
            <td colspan="{{$sale_type == 'buy' || $sale_type == 'sell' ? 5 : 4}}" style="text-align: right!important;"><strong>Total Revenue Amount</strong></td>
            <td><strong>{{ceil($total)}}</strong></td>
        </tr>
    </table>
</div>
</body>
</html>
