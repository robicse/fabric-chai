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

<h2>Total Buyer List</h2>

<table class="table table-bordered">
    <tr>
        <th>#SL</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Registration By</th>
        <th>Registration Date</th>
    </tr>
    @foreach($buyers as $key => $buyer)
        <tr>
            <td>{{$key + 1}}</td>
            <td>{{$buyer->user->name}}</td>
            <td>{{$buyer->user->phone}}</td>
            <td>{{$buyer->user->email}}</td>
            <td>{{$buyer->user->reg_by}}</td>
            <td>{{date('d-m-Y',strtotime($buyer->user->created_at))}}</td>
        </tr>
    @endforeach
</table>

</body>
</html>
