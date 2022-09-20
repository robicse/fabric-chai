@extends('frontend.layouts.master')
@section('title', 'Company Details')
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <div class="full-row" style="background-color: #ffffff;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-3 mobile_view">
                    <h3 class="mb-2 text-secondary">@lang('website.Employee Dashboard')</h3>
                </div>
                @include('frontend.employee.employee_sidebar')
                <div class="col-lg-9">
                    <div class="card">
                        <div class="row">
                            <div class="col-2">
                                <img src="{{url($message->sender->avatar_original)}}" class="" width="auto" height="100" style="border: 2px solid #ddd;margin: 20px">
                            </div>
                            <div class="col-9" style="margin-top: 20px">
                                <h4 style="color:#000;">{{$message->sender->seller->company_name}}</h4>
                                <h6 style="color:#000;"><i class="fa fa-map-marker"></i> {{$message->sender->seller->company_address}}</h6>
                                <h6 style="color:#000;"><i class="fa fa-phone"></i> {{$message->sender->seller->company_phone}}</h6>
                                <h6 style="color:#000;"><i class="fa fa-users"></i> {{$message->sender->employer->no_of_employee}}</h6>

                                <div style="margin-top: 20px;">
                                   <h5>মেসেজ:</h5>
                                   {{$message->message}}
                                </div>
                                <br/>
                                <br/>
                                <form action="{{route('employee.offer-replay-message')}}" method="POST">
                                    @csrf

                                    <input type="hidden" name="message_id" value="{{$message->id}}">
                                    <div class="col-md-6" style="margin-top: 20px;">
                                        <h5>আপনি আপনি রিপ্লাই দিতে ইচ্ছুক?</h5>
                                        <select name="receiver_agree_status" class="form-control">
                                            <option value="">@lang('website.Select')</option>
                                            <option value="Yes" {{$message->receiver_agree_status == 'Yes' ? 'selected' : ''}}>@lang('website.Yes')</option>
                                            <option value="No" {{$message->receiver_agree_status == 'No' ? 'selected' : ''}}>@lang('website.No')</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <h5>@lang('website.Reply Message'):</h5>
                                        <textarea name="receiver_reply_message" rows="5" cols="45">{{$message->receiver_reply_message}}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-small btn-success" style="color: white; padding: 0 10px;" @if(!empty($message->receiver_reply_message)) disabled @endif>@lang('website.Submit')</button>
                                    </div>
                                </form>
                                <div style="margin-top: 20px; margin-bottom: 20px;">
                                    <a class="btn btn-info" href="{{route('employee.company-info-details',$message->sender_user_id)}}">কোম্পানি তথ্য দেখুন</a>
                                    <a class="btn btn-success" href="tel:{{$message->sender->seller->company_phone}}" style="background-color: #500f50;">কোম্পানিকে কল করুন </a>
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

@endpush

