@extends('frontend.layouts.master')
@section('title', 'Employee Edit Profile')
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/select2/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/dist/css/spectrum.css')}}">
    <style>
        .select2-container--default .color-preview {
            height: 12px;
            width: 12px;
            display: inline-block;
            margin-right: 5px;
            margin-top: 2px;
        }
        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #aaa;
            border-radius: 4px;
            height: 45px!important;
        }

    </style>
@endpush
@section('content')

    <div class="full-row" style=" margin-top: -30px;">
        <div class="container">
            <div class="row">
                @include('frontend.employee.employee_breadcrumb')
                @include('frontend.employee.employee_sidebar')
                <div class="col-lg-9" style="background: white">
                    <h4 class="mt-3">@lang('website.Edit Profile')</h4>
                    <form class="woocommerce-form-login" action="{{route('employee.profile-update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <p class="col-lg-6 col-md-6 col-12">
                                <label for="name">নাম/Name <span class="required">*</span></label>
                                <input type="text" class="form-control" name="name" value="{{getNameByBnEn(Auth::User())}}" id="name"/>
                            </p>
                            <p class="col-lg-6 col-md-6 col-12">
                                <label for="email">ইমেইল/Email&nbsp; (@lang('website.Optional')) </label>
                                <input type="email" class="form-control" name="email" value="{{Auth::User()->email}}" id="" />
                            </p>
                            @php
                                $divisions = \App\Model\Division::all();
                                $districts = \App\Model\District::all();
                                $salary_ranges = \App\Model\SalaryRange::all();
                                $industryCategories = \App\Model\IndustryCategory::all();
                                $industrySubCategories = \App\Model\IndustrySubCategory::all();
                                $industryEmployeeTypes = \App\Model\IndustryEmployeeType::all();
                            @endphp
                            <div class="form-group col-lg-6 col-md-6 col-12">
                                <label for="division_id">বিভাগ/Division (@lang('website.Optional')) </label>
                                <select name="division_id" id="division_id" class="form-control demo-select2">
                                    <option value="">Select</option>
                                    @foreach($divisions as $division)
                                        <option value="{{$division->id}}" {{$employee->division_id == $division->id ? 'selected' : ''}}>{{getNameByBnEn($division)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-12">
                                <label for="district_id">জেলা/District (@lang('website.Optional')) </label>
                                <select name="district_id" id="district_id" class="form-control demo-select2">
                                    @foreach($districts as $district)
                                        <option value="{{$district->id}}" {{$employee->district_id == $district->id ? 'selected' : ''}}>{{getNameByBnEn($district)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-12">
                                <label for="upazila_id">থানা/Thana: &nbsp;<span class="required">*</span></label>
                                <select name="upazila_id" id="upazila_id" class="form-control demo-select2">

                                </select>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-12">
                                <label for="union_id">পোস্ট অফিস/Post Office: &nbsp;<span class="required">*</span></label>
                                <select name="union_id" id="union_id" class="form-control demo-select2">

                                </select>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-12">
                                <label for="city_corporation">সিটি কর্পোরেশন/City Corporation (@lang('website.Optional')) </label>
                                <select name="city_corporation" id="city_corporation" class="form-control demo-select2" >
                                    <option value="">@lang('website.Select')</option>
                                    @foreach(\App\Model\CityCorporation::all() as $cityCorporation)
                                        <option value="{{$cityCorporation->name}}" {{$employee->city_corporation == $cityCorporation->name ? 'selected' : ''}}>{{getNameByBnEn($cityCorporation)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <p class="col-lg-6 col-md-6 col-12">
                                <label for="village_or_area">গ্রাম অথবা এলাকা/Village or area:&nbsp;<span class="required">*</span></label>
                                <input type="text" class="form-control" name="village_or_area" id="village_or_area" value="{{$employee->village_or_area}}" required/>
                            </p>
                            <p class="col-lg-6 col-md-6 col-12">
                                <label for="marital_status">বৈবাহিক অবস্থা/Marital state:&nbsp; <span class="required">*</span></label>
                                <select name="marital_status" id="marital_status" class="form-control demo-select2" required>
                                    <option value="">@lang('website.Select')</option>
                                    <option value="Married" {{$employee->marital_status == 'Married' ? 'selected' : ''}}>@lang('website.Married')</option>
                                    <option value="Unmarried" {{$employee->marital_status == 'Unmarried' ? 'selected' : ''}}>@lang('website.Unmarried')</option>
                                    <option value="Widowed" {{$employee->marital_status == 'Widowed' ? 'selected' : ''}}>@lang('website.Widowed')</option>
                                </select>
                            </p>
                            <p class="col-lg-6 col-md-6 col-12">
                                <label for="gender">লিঙ্গ/Gender:&nbsp;<span class="required">*</span></label>
                                <select name="gender" id="gender" class="form-control demo-select2" required>
                                    <option value="">@lang('website.Select')</option>
                                    <option value="Male" {{$employee->gender == 'Male' ? 'selected' : ''}}>@lang('website.Male')</option>
                                    <option value="Female" {{$employee->gender == 'Female' ? 'selected' : ''}}>@lang('website.Female')</option>
                                    <option value="Neutral" {{$employee->gender == 'Neutral' ? 'selected' : ''}}>@lang('website.Neutral')</option>
                                    <option value="Common" {{$employee->gender == 'Common' ? 'selected' : ''}}>@lang('website.Common')</option>
                                </select>
                            </p>
                            <p class="col-lg-6 col-md-6 col-12">
                                <label for="age">বয়স/Age:&nbsp;<span class="required">*</span></label>
                                <select name="age" id="age" class="form-control demo-select2" required>
                                    <option value="">@lang('website.Select')</option>
                                    @for($i=16;$i<=60;$i++)
                                        <option value="{{$i}}" {{$employee->age == $i ? 'selected' : ''}}>{{getNumberToBangla($i)}}</option>
                                    @endfor
                                </select>
                            </p>
                            <p class="col-lg-6 col-md-6 col-12">
                                <label for="current_salary">বর্তমান বেতন/Current Salary:&nbsp;<span class="required">*</span></label>
                                <select name="current_salary" id="current_salary" class="form-control demo-select2" required>
                                    <option value="">@lang('website.Select')</option>
                                    @foreach($salary_ranges as $salary_range)
                                        <option value="{{$salary_range->start}} - {{$salary_range->end}}" {{$employee->current_salary == $salary_range->start.' - '.$salary_range->end ? 'selected' : ''}}>{{getNumberWithCurrencyByBnEn($salary_range->start)}} - {{getNumberWithCurrencyByBnEn($salary_range->end)}}</option>
                                    @endforeach
                                </select>
                            </p>
                            <p class="col-lg-6 col-md-6 col-12">
                                <label for="expected_salary">কাঙ্ক্ষিত বেতন/Expected Salary:&nbsp;<span class="required">*</span></label>
                                <select name="expected_salary" id="expected_salary" class="form-control demo-select2" required >
                                    <option value="">@lang('website.Select')</option>
                                    @foreach($salary_ranges as $salary_range)
                                        <option value="{{$salary_range->start}} - {{$salary_range->end}}" {{$employee->expected_salary == $salary_range->start.' - '.$salary_range->end ? 'selected' : ''}}>{{getNumberWithCurrencyByBnEn($salary_range->start)}} - {{getNumberWithCurrencyByBnEn($salary_range->end)}}</option>
                                    @endforeach
                                </select>
                            </p>
                            <p class="col-lg-6 col-md-6 col-12">
                                <label for="joining_duration">কয়দিনের মধ্যে যোগদান করতে পারবে / Duration for joining to new job: (@lang('website.Optional')) </label>
                                <select name="joining_duration" id="joining_duration" class="form-control demo-select2" required >
                                    <option value="">@lang('website.Select')</option>
                                    <option value="Immediately" {{$employee->joining_duration == 'Immediately' ? 'selected' : ''}}>@lang('website.Immediately')</option>
                                    <option value="1 Week" {{$employee->joining_duration == '1 Week' ? 'selected' : ''}}>@lang('website.1 Week')</option>
                                    <option value="2 Weeks" {{$employee->joining_duration == '2 Weeks' ? 'selected' : ''}}>@lang('website.2 Weeks')</option>
                                    <option value="1 Month" {{$employee->joining_duration == '1 Month' ? 'selected' : ''}}>@lang('website.1 Month')</option>
                                    <option value="2 Months" {{$employee->joining_duration == '2 Months' ? 'selected' : ''}}>@lang('website.2 Months')</option>
                                </select>
                            </p>
                            <div class="form-group col-lg-6 col-md-6 col-12" id="industry_category_area">
                                <label for="industry_category_id">নিজের দক্ষতা নির্বাচন করুন / Choose your expertise:&nbsp;<span class="required">*</span></label>
                                <select name="industry_category_id" id="industry_category_id" class="form-control demo-select2" >
                                    <option value="">@lang('website.Select')</option>
                                    @foreach($industryCategories as $industryCategory)
                                        <option value="{{$industryCategory->id}}" {{$employee->industry_category_id == $industryCategory->id ? 'selected' : ''}}>{{getNameByBnEn($industryCategory)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-12" id="industry_sub_category_area">
                                <label for="industry_sub_category_id">Industry Sub Category (@lang('website.Optional')) </label>
                                <select name="industry_sub_category_id" id="industry_sub_category_id" class="form-control demo-select2">
                                    @foreach($industrySubCategories as $industrySubCategory)
                                        <option value="{{$industrySubCategory->id}}" {{$employee->industry_sub_category_id == $industrySubCategory->id ? 'selected' : ''}}>{{getNameByBnEn($industrySubCategory)}}</option>
                                    @endforeach
{{--                                    @foreach($industrySubCategories as $industrySubCategory)--}}
{{--                                        <option value="{{$industrySubCategory->id}}" {{$employee->industry_sub_category_id == $industrySubCategory->id ? 'selected' : ''}}>{{$industrySubCategory->name}}</option>--}}
{{--                                    @endforeach--}}

                                </select>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-12" id="industry_employee_type_area">
                                <label for="industry_employee_type_id">Industry Employee Type (@lang('website.Optional')) </label>
                                <select name="industry_employee_type_id" id="industry_employee_type_id" class="form-control demo-select2">
                                    @foreach($industryEmployeeTypes as $industryEmployeeType)
                                        <option value="{{$industryEmployeeType->id}}" {{$employee->industry_employee_type_id == $industryEmployeeType->id ? 'selected' : ''}}>{{getNameByBnEn($industryEmployeeType)}}</option>
                                    @endforeach
{{--                                    @foreach($industryEmployeeTypes as $industryEmployeeType)--}}
{{--                                        <option value="{{$industryEmployeeType->id}}" {{$employee->industry_employee_type_id == $industryEmployeeType->id ? 'selected' : ''}}>{{$industryEmployeeType->name}}</option>--}}
{{--                                    @endforeach--}}
                                </select>
                            </div>
                            @php
                                $y = date('Y');
                            @endphp
                            <div style="display: none">
                                <select class="years">
                                    <option>Select</option>
                                    @for($i=$y;$i >= 1990; $i--)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div style="display: none">
                                <select class="end_years">
                                    <option>@lang('website.Select')</option>
                                    <option value="Current">Current</option>
                                    @for($i=$y;$i >= 1990; $i--)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div style="display: none">
                                <select class="form-control levels" name="level[]" id="level_1" onchange="getDegree(1,this)" style="background-color: white">
                                    @foreach(\App\Model\EducationLevel::all() as $educationLevel)
                                        <option value="{{$educationLevel->name}}" >{{$educationLevel->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group ">
                                <label class="control-label ml-3">এনআইডি সামনের দিক/NID front side:&nbsp;<span class="required">*</span> <small class="text-danger">(jpg,jpeg,png file only)</small></label>
                                <div class="ml-3 mr-3">
                                    <div class="row" id="nid_front_side">
                                        @if ($employee->nid_front_side != null)
                                            <div class="col-md-3 col-sm-4 col-xs-6">
                                                <div class="img-upload-preview">
                                                    <img loading="lazy"  src="{{ url($employee->nid_front_side) }}" alt="" class="img-responsive">
                                                    <input type="hidden" name="previous_factory_certificate" value="{{ $employee->nid_front_side }}">
                                                    <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row" id="nid_front_side_alt"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label ml-3">এনআইডি পিছনের দিক/NID back side:&nbsp;<span class="required">*</span> <small class="text-danger">(jpg,jpeg,png file only)</small></label>
                                <div class="ml-3 mr-3">
                                    <div class="row" id="nid_back_side">
                                        @if ($employee->nid_back_side != null)
                                            <div class="col-md-3 col-sm-4 col-xs-6">
                                                <div class="img-upload-preview">
                                                    <img loading="lazy"  src="{{ url($employee->nid_back_side) }}" alt="" class="img-responsive">
                                                    <input type="hidden" name="previous_factory_certificate" value="{{ $employee->nid_back_side }}">
                                                    <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row" id="nid_back_side_alt"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label ml-3">নিজের ছবি আপলোড করুন / Upload your picture:&nbsp;<span class="required">*</span> <small class="text-danger">(jpg,jpeg,png file only)</small></label>
                                <div class="ml-3 mr-3">
                                    <div class="row" id="employee_pic">
                                        @if ($employee->employee_pic != null)
                                            <div class="col-md-3 col-sm-4 col-xs-6">
                                                <div class="img-upload-preview">
                                                    <img loading="lazy"  src="{{ url($employee->employee_pic) }}" alt="" class="img-responsive">
                                                    <input type="hidden" name="previous_factory_certificate" value="{{ $employee->employee_pic }}">
                                                    <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row" id="employee_pic_alt"></div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="woocommerce-form-login__submit btn btn-primary rounded-0" >@lang('website.Update')</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{asset('backend/plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('backend/dist/js/spartan-multi-image-picker-min.js')}}"></script>
    <script>
        $(document).ready(function () {
            get_district();
            get_industry_sub_category_by_industry_category();
            get_industry_employee_type_by_industry_sub_category();
            getDegree(1,this);
            $('.demo-select2').select2();
        });

        $("#email").keyup(function () {
            var email = $("#email").val();
            console.log(email);
            $('#company_email').val(email);
        })
        $("#phone1").keyup(function () {
            var phone = $("#phone1").val();
            console.log(phone);
            $('#company_phone').val(phone);
        })

        // Get BN EN Name
        function getNameBnEn($name,$name_bn){
            var lang = $('#lang').val();
            var curr_lang = '';
            if(lang === 'en'){
                curr_lang = $name;
            }else{
                curr_lang = $name_bn ? $name_bn : $name;
            }
            return curr_lang;
        }

        function get_district() {
            var division_id = $('#division_id').val();
            $.post('{{ route('get_district_by_division') }}', {
                _token: '{{ csrf_token() }}',
                division_id: division_id
            }, function (data) {
                $('#district_id').html(null);
                for (var i = 0; i < data.length; i++) {
                    $('#district_id').append($('<option>', {
                        value: data[i].id,
                        text: getNameBnEn(data[i].name,data[i].name_bn)
                    }));
                    $('.demo-select2').select2();
                }
                $("#district_id > option").each(function() {
                    if(this.value == '{{$employee->district_id}}'){
                        $("#district_id").val(this.value).change();
                    }
                });
                get_upazila_by_district();
            });
        }

        $('#division_id').on('change', function () {
            console.log('jksdfjsZBGjd')
            get_district();
        });
        function get_upazila_by_district() {
            var district_id = $('#district_id').val();
            //console.log(category_id)
            $.post('{{ route('get_upazila_by_district') }}', {
                _token: '{{ csrf_token() }}',
                district_id: district_id
            }, function (data) {
                $('#upazila_id').html(null);
                $('#upazila_id').append($('<option>', {
                    value: null,
                    text: null
                }));
                //console.log(data)
                for (var i = 0; i < data.length; i++) {
                    $('#upazila_id').append($('<option>', {
                        value: data[i].id,
                        text: getNameBnEn(data[i].name,data[i].name_bn)
                    }));
                    $('.demo-select2').select2();
                }
                $("#upazila_id > option").each(function() {
                    if(this.value == '{{$employee->upazila_id}}'){
                        $("#upazila_id").val(this.value).change();
                    }
                });
                get_union_by_upazila();
            });
        }

        $('#district_id').on('change', function () {
            get_upazila_by_district();
        });
        function get_union_by_upazila() {
            var upazila_id = $('#upazila_id').val();
            //console.log(category_id)
            $.post('{{ route('get_union_by_upazila') }}', {
                _token: '{{ csrf_token() }}',
                upazila_id: upazila_id
            }, function (data) {
                $('#union_id').html(null);
                $('#union_id').append($('<option>', {
                    value: null,
                    text: null
                }));
                //console.log(data)
                for (var i = 0; i < data.length; i++) {
                    $('#union_id').append($('<option>', {
                        value: data[i].id,
                        text: getNameBnEn(data[i].name,data[i].name_bn)
                    }));
                    $('.demo-select2').select2();
                }
                $("#union_id > option").each(function() {
                    if(this.value == '{{$employee->union_id}}'){
                        $("#union_id").val(this.value).change();
                    }
                });
            });
        }

        $('#upazila_id').on('change', function () {
            get_union_by_upazila();
        });

        function get_industry_sub_category_by_industry_category() {
            var industry_category_id = $('#industry_category_id').val();
            //console.log(category_id)
            $.post('{{ route('get_industry_sub_category_by_industry_category') }}', {
                _token: '{{ csrf_token() }}',
                industry_category_id: industry_category_id
            }, function (data) {
                $('#industry_sub_category_id').html(null);
                $('#industry_employee_type_id').html(null);
                $('#industry_sub_category_id').append($('<option>', {
                    value: null,
                    text: null
                }));
                //console.log(data)
                for (var i = 0; i < data.length; i++) {
                    $('#industry_sub_category_id').append($('<option>', {
                        value: data[i].id,
                        text: getNameBnEn(data[i].name,data[i].name_bn)
                    }));
                    $('.demo-select2').select2();
                }
                $("#industry_sub_category_id > option").each(function() {
                    if(this.value == '{{$employee->industry_sub_category_id}}'){
                        $("#industry_sub_category_id").val(this.value).change();
                    }
                });
                get_industry_employee_type_by_industry_sub_category();
            });
        }
        $('#industry_category_id').on('change', function () {
            get_industry_sub_category_by_industry_category();
        });

        function get_industry_employee_type_by_industry_sub_category() {
            var industry_sub_category_id = $('#industry_sub_category_id').val();
            $.post('{{ route('get_industry_employee_type_by_industry_sub_category') }}', {
                _token: '{{ csrf_token() }}',
                industry_sub_category_id: industry_sub_category_id
            }, function (data) {
                $('#industry_employee_type_id').html(null);
                $('#industry_employee_type_id').append($('<option>', {
                    value: null,
                    text: null
                }));
                for (var i = 0; i < data.length; i++) {
                    $('#industry_employee_type_id').append($('<option>', {
                        value: data[i].id,
                        text: data[i].name
                    }));
                    $('.demo-select2').select2();
                }
                $("#industry_employee_type_id > option").each(function() {
                    if(this.value == '{{$employee->industry_employee_type_id}}'){
                        $("#industry_employee_type_id").val(this.value).change();
                    }
                });
            });
        }
        $('#industry_sub_category_id').on('change', function () {
            get_industry_employee_type_by_industry_sub_category();
        });


        $("#nid_front_side").spartanMultiImagePicker({
            fieldName: 'nid_front_side',
            maxCount: 1,
            rowHeight: '200px',
            groupClassName: 'col-md-3 col-sm-4 col-xs-6',
            maxFileSize: '1000000',
            dropFileLabel: "Drop Here",
            onExtensionErr: function (index, file) {
                console.log(index, file, 'extension err');
                alert('Please only input png or jpg type file')
            },
            onSizeErr: function (index, file) {
                console.log(index, file, 'file size too big');
                alert('Image size too big. Please upload below 100kb');
            },
            onAddRow:function(index){
                var altData = '<input type="text" placeholder="" name="nid_front_side[]" class="form-control" required=""></div>'
            },
            onRemoveRow : function(index){
                var index = index + 1;
                $(`#abc_${index}`).remove()
            },
        });

        $("#nid_back_side").spartanMultiImagePicker({
            fieldName: 'nid_back_side',
            maxCount: 1,
            rowHeight: '200px',
            groupClassName: 'col-md-3 col-sm-4 col-xs-6',
            maxFileSize: '1000000',
            dropFileLabel: "Drop Here",
            onExtensionErr: function (index, file) {
                console.log(index, file, 'extension err');
                alert('Please only input png or jpg type file')
            },
            onSizeErr: function (index, file) {
                console.log(index, file, 'file size too big');
                alert('Image size too big. Please upload below 100kb');
            },
            onAddRow:function(index){
                var altData = '<input type="text" placeholder="" name="nid_back_side[]" class="form-control" required=""></div>'
            },
            onRemoveRow : function(index){
                var index = index + 1;
                $(`#abc_${index}`).remove()
            },
        });

        $("#employee_pic").spartanMultiImagePicker({
            fieldName: 'employee_pic',
            maxCount: 1,
            rowHeight: '200px',
            groupClassName: 'col-md-3 col-sm-4 col-xs-6',
            maxFileSize: '1000000',
            dropFileLabel: "Drop Here",
            onExtensionErr: function (index, file) {
                console.log(index, file, 'extension err');
                alert('Please only input png or jpg type file')
            },
            onSizeErr: function (index, file) {
                console.log(index, file, 'file size too big');
                alert('Image size too big. Please upload below 100kb');
            },
            onAddRow:function(index){
                var altData = '<input type="text" placeholder="" name="employee_pic[]" class="form-control" required=""></div>'
            },
            onRemoveRow : function(index){
                var index = index + 1;
                $(`#abc_${index}`).remove()
            },
        });



        $('.remove-files').on('click', function(){
            $(this).parents(".col-md-3").remove();
        });
    </script>
@endpush

