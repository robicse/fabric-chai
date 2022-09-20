@extends('frontend.layouts.master')
@section("title","Bidder Information")
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
                    <h3 class="mb-2 text-secondary">Buyer Work Order</h3>
                </div>
                @include('frontend.buyer.work_order_sidebar')
                <div class="col-lg-9">
                    <h4>Bidder Information</h4>

                    @php
                        $user = \App\User::find($wo_bid->sender_user_id);
                        $days = \Carbon\Carbon::parse($user->created_at)->diffInDays(\Carbon\Carbon::now());
                             $complete_bids = \App\Model\WorkOrderBid::where('sender_user_id',$user->id)->where('bid_status',1)->count();
                             $reviews = \App\Model\WorkOrderReview::where('receiver_user_id',$user->id)->count();
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
                                <a href="{{route('buyer.work-order.see-review',encrypt($user->id))}}">
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
                                        <h5 class="card-title">{{userWorkOrderRating($user->id)}}</h5>
                                        <p>Ratings</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="" style="padding-top: 20px;">
                            <div class="row">
                                <div class="card col-6">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td>Name:</td>
                                            <td>{{$user->name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Company Name:</td>
                                            <td>{{$user->seller->company_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Company Phone:</td>
                                            <td>{{$user->seller->company_phone}}</td>
                                        </tr>
                                        <tr>
                                            <td>Company Address:</td>
                                            <td>{{$user->seller->company_address}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="" style="padding-top: 20px;">
                            <h4>Bid Information</h4>
                            <div class="row">
                                <div class="card col-6">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td>Bid Amount:</td>
                                            <td>{{single_price($wo_bid->total_price)}}</td>
                                        </tr>
                                        <tr>
                                            <td>Date and Time:</td>
                                            <td>{{date('j M Y h:i A',strtotime($wo_bid->created_at))}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding-top: 20px;">
                            <div class="col-md-4 col-6">
                                <a class="btn btn-info" href="{{route('buyer.work-order.see-review',encrypt($user->id))}}"> See Reviews</a>
                            </div>
                            @if($wo_bid->bid_status == 0)
                            <div class="col-md-4 col-6">
                                <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> Accept Bid</a>
                            </div>
                            @else
                                <div class="col-md-4 col-6">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#Reviewmodal">
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
                    {{--                    <h5 class="modal-title text-center" id="staticBackdropLabel">Are you sure?</h5>--}}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <h4 class="text-center">Are you sure?</h4>
                        <div>
                            <div style="font-size: 18px;">Are you sure you want to accept the following bid?</div><br>
                            Name: {{$user->name}}<br>
                            Bid: {{single_price($wo_bid->total_price)}}<br>
                            Product: {{$wo_bid->workOrderProduct->wish_to_work}}<br>
                            Quantity: {{$wo_bid->workOrderProduct->moq }} {{$wo_bid->workOrderProduct->unit->name}}<br>
                        </div>
                        <div class="text-center" style="padding-top: 20px;">
                            <a class="btn btn-success" href="{{route('buyer.my-work-order.bid-accept',$wo_bid->id)}}" >Accept Bid</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="Reviewmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="staticBackdropLabel">Are you sure?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('buyer.my-work-order.review-store')}}" method="POST">
                        @csrf
                        <input type="hidden" name="work_order_bid_id" value="{{$wo_bid->id}}">
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
                                    <h5>Rate the seller</h5>
                                    <div class="rating">
                                        <input name="rating" id="e5" value="5" type="radio"><label for="e5">☆</label>
                                        <input name="rating" id="e4" value="4" type="radio"><label for="e4">☆</label>
                                        <input name="rating" id="e3" value="3" type="radio"><label for="e3">☆</label>
                                        <input name="rating" id="e2" value="3" type="radio"><label for="e2">☆</label>
                                        <input name="rating" id="e1" value="1" type="radio"><label for="e1">☆</label>
                                    </div>

                                    <div class="">
                                        <label for="address" style="color: black">Write a review to the seller <span class="required">*</span></label>
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
