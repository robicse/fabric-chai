@extends('frontend.layouts.master')
@section("title","Accounts")
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
                    <div class="card card-info card-outline">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>@lang('website.SL')</th>
                                    <th>@lang('website.Invoice NO')</th>
                                    <th>@lang('website.Seller Name')</th>
                                    <th>@lang('website.Payment With')</th>
                                    <th>@lang('website.Payment Type')</th>
                                    <th>@lang('website.Transaction ID')</th>
                                    <th>@lang('website.Currency')</th>
                                    <th>@lang('website.Amount')</th>
                                    <th>@lang('website.Description')</th>
                                    <th>@lang('website.Date')</th>
                                    <th>@lang('website.Payment Status')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($transaction_reports != null)
                                    @foreach($transaction_reports as $key => $transaction_report)

                                        <tr>
                                            <td>{{getNumberToBangla($key + 1)}}</td>
                                            <td>
                                                {{getInvoiceByBnEn($transaction_report->invoice_code)}}
{{--                                                @php--}}
{{--                                                    $invoice_codes = explode('-',$transaction_report->invoice_code);--}}
{{--                                                    foreach($invoice_codes as $invoice_code){--}}
{{--                                                       echo getNumberToBangla($invoice_code);--}}
{{--                                                    }--}}
{{--                                                @endphp--}}


                                            </td>
                                            <td>{{getNameByBnEn($transaction_report->seller)}}</td>
                                            <td>
                                                @if($transaction_report->payment_with == 'Pay Manually')
                                                    @lang('website.Pay Manually')
                                                @endif
                                            </td>
                                            <td>
                                                @if($transaction_report->payment_type == 'Cash')
                                                    @lang('website.Cash')
                                                @endif
                                            </td>
                                            <td>{{$transaction_report->transaction_id}}</td>
                                            <td>{{currency()->code}}</td>
                                            <td>{{getNumberWithCurrencyByBnEn($transaction_report->amount)}}</td>
                                            <td>{{$transaction_report->description}}</td>
                                            <td>{{getDateConvertByBnEn($transaction_report->created_at)}}</td>
                                            <td>
                                                @if($transaction_report->payment_status == 'Paid')
                                                    @lang('website.Paid')
                                                @elseif($transaction_report->payment_status == 'Partial Paid')
                                                    @lang('website.Partial Paid')
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>@lang('website.SL')</th>
                                    <th>@lang('website.Invoice NO')</th>
                                    <th>@lang('website.Seller Name')</th>
                                    <th>@lang('website.Payment With')</th>
                                    <th>@lang('website.Payment Type')</th>
                                    <th>@lang('website.Transaction ID')</th>
                                    <th>@lang('website.Currency')</th>
                                    <th>@lang('website.Amount')</th>
                                    <th>@lang('website.Description')</th>
                                    <th>@lang('website.Date')</th>
                                    <th>@lang('website.Payment Status')</th>
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
