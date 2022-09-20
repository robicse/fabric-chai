<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>

<h2>Commission Report</h2>

<table>
    <tr>
        <th>#SL</th>
        <th>Name</th>
        <th>Total Product Sold</th>
        <th>Commission</th>
        <th>Paid</th>
        <th>Pending</th>
    </tr>
    @foreach($commissionReports as $key => $commissionReport)
        @php
            $seller = \App\User::where('id',$commissionReport->seller_user_id)->first();
        $CommissionPaidAmount = getTotalCommissionPaidAmount($seller->id) ? getTotalCommissionPaidAmount($seller->id) : 0;
        $pendingAmount = getTotalCommissionAmount($seller->id) - $CommissionPaidAmount;
        @endphp

        <tr>
            <td>{{$key + 1}}</td>
            <td>{{$seller->name}}</td>
            <td>{{getTotalSaleAmount($seller->id)}}</td>
            <td>{{getTotalCommissionAmount($seller->id)}}</td>
            <td>{{getTotalCommissionPaidAmount($seller->id)}}</td>
            <td>{{$pendingAmount}}</td>
        </tr>
    @endforeach
</table>

</body>
</html>
