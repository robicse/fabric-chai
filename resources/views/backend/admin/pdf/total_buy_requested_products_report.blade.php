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
    <h2 > Total Buy Requested Products Report</h2>

    <table class="table table-bordered">
        <tr>
            <th>#SL</th>
            <th>Buyer Name</th>
            <th>Product Name</th>
            <th>Unit Price</th>
            <th>Total Price</th>
            <th>Quantity</th>
            <th>Date</th>
        </tr>
        @foreach($totalProducts as $key=> $totalProduct)
            <tr>
                <td>{{$key + 1}}</td>
                <td>{{$totalProduct->user->name}}</td>
                <td>{{$totalProduct->name}}</td>
                @if($totalProduct->sizingProduct)
                    <td>{{$totalProduct->sizingProduct->price}}</td>
                    <td>{{$totalProduct->sizingProduct->total_price}}</td>
                @else
                    <td>{{$totalProduct->unit_price}}</td>
                    <td>{{$totalProduct->expected_price}}</td>
                @endif
                <td>{{$totalProduct->quantity}} {{$totalProduct->unit? $totalProduct->unit->name : ''}}</td>
                <td>{{date('dS M, Y',strtotime($totalProduct->created_at))}}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="6" style="text-align: right!important;"><strong>Total Products</strong></td>
            <td><strong>{{$totalProducts->count()}}</strong></td>
        </tr>

    </table>

</div>
</body>
</html>
