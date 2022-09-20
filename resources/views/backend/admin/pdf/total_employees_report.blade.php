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
    <h2 > Total Job Seekers Report</h2>

    <table class="table table-bordered">
        <tr>
            <th>#SL</th>
            <th>Employee Name</th>
            <th>Phone</th>
            <th>Date</th>
        </tr>
        @foreach($totalEmployees as $key=> $totalEmployee)
            <tr>
                <td>{{$key + 1}}</td>
                <td>{{$totalEmployee->user->name}}</td>
                <td>{{$totalEmployee->user->phone}}</td>
                <td>{{date('dS M, Y',strtotime($totalEmployee->created_at))}}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3" style="text-align: right!important;"><strong>Total Employees</strong></td>
            <td><strong>{{$totalEmployees->count()}}</strong></td>
        </tr>

    </table>

</div>
</body>
</html>
