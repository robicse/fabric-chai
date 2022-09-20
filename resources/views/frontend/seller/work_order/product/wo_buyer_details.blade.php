@extends('frontend.layouts.master')
@section("title","Work Order Buyer Details")
@push('css')
    <style>
        .p{
            color: black;
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
                    <h4>Work Order Buyer Details</h4>
                    @php
                    $buyer = \App\User::find($workOrder->user_id);
                        $days = \Carbon\Carbon::parse($buyer->created_at)->diffInDays(\Carbon\Carbon::now());
                     $complete_bids = 0;
                     $reviews = \App\Model\Review::where('receiver_user_id',$buyer->id)->count();
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
                                        <h5 class="card-title">{{userRating($buyer->id)}}</h5>
                                        <p>Ratings</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="" style="padding-top: 20px;">
                            <h4>Work Order Buyer Information</h4>
                            <div class="row">
                                <div class="card col-6">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td>Name:</td>
                                            <td>{{$buyer->name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone:</td>
                                            <td>{{$buyer->country_code.$buyer->phone}}</td>
                                        </tr>
                                        <tr>
                                            <td>Address:</td>
                                            <td>{{$buyer->address}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="padding-top: 20px;">
                            <div class="col-md-4 col-6">
                                <a class="btn btn-info" href="{{route('seller.work-order.bidders-review',encrypt($buyer->id))}}"> See Reviews</a>
                            </div>
                            <div class="col-md-4 col-6">
                                <a class="btn btn-success" href="tel:{{$buyer->country_code.$buyer->phone}}"> Call Buyer</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->

@stop
@push('js')

@endpush
