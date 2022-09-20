@extends('frontend.layouts.master')
@section('title', 'Membership Packages')
@push('css')
    <style>
        .btn-1 {
            padding: 0 10px;
            background-color: purple;
        }
        .m_t_30{
            margin-top: -30px;
        }
        .t_head{
            background-color: #008000;
            font-size: 20px;
            color: #fff;
        }
    </style>
@endpush
@section('content')
    <!-- /.breadcrumb -->
    <div class="full-row m_t_30">
        <div class="container">
            <div class="row">
                @if(Request::segment(2) == 'work-order')
                    <div class="col-lg-12 pt-3">
                        <h3 class="mb-2 text-secondary">@lang('website.Buyer Work Order')</h3>
                    </div>
                    @include('frontend.buyer.work_order_sidebar')
                @else
                    @include('frontend.buyer.buyer_breadcrumb')
                    @include('frontend.buyer.buyer_sidebar')
                @endif
                <div class="col-lg-9">
                    <h4>@lang('website.Membership Packages')</h4>

                    <table class="table table-bordered" data-pagination="no" data-per-page="5" data-page="1" data-id="3989" data-token="G5CZRAZPRKEY">
                        <thead class="t_head">
                        <tr>
                            <th class="product-name"> <span class="nobr"> @lang('website.Packages') </span></th>
                            @foreach($memberships_packages as $package)
                                <th class="product-price"> <span class="nobr"> {{ getPackageNameByBnEn($package) }} </span></th>
                            @endforeach
                        </tr>
                        </thead>
                        @php
                            $general = \App\Model\MembershipPackageDetail::where('membership_package_id',1)->first();
                            $gold = \App\Model\MembershipPackageDetail::where('membership_package_id',2)->first();
                            $platinum = \App\Model\MembershipPackageDetail::where('membership_package_id',3)->first();
                        @endphp
                        <tbody class="wishlist-items-wrapper">
                        <tr id="yith-wcwl-row-103" data-row-id="103">
                            <td class="product-name">@lang('website.Buy')</td>
                            <td class="product-name">{{getYesNoValue($general->buy)}}</td>
                            <td class="product-name">{{getYesNoValue($gold->buy)}}</td>
                            <td class="product-name">{{getYesNoValue($platinum->buy)}}</td>
                        </tr>
                        <tr id="yith-wcwl-row-103" data-row-id="103">
                            <td class="product-name">@lang('website.Sell')</td>
                            <td class="product-name">{{getYesNoValue($general->sell)}}</td>
                            <td class="product-name">{{getYesNoValue($gold->sell)}}</td>
                            <td class="product-name">{{getYesNoValue($platinum->sell)}}</td>
                        </tr>
                        <tr id="yith-wcwl-row-103" data-row-id="103">
                            <td class="product-name">@lang('website.Commission') %</td>
                            <td class="product-name">{{getNumberToBangla($general->commission)}}</td>
                            <td class="product-name">{{getNumberToBangla($gold->commission)}}</td>
                            <td class="product-name">{{getNumberToBangla($platinum->commission)}}</td>
                        </tr>
                        <tr id="yith-wcwl-row-103" data-row-id="103">
                            <td class="product-name">@lang('website.Job')</td>
                            <td class="product-name">{{getYesNoValue($general->job) }}</td>
                            <td class="product-name">{{getYesNoValue($gold->job) }}</td>
                            <td class="product-name">{{getYesNoValue($platinum->job)}}</td>
                        </tr>
                        <tr id="yith-wcwl-row-103" data-row-id="103">
                            <td class="product-name">@lang('website.Free SMS')</td>
                            <td class="product-name">{{getNumberToBangla($general->free_sms)}}</td>
                            <td class="product-name">{{getNumberToBangla($gold->free_sms)}}</td>
                            <td class="product-name">{{getNumberToBangla($platinum->free_sms)}}</td>
                        </tr>
                        <tr id="yith-wcwl-row-103" data-row-id="103">
                            <td class="product-name">@lang('website.Work Order')</td>
                            <td class="product-name">{{getYesNoValue($general->work_order)}}</td>
                            <td class="product-name">{{getYesNoValue($gold->work_order)}}</td>
                            <td class="product-name">{{getYesNoValue($platinum->work_order)}}</td>
                        </tr>
                        </tbody>

                        <tfoot>
                        <tr>
                            <td class="product-name"> <span class="nobr"> @lang('website.Packages Price') (BDT) </span></td>
                            @php
                                $checkMembershipStatus = checkMembershipStatus(Auth::User()->id);

                            $gold = \App\Model\MembershipPackage::find(2);
                            @endphp
                            @foreach($memberships_packages as $package)
                                <td class="product-price">
                                    @if($checkMembershipStatus == $package->id)
                                        <span class="bg bg-success">@lang('website.Activated')</span>
                                    @elseif($package->id == 1)
                                        <a href="#" class="btn btn-success btn-1" >@lang('website.Free')</a>
                                    @else
                                        <a class="btn btn-info btn-1" href="{{route('buyer.buy_now_details',$package->id)}}">@lang('website.Buy Now')</a>
{{--                                        <a class="btn btn-info btn-1" onclick="show_details_modal('{{$package->id}}');" data-toggle="modal" data-target="#exampleModal">@lang('website.Buy Now')</a>--}}
                                        @if($checkMembershipStatus == 2)
                                        <span class="nobr"> ৳{{getNumberToBangla($package->price -  $gold->price) }} </span>
                                        @else
                                            <span class="nobr"> ৳{{getNumberToBangla($package->price)  }} </span>
                                        @endif
                                    @endif

                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="product-name"> <span class="nobr"> @lang('website.Packages Price') (USD) </span></td>
                            @php
                                $checkMembershipStatus = checkMembershipStatus(Auth::User()->id);
                            @endphp
                            @foreach($memberships_packages as $package)
                                <td class="product-price">
                                    @if($checkMembershipStatus == $package->id)
                                        <span class="bg bg-success">@lang('website.Activated')</span>
                                    @elseif($package->id == 1)
                                        <a href="#" class="btn btn-success btn-1" >@lang('website.Free')</a>
                                    @else
                                        <a class="btn btn-info btn-1" onclick="show_details_modal_usd('{{$package->id}}');" data-toggle="modal" data-target="#exampleModal">@lang('website.Buy Now')</a>

                                        @if($checkMembershipStatus == 2)
                                            <span class="nobr"> ${{ getNumberToBangla(ceil(convert_to_usd($package->price -  $gold->price))) }} </span>
                                        @else
                                            <span class="nobr"> ${{ getNumberToBangla(ceil(convert_to_usd($package->price))) }} </span>
                                        @endif
                                    @endif

                                </td>
                            @endforeach
                        </tr>
                        </tfoot>
                    </table>
                    <div>
                        <h4>@lang('website.Other Facilities and Benefits')</h4>
                        <table class="table table-bordered" data-pagination="no" data-per-page="5" data-page="1" data-id="3989" data-token="G5CZRAZPRKEY">
                            <thead class="t_head">
                            <tr>
                                <th class="product-name"> <span class="nobr"> @lang('website.Other Benefits')</span></th>
                                @foreach($memberships_packages as $package)
                                    <th class="product-price"> <span class="nobr"> {{ getPackageNameByBnEn($package) }} </span></th>
                                @endforeach
                            </tr>
                            </thead>
                            @php
                                $general = \App\Model\MembershipPackageOtherBenefit::where('membership_package_id',1)->first();
                                $gold = \App\Model\MembershipPackageOtherBenefit::where('membership_package_id',2)->first();
                                $platinum = \App\Model\MembershipPackageOtherBenefit::where('membership_package_id',3)->first();
                            @endphp
                            <tbody class="wishlist-items-wrapper">
                            <tr id="yith-wcwl-row-103" data-row-id="103">
                                <td class="product-name">@lang('website.Market strategic information')*</td>
                                <td class="product-name">{{getYesNoValue($general->market_strategic) }}</td>
                                <td class="product-name">{{getYesNoValue($gold->market_strategic) }}</td>
                                <td class="product-name">{{getYesNoValue($platinum->market_strategic)}}</td>
                            </tr>
                            <tr id="yith-wcwl-row-103" data-row-id="103">
                                <td class="product-name">@lang('website.R&D facilities')</td>
                                <td class="product-name">{{getYesNoValue($general->rd_facilities)}}</td>
                                <td class="product-name">{{getYesNoValue($gold->rd_facilities)}}</td>
                                <td class="product-name">{{getYesNoValue($platinum->rd_facilities)}}</td>
                            </tr>
                            <tr id="yith-wcwl-row-103" data-row-id="103">
                                <td class="product-name">@lang('website.Costing facilities')</td>
                                <td class="product-name">{{getYesNoValue($general->costing_facilities)}}</td>
                                <td class="product-name">{{getYesNoValue($gold->costing_facilities)}}</td>
                                <td class="product-name">{{getYesNoValue($platinum->costing_facilities)}}</td>
                            </tr>
                            <tr id="yith-wcwl-row-103" data-row-id="103">
                                <td class="product-name">@lang('website.Promotion facilities')</td>
                                <td class="product-name">{{getYesNoValue($general->promotion_facilities)}}</td>
                                <td class="product-name">{{getYesNoValue($gold->promotion_facilities)}}</td>
                                <td class="product-name">{{getYesNoValue($platinum->promotion_facilities)}}</td>
                            </tr>
                            <tr id="yith-wcwl-row-103" data-row-id="103">
                                <td class="product-name">@lang('website.Bank loan facilities')</td>
                                <td class="product-name">{{getYesNoValue($general->bank_loan_facilities)}}</td>
                                <td class="product-name">{{getYesNoValue($gold->bank_loan_facilities)}}</td>
                                <td class="product-name">{{getYesNoValue($platinum->bank_loan_facilities)}}</td>
                            </tr>
                            <tr id="yith-wcwl-row-103" data-row-id="103">
                                <td class="product-name">@lang('website.Customer acquisition opportunity')</td>
                                <td class="product-name">{{getYesNoValue($general->customer_acquisition_facilities)}}</td>
                                <td class="product-name">{{getYesNoValue($gold->customer_acquisition_facilities)}}</td>
                                <td class="product-name">{{getYesNoValue($platinum->customer_acquisition_facilities)}}</td>
                            </tr>
                            <tr id="yith-wcwl-row-103" data-row-id="103">
                                <td class="product-name">@lang('website.Discount offers')</td>
                                <td class="product-name">{{getYesNoValue($general->discount_offers)}}</td>
                                <td class="product-name">{{getYesNoValue($gold->discount_offers)}}</td>
                                <td class="product-name">{{getYesNoValue($platinum->discount_offers)}}</td>
                            </tr>
                            <tr id="yith-wcwl-row-103" data-row-id="103">
                                <td class="product-name">@lang('website.Training facilities')</td>
                                <td class="product-name">{{getYesNoValue($general->training_facility)}}</td>
                                <td class="product-name">{{getYesNoValue($gold->training_facility)}}</td>
                                <td class="product-name">{{getYesNoValue($platinum->training_facility)}}</td>
                            </tr>
                            <tr id="yith-wcwl-row-103" data-row-id="103">
                                <td class="product-name">@lang('website.Ad discounts')</td>
                                <td class="product-name">{{getYesNoValue($general->ad_discounts)}}</td>
                                <td class="product-name">{{getYesNoValue($gold->ad_discounts)}}</td>
                                <td class="product-name">{{getYesNoValue($platinum->ad_discounts)}}</td>
                            </tr>
                            <tr id="yith-wcwl-row-103" data-row-id="103">
                                <td class="product-name">@lang('website.Credit facilities')</td>
                                <td class="product-name">{{getYesNoValue($general->credit_facilities)}}</td>
                                <td class="product-name">{{getYesNoValue($gold->credit_facilities)}}</td>
                                <td class="product-name">{{getYesNoValue($platinum->credit_facilities)}}</td>
                            </tr>
                            <tr id="yith-wcwl-row-103" data-row-id="103">
                                <td class="product-name">@lang('website.Loyalty Program')</td>
                                <td class="product-name">{{getYesNoValue($general->loyalty_program)}}</td>
                                <td class="product-name">{{getYesNoValue($gold->loyalty_program)}}</td>
                                <td class="product-name">{{getYesNoValue($platinum->loyalty_program)}}</td>
                            </tr>
                            <tr id="yith-wcwl-row-103" data-row-id="103">
                                <td class="product-name">@lang('website.Yarn price update')</td>
                                <td class="product-name">{{getYesNoValue($general->yarn_price_update)}}</td>
                                <td class="product-name">{{getYesNoValue($gold->yarn_price_update)}}</td>
                                <td class="product-name">{{getYesNoValue($platinum->yarn_price_update)}}</td>
                            </tr>
                            </tbody>

                        </table>
                    </div>
                    <div>
                        <h4>@lang('website.Membership Policies of Fabriclagbe.com')</h4>
                        <p>
                            {{getNumberToBangla(1)}}. @lang('website.The membership is not transferable.') <br>
                            {{getNumberToBangla(2)}}. @lang('website.The membership is not saleable')<br>
                            {{getNumberToBangla(3)}}. @lang('website.The validity of the membership is in 365 days')<br>
                            {{getNumberToBangla(4)}}. @lang("website.Member's need to have legal/verifiable identity")<br>
                            {{getNumberToBangla(5)}}. @lang('website.The members have to a verified/identified/declared address for sensitive deal.')<br>
                            {{getNumberToBangla(6)}}. @lang('website.Membership card/id/mobile number must be unique and private (owned by the member)')<br>
                            {{getNumberToBangla(7)}}. @lang('website.Membership will be terminated if any deceased')<br>
                            {{getNumberToBangla(8)}}. @lang("website.Member's must mention the priority date for gifts/vouchers (birthday/anniversary)")<br>
                            {{getNumberToBangla(9)}}. @lang("website.Member's must submit clear photo for order by photo campaign (you may get call from us for confirmation)")<br>
                            {{getNumberToBangla(10)}}. @lang("website.Member's must not order any illegal product or package")<br>
                            {{getNumberToBangla(11)}}. @lang("website.Member's must inform and show the membership in any direct purchase from merchants.")<br>
                            {{getNumberToBangla(12)}}. @lang('website.The discount may vary category wise')<br>
                            {{getNumberToBangla(13)}}. @lang('website.Credit is depended on individual credit score (may need to charge for verification)')<br>
                            {{getNumberToBangla(14)}}. @lang('website.fabriclagbe.com is not liable for credit scores/limit approval')<br>
                            {{getNumberToBangla(15)}}. @lang('website.fabriclagbe.com is authorized to change any offer or condition with prior notice or by the order from the government of Bangladesh or rules and regulations change.')
                        </p>
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
@endsection
@push('js')
    <script>
        function show_details_modal(id){
            $.post('{{ route('buyer.pay-now.details') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
                $('#details_modal').modal('show', {backdrop: 'static'});
                $('#details_modal #modal-content').html(data);
            });
        }
        function show_details_modal_usd(id){
            $.post('{{ route('buyer.pay-now-usd.details') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
                $('#details_modal').modal('show', {backdrop: 'static'});
                $('#details_modal #modal-content').html(data);
            });
        }
    </script>
@endpush
