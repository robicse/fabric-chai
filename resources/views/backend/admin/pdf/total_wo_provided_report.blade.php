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
    <h2 > Total Work Order Provided</h2>

    <table class="table table-bordered">
        <tr>
            <th>#SL</th>
            <th>Buyer Name</th>
            <th>Work Order Type</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
        @foreach($totalWorkOrders as $key=> $totalWorkOrder)
            <tr>
                <td>{{$key + 1}}</td>
                <td>{{$totalWorkOrder->buyerUser->name}}</td>
                <td>{{$totalWorkOrder->workOrderProduct->wish_to_work}}</td>
                <td>{{$totalWorkOrder->total_price}}</td>
                <td>{{date('dS M, Y',strtotime($totalWorkOrder->created_at))}}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="4" style="text-align: right!important;"><strong>Total Work Order Provided</strong></td>
            <td><strong>{{$totalWorkOrders->count()}}</strong></td>
        </tr>

    </table>

</div>
</body>
</html>
