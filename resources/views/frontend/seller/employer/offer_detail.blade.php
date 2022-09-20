@extends('frontend.layouts.master')
@section("title","Employer Offer Detail")
@push('css')

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
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <h3 class="card-title float-left">@lang('website.Employer Offer Detail')</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>@lang('website.Date')</th>
                                            <th>@lang('website.Candidates')</th>
                                            <th>@lang('website.SMS Sent')</th>
                                            <th>@lang('website.Cost/Message')</th>
                                            <th>@lang('website.Total')</th>
                                            <th>@lang('website.Reply Status')</th>
                                            <th>@lang('website.Reply Message')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($messages as $key => $message)
                                            <tr>
                                                <td>{{getDateConvertByBnEn($message->created_at)}}</td>
                                                <td>{{getNumberToBangla(1)}}</td>
                                                <td>{{getNumberToBangla(1)}}</td>
                                                <td>{{$message->cost_per_sms}}</td>
                                                <td>{{$message->cost_per_sms*1}}</td>
                                                <td>
                                                    @if(!empty($message->receiver_agree_status))
                                                        {{$message->receiver_agree_status}}
                                                    @else
                                                        @lang('website.No Reply Yet')!
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($message->receiver_reply_message))
                                                        {{$message->receiver_reply_message}}
                                                    @else
                                                        @lang('website.No Reply Yet')!
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    @if($messages->count() > 0)
                                        <div class="mt-5 mb-2 text-center">
                                        <a class="btn btn-info" href="{{route('employer.candidates-list',$offer->id)}}">@lang('website.Candidates List')</a>
                                        </div>
                                    @endif
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@push('js')

@endpush
