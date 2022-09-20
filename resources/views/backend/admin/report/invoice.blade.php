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
                    <img src="{{asset('frontend/logo.png')}}" width="154px">
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
                    <b>Register Office :</b>Doukadi, Kathalia, Madhobdi, Narsingdi <br>
                    <b>Corporate Office :</b>Azad Plaza (4th Floor), TA-98/1, Gulshan, Badda Link Road, Gulshan-1, Dhaka-1212 <br>
                    <b>Phone :</b> 09678-236236<br>
                    <b>Email :</b> info@fabriclage.com<br>
                </address>
            </div>
        @php
            $seller = \App\Model\Seller::where('user_id',$saleRecord->seller_user_id)->first();
            $buyer = \App\User::where('id',$saleRecord->buyer_user_id)->first();
        @endphp
        <!-- /.col -->
            <div class="col-sm-3 invoice-col">
                Buyer Info
                <address>
                    <strong>{{$buyer->name}}</strong><br>
                    {{$buyer->address}}<br>
                    Phone: {{$buyer->country_code.$buyer->phone}}<br>
                    Email: {{$buyer->email}}
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
                <b>Invoice: {{$saleRecord->invoice_code}}</b><br>
                <br>
                <b>Date:</b> {{date('j M Y h:i A',strtotime($saleRecord->updated_at))}}<br>
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
                        <th>Product Name</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                        <th>Bid Unit Price</th>
                        <th>Bid Total Price</th>
                        <th>Commission ({{commissionValue($saleRecord->membership_package_id)}}%)</th>
                        <th>VAT (15 %)</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        <td>{{$saleRecord->product->name}}</td>
                        <td>{{$saleRecord->product->quantity}} {{$saleRecord->product->unit->name}}</td>
                        <td>
                            {{single_price($saleRecord->product->unit_price)}}
                        </td>
                        <td>
                            {{single_price($saleRecord->productBid->unit_bid_price)}}
                        </td>
                        <td>
                            {{single_price($saleRecord->amount)}}
                        </td>
                        <td>
                            {{single_price($saleRecord->commission)}}
                        </td>
                        <td>
                            {{single_price($saleRecord->vat)}}
                        </td>
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
                {{--                <p class="lead">Amount Due 2/22/2014</p>--}}

                <div class="table-responsive">
                    <table class="table">
                        {{--                        <tr>--}}
                        {{--                            <th style="width:50%">Subtotal:</th>--}}
                        {{--                            <td>{{$saleRecord->amount}}</td>--}}
                        {{--                        </tr>--}}
                        <tr>
                            <th>Commission ({{commissionValue($saleRecord->membership_package_id)}}%) :</th>
                            <td>
                                {{single_price($saleRecord->commission)}}
                            </td>
                        </tr>
                        <tr>
                            <th>Vat (15%)</th>
                            <td>
                                {{single_price($saleRecord->vat)}}
                            </td>
                        </tr>
                        <tr>
                            <th>Total Commission:</th>
                            {{--                            <td>{{$saleRecord->amount-($saleRecord->commission+$saleRecord->vat)}}</td>--}}
                            <td>
                                @php
                                    $total = $saleRecord->commission+$saleRecord->vat;
                                @endphp
                                {{single_price($total)}}
                            </td>
                        </tr>
                        <tr>
                            <th>Total Commission <small>(In Word)</small> :</th>
                            <td>
                                {{ucwords($digit->format($total))}} Only
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div style="padding: 20px;">
            <h3 class="text-center">Terms and Condition</h3>
            <p>
                1. Once you confirm you will not be able to accept other bids,
                no one will be able to bid on this product as well.
            </p>
            <p>
                2. Our authority will not take any responsibility for any other transaction or
                product related issue. Payment, delivery, quality, quantity, testing parameter of
                this product will be handled manually by buyer and seller. Fabric Lagbe will not
                liable for any of the aforementioned issues.
            </p>
            <p>
                3. I'm liable to pay {{sellerCurrentCommission($saleRecord->seller_user_id)}}% commission of the above mentioned total price as per
                Bangladeshi Govt. commission regulation act.
            </p>
        </div>
        <div style="padding: 20px;">
            <p>
                ১. বিড একবার কন্ফার্ম হওয়ার পর অন্য কোন বিড গ্রহণ করা যাবে না। আপনার বিড-কৃত পণ্যটিতে অন্য কেউ বিড করতে পারবে না।
            </p>
            <p>
                ২.অ্যাপ কর্তৃপক্ষ অন্য কোনও লেনদেন বা পণ্য সম্পর্কিত সমস্যার জন্য কোনও দায় নিবে না। এই পণ্যটির প্রদান, বিতরণ, গুণগতমান, পরিমান, পরীক্ষার প্যারামিটার ক্রেতা এবং বিক্রেতা ম্যানুয়ালি পরিচানলা করবে।  ফ্যাব্রিক লাগবে উপরোক্ত বিষয়গুলির জন্য দায়বদ্ধ হবে না।
            </p>
            <p>
                ৩. আমি বাংলাদেশ সরকার এর কমিশন নিয়ন্ত্রণ আইন অনুযায়ী উল্লেখিত মোট দামের ১% কমিশন, প্রয়োজনীয় সার্ভিস চার্জ এবং ১৫% সরকারি ভ্যাট প্রদান করতে দায়বদ্ধ।
            </p>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- ./wrapper -->

<script type="text/javascript">
    window.addEventListener("load", window.print());
</script>
</body>
</html>
