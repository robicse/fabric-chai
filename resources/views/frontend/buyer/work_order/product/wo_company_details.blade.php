@extends('frontend.layouts.master')
@section('title', 'Employee Details')
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@section('content')
    <div class="full-row" style="background-color: #ffffff;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-3">
                    <h3 class="mb-2 text-secondary">@lang('website.Buyer Work Order')</h3>
                </div>
                @include('frontend.buyer.work_order_sidebar')
                <div class="col-lg-9">

                    <div class="row">
                        <h3 class="text-center col-md-8">@lang('website.Company and Factory Profile')</h3>
                        <div class="card col-md-8 col-12" >
                            @php
                                $seller = \App\Model\Seller::where('user_id',$user->id)->first();
                                $employer = \App\Model\Employer::where('user_id',$user->id)->first();
                                $factory = \App\Model\WorkorderFactory::where('user_id',$user->id)->first();
                            @endphp
                            <div class="row">
                                <div class="col-3">
                                    @if(!empty($factory->factory_image))
                                        <img src="{{ url($factory->factory_image) }}" class="" width="auto" height="100" style="border: 2px solid #ddd;margin: 20px">
                                    @else
                                        <img src="{{url($seller->user->avatar_original)}}" class="" width="auto" height="100" style="border: 2px solid #ddd;margin: 20px">
                                    @endif
                                </div>
                                <div class="col-9" style="margin-top: 20px">
                                    <ul>
                                        <li class=""><h4>{{getCompanyNameByBnEn($seller)}}</h4></li>
                                        <li class=" mb-3"><i class="fa fa-map-marker"></i> {{getCompanyAddressByBnEn($seller)}}</li>
                                        <li class=" mb-3"><i class="fa fa-users"></i> {{$seller->company_no_of_employee}}</li>
                                        <li>
                                            <a type="button" href="tel:{{$seller->company_phone}}" class="btn btn-success" style="background-color: #500f50;">
                                                @lang('website.Call')
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="row" style="margin-top:20px">
                        <div class="col-lg-8 col-md-8 col-12">
                            <h4 class="text-left">@lang('website.Company Profile')</h4>
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td>@lang('website.Owner Name'):</td>
                                    <td>{{$seller->company_owner_name}}</td>
                                </tr>
                                <tr>
                                    <td>@lang('website.Location'):</td>
                                    <td>{{$seller->company_address}}</td>
                                </tr>
                                <tr>
                                    <td>@lang('website.Phone Number'):</td>
                                    <td>{{$seller->company_phone}}</td>
                                </tr>
                                <tr>
                                    <td>@lang('website.Email'):</td>
                                    <td>{{$seller->company_email}}</td>
                                </tr>
{{--                                <tr>--}}
{{--                                    <td>Number of Staff:</td>--}}
{{--                                    <td>{{$employer->no_of_employee}}</td>--}}
{{--                                </tr>--}}
                                <tr>
                                    <td>@lang('website.Membership'):</td>
                                    <td>{{$seller->user->membershipPackage->package_name}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-8 col-md-8 col-12">
                            <h4 class="text-left">@lang('website.Factory Profile')</h4>
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td>@lang('website.Mill Representative Name 1'):</td>
                                    <td>{{$factory->mill_representative_name_1}}</td>
                                </tr>
                                <tr>
                                    <td>@lang('website.Mill Representative Name 2'):</td>
                                    <td>{{$factory->mill_representative_name_2}}</td>
                                </tr>
                                <tr>
                                    <td>@lang('website.Mill Representative Phone 1'):</td>
                                    <td>{{$factory->mill_representative_phone_1}}</td>
                                </tr>
                                <tr>
                                    <td>@lang('website.Mill Representative Phone 2'):</td>
                                    <td>{{$factory->mill_representative_phone_2}}</td>
                                </tr>

                                <tr>
                                    <td>@lang('website.Ownership Of The Factory'):</td>
                                    <td>{{$factory->ownership_of_the_factory}}</td>
                                </tr>
                                <tr>
                                    <td>@lang('website.Mill Production Strength'):</td>
                                    <td>{{$factory->mill_production_strength}}</td>
                                </tr>
                                <tr>
                                    <td>@lang('website.Membership'):</td>
                                    <td>{{$factory->membership}}</td>
                                </tr>
                                <tr>
                                    <td>@lang('website.Bank Name And Address'):</td>
                                    <td>{{$factory->bank_name_and_address}}</td>
                                </tr>
                                <tr>
                                    <td>@lang('website.Certificate'):</td>
                                    <td>{{$factory->certificate}}</td>
                                </tr>
                                <tr>
                                    <td>@lang('website.Source Of Gas And Electricity'):</td>
                                    <td>{{$factory->source_of_gas_and_electricity}}</td>
                                </tr>
                                <tr>
                                    <td>@lang('website.Total No Of Workers'):</td>
                                    <td>{{$factory->total_no_of_worker}}</td>
                                </tr>
                                <tr>
                                    <td>@lang('website.Location Of The Mill'):</td>
                                    <td>{{$factory->location_of_the_mill}} </td>
                                </tr>
                                <tr>
                                    <td>@lang('website.Trade License Authority'):</td>
                                    <td>{{$factory->trade_license_authority}} </td>
                                </tr>
                                <tr>
                                    <td>@lang('website.Country Of Origin'):</td>
                                    <td>{{$factory->country_of_origin}} </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    @php
                        $featured_products= \App\Model\WorkOrderProduct::where('user_id',$user->id)->where('user_type','seller')->where('published',1)->where('verification_status',1)->latest()->get();
                    @endphp
                    @if($featured_products->count() > 0)
                        <div class="row" style="padding: 30px 0;">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <div class="bg-white border-light border-start">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="section-head d-flex align-items-center p-20 border border-light border-start-0">
                                                        <h4 class="font-500 text-dark mb-0 mr-auto">@lang('website.Products We Make'):</h4>
                                                        <a href="#" class="btn btn-success">@lang('website.View All')</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row e-bg-white e-hover-shadow-one e-border-one" style="min-height: 358px!important;">
                                                @foreach($featured_products as $featured_product)
                                                    {{workOrderProductComponent($featured_product)}}
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')

@endpush

