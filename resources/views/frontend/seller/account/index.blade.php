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
                    <div>
                        @php
                            $getTotalCommissionAmount = getTotalCommissionAmount(Auth::user()->id);
                            $getTotalCommissionPaidAmount = getTotalCommissionPaidAmount(Auth::user()->id);
                        @endphp
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-6">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">
                                            @if(currency()->code == 'BDT')
                                                {{two_digit_single_price(getTotalSaleAmount(Auth::user()->id))}}
                                            @else
                                                {{single_price(getTotalSaleAmount(Auth::user()->id))}}
                                            @endif
                                        </h5>
                                        <p>@lang('website.Total Sale Amount')</p> <br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-6">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">
                                            @if(currency()->code == 'BDT')
                                                {{two_digit_single_price(getTotalCommissionAmount(Auth::user()->id))}}
                                            @else
                                                {{single_price(getTotalCommissionAmount(Auth::user()->id))}}
                                            @endif
                                        </h5>
                                        <p>@lang('website.Total Sale Commission Amount')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-6">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">
                                            @if(currency()->code == 'BDT')
                                                {{two_digit_single_price(getTotalVatAmount(Auth::user()->id))}}
                                            @else
                                                {{single_price(getTotalVatAmount(Auth::user()->id))}}
                                            @endif
                                        </h5>
                                        <p>@lang('website.Total Vat Amount')</p><br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-6">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">
                                            @if(currency()->code == 'BDT')
                                                {{two_digit_single_price(getTotalCommissionPaidAmount(Auth::user()->id))}}
                                            @else
                                                {{single_price(getTotalCommissionPaidAmount(Auth::user()->id))}}
                                            @endif
                                        </h5>
                                        <p>@lang('website.Total Commission Paid Amount')</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="row">
                            <div class="col-12" style="padding-bottom: 20px;">&nbsp;</div>
                        </div>
                    </div>
                    <div>
                        <div class="row">
                            <div class="col-12" style="padding-bottom: 20px;">
                                <div class="card card-info card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title float-left">@lang('website.Recorded Sales')</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body table-responsive">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>@lang('website.SL')</th>
                                                <th>@lang('website.Pay Now')</th>
                                                <th>@lang('website.Invoice NO')</th>
                                                <th>@lang('website.Seller Name')</th>
                                                <th>@lang('website.Buyer Name')</th>
                                                <th>@lang('website.Product Image')</th>
                                                <th>@lang('website.Product Name')</th>
                                                <th>@lang('website.Amount')</th>
                                                <th>@lang('website.Commission')</th>
                                                <th>@lang('website.VAT')</th>
                                                <th>@lang('website.Total Commission')</th>
                                                <th>@lang('website.Quantity')</th>
                                                <th>@lang('website.Date')</th>
                                                <th>@lang('website.Status')</th>
                                                <th>@lang('website.Print')</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($saleRecords as $key => $saleRecord)
                                                <tr>
                                                    <td>{{getNumberToBangla($key + 1)}}</td>
                                                    <td>
                                                        @if($saleRecord->payment_status == 'Pending')
{{--                                                            <a class="btn btn-info" onclick="show_details_modal('{{$saleRecord->id}}');" data-toggle="modal" data-target="#exampleModal">@lang('website.Pay')</a>--}}
                                                            <a class="btn btn-info" href="{{ route('seller.commission_pay',$saleRecord->id) }}">@lang('website.Pay')</a>
                                                        @elseif($saleRecord->payment_status == 'Partial Paid')
                                                            <span class="bg-warning">@lang('website.Partial Paid')</span>
                                                        @else
                                                            <i class="fa fa-check" style="color: green; font-size: 24px;"></i> @lang('website.Paid')
                                                        @endif
                                                    </td>
                                                    <td>{{getInvoiceByBnEn($saleRecord->invoice_code)}}</td>
                                                    <td>{{getNameByBnEn($saleRecord->selleruser)}}</td>
                                                    <td>{{getNameByBnEn($saleRecord->buyeruser)}}</td>
                                                    <td>
                                                        <img src="{{url($saleRecord->product->thumbnail_img)}}" width="50" height="50" alt="">
                                                    </td>
                                                    <td>{{getNameByBnEn($saleRecord->product)}}</td>
                                                    <td>{{getNumberWithCurrencyByBnEn($saleRecord->amount)}}</td>
{{--                                                    <td>{{single_price($saleRecord->commission)}}</td>--}}
{{--                                                    <td>{{single_price($saleRecord->vat)}}</td>--}}
{{--                                                    <td>{{single_price($saleRecord->admin_commission)}}</td>--}}
                                                    <td>{{getNumberWithCurrencyByBnEn($saleRecord->commission)}}</td>
                                                    <td>{{getNumberWithCurrencyByBnEn($saleRecord->vat)}} ({{getNumberToBangla($saleRecord->vat_percentage)}}%)</td>
                                                    <td>{{getNumberWithCurrencyByBnEn($saleRecord->admin_commission)}}</td>
                                                    <td>{{getNumberToBangla($saleRecord->product->quantity)}} {{getNameByBnEn($saleRecord->product->unit)}}</td>
                                                    <td>{{getDateConvertByBnEn($saleRecord->created_at)}}</td>

                                                    @if($saleRecord->payment_status == 'Pending')
                                                        <td>
                                                            <span class="bg-warning">@lang('website.Pending')</span>
                                                        </td>
                                                    @else
                                                        <td>
                                                            <span class="bg-success">
                                                                @if($saleRecord->payment_status == 'Paid')
                                                                    @lang('website.Paid')
                                                                @elseif($saleRecord->payment_status == 'Partial Paid')
                                                                    @lang('website.Partial Paid')
                                                                @endif
                                                            </span>
                                                        </td>
                                                    @endif
                                                    <td>
                                                        <a class="btn btn-primary" href="{{route('seller.recorded-transaction.print',encrypt($saleRecord->id))}}"><i class="fa fa-print"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>@lang('website.SL')</th>
                                                <th>@lang('website.Pay Now')</th>
                                                <th>@lang('website.Invoice NO')</th>
                                                <th>@lang('website.Seller Name')</th>
                                                <th>@lang('website.Buyer Name')</th>
                                                <th>@lang('website.Product Image')</th>
                                                <th>@lang('website.Product Name')</th>
                                                <th>@lang('website.Amount')</th>
                                                <th>@lang('website.Commission')</th>
                                                <th>@lang('website.VAT')</th>
                                                <th>@lang('website.Total Commission')</th>
                                                <th>@lang('website.Quantity')</th>
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
    </div>
    <!-- Modal -->
    <div class="modal fade" id="details_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="modal-content">
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

    <script>

        function show_details_modal(id){
            $.post('{{ route('seller.sale-report.details') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
                $('#details_modal').modal('show', {backdrop: 'static'});
                $('#details_modal #modal-content').html(data);
            });
        }
    </script>
@endpush
