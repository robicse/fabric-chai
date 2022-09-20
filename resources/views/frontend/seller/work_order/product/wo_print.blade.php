<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Fabric Lagbe | Invoice Print</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 4 -->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('backend/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('backend/dist/css/adminlte.min.css')}}">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body>
<div class="wrapper">
    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-12">
                <h2 class="page-header">
                    <img src="{{asset('frontend/logo.png')}}" width="154px" height="">
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-3 invoice-col">
                Company Info
                <address>
                    <strong>Fabric Lagbe</strong><br>
                    <b>Address :</b> Azad Plaza (4th Floor), TA-98/1, Gulshan, Badda Link Road, Gulshan-1, Dhaka-1212 <br>
                    <b>Phone :</b> 09678-236236<br>
                    <b>Email :</b> info@fabriclage.com<br>
                </address>
            </div>
        @php
            $seller = \App\Model\Seller::where('user_id',$wo_sale_record->seller_user_id)->first();
            $buyer = \App\User::where('id',$wo_sale_record->buyer_user_id)->first();
        @endphp
        <!-- /.col -->
            <div class="col-sm-3 invoice-col">
                Buyer Info
                <address>
                    <b>Name:</b>  <strong>{{$buyer->name}}</strong><br>
                    <b>Address:</b> {{$buyer->address}}<br>
                    <b>Phone:</b> {{$buyer->country_code.$buyer->phone}}<br>
                    <b>Email:</b> {{$buyer->email}}
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-3 invoice-col">
                Seller Info
                <address>
                    <b>Seller Name:</b> <strong> {{$seller->company_name}}</strong><br>
                    <b>Phone:</b> {{$seller->user->country_code.$seller->user->phone}}<br>
                    <b>Company Name:</b> {{$seller->company_name}}<br>
                    <b>Company Address:</b> {{$seller->company_address}}<br>
                    <b>Email:</b> {{$seller->company_email}}
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-3 invoice-col">
                <b>Invoice: {{$wo_sale_record->invoice_code}}</b><br>
                <br>
                <b>Date:</b> {{date('j M Y h:i A',strtotime($wo_sale_record->created_at))}}<br>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Production Capability Name</th>
                        <th>Quantity</th>
                        <th>Sale Price</th>
{{--                        <th>Delivery Time</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{$wo_sale_record->workOrderProduct->wish_to_work}}</td>
                        @if($wo_sale_record->work_order_quotation_request_id == null)
                            <td>{{$wo_sale_record->workOrderProduct->quantity}} {{$wo_sale_record->workOrderProduct->unit->name}}</td>
                        @else
                            <td>{{$wo_sale_record->requestedQuotation->quantity}} {{$wo_sale_record->workOrderProduct->unit->name}}</td>
                        @endif

                        <td>
                            @if(currency()->code == 'BDT')
                                {{two_digit_single_price($wo_sale_record->amount)}}
                            @else
                                {{single_price($wo_sale_record->amount)}}
                            @endif
                        </td>
{{--                        <td>{{$wo_sale_record->workOrderProduct->delivery_time}} Days</td>--}}
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-6">

            </div>
            <!-- /.col -->
            <div class="col-6">

                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th>Total:</th>
                            <td>{{single_price($wo_sale_record->amount)}}</td>
                        </tr>
                        <tr>
                            <th>Total <small>(In Word)</small> :</th>
                            <td>
                                {{ucwords($digit->format($wo_sale_record->amount))}} Only
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>
<!-- ./wrapper -->

<script type="text/javascript">
    window.addEventListener("load", window.print());
</script>
</body>
</html>
