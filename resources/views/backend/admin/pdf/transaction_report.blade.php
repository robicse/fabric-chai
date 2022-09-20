<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>
<body>

<h2 class="text-center">Transaction Report</h2>

<table class="table table-striped table-bordered">
    <tr>
        <th>#SL</th>
        <th>Invoice NO</th>
        <th>Seller Name</th>
        <th>Transaction ID</th>
        <th>Transaction Method</th>
        <th>Currency</th>
        <th>Commission Amount</th>
        <th>Description</th>
        <th>Date</th>
        <th>Payment Status</th>
    </tr>
    @foreach($transaction_reports as $key => $transaction_report)

        <tr>
            <td>{{$key + 1}}</td>
            <td>{{$transaction_report->invoice_code}}</td>
            <td>{{$transaction_report->seller->name}}</td>
            <td>{{$transaction_report->transaction_id}}</td>
            <td>{{$transaction_report->payment_type}}</td>
            <td>{{$transaction_report->currency}}</td>
            <td>{{$transaction_report->amount}}</td>
            <td>{{$transaction_report->description}}</td>
            <td>{{date('j M Y h:i A',strtotime($transaction_report->created_at))}}</td>
            <td>
                {{$transaction_report->payment_status}}
            </td>
        </tr>
    @endforeach
</table>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>
