@extends('frontend.layouts.master')
@section("title","Recorded Transactions")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <!-- Main content -->
    <div class="full-row" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                @include('frontend.seller.seller_breadcrumb')
                @include('frontend.seller.seller_sidebar')
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <h3 class="card-title float-left">@lang('website.Recorded Transactions')</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>@lang('website.SL')</th>
                                            <th>@lang('website.Invoice NO')</th>
                                            <th>@lang('website.Seller Name')</th>
                                            <th>@lang('website.Buyer Name')</th>
                                            <th>@lang('website.Product Image')</th>
                                            <th>@lang('website.Product Name')</th>
                                            <th>@lang('website.Quantity')</th>
                                            <th>@lang('website.Sale Amount')</th>
                                            <th>@lang('website.Commission')</th>
                                            <th>@lang('website.VAT') </th>
                                            <th>@lang('website.Total Commission')</th>
                                            <th>@lang('website.Date')</th>
                                            <th>@lang('website.Status')</th>
                                            <th>@lang('website.Print')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($saleRecords as $key => $saleRecord)
                                            <tr>
                                                <td>{{$key + 1}}</td>
                                                <td>{{getInvoiceByBnEn($saleRecord->invoice_code)}}</td>
                                                <td>{{getNameByBnEn($saleRecord->selleruser)}}</td>
                                                <td>{{getNameByBnEn($saleRecord->buyeruser)}}</td>
                                                <td>
                                                    <img src="{{url($saleRecord->product->thumbnail_img)}}" width="50" height="50" alt="">
                                                </td>
                                                <td>{{getNameByBnEn($saleRecord->product)}}</td>
                                                <td>{{getNumberToBangla($saleRecord->product->quantity)}} {{getNameByBnEn($saleRecord->product->unit)}}</td>
                                                <td>{{getNumberWithCurrencyByBnEn($saleRecord->amount)}}</td>
{{--                                                <td>{{single_price($saleRecord->commission)}}</td>--}}
{{--                                                <td>{{single_price($saleRecord->vat)}}</td>--}}
{{--                                                <td>{{single_price($saleRecord->admin_commission)}}</td>--}}
                                                <td>{{getNumberWithCurrencyByBnEn($saleRecord->commission)}}</td>
                                                <td>{{getNumberWithCurrencyByBnEn($saleRecord->vat)}} ({{getNumberToBangla($saleRecord->vat_percentage)}}%)</td>
                                                <td>{{getNumberWithCurrencyByBnEn($saleRecord->admin_commission)}}</td>
                                                <td>{{getDateConvertByBnEn($saleRecord->created_at)}}</td>
                                                <td>
                                                    <span class="bg-success">
                                                        @lang('website.Successful')
                                                    </span>
                                                </td>
                                                <td>
                                                    <a class="btn btn-primary" href="{{route('seller.recorded-transaction.print',encrypt($saleRecord->id))}}"><i class="fa fa-print"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>@lang('website.SL')</th>
                                            <th>@lang('website.Invoice NO')</th>
                                            <th>@lang('website.Seller Name')</th>
                                            <th>@lang('website.Buyer Name')</th>
                                            <th>@lang('website.Product Image')</th>
                                            <th>@lang('website.Product Name')</th>
                                            <th>@lang('website.Quantity')</th>
                                            <th>@lang('website.Sale Amount')</th>
                                            <th>@lang('website.Commission')</th>
                                            <th>@lang('website.VAT')</th>
                                            <th>@lang('website.Total Commission')</th>
                                            <th>@lang('website.Date')</th>
                                            <th>@lang('website.Status')</th>
                                            <th>@lang('website.Print')</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@push('js')
    <script src="{{asset('backend/plugins/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables/dataTables.bootstrap4.js')}}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script>
        $(function () {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });

    </script>
@endpush
