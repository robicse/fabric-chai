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
        <th>Company Name</th>
        <th>Company Phone</th>
        <th>Company Address</th>
        <th>Registration By</th>
        <th>Registration Date</th>
    </tr>
    @foreach($employers as $key => $employer)
        <tr>
            <td>{{$key + 1}}</td>
            <td>{{$employer->user->name}}</td>
            <td>{{$employer->seller->company_name}}</td>
            <td>{{$employer->seller->company_phone}}</td>
            <td>{{$employer->seller->company_address}}</td>
            <td>{{$employer->user->reg_by}}</td>
            <td>{{date('d-m-Y',strtotime($employer->user->created_at))}}</td>
        </tr>
    @endforeach
</table>

</body>
</html>
