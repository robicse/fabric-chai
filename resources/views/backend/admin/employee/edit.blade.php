@extends('backend.layouts.master')
@section("title","Edit Employee Registration")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/select2/select2.min.css')}}">
    <style>
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
                    <h1>Edit Employee Registration</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Edit Employee</li>
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
                            <h3 class="card-title">Edit Employee Registration </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{route('admin.employee.update',$employee->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <h5 class="text-info">ব্যক্তিগত তথ্য/Personal Information</h5> <hr>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-4 col-sm-4 col-form-label">নাম/Name <span class="required">*</span></label>
                                    <div class="col-6 col-sm-6">
                                        <input type="text" class="form-control" name="name" value="{{@$employee->user->name}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-4 col-sm-4 col-form-label">মোবাইল নাম্বার/Mobile Number (@lang('website.Optional')) <span class="required">*</span></label>
                                    <div class="col-1 col-sm-1">
                                        <input type="text" class="form-control" name="countyCodePrefix" value="{{$employee->user->country_code}}" readonly>

                                    </div>
                                    <div class="col-5 col-sm-5">
                                        <input  type="number" class="form-control" name="phone" value="{{$employee->user->phone}}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-4 col-sm-4 col-form-label">ইমেইল/Email (@lang('website.Optional'))</label>
                                    <div class="col-6 col-sm-6">
                                        <input type="email" class="form-control" name="email" value="{{$employee->user->email}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="marital_status" class="col-4 col-sm-4 col-form-label">বৈবাহিক অবস্থা/Marital State (@lang('website.Optional')) </label>
                                    <div class="col-6 col-sm-6">
                                        <select name="marital_status" id="marital_status" class="form-control demo-select2">
                                            <option value="">Please Select Marital State</option>
                                            <option value="Married" {{$employee->marital_status == 'Married' ? 'selected': ''}}>Married</option>
                                            <option value="Unmarried" {{$employee->marital_status == 'Unmarried' ? 'selected': ''}}>Unmarried</option>
                                            <option value="Widowed" {{$employee->marital_status == 'Widowed' ? 'selected': ''}}>Widowed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="age" class="col-4 col-sm-4 col-form-label">বয়স/Age: (@lang('website.Optional')) </label>
                                    <div class="col-6 col-sm-6">
                                        <select name="age" id="age" class="form-control demo-select2">
                                            <option value="">Please Select Age</option>
                                            @for($i=16;$i<=60;$i++)
                                                <option value="{{$i}}" {{$employee->age == $i ? 'selected': ''}}>{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="gender" class="col-4 col-sm-4 col-form-label">লিঙ্গ/Gender: (@lang('website.Optional'))</label>
                                    <div class="col-6 col-sm-6">
                                        <select name="gender" id="gender" class="form-control demo-select2">
                                            <option value="">Please Select Gender</option>
                                            <option value="Male" {{$employee->gender == 'Male' ? 'selected': ''}}>Male</option>
                                            <option value="Female" {{$employee->gender == 'Female' ? 'selected': ''}}>Female</option>
                                            <option value="Others" {{$employee->gender == 'Others' ? 'selected': ''}}>Others</option>
                                        </select>
                                    </div>
                                </div>

                                @php
                                    $divisions = \App\Model\Division::all();
                                @endphp
                                <div class="form-group row">
                                    <label for="division_id" class="col-4 col-sm-4 col-form-label">বিভাগ/Division (@lang('website.Optional')) </label>
                                    <div class="col-6 col-sm-6">
                                        <select name="division_id" id="division_id" class="form-control demo-select2">
                                            <option value="">Please Select Division</option>
                                            @foreach($divisions as $division)
                                                <option value="{{$division->id}}" {{$employee->division_id == $division->id ? 'selected':''}}>{{$division->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="district_id" class="col-4 col-sm-4 col-form-label">জেলা/District (@lang('website.Optional')) </label>
                                    <div class="col-6 col-sm-6">
                                        <select name="district_id" id="district_id" class="form-control demo-select2">
                                            <option value="">Please Select District</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="upazila_id" class="col-4 col-sm-4 col-form-label">থানা/Thana (@lang('website.Optional')) </label>
                                    <div class="col-6 col-sm-6">
                                        <select name="upazila_id" id="upazila_id" class="form-control demo-select2">
                                            <option value="">Please Select Thana</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="union_id" class="col-4 col-sm-4 col-form-label">পোস্ট অফিস/Post Office (@lang('website.Optional')) </label>
                                    <div class="col-6 col-sm-6">
                                        <select name="union_id" id="union_id" class="form-control demo-select2">
                                            <option value="">Please Select Post Office</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="village_or_area" class="col-4 col-sm-4 col-form-label">গ্রাম অথবা এলাকা/village or area (@lang('website.Optional')) </label>
                                    <div class="col-6 col-sm-6">
                                        <input type="text" class="form-control" name="village_or_area" id="village_or_area" value="{{$employee->village_or_area}}"/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="nid_front_side" class="col-4 col-sm-4 col-form-label">এনআইডি সামনের দিক/NID Front Side (@lang('website.Optional')) </label>
                                    <div class="col-6 col-sm-6">
                                        <input type="file" class="form-control" name="nid_front_side">
                                        @if($employee->nid_front_side != null)
                                        <a href="{{url($employee->nid_front_side)}}" target="_blank">
                                            <b class="text-dark">{{$employee->nid_front_side}}</b>
                                        </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nid_back_side" class="col-4 col-sm-4 col-form-label">এনআইডি পিছনের দিক/NID Back Side (@lang('website.Optional')) </label>
                                    <div class="col-6 col-sm-6">
                                        <input type="file" class="form-control" name="nid_back_side">
                                        @if($employee->nid_back_side != null)
                                        <a href="{{url($employee->nid_back_side)}}" target="_blank">
                                            <b class="text-dark">{{$employee->nid_back_side}}</b>
                                        </a>
                                        @endif
                                    </div>
                                </div>
                                @php
                                    $salary_ranges = \App\Model\SalaryRange::all();
                                    $industryCategories = \App\Model\IndustryCategory::all();
                                @endphp
                                <h5 class="text-info" style="margin-top: 50px;">চাকরী সংক্রান্ত তথ্য/Job Information</h5> <hr>
                                <div class="form-group row">
                                    <label for="no_of_employee" class="col-4 col-sm-4 col-form-label">বর্তমান বেতন/Current Salary (@lang('website.Optional')) </label>
                                    <div class="col-6 col-sm-6">
                                        <select name="current_salary" id="current_salary" class="form-control demo-select2" required>
                                            <option value="">Please Select Current Salary</option>
                                            @foreach($salary_ranges as $salary_range)
                                                <option value="{{$salary_range->range}}" {{$employee->current_salary == $salary_range->range ? 'Selected':''}}>{{$salary_range->range}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="no_of_employee" class="col-4 col-sm-4 col-form-label">কাঙ্ক্ষিত বেতন/Expected Salary (@lang('website.Optional')) </label>
                                    <div class="col-6 col-sm-6">
                                        <select name="expected_salary" id="expected_salary" class="form-control demo-select2">
                                            <option value="">Please Select Expected Salary</option>
                                            @foreach($salary_ranges as $salary_range)
                                                <option value="{{$salary_range->range}}" {{$employee->expected_salary == $salary_range->range ? 'Selected':''}}>{{$salary_range->range}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="looking_job_industry_category_id" class="col-4 col-sm-4 col-form-label">যে কাজ খুঁজছি/Looking for Job in (@lang('website.Optional')) </label>
                                    <div class="col-6 col-sm-6">
                                        <select name="looking_job_industry_category_id" id="looking_job_industry_category_id" class="form-control demo-select2">
                                            <option value="">Please Select Job Type</option>
                                            @foreach($industryCategories as $industryCategory)
                                                <option value="{{$industryCategory->id}}" {{$employee->looking_job_industry_category_id == $industryCategory->id ? 'Selected':''}}>{{$industryCategory->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="joining_duration" class="col-4 col-sm-4 col-form-label">কয়দিনের মধ্যে যোগদান করতে পারবেন/Duration for Joining New Job (@lang('website.Optional')) </label>
                                    <div class="col-6 col-sm-6">
                                        <select name="joining_duration" id="joining_duration" class="form-control demo-select2" >
                                            <option value="">Select</option>
                                            <option value="Immediately" {{$employee->joining_duration == 'Immediately' ? 'selected': ''}}>Immediately</option>
                                            <option value="1 Week" {{$employee->joining_duration == '1 Week' ? 'selected': ''}}>1 Week</option>
                                            <option value="2 Weeks" {{$employee->joining_duration == '2 Weeks' ? 'selected': ''}}>2 Weeks</option>
                                            <option value="3 Weeks" {{$employee->joining_duration == '3 Weeks' ? 'selected': ''}}>3 Weeks</option>
                                            <option value="1 Month" {{$employee->joining_duration == '1 Month' ? 'selected': ''}}>1 Month</option>
                                            <option value="2 Months" {{$employee->joining_duration == '2 Months' ? 'selected': ''}}>2 Months</option>
                                            <option value="3 Months" {{$employee->joining_duration == '3 Months' ? 'selected': ''}}>3 Months</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="employee_pic" class="col-4 col-sm-4 col-form-label">নিজের ছবি আপলোড করুন/Upload Your Photo (@lang('website.Optional')) </label>
                                    <div class="col-6 col-sm-6">
                                        <input type="file" class="form-control" name="employee_pic">
                                        @if($employee->employee_pic != null)
                                        <a href="{{url($employee->employee_pic)}}" target="_blank">
                                            <b class="text-dark">{{$employee->employee_pic}}</b>
                                        </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="joining_duration" class="col-4 col-sm-4 col-form-label">নিজের দক্ষতা নির্বাচন করুন/Choose Your Expertise (@lang('website.Optional')) </label>
                                    <div class="col-2 col-sm-2">
                                        <select name="industry_category_id" id="industry_category_id" class="form-control demo-select2" >
                                            <option value="">Expertise Area</option>
                                            @foreach($industryCategories as $industryCategory)
                                                <option value="{{$industryCategory->id}}" {{$employee->industry_category_id == $industryCategory->id ? 'selected':'' }}>{{$industryCategory->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2 col-sm-2">
                                        <select name="industry_sub_category_id" id="industry_sub_category_id" class="form-control demo-select2" >
                                            <option value="">Subcategory</option>

                                        </select>
                                    </div>
                                    <div class="col-2 col-sm-2">
                                        <select name="industry_employee_type_id" id="industry_employee_type_id" class="form-control demo-select2">
                                            <option value="">Expertise</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="experience" class="col-4 col-sm-4 col-form-label">উক্ত দক্ষতায় কতদিনের অভিজ্ঞতা আছে/Years of Experience in above Expertise</label>
                                    <div class="col-6 col-sm-6">
                                        <input type="text" class="form-control" name="experience" value="{{$employee->experience}}"/>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
    <script src="{{asset('backend/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script src="{{asset('backend/plugins/select2/select2.full.min.js')}}"></script>

    <script>

        $(document).ready(function() {
            $('.demo-select2').select2();
            get_district();
            get_industry_sub_category_by_industry_category();
        });

        function get_industry_sub_category_by_industry_category() {
            var industry_category_id = $('#industry_category_id').val();
            //console.log(category_id)
            $.post('{{ route('get_industry_sub_category_by_industry_category') }}', {
                _token: '{{ csrf_token() }}',
                industry_category_id: industry_category_id
            }, function (data) {
                // $('#industry_sub_category_id').html(null);
                // $('#industry_sub_category_id').append($('<option>', {
                //     value: null,
                //     text: null
                // }));
                //console.log(data)
                for (var i = 0; i < data.length; i++) {
                    $('#industry_sub_category_id').append($('<option>', {
                        value: data[i].id,
                        text: data[i].name
                    }));
                    $('.demo-select2').select2();
                }
                $("#industry_sub_category_id > option").each(function() {
                    if(this.value == '{{$employee->industry_sub_category_id}}'){
                        $("#industry_sub_category_id").val(this.value).change();
                    }
                });
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
                // $('#industry_employee_type_id').html(null);
                // $('#industry_employee_type_id').append($('<option>', {
                //     value: null,
                //     text: null
                // }));
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

    </script>
    <script>
        function get_district() {
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
                    if(this.value == '{{$employee->district_id}}'){
                        $("#district_id").val(this.value).change();
                    }
                });
                get_upazila_by_district();
            });
        }
        $('#division_id').on('change', function () {
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
                        text: data[i].name
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
                        text: data[i].name
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
    </script>
@endpush
