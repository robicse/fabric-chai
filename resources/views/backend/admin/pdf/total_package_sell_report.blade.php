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
    <h2 > Total Package Sell Report</h2>

    <table class="table table-bordered">
        <tr>
            <th>#SL</th>
            <th>Name</th>
            <th>Package Amount</th>
            <th>Date</th>
        </tr>
        @foreach($totalPackageSells as $key=> $totalPackageSell)
            @php
                $user = \App\User::find($totalPackageSell->user_id);
            @endphp
            <tr>
                <td>{{$key + 1}}</td>
                <td>{{$user->name}}</td>
                <td>{{$totalPackageSell->amount}}</td>
                <td>{{date('dS M, Y',strtotime($totalPackageSell->created_at))}}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3" style="text-align: right!important;"><strong>Total Package Number</strong></td>
            <td><strong>{{$totalPackageSells->count()}}</strong></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right!important;"><strong>Total Amount</strong></td>
            <td><strong>{{$totalPackageSells->sum('amount')}}</strong></td>
        </tr>
    </table>

</div>
</body>
</html>
