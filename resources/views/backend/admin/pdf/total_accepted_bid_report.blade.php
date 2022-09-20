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
    <h2 > Total Bid Accepted Report</h2>

    <table class="table table-bordered">
        <tr>
            <th>#SL</th>
            <th>Product Name</th>
            <th>Bid Unit Price</th>
            <th>Bid Total Price</th>
            <th>Date</th>
        </tr>
        @foreach($totalAcceptedBids as $key=> $totalAcceptedBid)
            <tr>
                <td>{{$key + 1}}</td>
                <td>{{$totalAcceptedBid->product->name}}</td>
                <td>{{$totalAcceptedBid->unit_bid_price}}</td>
                <td>{{$totalAcceptedBid->total_bid_price}}</td>
                <td>{{date('dS M, Y',strtotime($totalAcceptedBid->created_at))}}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="4" style="text-align: right!important;"><strong>Total Bids</strong></td>
            <td><strong>{{$totalAcceptedBids->count()}}</strong></td>
        </tr>

    </table>

</div>
</body>
</html>
