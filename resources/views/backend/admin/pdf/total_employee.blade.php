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

<h2>Total Employee List</h2>

<table class="table table-bordered">
    <tr>
        <th>#SL</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Registration By</th>
        <th>Registration Date</th>
    </tr>
    @foreach($employees as $key => $employee)
        <tr>
            <td>{{$key + 1}}</td>
            <td>{{$employee->user->name}}</td>
            <td>{{$employee->user->phone}}</td>
            <td>{{$employee->user->email}}</td>
            <td>{{$employee->user->reg_by}}</td>
            <td>{{date('d-m-Y',strtotime($employee->user->created_at))}}</td>
        </tr>
    @endforeach
</table>

</body>
</html>
