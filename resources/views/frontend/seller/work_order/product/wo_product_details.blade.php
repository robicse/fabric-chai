@extends('frontend.layouts.master')
@section('title', 'Work Order Details')
@push('css')
    <link rel="stylesheet" href="{{asset('frontend/assets/x-zoom/css/xzoom.min.css')}}">

    <style>
        @media (max-width:700px){
            .xzoom-gallery3{
                width: 80px;
            }
        }
    </style>
@endpush
@section('content')
    <div class="full-row" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-3">
                    <h3 class="mb-2 text-secondary">Manufacturer Work Order</h3>
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
                                        <td class="td_2"> {{two_digit_single_price($workOrderProduct->unit_price)}}</td>
                                    </tr>
                                    <tr>
                                        <td>Machine Types: </td>
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

                                <form action="{{route('seller.work-order-bid.store',$workOrderProduct->id)}}" method="post">
                                    @csrf
                                    @php
                                        $bidCheck =\App\Model\WorkOrderBid::where('sender_user_id',Auth::id())->where('work_order_product_id',$workOrderProduct->id)->first();
                                    @endphp
                                    @if(empty($bidCheck))
{{--                                    <div class="row">--}}
{{--                                        <div class="col-4">--}}
{{--                                            <h5>Bid Your Price </h5>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-7 col-9">--}}
{{--                                            <div class="form-group d-inline">--}}
{{--                                                <input type="number" class="form-control" name="unit_price" id="unit_price" min="0" step="0.00001" placeholder=" Enter Your Bid Price" style="border: 1px solid #dddddd; background-color: white" onkeyup="get_bid_price(this)" required>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                        <div class="row">
                                            <div class="col-3">
                                                <h5>Bid Price (Unit) ({{currency()->code}}):</h5>
                                            </div>
                                            <div class="col-md-9 col-9">
                                                <div class="form-group d-inline">

                                                    <input type="hidden" class="form-control" name="qty" id="qty" value="{{$workOrderProduct->moq}}">
                                                    <input type="number" class="form-control" name="bid_price" id="bid_price" min="0" step="0.00001" placeholder="({{currency_symbol()}}) Enter Your Bid Amount by Unit Price" style="border: 1px solid #dddddd" onkeyup="get_bid_price(this)" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3">
                                                <h5>Bid Price (Total) ({{currency()->code}}):</h5>
                                            </div>
                                            <div class="col-md-9 col-9">
                                                <div class="form-group d-inline">
                                                    <input type="number" class="form-control" name="" id="bid_total_price" min="0" step="0.00001" placeholder="0" style="background-color: #f3f3f3" readonly required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3">
                                                <h5>Bid Price (Unit) ({{currency()->code == 'BDT' ? 'USD' : 'BDT'}}):</h5>
                                            </div>
                                            <div class="col-md-9 col-9">
                                                <div class="form-group d-inline">
                                                    <input type="number" class="form-control" name="" id="bid_convert_unit_price" min="0" step="0.00001" placeholder="0" style="background-color: #f3f3f3" readonly required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3">
                                                <h5>Bid Price (Total) ({{currency()->code == 'BDT' ? 'USD' : 'BDT'}}):</h5>
                                            </div>
                                            <div class="col-md-9 col-9">
                                                <div class="form-group d-inline">
                                                    <input type="number" class="form-control" name="" id="bid_convert_total_price" min="0" step="0.00001" placeholder="0" style="background-color: #f3f3f3" readonly required>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div>
                                            <p>You've already bidden for this product.</p>
                                        </div>
                                    @endif

                                    <div class="row">

                                        @if(empty($bidCheck))
                                        <div class="col-4">
                                            <div class="form-group pb-2 mb-2">
                                                <div>&nbsp;</div>
                                                <button type="submit" class="btn btn-success">Bid for Trade</button>
                                            </div>
                                        </div>
                                        @else
                                            <div class="col-4">
                                                <div class="form-group pb-2 mb-2">
                                                    <div>&nbsp;</div>
                                                    <button class="btn" style="background-color: #7C7C7C">Already Bid</button>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-4">
                                            <div class="form-group  pb-2 mb-2">
                                                <div>&nbsp;</div>
                                                <a class="btn btn-info" href="{{route('seller.work-order.bidders-review',encrypt($workOrderProduct->user_id))}}">See Review</a>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group  pb-2 mb-2">
                                                <div>&nbsp;</div>
                                                <a class="btn btn-primary" href="{{route('seller.work-order.buyer-details',encrypt($workOrderProduct->id))}}">Buyer Profile</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
            <script>
                function get_bidPrice() {
                    var bid_price = $('#bid_price').val();
                    console.log(bid_price)
                    $('#bidPrice').val(bid_price);
                }

                function get_bid_price(el){
                    var bid_price = el.value;
                    var qty = $('#qty').val();
                    //console.log(el.value)
                    $.post('{{ route('bid.price.convert') }}',
                        {
                            _token:'{{ csrf_token() }}',
                            bid_price:bid_price,
                            qty:qty
                        },
                        function(data){
                            // location.reload();
                            console.log(data);
                            $('#bid_total_price').val(data.bid_total_price);
                            $('#bid_convert_unit_price').val(data.bid_convert_unit_price);
                            $('#bid_convert_total_price').val(data.bid_convert_total_price);
                        });
                }
            </script>
    @endpush

