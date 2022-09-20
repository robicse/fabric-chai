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
                    <h3 class="mb-2 text-secondary">Buyer Work Order</h3>
                </div>
                @include('frontend.buyer.work_order_sidebar')
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
                                <h1 class="product_title entry-title">{{$workOrderProduct->name}}</h1>
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>Product:</td>
                                        <td class="td_2"> {{allCategoryPrint($workOrderProduct)}}</td>
                                    </tr>
                                    <tr>
                                        <td>Unit:</td>
                                        <td class="td_2"> {{$workOrderProduct->unit->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Unit Price:</td>
                                        <td class="td_2"> {{single_price($workOrderProduct->unit_price)}}</td>
                                    </tr>
                                    <tr>
                                        <td>M/C Type: </td>
                                        @php
                                            $machineTypes = json_decode($workOrderProduct->machine_type)
                                        @endphp
                                        <td class="td_2">
                                            @foreach($machineTypes as $machineType)
                                                @php
                                                    $machine = \App\Model\MachineType::find($machineType);
                                                @endphp
                                                {{$machine->name}} |
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Number of Machines: </td>
                                        <td class="td_2"> {{$workOrderProduct->no_of_machines}}</td>
                                    </tr>
                                    <tr>
                                        <td>Product Capacity Per Day: </td>
                                        <td class="td_2"> {{$workOrderProduct->pc_per_day}} {{$workOrderProduct->unit->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Product Capacity Per Day: </td>
                                        <td class="td_2"> {{$workOrderProduct->total_pc_per_day}} {{$workOrderProduct->unit->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Minimum Order Quantity: </td>
                                        <td class="td_2"> {{$workOrderProduct->moq}} {{$workOrderProduct->unit->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Required Order Quantity: </td>
                                        <td class="td_2"> {{$workOrderProduct->max_oq}} {{$workOrderProduct->unit->name}}</td>
                                    </tr>
                                    <tr>
                                        <td class="table_head">Production Time: </td>
                                        <td class="td_2"> {{$workOrderProduct->production_time}} Day</td>
                                    </tr>
                                    <tr>
                                        <td class="table_head">Finishing Time: </td>
                                        <td class="td_2"> {{$workOrderProduct->finishing_time}} Day</td>
                                    </tr>
                                    <tr>
                                        <td class="">Delivery Time: </td>
                                        <td class="td_2"> {{$workOrderProduct->delivery_time}} Day</td>
                                    </tr>
                                    <tr>
                                        <td class="table_head">Details: </td>
                                        <td class="td_2"> {!! $workOrderProduct->description !!}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group pb-2 mb-2">
                                            <div>&nbsp;</div>
                                            <a class="btn btn-info" href="{{route('buyer.my-work-order.bidder-list',encrypt($workOrderProduct->id))}}">Bidder List</a>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group  pb-2 mb-2">
                                            <div>&nbsp;</div>
                                            <a class="btn btn-success" href="{{route('buyer.work-order.dashboard')}}">Close</a>
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

