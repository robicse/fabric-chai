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

<h2>Top Seller Report</h2>

<table>
    <tr>
        <th>#SL</th>
        <th>Name</th>
        <th>Total Product Sold</th>
        <th>Total Commission</th>
        <th>Total Earning</th>
    </tr>
    @foreach($reports as $key => $report)
        @php
            $seller = \App\User::where('id',$report->seller_user_id)->first();
        @endphp

        <tr>
            <td>{{$key + 1}}</td>
            <td>{{$seller->name}}</td>
            <td>{{$report->total_product_sold}}</td>
            <td>{{getTotalCommissionAmount($seller->id)}}</td>
            <td>{{getTotalCommissionPaidAmount($seller->id)}}</td>
        </tr>
    @endforeach
</table>

</body>
</html>
