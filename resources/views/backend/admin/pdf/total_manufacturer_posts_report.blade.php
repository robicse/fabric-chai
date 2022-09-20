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
    <h2 > Total Manufacturer Posts Report</h2>

    <table class="table table-bordered">
        <tr>
            <th>#SL</th>
            <th>Manufacturer Name</th>
            <th>Production Capability Name</th>
            <th>Types of Industry</th>
            <th>Unit Price</th>
            <th>Date</th>
        </tr>
        @foreach($totalManufacturerPosts as $key=> $totalManufacturerPost)
            <tr>
                <td>{{$key + 1}}</td>
                <td>{{$totalManufacturerPost->user->name}}</td>
                <td>{{$totalManufacturerPost->wish_to_work}}</td>
                <td>{{$totalManufacturerPost->types_of_industry}}</td>
                <td>{{$totalManufacturerPost->unit_price}}</td>
                <td>{{date('dS M, Y',strtotime($totalManufacturerPost->created_at))}}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="5" style="text-align: right!important;"><strong>Total Posts</strong></td>
            <td><strong>{{$totalManufacturerPosts->count()}}</strong></td>
        </tr>

    </table>

</div>
</body>
</html>
