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
    <h2 > Total Transaction Report</h2>

    <table class="table table-bordered">
        <tr>
            <th>#SL</th>
            <th>Transaction Amount</th>
            <th>Payment Status</th>
            <th>Date</th>
        </tr>
        @foreach($totalTransactions as $key=> $totalTransaction)
            <tr>
                <td>{{$key + 1}}</td>
                <td>{{$totalTransaction->amount + $totalTransaction->admin_commission}}</td>
                <td>{{$totalTransaction->payment_status}}</td>
                <td>{{date('dS M, Y',strtotime($totalTransaction->created_at))}}</td>
            </tr>
        @endforeach
        @php
            $paid = $totalTransactions->where('payment_status','Paid')->sum('commission');
            $due = $totalTransactions->where('payment_status','!=','Paid')->sum('commission');
            $total = $totalTransactions->sum('amount');
        @endphp
        <tr>
            <td colspan="3" style="text-align: right!important;"><strong>Total Transaction Number</strong></td>
            <td><strong>{{$totalTransaction->count()}}</strong></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right!important;"><strong>Total Transaction Paid Amount</strong></td>
            <td><strong>{{$paid}}</strong></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right!important;"><strong>Total Transaction Due Amount</strong></td>
            <td><strong>{{$due}}</strong></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right!important;"><strong>Total Transaction Amount</strong></td>
            <td><strong>{{$total}}</strong></td>
        </tr>
    </table>

</div>
</body>
</html>
