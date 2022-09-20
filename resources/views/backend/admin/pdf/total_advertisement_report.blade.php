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
    <h2 > Total Advertisement Report</h2>

    <table class="table table-bordered">
        <tr>
            <th>#SL</th>
            <th>Title</th>
            <th>Date</th>
        </tr>
        @foreach($totalAdvertisements as $key=> $totalAdvertisement)
            <tr>
                <td>{{$key + 1}}</td>
                <td>{{$totalAdvertisement->title}}</td>
                <td>{{date('dS M, Y',strtotime($totalAdvertisement->created_at))}}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2" style="text-align: right!important;"><strong>Total {{ $type == 'slider' ? 'Sliders': 'Advertisements' }}</strong></td>
            <td><strong>{{$totalAdvertisements->count()}}</strong></td>
        </tr>

    </table>

</div>
</body>
</html>
