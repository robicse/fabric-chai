@extends('frontend.layouts.master')
@section('title','Jobs')
@push('css')
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
        .sign_up_btn{
            min-height: 44px;
            margin-bottom: 10px;
        }
        .font_16{
           font-size: 16px!important;
        }
        @media (max-width:575px){
            .dc-joinforms{
                padding: 9px 0px;
            }
        }
    </style>
@endpush
@section('content')

    <main id="dc-main" class="dc-main dc-haslayout dc-innerbgcolor">
        <!--Register Form Start-->
        <div class="dc-haslayout dc-main-section">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 push-lg-2">
                        <div class="dc-registerformhold">
                            <div class="dc-registerformmain">
                                <div class="dc-joinforms">
                                    <h3>Employee Registration</h3>
                                    <form class="dc-formtheme dc-formregister" method="POST" action="{{route('user.register')}}" enctype="multipart/form-data">
                                        <br>
                                    @csrf
                                    <!--  <label for="phone_number">Phone Number</label> -->
                                        <fieldset class="dc-registerformgroup">
                                            <h5>Personal Information</h5>
                                            <p>
                                                <label for="company_name">Enter Full Name&nbsp;<span class="required">*</span></label>
                                                <input type="text" class="form-control" name="name" id="name" required/>
                                            </p>
                                            <p>
                                                <input id="phone1" type="tel" class="phone_val" name="phone" placeholder="phone*" required>
                                                <input id="countyCodePrefix1" type="hidden" name="countyCodePrefix" required>
                                            </p>
                                            <p>
                                                <label for="email">Email&nbsp;</label>
                                                <input type="email" class="form-control" name="email" id="email"/>
                                            </p>
{{--                                            <p>--}}
{{--                                                <label for="address">Your Address&nbsp;</label>--}}
{{--                                                <input type="text" class="form-control" name="address" id="address"/>--}}
{{--                                            </p>--}}
                                            <div>
                                                <label for="marital_state">Marital State</label>
                                                <select name="marital_state" id="marital_state" class="form-control demo-select2 font_16">
                                                    <option>Please select marital state</option>
                                                    <option value="Married">Married</option>
                                                    <option value="Unmarried">Unmarried</option>
                                                    <option value="Widowed">Widowed</option>
                                                </select>
                                            </div>
                                            <p>
                                                <label for="age">Date of Birth&nbsp;</label>
                                                <input type="date" class="form-control" name="age" id="age" required/>
                                            </p>
                                            <div>
                                                <label for="gender">Gender</label>
                                                <select name="gender" id="gender" class="form-control demo-select2 font_16">
                                                    <option>Please Select Gender</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Others">Others</option>
                                                </select>
                                            </div>
                                            @php
                                                $districts = \App\Model\District::all();
                                            @endphp
                                            <div class="" id="district_id">
                                                <label for="district_id">Division</label>
                                                <select name="district_id" id="division_id" class="form-control demo-select2">
                                                    <option value="">Select</option>
                                                    @foreach($districts as $district)
                                                        <option value="{{$district->id}}">{{$district->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </fieldset>
                                        <fieldset class="dc-registerformgroup">
                                            <h5>Job Information</h5>
                                            <p>
                                                <label for="company_name">Enter Full Name&nbsp;<span class="required">*</span></label>
                                                <input type="text" class="form-control" name="name" id="name" required/>
                                            </p>
                                            <p>
                                                <input id="phone1" type="tel" class="phone_val" name="phone" placeholder="phone*" required>
                                                <input id="countyCodePrefix1" type="hidden" name="countyCodePrefix" required>
                                            </p>
                                            <p>
                                                <label for="email">Email&nbsp;</label>
                                                <input type="email" class="form-control" name="email" id="email"/>
                                            </p>
                                            <p>
                                                <label for="address">Your Address&nbsp;</label>
                                                <input type="text" class="form-control" name="address" id="address"/>
                                            </p>
                                            <p>
                                                <label for="password">Password&nbsp;<span class="required">*</span></label>
                                                <input class="form-control" type="password" name="password" minlength="8" id="password" />
                                            </p>
                                            <div class="form-group text-center">
                                                <button class="dc-btn sign_up_btn" type="submit" value="Sign-up">Submit</button>
                                            </div>
                                        </fieldset>
                                    </form>
                                    <div class="dc-registerformfooter">
                                        <span>Already Have an Account? <a href="{{route('login')}}">Login Now</a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
@push('js')
    <script>
        $(function () {
            $("input[name='user_type']").click(function () {
                if ($("#buyer").is(":checked")) {
                    $('#seller_form').html('');
                } else {
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
                }
            });
        });
    </script>

{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"></script>
    {{--this section for custom js, only for this page--}}
    <script>
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
@endpush
