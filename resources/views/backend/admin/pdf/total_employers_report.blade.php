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
    <h2 > Total Job Providers Report</h2>

    <table class="table table-bordered">
        <tr>
            <th>#SL</th>
            <th>Employer Name</th>
            <th>Phone</th>
            <th>Company Name</th>
            <th>Company Phone</th>
            <th>Date</th>
        </tr>
        @foreach($totalEmployers as $key=> $totalEmployer)
            <tr>
                <td>{{$key + 1}}</td>
                <td>{{$totalEmployer->user->name}}</td>
                <td>{{$totalEmployer->user->phone}}</td>
                <td>{{$totalEmployer->seller->company_name}}</td>
                <td>{{$totalEmployer->seller->company_phone}}</td>
                <td>{{date('dS M, Y',strtotime($totalEmployer->created_at))}}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="5" style="text-align: right!important;"><strong>Total Employers</strong></td>
            <td><strong>{{$totalEmployers->count()}}</strong></td>
        </tr>

    </table>

</div>
</body>
</html>
