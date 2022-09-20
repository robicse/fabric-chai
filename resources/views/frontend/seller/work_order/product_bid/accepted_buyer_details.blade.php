@extends('frontend.layouts.master')
@section("title","Accepted Bidder Details")
@push('css')
    <style>
        p, p a {
            color: #aaa;
            text-decoration: none;
        }
        p a:hover,
        p a:focus {
            text-decoration: underline;
        }
        p + p { color: #bbb; margin-top: 2em;}
        .detail {position: absolute; text-align: right; right: 5px; bottom: 5px; width: 50%;}

        a[href*="intent"] {
            display:inline-block;
            margin-top: 0.4em;
        }
        /*
   * Rating styles
   */
        .rating {
            width: 226px;
            margin: 0 auto 1em;
            font-size: 45px;
            overflow:hidden;
        }
        .rating input {
            float: right;
            opacity: 0;
            position: absolute;
        }
        .rating a,
        .rating label {
            float:right;
            color: #aaa;
            text-decoration: none;
            -webkit-transition: color .4s;
            -moz-transition: color .4s;
            -o-transition: color .4s;
            transition: color .4s;
        }
        .rating label:hover ~ label,
        .rating input:focus ~ label,
        .rating label:hover,
        .rating a:hover,
        .rating a:hover ~ a,
        .rating a:focus,
        .rating a:focus ~ a		{
            color: orange;
            cursor: pointer;
        }
        .rating2 {
            direction: rtl;
        }
        .rating2 a {
            float:none
        }
        @media (max-width:575px){
            .rating {
                width: 300px;
                margin: 0 auto 1em;
                font-size: 45px;
                overflow:hidden;
            }
        }
    </style>
@endpush
@section('content')
    <!-- Main content -->
    <div class="full-row" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-3">
                    <h3 class="mb-2 text-secondary">Manufacturer Work Order</h3>
                </div>
                @include('frontend.seller.work_order_sidebar')
                <div class="col-lg-9">
                    <h3>Buyer Information</h3>
                    @php
                        $days = \Carbon\Carbon::parse($buyer->created_at)->diffInDays(\Carbon\Carbon::now());
                        $complete_bids = \App\Model\WorkOrderBid::where('receiver_user_id',$buyer->id)->where('bid_status',1)->count();
                        $reviews = \App\Model\WorkOrderReview::where('receiver_user_id',$buyer->id)->count();
                    @endphp
                    <div>
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-6 mb-1">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{$days}}</h5>
                                        <p>Experience (Days)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-6 mb-1">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{$complete_bids}}</h5>
                                        <p>Completed Bids</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-6 mb-1">
                                <a href="{{route('seller.work-order.bidders-review',encrypt($buyer->id))}}">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">{{$reviews}}</h5>
                                            <p>Reviews</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-6 mb-1">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{userWorkOrderRating($buyer->id)}}</h5>
                                        <p>Ratings</p>
                                    </div>
                                </div>
                            </div>
                        </div>

{{--                        <div class="" style="padding-top: 20px;">--}}
{{--                            <div class="row">--}}
{{--                                <div class="card col-8">--}}
{{--                                    <table class="table">--}}
{{--                                        <tbody>--}}
{{--                                        <tr>--}}
{{--                                            <td>Name:</td>--}}
{{--                                            <td>{{$buyer->name}}</td>--}}
{{--                                        </tr>--}}
{{--                                        <tr>--}}
{{--                                            <td>Address:</td>--}}
{{--                                            <td>{{$buyer->address}}</td>--}}
{{--                                        </tr>--}}
{{--                                        <tr>--}}
{{--                                            <td>Phone Number:</td>--}}
{{--                                            <td>{{$buyer->country_code.$buyer->phone}}</td>--}}
{{--                                        </tr>--}}
{{--                                        </tbody>--}}
{{--                                    </table>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="row" style="padding-top: 20px;">
                            <div class="col-md-3 col-4">
                                <a class="btn btn-success" href="{{route('seller.work-order.bidders-review',encrypt($buyer->id))}}" style="background-color: #17a2b8;"> See Reviews</a>
                            </div>
                            <div class="col-md-3 col-4">
                                <a class="btn btn-success" href="tel:{{$buyer->country_code.$buyer->phone}}" style="background-color: #609b35;"> Call Bidder</a>
                            </div>
                            @php
                                $reviewCheck = \App\Model\WorkOrderReview::where('work_order_product_id',$WOProductBid->work_order_product_id)->where('sender_user_id',Auth::id())->first();
                            @endphp
                            @if(empty($reviewCheck))
                                <div class="col-md-3 col-4">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="background-color: #500f50;">
                                        For Review
                                    </button>
                                </div>
                            @endif
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
                    <h5 class="modal-title text-center" id="staticBackdropLabel">Are you sure?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('seller.work-order-review-store')}}" method="POST">
                        @csrf
                        <input type="hidden" name="work_order_bid_id" value="{{$WOProductBid->id}}">
                        <div>
                            <h5>Did this Sale happen?</h5>
                            <div class="row">
                                <div class="col-3">
                                    <input type="radio" name="sale_status" data-index="0" id="sale_status" value="1" class="shipping_method" checked>
                                    <label style="font-size: 22px">Yes</label>
                                </div>
                                <div class="col-3">
                                    <input type="radio" name="sale_status" data-index="0" id="sale_status_no" value="0" class="shipping_method">
                                    <label style="font-size: 22px">No</label>
                                </div>
                            </div>
                            <div class="" style="padding-top: 20px">
                                <div class="row">
                                    <h5>Rate the buyer</h5>
                                    <div class="rating">
                                        <input name="rating" id="e5" value="5" type="radio"><label for="e5">☆</label>
                                        <input name="rating" id="e4" value="4" type="radio"><label for="e4">☆</label>
                                        <input name="rating" id="e3" value="3" type="radio"><label for="e3">☆</label>
                                        <input name="rating" id="e2" value="3" type="radio"><label for="e2">☆</label>
                                        <input name="rating" id="e1" value="1" type="radio"><label for="e1">☆</label>
                                    </div>

                                    <div class="">
                                        <label for="address" style="color: black">Write a review to the buyer <span class="required">*</span></label>
                                        <textarea class="form-control border border-black" name="comment" id="comment" rows="3" placeholder="Textarea" style="background-color: #f3f3f3;" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="padding-top: 20px;">
                                <div class="col-md-6 col-6">
                                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" style="background-color: #ab0e0e;">Close</button>
                                </div>
                                <div class="col-md-6 col-6">
                                    <button type="submit" class="btn btn-success" style="background-color: #4ce43a;">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop
@push('js')

@endpush
