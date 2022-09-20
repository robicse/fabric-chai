<!DOCTYPE html>
<html>
<head>
{{--    <style>--}}
{{--        table {--}}
{{--            font-family: arial, sans-serif;--}}
{{--            border-collapse: collapse;--}}
{{--            width: 100%;--}}
{{--        }--}}

{{--        td, th {--}}
{{--            border: 1px solid #dddddd;--}}
{{--            text-align: left;--}}
{{--            padding: 8px;--}}
{{--        }--}}

{{--        tr:nth-child(even) {--}}
{{--            background-color: #dddddd;--}}
{{--        }--}}
{{--    </style>--}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>
<body>

<h2 class="text-center">SMS Report</h2>

<table class="table table-striped table-bordered">
    <tr>
        <th>#SL</th>
        <th>Name</th>
        <th>Phone</th>
        <th>SMS Sent</th>
    </tr>
    @foreach($sms_reports as $key => $report)
        @php
            $user = \App\User::where('id',$report->sender_user_id)->first();
        @endphp

        <tr>
            <td>{{$key + 1}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->country_code.$user->phone}}</td>
            <td>{{$report->total_sms}}</td>
        </tr>
    @endforeach
</table>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>
