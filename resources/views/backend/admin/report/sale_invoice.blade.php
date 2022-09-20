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
                @lang('website.Company Info')
                <address>
                    <strong>@lang('website.Fabric Lagbe')</strong><br>
                    <b>Register Office :</b>Doukadi, Kathalia, Madhobdi, Narsingdi <br>
                    <b>Corporate Office :</b>Azad Plaza (4th Floor), TA-98/1, Gulshan, Badda Link Road, Gulshan-1, Dhaka-1212 <br>
                    <b>Phone :</b> {{getNumberToBangla('09678')}}-{{getNumberToBangla('236236')}}<br>
                    <b>Email :</b> info@fabriclage.com<br>
                </address>
            </div>
        @php
            $seller = \App\Model\Seller::where('user_id',$saleRecord->seller_user_id)->first();
            $buyer = \App\User::where('id',$saleRecord->buyer_user_id)->first();
        @endphp
        <!-- /.col -->
            <div class="col-sm-3 invoice-col">
                @lang('website.Buyer Info')
                <address>
                    <strong>{{getNameByBnEn($buyer)}}</strong><br>
                    {{getAddressByBnEn($buyer)}}<br>
                    Phone:
                    @if(app()->getLocale('locale') == 'en')
                        {{$buyer->country_code}}
                    @else
                        +৮৮০
                    @endif
                    {{getNumberToBangla($buyer->phone)}}<br>
                    Email: {{$buyer->email}}
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-3 invoice-col">
                @lang('website.Seller Info')
                <address>
                    <b>Seller Name:</b> <strong> {{getNameByBnEn($seller->user)}}</strong><br>
                    <b>Phone:</b>
                    @if(app()->getLocale('locale') == 'en')
                        {{$seller->user->country_code}}
                    @else
                        +৮৮০
                    @endif
                    {{getNumberToBangla($seller->user->phone)}}<br>
                    <b>Company Name:</b> {{getCompanyNameByBnEn($seller)}}<br>
                    <b>Company Address:</b> {{getCompanyAddressByBnEn($seller)}}<br>
                    <b>Email:</b> {{$seller->company_email}}
                </address>
            </div>
            <!-- /.col -->
            @php
                $paymentHistory = \App\Model\PaymentHistory::where('sale_record_id',$saleRecord->id)->latest()->first();
            @endphp
            <div class="col-sm-3 invoice-col">
                <b>Invoice: {{getInvoiceByBnEn($saleRecord->invoice_code)}}</b><br>
                <br>
                {{--                <b>Order ID:</b> 4F3S8J<br>--}}
                <b>Create Date:</b> {{getDateConvertByBnEn($saleRecord->created_at)}}<br>
                <b>Payment Date:</b>{{$paymentHistory?getDateConvertByBnEn($saleRecord->updated_at):'N/A'}} <br>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    @php
        $vat = \App\Model\Vat::first();
    @endphp
    <!-- Table row -->
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>@lang('website.Product Name')</th>
                        <th>@lang('website.Qty')</th>
                        <th>@lang('website.Unit Price')</th>
                        <th>@lang('website.Bid Unit Price')</th>
                        <th>@lang('website.Bid Total Price')</th>
                        <th>@lang('website.Commission') ({{commissionValue($saleRecord->membership_package_id)}}%)</th>
                        <th>@lang('website.VAT') ({{getNumberToBangla($saleRecord->vat_percentage)}}%)</th>
                        <th>Payment Status</th>
                        <th>Payment Type</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{getNameByBnEn($saleRecord->product)}}</td>
                        <td>{{getNumberToBangla($saleRecord->product->quantity)}} {{getNameByBnEn($saleRecord->product->unit)}}</td>
                        <td>{{getNumberWithCurrencyByBnEn($saleRecord->product->unit_price)}}</td>
                        <td>{{getNumberWithCurrencyByBnEn($saleRecord->productBid->unit_bid_price)}}</td>
                        <td>{{getNumberWithCurrencyByBnEn($saleRecord->amount)}}</td>
                        <td>{{getNumberWithCurrencyByBnEn($saleRecord->commission)}}</td>
                        <td>{{getNumberWithCurrencyByBnEn($saleRecord->vat)}}</td>
                        <td>{{$saleRecord->payment_status}}</td>

                        <td>{{$paymentHistory?$paymentHistory->payment_type:'N/A'}}</td>
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
                            <th>@lang('website.Commission') ({{getNumberToBangla(commissionValue($saleRecord->membership_package_id))}}%) :</th>
                            <td>{{getNumberWithCurrencyByBnEn($saleRecord->commission)}}</td>
                        </tr>
                        <tr>
                            <th>@lang('website.VAT') ({{getNumberToBangla($saleRecord->vat_percentage)}}%)</th>
                            <td>{{getNumberWithCurrencyByBnEn($saleRecord->vat)}}</td>
                        </tr>
                        <tr>
                            <th>@lang('website.Total Commission'):</th>
                            {{--                            <td>{{$saleRecord->amount-($saleRecord->commission+$saleRecord->vat)}}</td>--}}
                            <td>
                                @php
                                    $total = $saleRecord->commission+$saleRecord->vat;
                                @endphp
                                {{getNumberWithCurrencyByBnEn($total)}}
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('website.Total Commission') <small>(In Word)</small> :</th>
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

        <div style="padding: 20px; padding-top: 150px;">
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
