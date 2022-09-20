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

<h2>Sales Report</h2>

<table>
    <tr>
        <th>#SL</th>
        <th>Product Name</th>
        <th>Seller Name</th>
        <th>Buyer Name</th>
        <th>Buyer Amount</th>
        <th>Buyer Rating</th>
        <th>Buyer Status</th>
        <th>Seller Rating</th>
        <th>Seller Status</th>
    </tr>
    @foreach($sale_records as $key => $sale_record)
        @php
            $seller = \App\User::where('id',$sale_record->seller_user_id)->first();
            $buyer = \App\User::where('id',$sale_record->buyer_user_id)->first();
        @endphp

        <tr>
            <td>
                {{$key + 1}}
            </td>
            <td>
                {{$sale_record->product->name}}
            </td>
            <td>{{$seller->name}}</td>
            <td>{{$buyer->name}}</td>
            <td>{{$sale_record->amount}}</td>
            <td>{{userRating($sale_record->buyer_user_id)}}</td>
            <td>
                @if(userRating($sale_record->buyer_user_id) >= 1)
                   Complete
                @else
                   In-Complete
                @endif

            </td>
            <td>
                {{userRating($sale_record->seller_user_id)}}
            </td>
            <td>
                @if(userRating($sale_record->seller_user_id) >= 1)
                   Complete
                @else
                    In-Complete
                @endif
            </td>

        </tr>
    @endforeach
</table>

</body>
</html>
