@extends('frontend.layouts.master')
@section('title', 'Employee Dashboard')
@push('css')
@endpush
@section('content')
    <div class="full-row" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                @include('frontend.employee.employee_breadcrumb')
                @include('frontend.employee.employee_sidebar')
                <div class="col-lg-9 col-sm-9" style="background: white;">
                    <div class="row mt-4" >
                        <div class="col-12 mb-3">
                            <h3 class="text-center">
                                স্বাগতম, {{getNameByBnEn(Auth::user())}}</h3>
                        </div>
                        <div class="col-6 " style="margin-left: 250px;">
                            <h5 style="color: black">কর্মসংস্থানের অবস্থা:</h5>
                            <form action="{{route('employee.change-job-status')}}" method="POST">
                                @csrf
                                <div class="input-group mb-3 ">
                                    @if(Auth::user()->employee->current_job_status == 0)
                                        <input type="text" class="form-control col-6" placeholder="আমি চাকরী খুঁজছি" readonly>
                                        <button type="submit" class="btn btn-small btn-success" style="color: white; padding: 0 10px;"><i class="fa fa-sync-alt"></i>  পরিবর্তন</button>
                                    @else
                                        <input type="text" class="form-control col-6" placeholder="আমি বর্তমানে চাকরীতে আছি" readonly>
                                        <button type="submit" class="btn btn-small btn-danger" style="color: white; padding: 0 10px;"><i class="fa fa-sync-alt"></i>  পরিবর্তন</button>
                                    @endif
                                </div>
                            </form>
                        </div>
                        @if($messages->count() != 0 && Auth::user()->employee->current_job_status == 0)
                            <div class="mt-5">
                                <h5>আপনার সাম্প্রতিক অফার:</h5>
                                <div class="card-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
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
                                                <td> {{getDateConvertByBnEn($message->created_at)}}</td>
                                                <td>
                                                    <a class="btn btn-sm btn-success" href="{{route('employee.offer-details',$message->id)}}">
                                                        বিস্তারিত
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>#SL</th>
                                            <th>Company Name</th>
                                            <th>Message</th>
                                            <th>Date & Time</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        @else
                            <h4 class="text-center mt-5">@lang('website.No offer found yet')!!!</h4>
                        @endif


                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')

@endpush

