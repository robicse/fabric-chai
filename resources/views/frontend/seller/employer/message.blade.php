@extends('frontend.layouts.master')
@section("title","Message Log")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <!-- Main content -->
    <div class="full-row" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-3 mobile_view">
                    <h3 class="mb-2 text-secondary">@lang('website.Employer Dashboard')</h3>
                </div>
                @include('frontend.seller.seller_sidebar')
                <div class="col-lg-9">
                    <div>
                        @php
                            $per_sms_cost = \App\Model\MessageCharge::pluck('cost_per_sms')->first();
                                $checkTotalChargeSMSSent = checkTotalChargeSMSSent($seller_id) ? checkTotalChargeSMSSent($seller_id) : 0;
                                $checkTotalSmsCostSentAmount = checkTotalSmsCostSentAmount($seller_id) ? checkTotalSmsCostSentAmount($seller_id) : 0;
                                $checkTotalSmsCostSentAmountOnlineCharge = checkTotalSmsCostSentAmountOnlineCharge($seller_id) ? checkTotalSmsCostSentAmountOnlineCharge($seller_id) : 0;
                                $checkTotalCostSMS = checkTotalCostSMS($seller_id) ? checkTotalCostSMS($seller_id) : 0;
                                $checkTotalSmsCostSentAmount = checkTotalSmsCostSentAmount($seller_id) ? checkTotalSmsCostSentAmount($seller_id) : 0;
                                $payment_total_sms_cost = $checkTotalSmsCostSentAmount - $checkTotalSmsCostSentAmountOnlineCharge;
                                //$due_total_sms_cost = $checkTotalCostSMS - $payment_total_sms_cost;

                                $total_paid_sms_cost = totalSMSSend($seller_id) > totalFreeSMS($seller_id) ? totalSMSSend($seller_id) > totalFreeSMS($seller_id) : 0 * $per_sms_cost;
                                $due_total_sms_cost = $total_paid_sms_cost - checkTotalSmsCostSentAmount($seller_id);


                        @endphp
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-6 pb-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <p>@lang('website.Total Free SMS')</p>
                                        <h5 class="card-title">
                                            {{getNumberToBangla(totalFreeSMS($seller_id))}}
                                        </h5>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-6 pb-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <p>@lang('website.Total SMS Sent')</p>
                                        <h5 class="card-title">
                                            {{getNumberToBangla(totalSMSSend($seller_id))}}
                                        </h5>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-6 pb-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <p>@lang('website.Remaining Free SMS')</p>
                                        <h5 class="card-title">
                                            {{getNumberToBangla(totalFreeSMS($seller_id) - totalSMSSend($seller_id))}}
                                        </h5>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-6 pb-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <p>@lang('website.Paid SMS Used')</p>
                                        <h5 class="card-title">
                                            {{totalSMSSend($seller_id) > totalFreeSMS($seller_id) ? getNumberToBangla(totalSMSSend($seller_id) - totalFreeSMS($seller_id)) : getNumberToBangla(0) }}
                                        </h5>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-6 pb-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <p>@lang('website.Per Paid SMS Cost')</p>
                                        <h5 class="card-title">
                                            {{getNumberWithCurrencyByBnEn(two_digit_single_price($per_sms_cost))}}
                                        </h5>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-6 pb-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <p>@lang('website.Total Paid SMS Cost')</p>
                                        <h5 class="card-title">
                                            {{getNumberWithCurrencyByBnEn(two_digit_single_price($total_paid_sms_cost))}}
                                        </h5>

                                    </div>
                                </div>
                            </div>
                            {{--                            <div class="col-lg-3 col-md-3 col-6">--}}
                            {{--                                <div class="card">--}}
                            {{--                                    <div class="card-body text-center">--}}
                            {{--                                        <h5 class="card-title">--}}
                            {{--                                            {{checkTotalFreeSMSSent($seller_id) ? checkTotalFreeSMSSent($seller_id) : 0}}--}}
                            {{--                                        </h5>--}}
                            {{--                                        <p>Total Free SMS</p>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}


                            <div class="col-lg-3 col-md-3 col-6">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <p>@lang('website.Payment Done')</p>
                                        <h5 class="card-title">
                                            {{getNumberWithCurrencyByBnEn(checkTotalSmsCostSentAmount($seller_id))}}
                                        </h5>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-6">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <p>@lang('website.Due SMS Cost')</p>
                                        <h5 class="card-title">
                                            {{getNumberWithCurrencyByBnEn($due_total_sms_cost)}}
                                        </h5>


                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                @if(currency()->code == 'BDT' && $due_total_sms_cost > 10)
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="background-color: #500f50;">
                                        @lang('website.Pay')
                                    </button>
                                @elseif(currency()->code == 'USD' && $due_total_sms_cost > 1)
                                @else
                                    <button type="button" class="btn btn-success" style="background-color: #500f50;" onclick="pay_button()">
                                        @lang('website.Pay')
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="row">
                            <div class="col-12" style="padding-bottom: 20px;">&nbsp;</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <h3 class="card-title float-left">@lang('website.Message Log')</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>@lang('website.SL')</th>
                                            <th>@lang('website.Date and Time')</th>
                                            <th>@lang('website.Send To')</th>
                                            <th>@lang('website.Message')</th>
                                            <th>@lang('website.Cost')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $total_cost = 0;
                                        @endphp
                                        @foreach($messages as $key => $message)
                                            @php
                                                $total_cost += $message->cost_per_sms;
                                            @endphp
                                            <tr>
                                                <td>{{getNumberToBangla($key + 1)}}</td>
                                                <td>{{getDateConvertByBnEn($message->created_at)}}</td>
                                                <td>{{getNameByBnEn($message->user)}}</td>
                                                <td>{{$message->message}}</td>
                                                <td>{{getNumberToBangla($message->cost_per_sms)}}</td>

                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th colspan="5" style="text-align: right">@lang('website.Total Cost'): {{$total_cost}}</th>
                                        </tr>
                                        </tbody>
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

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="staticBackdropLabel">@lang('website.Pay Due Amount')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('pay-now-sms-cost')}}" method="POST">
                        @csrf
                        {{--                        <input type="hidden" name="employee_user_id" value="{{getEmployeeUserIdByEmployeeId($employee->id)}}">--}}
                        <div>
                            <div class="row">
                                <div class="col-4">
                                    <label class="col-form-label">@lang('website.')Commission Due Amount</label>
                                </div>
                                <div class="col-8">
                                    {{--                                    <input type="hidden" name="invoice_code" value="FLI202020" class="form-control">--}}

                                    <input type="text" name="due_amount" value="{{currency()->code == 'BDT' ? format_price_without_symbol($due_total_sms_cost) : single_price_without_symbol($due_total_sms_cost)}}"  style="border: 1px solid #dddddd" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-4">
                                            <input type="radio" name="payment_with" value="Pay Online" id="payOnline" class="shipping_method" onclick="ShowHidePaymentWith()" checked>
                                            <label for="payOnline">@lang('website.')Pay Online</label>
                                        </div>

                                        <div class="col-4">
                                            <input type="radio" name="payment_with" value="Pay Manually" id="PayManually" class="shipping_method" onclick="ShowHidePaymentWith()">
                                            <label for="PayManually">@lang('website.')Pay Manually</label>
                                        </div>


                                        <div class="row">
                                            <div class="col-4">
                                                <div id="div_pay_online">
                                                    <div class="col-12">
                                                        <input type="radio" name="payment_type" value="SSL Commerz" id="SSLCommerz" class="shipping_method" checked>
                                                        <label for="SSLCommerz">@lang('website.')SSL Commerz</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="radio" name="payment_type" value="Stripe" id="Stripe" class="shipping_method">
                                                        <label for="Stripe">@lang('website.')Stripe</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div id="div_pay_manually" style="display: none;">
                                                    <div class="col-4">
                                                        <input type="radio" name="payment_type" value="Cash" id="Cash" class="shipping_method" onclick="ShowHidePaymentType()">
                                                        <label for="Cash">@lang('website.')Cash</label>
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="radio" name="payment_type" value="LC" id="LC" class="shipping_method" onclick="ShowHidePaymentType()">
                                                        <label for="LC">@lang('website.')LC</label>
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="radio" name="payment_type" value="Check" id="Check" class="shipping_method" onclick="ShowHidePaymentType()">
                                                        <label for="Check">@lang('website.')Cheque</label>
                                                    </div>
                                                    <div id="div_check_number" style="display: none;">
                                                        <div class="col-4">
                                                            @lang('website.')Bank Name:
                                                            <input type="text" name="bank_name" id="txtBankName" />
                                                        </div>
                                                        <div class="col-4">
                                                            @lang('website.')Cheque Number:
                                                            <input type="text" name="check_number" id="txtEmail" />
                                                        </div>
                                                        <div class="col-4">
                                                            @lang('website.')Dispatch Date:
                                                            <input type="text" name="dispatch_date" id="txtDispatchDate" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <br/>
                            <div class="col-12">&nbsp;</div>
                            <div class="row" id="div_description" style="display: none;">
                                <div class="col-4">
                                    <label>@lang('website.')Description <span>*</span></label>
                                </div>
                                <div class="col-8">
                                    {{--                    <textarea class="form-control" name="description" required></textarea>--}}
                                    <textarea name="description" id="meta_desc" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="col-4 mt-3">
                                    <label>@lang('website.Account Name'): </label>
                                </div>
                                <div class="col-8 mt-3">@lang('website.Fabric Lagbe Limited')</div>

                                <div class="col-4">
                                    <label>@lang('website.A/c No').: </label>
                                </div>
                                <div class="col-8">{{getNumberToBangla(1301010010590)}}</div>
                                <div class="col-4">
                                    <label>@lang('website.Bank Name'): </label>
                                </div>
                                <div class="col-8">@lang('website.Mutual Trust Bank Limited')</div>
                                <div class="col-4">
                                    <label>@lang('website.Branch Name'): </label>
                                </div>
                                <div class="col-8">@lang('website.Gulshan Branch')</div>
                                <div class="col-4">
                                    <label>@lang('website.Branch Code'): </label>
                                </div>
                                <div class="col-8">{{getNumberToBangla(175261840)}}</div>
                                <div class="col-4">
                                    <label>@lang('website.Swift Code'): </label>
                                </div>
                                <div class="col-8">MTBLBDDHGUL</div>
                                <div class="col-4">
                                    <label>@lang('website.Routing Number'): </label>
                                </div>
                                <div class="col-8">{{getNumberToBangla(145261720)}}</div>
                            </div>

                            <div class="row" style="padding-top: 20px;">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" style="background-color: #ab0e0e;">@lang('website.Close')</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-success" style="background-color: #4ce43a;">@lang('website.Submit')</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<input type="hidden" id="currency_code" value="{{currency()->code}}">
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
        function pay_button(){
            var currency_code = $('#currency_code').val();
            // alert(currency_code)
            if (currency_code == 'BDT'){
                toastr.warning('Due Amount must be greater than 10 BDT');
            }else {
                toastr.warning('Due Amount must be greater than 1 USD');
            }

        }

    </script>
@endpush
