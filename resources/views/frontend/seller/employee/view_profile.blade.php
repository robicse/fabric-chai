@extends('frontend.layouts.master')
@section('title', 'Employee Details')
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">

    <style>
        #the-count {
            float: right;
            padding: 0.1rem 0 0 0;
            font-size: 0.875rem;
        }
    </style>
@endpush
@section('content')
    <div class="full-row" style="background-color: #ffffff;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-3 mobile_view">
                    <h3 class="mb-2 text-secondary">@lang('website.Employer Dashboard')</h3>
                </div>
                @include('frontend.seller.seller_sidebar')
                <div class="col-lg-9">
                    <div class="card">
                        <div class="row">
                            <div class="col-3">
                                @if(!empty($employee->employee_pic))
                                    <img src="{{ url($employee->employee_pic) }}" class="" width="auto" height="100" style="border: 2px solid #ddd;margin: 20px">
                                @else
                                    <img src="{{url($employee->user->avatar_original)}}" class="" width="auto" height="100" style="border: 2px solid #ddd;margin: 20px">
                                @endif
                            </div>
                            <div class="col-9" style="margin-top: 20px">
                                <ul>
                                    <li class="">{{getNameByBnEn($employee->user)}}</li>
                                    <li class="text-success mb-3"><i class="fas fa-shield-alt "></i> {{$employee->verification_status == 0 ? 'Applied' : 'Verified'}}</li>
                                    <li>
                                        <a class="btn btn-info" href="tel:{{$employee->user->country_code}}{{$employee->user->phone}}">@lang('website.Call Now'):</a>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="background-color: #500f50;">
                                            @lang('website.Message')
                                        </button>
                                        @php
                                            $checkAlreadyShortlisted = checkAlreadyShortlisted(getEmployerIdByUserId(Auth::user()->id), $employee->id);
                                        @endphp

                                        <a class="btn btn-{{$checkAlreadyShortlisted && $checkAlreadyShortlisted->status == 1? 'primary':'success'}}" href="{{route('employee.employee_shortlist_unshortlist',$employee->id)}}">
                                            @if($checkAlreadyShortlisted && $checkAlreadyShortlisted->status == 1)
                                                @lang('website.Shortlisted')
                                            @else
                                                @lang('website.Shortlist')
                                            @endif
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top:20px">
                        <div class="col-lg-6 col-md-6 col-12">
                            <h4 class="text-left">@lang('website.Personal Information')</h4>
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td>@lang('website.Name'):</td>
                                    <td>{{getNameByBnEn($employee->user)}}</td>
                                </tr>
                                <tr>
                                    <td>@lang('website.Marital Status'):</td>
                                    <td>@lang('website.'.$employee->marital_status)</td>
                                </tr>
                                <tr>
                                    <td>@lang('website.Age'):</td>
                                    <td>{{getNumberToBangla($employee->age)}}</td>
                                </tr>
                                <tr>
                                    <td>@lang('website.Gender'):</td>
                                    <td>@lang('website.'.$employee->gender)</td>
                                </tr>
                                <tr>
                                    <td>@lang('website.Division'):</td>
                                    <td>
                                        {{$employee->division_id != NULL ? getNameByBnEn($employee->division) :''}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>@lang('website.District'):</td>
                                    <td>{{$employee->district_id != NULL ? getNameByBnEn($employee->district):''}}</td>
                                </tr>
                                <tr>
                                    <td>@lang('website.Thana'):</td>
                                    <td>
                                        {{$employee->upazila != NULL ? getNameByBnEn($employee->upazila):''}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>@lang('website.Post Office'):</td>
                                    <td>
                                        {{$employee->union != NULL ? getNameByBnEn($employee->union):''}}
                                    </td>
                                </tr>

                                <tr>
                                    <td>@lang('website.Village/Area'):</td>
                                    <td>{{$employee->village_or_area}}</td>
                                </tr>
                                <tr>
                                    <td>@lang('website.Contact No'):</td>
                                    <td>{{$employee->user->country_code.$employee->user->phone}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <h4 class="text-left">@lang('website.Job Information')</h4>
                            <table class="table table-bordered">
                                <tbody>
                                @php
                                    $current_salary = explode(' - ',$employee->current_salary);
                                    $expected_salary = explode(' - ',$employee->expected_salary);
                                @endphp
                                <tr>
                                    <td>@lang('website.Current Salary'):</td>
                                    <td>
                                        @if($employee->current_salary)
                                            {{getNumberWithCurrencyByBnEn($current_salary[0]) .' - '. getNumberWithCurrencyByBnEn($current_salary[1]) }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>@lang('website.Expected Salary'):</td>
                                    <td>
                                        @if($employee->expected_salary)
                                            {{getNumberWithCurrencyByBnEn($expected_salary[0]) .' - '. getNumberWithCurrencyByBnEn($expected_salary[1]) }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>@lang('website.Looking For Job In'):</td>
                                    <td>{{$employee->looking_job_industry_category_id ? $employee->lookingForJob->name : '' }}</td>
                                </tr>

                                <tr>
                                    <td>@lang('website.Joining Duration'):</td>
                                    <td>{{$employee->joining_duration}}</td>
                                </tr>
                                <tr>
                                    <td>@lang('website.Expertise'):</td>
                                    <td>{{$employee->industrycategory ? $employee->industrycategory->name : ''}}</td>
                                </tr>
                                </tbody>
                            </table>
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
                    <h5 class="modal-title text-center" id="staticBackdropLabel">@lang('website.Write Your Message')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('employee.employer_to_employee_message')}}" method="POST">
                        @csrf
                        <input type="hidden" name="employee_user_id" value="{{getEmployeeUserIdByEmployeeId($employee->id)}}">
                        <div>
                            <div class="" style="padding-top: 20px">
                                <div class="row">
                                    <div class="">
                                        <textarea class="form-control border border-black" name="message" id="the-textarea" rows="8" placeholder="Textarea" style="background-color: #f3f3f3;" autofocus required></textarea>
                                    </div>
                                </div>
                                <div id="the-count">
                                    <span id="current">0</span>
                                    <span >/</span>
                                    <span id="no_of_sms"> 1</span>
                                </div>
                            </div>
                            <div class="row" style="padding-top: 20px;">
                                <div class="col-md-6 col-6">
                                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" style="background-color: #ab0e0e;">@lang('website.Close')</button>
                                </div>
                                <div class="col-md-6 col-6">
                                    <button type="submit" class="btn btn-success" style="background-color: #4ce43a;">@lang('website.Submit')</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>

        $('textarea').keyup(function() {

            var characterCount = $(this).val().length,
                current = $('#current'),
                no_of_sms = $('#no_of_sms'),
                theCount = $('#the-count');

            current.text(characterCount);
            if (characterCount > 60){
                var value = Math.ceil(parseInt(characterCount)/60);
                $('#no_of_sms').html(value)
            }else {
                $('#no_of_sms').html(1)
            }
        });
    </script>
@endpush

