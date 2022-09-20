@extends('backend.layouts.master')
@section("title","Create Employer")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/select2/select2.min.css')}}">
    <link href="{{asset('frontend/css/intlTelInput.min.css')}}" rel="stylesheet">
{{--    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/css/intlTelInput.css" rel="stylesheet"--}}
{{--          media="screen">--}}
    <link href="https://fonts.googleapis.com/css?family=Alatsi&display=swap" rel="stylesheet">
    {{--this section for custom css only for this page--}}
    <link rel="stylesheet" href="{{asset('frontend/css/doctor-reg.min.css')}}">

    <style>
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
                    <h1>Create Employer</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Create Employer</li>
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
                            <h3 class="card-title">Create Employer </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{route('admin.employer.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <h5 class="text-info">Personal Information</h5> <hr>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-4 col-sm-4 col-form-label">Name <span class="required">*</span></label>
                                    <div class="col-6 col-sm-6">
                                        <input type="text" class="form-control" name="name" placeholder="Enter Full Name" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-4 col-sm-4 col-form-label">Phone Number <span class="required">*</span></label>
                                    <div class="col-6 col-sm-6">
{{--                                        <input id="phone1" type="tel" class="phone_val" name="phone" placeholder="Employer's Phone Number" required>--}}
{{--                                        <input id="countyCodePrefix1" type="hidden" name="countyCodePrefix" required>--}}
                                        <input type="number" class="form-control" name="phone" placeholder="Employer's Phone Number" required>
                                        <input type="hidden" name="countyCodePrefix" value="+880" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-4 col-sm-4 col-form-label">Email (@lang('website.Optional')) </label>
                                    <div class="col-6 col-sm-6">
                                        <input type="email" class="form-control" name="email" placeholder="Employer's Email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-4 col-sm-4 col-form-label">Employer's Address (@lang('website.Optional')) </label>
                                    <div class="col-6 col-sm-6">
                                        <input type="text" class="form-control" name="address" placeholder="Employer's Address">
                                    </div>
                                </div>

                                <h5 class="text-info" style="margin-top: 50px;">Company Information</h5> <hr>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-4 col-sm-4 col-form-label">Company Name (@lang('website.Optional')) </label>
                                    <div class="col-6 col-sm-6">
                                        <input type="text" class="form-control" name="company_name" placeholder="Employer's Company Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-4 col-sm-4 col-form-label">Company Owner's Name (@lang('website.Optional')) </label>
                                    <div class="col-6 col-sm-6">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-4 col-sm-4 col-form-label">Company Contact No. 
                              (@lang('website.Optional')) (@lang('website.Optional'))</label>
                                    <div class="col-6 col-sm-6">
                                        <input type="number" class="form-control" name="company_phone" placeholder="Employer's Company Contact No.">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-4 col-sm-4 col-form-label">Company Email </label>
                                    <div class="col-6 col-sm-6">
                                        <input type="email (@lang('website.Optional'))" class="form-control" name="company_email" placeholder="Employer's Company Email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-4 col-sm-4 col-form-label">Company Address  (@lang('website.Optional'))</label>
                                    <div class="col-6 col-sm-6">
                                        <input type="text" class="form-control" name="company_address" placeholder="Employer's Company Address">
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
                                                <option value="{{$division->id}}">{{$division->name}}</option>
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
                                    <label for="industry_category_id" class="col-4 col-sm-4 col-form-label">Looking to Hire</label>
                                    <div class="col-6 col-sm-6">
                                        <select name="industry_category_id[]" id="selected_category" class="form-control demo-select2" multiple>
                                            <option>Select</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="no_of_employee" class="col-4 col-sm-4 col-form-label">Number of Employees</label>
                                    <div class="col-6 col-sm-6">
                                        <select name="no_of_employee" id="no_of_employee" class="form-control demo-select2">
                                            <option value="">Please Select No. of Employees</option>
                                            <option value="0-10">0-10</option>
                                            <option value="10-50">10-50</option>
                                            <option value="50-100">50-100</option>
                                            <option value="100-200">100-200</option>
                                            <option value="200-500">200-500</option>
                                            <option value="500-1,000">500-1,000</option>
                                            <option value="1,000-2,000">1,000-2,000</option>
                                            <option value="2,000-5,000">2,000-5,000</option>
                                            <option value="5,000-10,000">5,000-10,000</option>
                                            <option value="10,000+">10,000+</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="salary_type" class="col-4 col-sm-4 col-form-label">Company Salary Type</label>
                                    <div class="col-6 col-sm-6">
                                        <select name="salary_type" id="salary_type" class="form-control demo-select2">
                                            <option value="">Please Select Salary Type</option>
                                            <option value="Production">Production</option>
                                            <option value="Monthly">Monthly</option>
                                            <option value="Bi-Weekly">Bi-Weekly</option>
                                            <option value="Fixed">Fixed</option>
                                            <option value="Contract">Contract</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                @php
                                    $now = date('Y');
                                    $last= date('Y')-50;
                                @endphp
                                <div class="form-group row">
                                    <label for="established_year" class="col-4 col-sm-4 col-form-label">Company Established Year</label>
                                    <div class="col-6 col-sm-6">
                                        <select name="established_year" id="established_year" class="form-control demo-select2">
                                            <option value="">Please Select Established Year</option>
                                            @for($i=$now; $i>= $last; $i--)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <h5 class="text-info" style="margin-top: 50px;">Please Upload Required Documents</h5> <hr>
                                <div class="form-group row">
                                    <label for="trade_licence" class="col-4 col-sm-4 col-form-label">Trade License</label>
                                    <div class="col-6 col-sm-6">
                                        <input type="file" class="form-control" name="trade_licence">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="vat" class="col-4 col-sm-4 col-form-label">VAT</label>
                                    <div class="col-6 col-sm-6">
                                        <input type="file" class="form-control" name="vat">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="owner_nid_front" class="col-4 col-sm-4 col-form-label">NID of Owner (Front)</label>
                                    <div class="col-6 col-sm-6">
                                        <input type="file" class="form-control" name="owner_nid_front">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="owner_nid_back" class="col-4 col-sm-4 col-form-label">NID of Owner (Back)</label>
                                    <div class="col-6 col-sm-6">
                                        <input type="file" class="form-control" name="owner_nid_back">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="factory_certificate" class="col-4 col-sm-4 col-form-label">Factory Certificate</label>
                                    <div class="col-6 col-sm-6">
                                        <input type="file" class="form-control" name="factory_certificate">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="fire_licence" class="col-4 col-sm-4 col-form-label">Fire License</label>
                                    <div class="col-6 col-sm-6">
                                        <input type="file" class="form-control" name="fire_licence">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="membership_image" class="col-4 col-sm-4 col-form-label">Membership <small class="text-info">(BTMA/BGMEA/BKMEA/Others)</small></label>
                                    <div class="col-6 col-sm-6">
                                        <input type="file" class="form-control" name="membership_image">
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
        $(function () {
            $("input[name='user_type']").click(function () {
                if ($("#buyer").is(":checked")) {
                    $('#seller_form').html('');
                    $('#employee_form').html('');
                } else if($("#seller").is(":checked"))  {
                    $('#employee_form').html('');
                    var user_type = $('#seller').val();
                    $.post('{{ route('get_seller_form') }}',{_token:'{{ csrf_token() }}', user_type:user_type}, function(data){
                        $('#seller_form').html(data);
                        var email = $("#email").val();
                        //console.log(email);
                        $('#company_email').val(email);
                        var phone = $("#phone1").val();
                        //console.log(phone);
                        $('#company_phone').val(phone);

                        var countyCodePrefix1 = $(".flag-container").find('.selected-dial-code').html();
                        if(countyCodePrefix1 != '+880'){
                            $("#division_area").hide();
                            $("#district_area").hide();
                        }else{
                            $("#division_area").show();
                            $("#district_area").show();
                        }
                    });
                }else if($("#employee").is(":checked")) {
                    $('#seller_form').html('');
                    var user_type = $('#employee').val();
                    $.post('{{ route('get_employee_form') }}',{_token:'{{ csrf_token() }}', user_type:user_type}, function(data){
                        $('#employee_form').html(data);
                        var countyCodePrefix1 = $(".flag-container").find('.selected-dial-code').html();
                        if(countyCodePrefix1 != '+880'){
                            $("#division_area").hide();
                            $("#district_area").hide();
                        }else{
                            $("#division_area").show();
                            $("#district_area").show();
                        }
                    });
                }else{
                    console.log('others');
                }
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"></script>
    {{--this section for custom js, only for this page--}}
    <script>

        $(document).ready(function() {
            $('.demo-select2').select2();
        });

        var telInput = $("#phone"),
            errorMsg = $("#error-msg"),
            validMsg = $("#valid-msg");

        // initialise plugin
        telInput.intlTelInput({

            allowExtensions: true,
            formatOnDisplay: true,
            autoFormat: true,
            autoHideDialCode: true,
            autoPlaceholder: true,
            defaultCountry: "auto",
            ipinfoToken: "yolo",

            nationalMode: false,
            numberType: "MOBILE",
            //onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
            preferredCountries: ['bn', 'sa', 'ae', 'qa', 'om', 'bh', 'kw', 'ma'],
            preventInvalidNumbers: true,
            separateDialCode: true,
            initialCountry: "auto",

            geoIpLookup: function (callback) {
                $.get("https://ipinfo.io", function () {
                }, "jsonp").always(function (resp) {
                    console.log(resp);
                    var countryCode = (resp && resp.country) ? resp.country : "";
                    //console.log(countryCode);
                    callback(countryCode);
                });
            },
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"
        });
        var reset = function () {
            telInput.removeClass("error");
            errorMsg.addClass("hide");
            validMsg.addClass("hide");
        };

        // on blur: validate
        telInput.blur(function () {
            var countyCodePrefix = $(".flag-container").find('.selected-dial-code').html();
            $("#countyCodePrefix").val(countyCodePrefix);
            // console.log(countyCodePrefix);
            //console.log(telInput)
            var phone = $("#phone1").val();
            console.log(phone);

            reset();
            if ($.trim(telInput.val())) {
                if (telInput.intlTelInput("isValidNumber")) {
                    validMsg.removeClass("hide");
                } else {
                    telInput.addClass("error");
                    errorMsg.removeClass("hide");
                }
            }
        });

        // on keyup / change flag: reset
        telInput.on("keyup change", reset);



        //For register


        var telInput1 = $("#phone1"),
            errorMsg1 = $("#error-msg1"),
            errorMsg2 = $("#error-msg2"),
            validMsg1 = $("#valid-msg1");

        telInput1.intlTelInput({

            allowExtensions: true,
            formatOnDisplay: true,
            autoFormat: true,
            autoHideDialCode: true,
            autoPlaceholder: true,
            defaultCountry: "auto",
            ipinfoToken: "yolo",

            nationalMode: false,
            numberType: "MOBILE",

            preferredCountries: ['bn', 'sa', 'ae', 'qa', 'om', 'bh', 'kw', 'ma'],
            preventInvalidNumbers: true,
            separateDialCode: true,
            initialCountry: "auto",

            geoIpLookup: function (callback) {
                $.get("https://ipinfo.io", function () {
                }, "jsonp").always(function (resp) {
                    console.log(resp);
                    var countryCode = (resp && resp.country) ? resp.country : "";

                    callback(countryCode);


                });
            },
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"

        });

        var reset = function () {
            telInput1.removeClass("error");
            errorMsg1.addClass("hide");
            validMsg1.addClass("hide");
        };


        telInput1.blur(function () {
            var countyCodePrefix1 = $(".flag-container").find('.selected-dial-code').html();
            console.log(countyCodePrefix1)
            if(countyCodePrefix1 != '+880'){
                $("#division_area").hide();
                $("#district_area").hide();
            }else{
                $("#division_area").show();
                $("#district_area").show();
            }
            var phone_val = $('.phone_val').val();
            console.log(phone_val);
            $.post('{{ route('check_user_phone') }}',{_token:'{{ csrf_token() }}', phone_val:phone_val}, function(data){
                // console.log(data);
                if(data == 1){
                    toastr.warning('This phone number already exist!');
                }
            });

            $("#countyCodePrefix1").val(countyCodePrefix1);

            reset();
            if ($.trim(telInput1.val())) {
                if (telInput1.intlTelInput("isValidNumber")) {
                    validMsg1.removeClass("hide");
                } else {
                    telInput1.addClass("error");
                    errorMsg1.removeClass("hide");
                }
            }
        });


        telInput1.on("keyup change", reset);

    </script>
    <script>
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
            });
        }
        $('#division_id').on('change', function () {
            get_district_by_division();
        });
    </script>
@endpush
