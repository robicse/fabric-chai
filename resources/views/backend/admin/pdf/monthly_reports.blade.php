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

<h2>Monthly Earning Report</h2>

<table>
    <tr>
        <th>#SL</th>
        <th>Name</th>
        <th>Total Product Sold</th>
        <th>Total Commission</th>
        <th>Total Earning</th>
    </tr>
    @foreach($monthly_reports as $key => $monthly_report)
        @php
            $seller = \App\User::where('id',$monthly_report->seller_user_id)->first();
        @endphp

        <tr>
            <td>{{$key + 1}}</td>
            <td>{{$seller->name}}</td>
            <td>{{$monthly_report->total_product_sold}}</td>
            <td>{{getTotalCommissionAmountDateBetween($seller->id,$from_date, $to_date)}}</td>
            <td>{{getTotalCommissionPaidAmountDateBetween($seller->id,$from_date, $to_date)}}</td>
        </tr>
    @endforeach
</table>

</body>
</html>
