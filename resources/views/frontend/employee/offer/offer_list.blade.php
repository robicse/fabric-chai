@extends('frontend.layouts.master')
@section('title', 'Employee Offer List')
@push('css')
    <style>
        .btn {
            padding: 0 10px;
        }
    </style>
@endpush
@section('content')
    <div class="full-row" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-3 mobile_view">
                    <h3 class="mb-2 text-secondary">@lang('website.Employee Dashboard')</h3>
                </div>
                @include('frontend.employee.employee_sidebar')
                <div class="col-lg-9 col-sm-9" style="background: #fff;">
                    <h4 class="text-center mt-2">@lang('website.Offer List')</h4>
                    @if($messages->count() > 0)
                        <div class="card-body table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead >
                                <tr>
                                    <th>@lang('website.SL')</th>
                                    <th>@lang('website.Company Name')</th>
                                    <th>@lang('website.Message')</th>
                                    <th>@lang('website.Date and Time')</th>
                                    <th>@lang('website.Action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($messages as $key => $message)
                                    <tr>
                                        <td>{{getNumberToBangla($key + 1)}}</td>
                                        <td>{{$message->sender->seller->company_name}}</td>
                                        <td>{{$message->message}}</td>
                                        <td>{{getDateConvertByBnEn($message->created_at)}}</td>
                                        <td>
                                            <a class="btn btn-sm btn-success" href="{{route('employee.offer-details',$message->id)}}">
                                                @lang('website.Details')
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>@lang('website.SL')</th>
                                    <th>@lang('website.Company Name')</th>
                                    <th>@lang('website.Message')</th>
                                    <th>@lang('website.Date and Time')</th>
                                    <th>@lang('website.Action')</th>
                                </tr>
                                </tfoot>
                            </table>
                            @else
                                <h3 class="text-center mt-3">@lang('website.No Messages Found')!</h3>
                            @endif
                        </div>
                </div>
            </div>
        </div>

@endsection
@push('js')

@endpush

