@extends('backend.layouts.master')
@section("title","Edit Employer")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/select2/select2.min.css')}}">
    <link href="{{asset('frontend/css/intlTelInput.min.css')}}" rel="stylesheet">
{{--    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/css/intlTelInput.css" rel="stylesheet"--}}
{{--          media="screen">--}}
    <link href="https://fonts.googleapis.com/css?family=Alatsi&display=swap" rel="stylesheet">
    {{--this section for custom css only for this page--}}
    <link rel="stylesheet" href="{{asset('frontend/css/doctor-reg.min.css')}}">

    <style>
        .dc-registerformhold {
            background: #fff;
        }

        textarea, select, .dc-select select, .form-control, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input {
            color: #373737;
            outline: none;
            height: 40px;
            background: #fff;
            font-size: 14px;
            -webkit-box-shadow: none;
            box-shadow: none;
            line-height: 18px;
            padding: 10px 20px;
            border-radius: 4px;
            display: inline-block;
            vertical-align: middle;
            border: 1px solid #dddddd;
            text-transform: inherit;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            font-family: 'Alatsi', sans-serif;
        }

        .dc-formregister .dc-registerformgroup .form-group {
            margin: 0;
            padding: 11px;
        }

        .dc-btn {
            min-width: 120px;
            padding: 0 10px;
            font: 400 16px/27px 'Alatsi', sans-serif;
            /*border-color:#9b8cc2;*/
        }
        .dc-joinforms {
            padding: 10px 74px;
        }
        @media (max-width:575px){
            .dc-joinforms{
                padding: 9px 0px;
            }
        }
        .required{
            color: red;
        }
    </style>
@endpush
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Employer</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Edit Employer</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Employer </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{route('admin.employer.update',$employer->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <h5 class="text-info">Personal Information</h5> <hr>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-4 col-sm-4 col-form-label">Name <span class="required">*</span></label>
                                    <div class="col-6 col-sm-6">
                                        <input type="text" class="form-control" name="name" value="{{$employer->user->name}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-4 col-sm-4 col-form-label">Phone Number <span class="required">*</span></label>
                                    <div class="col-1 col-md-2 col-sm-1">
                                        {{--                                        <input id="phone1" type="tel" class="phone_val" name="phone" value="{{$employer->user->phone}}" required>--}}
                                        {{--                                        <input id="countyCodePrefix1" type="hidden" name="countyCodePrefix" value="{{$employer->user->country_code}}" required>--}}
                                        <input type="text" class="form-control" name="countyCodePrefix" value="{{$employer->user->country_code}}" readonly>

                                    </div>
                                    <div class="col-5 col-sm-5 col-md-4">
                                        <input type="number" class="form-control" name="phone" value="{{$employer->user->phone}}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-4 col-sm-4 col-form-label">Email</label>
                                    <div class="col-6 col-sm-6">
                                        <input type="email" class="form-control" name="email" value="{{$employer->user->email}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-4 col-sm-4 col-form-label">Employer's Address</label>
                                    <div class="col-6 col-sm-6">
                                        <input type="text" class="form-control" name="address" value="{{$employer->user->address}}">
                                    </div>
                                </div>

                                <h5 class="text-info" style="margin-top: 50px;">Company Information</h5> <hr>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-4 col-sm-4 col-form-label">Company Name (@lang('website.Optional'))</label>
                                    <div class="col-6 col-sm-6">
                                        <input type="text" class="form-control" name="company_name" value="{{$employer->seller->company_name}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-4 col-sm-4 col-form-label">Company Owner's Name (@lang('website.Optional'))</label>
                                    <div class="col-6 col-sm-6">
                                        <input type="text" class="form-control" name="owner_name" value="{{$employer->owner_name}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-4 col-sm-4 col-form-label">Company Contact No. (@lang('website.Optional'))</label>
                                    <div class="col-6 col-sm-6">
                                        <input type="number" class="form-control" name="company_phone" value="{{$employer->seller->company_phone}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-4 col-sm-4 col-form-label">Company Email (@lang('website.Optional'))</label>
                                    <div class="col-6 col-sm-6">
                                        <input type="email" class="form-control" name="company_email" value="{{$employer->seller->company_email}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-4 col-sm-4 col-form-label">Company Address (@lang('website.Optional'))</label>
                                    <div class="col-6 col-sm-6">
                                        <input type="text" class="form-control" name="company_address" value="{{$employer->seller->company_address}}">
                                    </div>
                                </div>
                                @php
                                    $divisions = \App\Model\Division::all();
                                @endphp
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-4 col-sm-4 col-form-label">Company Address Division (@lang('website.Optional'))</label>
                                    <div class="col-6 col-sm-6">
                                        <select name="division_id" id="division_id" class="form-control demo-select2">
                                            <option value="">Please Select Division</option>
                                            @foreach($divisions as $division)
                                                <option value="{{$division->id}}" {{$employer->seller->division_id == $division->id ? 'Selected' : ''}}>{{$division->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-4 col-sm-4 col-form-label">Company Address District (@lang('website.Optional'))</label>
                                    <div class="col-6 col-sm-6">
                                        <select name="district_id" id="district_id" class="form-control demo-select2">
                                            <option>Select District</option>
                                        </select>
                                    </div>
                                </div>
                                @php
                                    $categories = \App\Model\IndustryCategory::all();
                                @endphp

                                <div class="form-group row">
                                    <label for="industry_category_id" class="col-4 col-sm-4 col-form-label">Looking to Hire (@lang('website.Optional'))</label>
                                    <div class="col-6 col-sm-6">
                                        <select name="industry_category_id[]" id="selected_category" class="form-control demo-select2" multiple>
                                            <option>Select</option>
                                            @foreach($categories as $category)
                                                @php
                                                    $ids = json_decode($employer->industry_category_id)
                                                @endphp
                                                @if($ids)
                                                    @foreach($ids as $id)
                                                        <option value="{{$category->id}}" {{$id == $category->id ? 'selected':''}}>{{$category->name}}</option>
                                                    @endforeach
                                                @endif
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="no_of_employee" class="col-4 col-sm-4 col-form-label">Number of Employees (@lang('website.Optional'))</label>
                                    <div class="col-6 col-sm-6">
                                        <select name="no_of_employee" id="no_of_employee" class="form-control demo-select2">
                                            <option value="">Please Select No. of Employees</option>
                                            <option value="0-10" {{$employer->no_of_employee == '0-10' ? 'Selected':''}}>0-10</option>
                                            <option value="10-50" {{$employer->no_of_employee == '10-50' ? 'Selected':''}}>10-50</option>
                                            <option value="50-100" {{$employer->no_of_employee == '50-100' ? 'Selected':''}}>50-100</option>
                                            <option value="100-200" {{$employer->no_of_employee == '100-200' ? 'Selected':''}}>100-200</option>
                                            <option value="200-500" {{$employer->no_of_employee == '200-500' ? 'Selected':''}}>200-500</option>
                                            <option value="500-1,000" {{$employer->no_of_employee == '500-1,000' ? 'Selected':''}}>500-1,000</option>
                                            <option value="1,000-2,000" {{$employer->no_of_employee == '1,000-2,000' ? 'Selected':''}}>1,000-2,000</option>
                                            <option value="2,000-5,000" {{$employer->no_of_employee == '2,000-5,000' ? 'Selected':''}}>2,000-5,000</option>
                                            <option value="5,000-10,000" {{$employer->no_of_employee == '5,000-10,000' ? 'Selected':''}}>5,000-10,000</option>
                                            <option value="10,000+" {{$employer->no_of_employee == '10,000+' ? 'Selected':''}}>10,000+</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="salary_type" class="col-4 col-sm-4 col-form-label">Company Salary Type (@lang('website.Optional'))</label>
                                    <div class="col-6 col-sm-6">
                                        <select name="salary_type" id="salary_type" class="form-control demo-select2">
                                            <option value="">Please Select Salary Type</option>
                                            <option value="Production" {{$employer->salary_type == 'Production' ? 'Selected':''}}>Production</option>
                                            <option value="Monthly" {{$employer->salary_type == 'Monthly' ? 'Selected':''}}>Monthly</option>
                                            <option value="Bi-Weekly" {{$employer->salary_type == 'Bi-Weekly' ? 'Selected':''}}>Bi-Weekly</option>
                                            <option value="Fixed" {{$employer->salary_type == 'Fixed' ? 'Selected':''}}>Fixed</option>
                                            <option value="Contract" {{$employer->salary_type == 'Contract' ? 'Selected':''}}>Contract</option>
                                            <option value="Other" {{$employer->salary_type == 'Other' ? 'Selected':''}}>Other</option>
                                        </select>
                                    </div>
                                </div>
                                @php
                                    $now = date('Y');
                                    $last= date('Y')-50;
                                @endphp
                                <div class="form-group row">
                                    <label for="established_year" class="col-4 col-sm-4 col-form-label">Company Established Yearc(@lang('website.Optional'))</label>
                                    <div class="col-6 col-sm-6">
                                        <select name="established_year" id="established_year" class="form-control demo-select2">
                                            <option value="">Please Select Established Year</option>
                                            @for($i=$now; $i>= $last; $i--)
                                                <option value="{{$i}}" {{$employer->established_year == $i ? 'Selected':''}}>{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <h5 class="text-info" style="margin-top: 50px;">Please Upload Required Documents (@lang('website.Optional'))</h5> <hr>
                                <div class="form-group row">
                                    <label for="trade_licence" class="col-4 col-sm-4 col-form-label">Trade License</label>

                                    <div class="col-6 col-sm-6" style="margin-top: -10px;">

                                        @if($employer->seller->trade_licence && $employer->seller->trade_licence != "[]"  )
                                            <a href="{{url($employer->seller->trade_licence)}}" target="_blank">{{explode('/', $employer->seller->trade_licence)[3]}}</a>
                                        @endif
                                        <input type="file" class="form-control" value="" name="trade_licence">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="vat" class="col-4 col-sm-4 col-form-label">VAT (@lang('website.Optional'))</label>
                                    <div class="col-6 col-sm-6">
                                        @if($employer->vat)
                                            <a href="{{url($employer->vat)}}" target="_blank">{{explode('/', $employer->vat)[3]}}</a>
                                        @endif
                                        <input type="file" class="form-control" name="vat">
{{--                                        <a href="{{url($employer->vat)}}" target="_blank">--}}
{{--                                            <b class="text-dark">{{$employer->vat}}</b>--}}
{{--                                        </a>--}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="owner_nid_front" class="col-4 col-sm-4 col-form-label">NID of Owner (Front) (@lang('website.Optional'))</label>
                                    <div class="col-6 col-sm-6">
                                        @if($employer->owner_nid_front)
                                            <a href="{{url($employer->owner_nid_front)}}" target="_blank">{{explode('/', $employer->owner_nid_front)[3]}}</a>
                                        @endif
                                        <input type="file" class="form-control" name="owner_nid_front">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="owner_nid_back" class="col-4 col-sm-4 col-form-label">NID of Owner (Back) (@lang('website.Optional'))</label>
                                    <div class="col-6 col-sm-6">
                                        @if($employer->owner_nid_back)
                                            <a href="{{url($employer->owner_nid_back)}}" target="_blank">{{explode('/', $employer->owner_nid_back)[3]}}</a>
                                        @endif
                                        <input type="file" class="form-control" name="owner_nid_back">

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="factory_certificate" class="col-4 col-sm-4 col-form-label">Factory Certificate(@lang('website.Optional'))</label>
                                    <div class="col-6 col-sm-6">
                                        @if($employer->factory_certificate)
                                            <a href="{{url($employer->factory_certificate)}}" target="_blank">{{explode('/', $employer->factory_certificate)[3]}}</a>
                                        @endif
                                        <input type="file" class="form-control" name="factory_certificate">
{{--                                        <a href="{{url($employer->factory_certificate)}}" target="_blank">--}}
{{--                                            <b class="text-dark">{{$employer->factory_certificate}}</b>--}}
{{--                                        </a>--}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="fire_licence" class="col-4 col-sm-4 col-form-label">Fire Licens e</label>
                                    <div class="col-6 col-sm-6">
                                        @if($employer->fire_licence)
                                            <a href="{{url($employer->fire_licence)}}" target="_blank">{{explode('/', $employer->fire_licence)[3]}}</a>
                                        @endif
                                        <input type="file" class="form-control" name="fire_licence">
{{--                                        <a href="{{url($employer->fire_licence)}}" target="_blank">--}}
{{--                                            <b class="text-dark">{{$employer->fire_licence}}</b>--}}
{{--                                        </a>--}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="membership_image" class="col-4 col-sm-4 col-form-label">Membership <small class="text-info">(BTMA/BGMEA/BKMEA/Others)</small></label>
                                    <div class="col-6 col-sm-6">
                                        @if($employer->membership_image)
                                            <a href="{{url($employer->membership_image)}}" target="_blank">{{explode('/', $employer->membership_image)[3]}}</a>
                                        @endif
                                        <input type="file" class="form-control" name="membership_image">
{{--                                        <a href="{{url($employer->membership_image)}}" target="_blank">--}}
{{--                                            <b class="text-dark">{{$employer->membership_image}}</b>--}}
{{--                                        </a>--}}
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
                <!-- right column -->
                <div class="col-md-6">

                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>



@stop
@push('js')
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script src="{{asset('backend/plugins/select2/select2.full.min.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('.demo-select2').select2();
            get_district_by_division();

            function get_district_by_division() {
                var division_id = $('#division_id').val();
                //console.log(category_id)
                $.post('{{ route('get_district_by_division') }}', {
                    _token: '{{ csrf_token() }}',
                    division_id: division_id
                }, function (data) {
                    $('#district_id').html(null);

                    for (var i = 0; i < data.length; i++) {
                        $('#district_id').append($('<option>', {
                            value: data[i].id,
                            text: data[i].name
                        }));
                        $('.demo-select2').select2();
                    }
                    $("#district_id > option").each(function() {
                        if(this.value == '{{$employer->seller->district_id}}'){
                            $("#district_id").val(this.value).change();
                        }
                    });
                });
            }
            $('#division_id').on('change', function () {
                get_district_by_division();
            });
        });
    </script>
@endpush
