@extends('frontend.layouts.master')
@section('title', 'My Work Order Details')
@push('css')
    <link rel="stylesheet" href="{{asset('frontend/assets/x-zoom/css/xzoom.min.css')}}">

    <style>
        @media (max-width:700px){
            .xzoom-gallery3{
                width: 80px;
            }
        }
        .table_head{
            font-size: 18px;
            margin-right: 20px;
        }
    </style>
@endpush
@section('content')
    <div class="full-row" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-3">
                    <h3 class="mb-2 text-secondary">@lang('website.Manufacturer Work Order')</h3>
                </div>
                @include('frontend.seller.work_order_sidebar')
                <div class="col-lg-9 col-sm-9">
                    <div class="row single-product-wrapper">
                        <div class="col-12 col-md-6 col-lg-5">
                            <div class="xzoom-container">
                                <img class="img-fluid xzoom3" src="{{url($workOrderProduct->thumbnail_img)}}" xoriginal="{{url($workOrderProduct->thumbnail_img)}}" style="height: 400px; width: 350px;" />
                                @php
                                    $photos=json_decode($workOrderProduct->photos);
                                @endphp
                                <div class="xzoom-thumbs">
                                    @if(count($photos) > 0)
                                        @foreach($photos as $key2 => $photo)
                                            <a href="{{url($photo)}}">
                                                <img class="xzoom-gallery3" width="80" src="{{url($photo)}}" @if($key2 == 0) xpreview="{{url($photo)}}" @endif title="">
                                            </a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-7">
                            <div class="summary-inner">
                                <h1 class="product_title entry-title">{{$workOrderProduct->wish_to_work}}</h1>
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>@lang('website.Types of Industry'):</td>
                                        <td class="td_2"> {{$workOrderProduct->types_of_industry}}</td>
                                    </tr>
                                    @if($workOrderProduct->workOrderCategory)
                                    <tr>
                                        <td>@lang('website.Category'):</td>
                                        <td class="td_2"> {{allCategoryPrint($workOrderProduct->workOrderCategory)}}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td>@lang('website.Unit'):</td>
                                        <td class="td_2"> {{$workOrderProduct->unit ? getNameByBnEn($workOrderProduct->unit) : ''}}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('website.Unit Price'):</td>
                                        <td class="td_2"> {{getNumberWithCurrencyByBnEn($workOrderProduct->unit_price)}}</td>
                                    </tr>
                                    @php
                                        $details = \App\Model\WorkOrderProductDetails::where('work_order_product_id',$workOrderProduct->id)->get();
                                    @endphp
{{--                                    @foreach( $details as $detail)--}}
                                    <tr>
                                        <td>@lang('website.M/C Type'): </td>
                                        @foreach($details as $detail)
                                        <td >
                                            {{$detail->machineType->name}}
                                        </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>@lang('website.Number of Machines'): </td>
                                        @foreach($details as $detail)
                                            <td class="td_2">
                                                {{getNumberToBangla($detail->no_of_machines)}}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>@lang('website.Product Capacity Per Day'): </td>
                                        @foreach($details as $detail)
                                            <td class="td_2">
                                                {{getNumberToBangla($detail->pc_per_day)}} {{$workOrderProduct->unit ? getNameByBnEn($workOrderProduct->unit) : ''}}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>@lang('website.Total Product Capacity Per Day'): </td>
                                        @foreach($details as $detail)
                                            <td class="td_2">
                                                {{getNumberToBangla($detail->total_pc_per_day)}} {{$workOrderProduct->unit ? getNameByBnEn($workOrderProduct->unit) : ''}}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>@lang('website.Minimum Order Quantity'): </td>
                                        @foreach($details as $detail)
                                            <td class="td_2">
                                                {{getNumberToBangla($detail->moq)}} {{$workOrderProduct->unit ? getNameByBnEn($workOrderProduct->unit) : ''}}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>@lang('website.Maximum Order Quantity'): </td>
                                        @foreach($details as $detail)
                                            <td class="td_2">
                                                {{getNumberToBangla($detail->max_oq)}} {{$workOrderProduct->unit ? getNameByBnEn($workOrderProduct->unit) : ''}}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="table_head">@lang('website.Production Time'): </td>
                                        @foreach($details as $detail)
                                            <td class="td_2">
                                                {{getNumberToBangla($detail->production_time)}} @lang('website.Days')
                                            </td>
                                        @endforeach

                                    </tr>
                                    <tr>
                                        <td class="table_head">@lang('website.Finishing Time'): </td>
                                        @foreach($details as $detail)
                                            <td class="td_2">
                                                {{getNumberToBangla($detail->finishing_time)}} @lang('website.Days')
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="">@lang('website.Delivery Time'): </td>
                                        @foreach($details as $detail)
                                            <td class="td_2">
                                                {{getNumberToBangla($detail->delivery_time)}} @lang('website.Days')
                                            </td>
                                        @endforeach
                                    </tr>
{{--                                    @endforeach--}}
                                    <tr>
                                        <td class="table_head">@lang('website.Details'): </td>
                                        <td class="td_2"> {!! $workOrderProduct->description !!}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group pb-2 mb-2">
                                            <div>&nbsp;</div>
                                            <a class="btn btn-info" href="{{route('seller.my-work-order.quotation-list',encrypt($workOrderProduct->id))}}">@lang('website.Quotation List')</a>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group  pb-2 mb-2">
                                            <div>&nbsp;</div>
                                            <a class="btn btn-success" href="{{route('seller.work-order.dashboard')}}">@lang('website.Close')</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @endsection
        @push('js')
            <script src="{{asset('frontend/assets/x-zoom/dist/xzoom.min.js')}}"></script>
            <script src="{{asset('frontend/assets/x-zoom/setup.js')}}"></script>
    @endpush

