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
    <h2 > Total VAT Report</h2>

    <table class="table table-bordered">
        <tr>
            <th>#SL</th>
            <th>VAT Amount</th>
            <th>Payment Status</th>
            <th>Date</th>
        </tr>
        @foreach($totalVats as $key=> $totalVat)
            <tr>
                <td>{{$key + 1}}</td>
                <td>{{$totalVat->commission * 0.15}}</td>
                <td>{{$totalVat->payment_status}}</td>
                <td>{{date('dS M, Y',strtotime($totalVat->created_at))}}</td>
            </tr>
        @endforeach
        @php
            $paid = $totalVats->where('payment_status','Paid')->sum('commission');
            $due = $totalVats->where('payment_status','!=','Paid')->sum('commission');
        @endphp
        <tr>
            <td colspan="3" style="text-align: right!important;"><strong>Total VAT Number</strong></td>
            <td><strong>{{$totalVats->count()}}</strong></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right!important;"><strong>Total VAT Paid Amount</strong></td>
            <td><strong>{{ceil($paid * 0.15)}}</strong></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right!important;"><strong>Total VAT Due Amount</strong></td>
            <td><strong>{{ceil($due * 0.15)}}</strong></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right!important;"><strong>Total VAT Amount</strong></td>
            <td><strong>{{ceil($totalVats->sum('commission') * 0.15)}}</strong></td>
        </tr>
    </table>

</div>
</body>
</html>
