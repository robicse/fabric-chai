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
                                <img src="{{url($user->avatar_original)}}" class="" width="auto" height="100" style="border: 2px solid #ddd;margin: 20px">
                            </div>
                            <div class="col-9" style="margin-top: 20px">
                                <h3 style="color:#000;">{{$user->seller->company_name}}</h3>
                                <h6 style="color:#000;"><i class="fa fa-phone"></i> {{$user->seller->company_phone}}</h6>
                                <h6 style="color:#000;"><i class="fa fa-map-marker"></i> {{$user->seller->company_address}}</h6>
                                <h6 style="color:#000;"><i class="fa fa-users"></i> {{$user->employer->no_of_employee}}</h6>
                            </div>
                            <div class="col-12" style="margin: 20px;">
                                <div class="row">
                                    <h3>কোম্পানি তথ্য</h3>
                                    <div class="card col-lg-8 col-md-8 col-12">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <td>প্রতিষ্ঠিত হয়:</td>
                                                <td>{{getNumberToBangla($user->employer->established_year)}}</td>
                                            </tr>
                                            <tr>
                                                <td>মালিকের নাম:</td>
                                                <td>{{$user->employer->owner_name}}</td>
                                            </tr>
                                            <tr>
                                                <td>ঠিকানা:</td>
                                                <td>{{$user->seller->company_address}}</td>
                                            </tr>
                                            <tr>
                                                <td>ফোন নম্বর:</td>
                                                <td>{{$user->seller->company_phone}}</td>
                                            </tr>
                                            <tr>
                                                <td>ইমেইল:</td>
                                                <td>{{$user->seller->company_email}}</td>
                                            </tr>
                                            <tr>
                                                <td>কর্মীর সংখ্যা:</td>
                                                <td>{{$user->employer->no_of_employee}}</td>
                                            </tr>
                                            <tr>
                                                <td>বেতনের প্রকার:</td>
                                                <td>{{$user->employer->salary_type}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div style="margin: 20px;">
                                <a class="btn btn-success" href="tel:{{$user->seller->company_phone}}" style="background-color: #500f50;">কোম্পানিকে কল করুন </a>
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

