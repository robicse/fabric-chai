@extends('frontend.layouts.master')
@section('title', 'Buyer Work Order Product Details')
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
        .td_2{
            padding-left: 50px;
        }
    </style>
@endpush
@section('content')
    <div class="full-row" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-3">
                    <h3 class="mb-2 text-secondary">@lang('website.Buyer Work Order')</h3>
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
                                                {{getNameByBnEn($detail->machineType)}}
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
                                                {{getNumberToBangla($detail->pc_per_day)}} {{getNameByBnEn($workOrderProduct->unit)}}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>@lang('website.Total Product Capacity Per Day'): </td>
                                        @foreach($details as $detail)
                                            <td class="td_2">
                                                {{getNumberToBangla($detail->total_pc_per_day)}} {{getNameByBnEn($workOrderProduct->unit)}}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>@lang('website.Minimum Order Quantity'): </td>
                                        @foreach($details as $detail)
                                            <td class="td_2">
                                                {{getNumberToBangla($detail->moq)}} {{getNameByBnEn($workOrderProduct->unit)}}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>@lang('website.Maximum Order Quantity'): </td>
                                        @foreach($details as $detail)
                                            <td class="td_2">
                                                {{getNumberToBangla($detail->max_oq)}} {{getNameByBnEn($workOrderProduct->unit)}}
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
                                    <tr>
                                        <td class="table_head">@lang('website.Details'): </td>
                                        <td class="td_2"> {!! $workOrderProduct->description !!}</td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                        </div>
                        <div class="col-12 col-md-8 col-lg-8">
                            @php
                                $check = \App\Model\WorkOrderQuotationRequest::where('buyer_user_id',Auth::id())->where('work_order_product_id',$workOrderProduct->id)->first();
                            @endphp

                                <div>
                                    <form action="{{route('buyer.work-order.quotation-request.store')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="work_order_product_id" value="{{$workOrderProduct->id}}">
                                        @if(empty($check))
                                        <div class="row">
                                            <div class="col-4">
                                                <h5>@lang('website.Required Quantity'): ({{getNameByBnEn($workOrderProduct->unit)}})</h5>
                                            </div>
                                            <div class="col-md-8 col-8">
                                                <div class="form-group d-inline">
                                                    <input type="number" class="form-control" name="qty" id="qty" min="{{$workOrderProduct->moq}}" max="{{$workOrderProduct->max_oq}}" placeholder="@lang('website.Enter Your required quantity')" required>
                                                    {{--<input type="number" class="form-control" name="bid_price" id="bid_price" min="0" step="0.00001" placeholder="({{currency_symbol()}}) Enter Your Bid Amount by Unit Price" style="border: 1px solid #dddddd" onkeyup="get_bid_price(this)" required>--}}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-4">
                                                <h5>@lang('website.Bid Price') (@lang('website.Unit')) (@lang('website.'.currency()->code)):</h5>
                                            </div>
                                            <div class="col-md-8 col-8">
                                                <div class="form-group d-inline">

                                                    {{--                                                <input type="hidden" class="form-control" name="qty" id="qty" value="{{$workOrderProduct->moq}}">--}}
                                                    <input type="number" class="form-control" name="bid_price" id="bid_price" min="0" step="0.00001" placeholder="({{currency_symbol()}}) @lang('website.Enter Your Bid Amount by Unit Price')" style="border: 1px solid #dddddd" onkeyup="get_bid_price(this)" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-4">
                                                <h5>@lang('website.Bid Price') (@lang('website.Total')) (@lang('website.'.currency()->code)):</h5>
                                            </div>
                                            <div class="col-md-8 col-8">
                                                <div class="form-group d-inline">
                                                    <input type="number" class="form-control" name="" id="bid_total_price" min="0" step="0.00001" placeholder="0" style="background-color: #f3f3f3" readonly required>
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                        $currency_code = currency()->code == 'BDT' ? 'USD' : 'BDT';
                                        @endphp
                                        <div class="row mt-2">
                                            <div class="col-4">
                                                <h5>@lang('website.Bid Price') (@lang('website.Unit')) (@lang('website.'.$currency_code)):</h5>
                                            </div>
                                            <div class="col-md-8 col-8">
                                                <div class="form-group d-inline">
                                                    <input type="number" class="form-control" name="" id="bid_convert_unit_price" min="0" step="0.00001" placeholder="0" style="background-color: #f3f3f3" readonly required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-4">
                                                <h5>@lang('website.Bid Price') (@lang('website.Total')) (@lang('website.'.$currency_code)):</h5>
                                            </div>
                                            <div class="col-md-8 col-8">
                                                <div class="form-group d-inline">
                                                    <input type="number" class="form-control" name="" id="bid_convert_total_price" min="0" step="0.00001" placeholder="0" style="background-color: #f3f3f3" readonly required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-4">
                                                <h5>@lang('website.Details')</h5>
                                            </div>
                                            <div class="col-md-8 col-8">
                                                <div class="form-group d-inline">
                                                    <textarea class="form-control" name="details" rows="3"></textarea>
                                                </div>
                                            </div>

                                        </div>
                                        @else
                                            <p><span class="text-danger">*</span>@lang('website.You have already requested for quotation')</p>
                                        @endif
                                        <div class="row">

                                            <div class="col-6">

                                                @if(empty($check))
                                                    <div class="form-group pb-2 mb-2">
                                                        <div>&nbsp;</div>
                                                        <button type="submit" class="btn btn-info">@lang('website.Request for Quotation')</button>
                                                    </div>
                                                @else
                                                    <div class="form-group pb-2 mb-2">
                                                        <div>&nbsp;</div>
                                                        <button type="button" class="btn" style="background-color: #7C7C7C">@lang('website.Request Submitted')</button>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group  pb-2 mb-2">
                                                    <div>&nbsp;</div>
                                                    <a class="btn btn-success" href="{{route('buyer.work-order.company-details',encrypt($workOrderProduct->user_id))}}">@lang('website.Company Profile')</a>
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
        <!-- Modal -->
        {{--        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">--}}
        {{--            <div class="modal-dialog">--}}
        {{--                <div class="modal-content">--}}
        {{--                    <div class="modal-header">--}}
        {{--                        <h4 class="modal-title text-center" id="staticBackdropLabel">Request for Quotation</h4>--}}
        {{--                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
        {{--                    </div>--}}
        {{--                    <div class="modal-body">--}}
        {{--                        <div>--}}
        {{--                            <form action="{{route('buyer.work-order.quotation-request.store')}}" method="post">--}}
        {{--                                @csrf--}}
        {{--                                <div>--}}
        {{--                                    <input type="hidden" name="work_order_product_id" value="{{$workOrderProduct->id}}">--}}
        {{--                                    <div style="font-size: 18px;">--}}
        {{--                                        Product: {{$workOrderProduct->name}}<br>--}}
        {{--                                    </div><br>--}}
        {{--                                    <div class="form-group">--}}
        {{--                                        <label>Unit Price </label>--}}
        {{--                                        <input type="text" name="unit_price" id="unit_price" value="{{$workOrderProduct->unit_price}}" class="form-control" readonly>--}}
        {{--                                    </div>--}}
        {{--                                    <div class="form-group mt-2">--}}
        {{--                                        <label>Quantity Required ({{$workOrderProduct->unit->name}})</label>--}}
        {{--                                        <input type="number" name="quantity" id="quantity" min="{{$workOrderProduct->moq}}" class="form-control" onkeyup="get_total_price(this)" required>--}}
        {{--                                        <small class="text-danger">*Minimum Order Quantity: {{$workOrderProduct->moq}} {{$workOrderProduct->unit->name}}</small>--}}
        {{--                                    </div>--}}
        {{--                                    <div class="form-group mt-2">--}}
        {{--                                        <label>Total Price </label>--}}
        {{--                                        <input type="text" name="total_price" id="total_price" class="form-control" readonly>--}}
        {{--                                    </div>--}}
        {{--                                    <div class="form-group mt-2">--}}
        {{--                                        <label>Details </label>--}}
        {{--                                        <textarea class="form-control" name="details" rows="3"></textarea>--}}
        {{--                                    </div>--}}
        {{--                                </div>--}}
        {{--                                <div class="text-center" style="padding-top: 20px;">--}}
        {{--                                    <button type="submit" class="btn btn-success" >Submit</button>--}}
        {{--                                </div>--}}
        {{--                            </form>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
    </div>

@endsection
@push('js')
    <script src="{{asset('frontend/assets/x-zoom/dist/xzoom.min.js')}}"></script>
    <script src="{{asset('frontend/assets/x-zoom/setup.js')}}"></script>

    <script>
        // function get_total_price(el){
        //     var quantity = el.value;
        //     var unit_price =  $('#unit_price').val();
        //     if(quantity == ''){
        //         alert('Quantity must be greater than 0')
        //         return false;
        //     }
        //     if (quantity > 0 && unit_price > 0){
        //         var total_price =unit_price * quantity;
        //         $('#total_price').val(total_price);
        //     }
        // }
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

