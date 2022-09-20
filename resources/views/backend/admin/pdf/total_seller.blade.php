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

<h2>Total Seller List</h2>

<table class="table table-bordered table-responsive">
    <tr>
        <th>#SL</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Company Name</th>
        <th>Company Phone</th>
        <th>Company Address</th>
        <th>Registration By</th>
        <th>Registration Date</th>
    </tr>
    @foreach($sellers as $key => $seller)
        <tr>
            <td>{{$key + 1}}</td>
            <td>{{$seller->user->name}}</td>
            <td>{{$seller->user->phone}}</td>
            <td>{{$seller->company_name}}</td>
            <td>{{$seller->company_phone}}</td>
            <td>{{$seller->company_address}}</td>
            <td>{{$seller->user->reg_by}}</td>
            <td>{{date('d-m-Y',strtotime($seller->user->created_at))}}</td>
        </tr>
    @endforeach
</table>

</body>
</html>
