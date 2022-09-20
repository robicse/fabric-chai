@extends('frontend.layouts.master')
@section('title', 'Login')
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
            /*border: 2px solid #9b8cc2;*/
            text-transform: inherit;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            font-family: 'Alatsi', sans-serif;
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
            /*border: 2px solid #9b8cc2;*/
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
        /* .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
            color: #495057;
            background-color: #fff;
             border-color: #fff #fff #fff #fff;
        } */
        .nav-tabs .nav-item.show .nav-link, .nav-tabs  {
            /*color: #9b8cc2;*/
            background-color: #fff;
            border-color: #fff #fff #fff #fff;
            font-size: 18px;
            font-weight: bold;
            font-family: 'Alatsi', sans-serif;
            color:#ea1947;
        }
        .nav-tabs .nav-link:focus, .nav-tabs .nav-link:hover {
            border: 2px solid;
            border-color: #fff #fff #ea1947 #fff;
        }

        .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
            /*color: #9b8cc2;*/
            background-color: #fff;
            border: 2px solid;
            border-color: #fff #fff #9b8cc2 #fff;

        }
        a, p a, p a:hover, a:hover, a:focus, a:active {
            color:#ea1947;
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
        .forget{
            cursor: pointer;
        }
        p.forget:hover{
            color: #FF0000;
        }

        /*.mobile_view_login{*/
        /*    display: none;*/
        /*}*/
        @media only screen and (max-width: 700px) {
            .card_height{
                height: 186px;
            }
            /*.web_view_login{*/
            /*    display: none;*/
            /*}*/
            /*.mobile_view_login{*/
            /*    display: flex;*/
            /*}*/
        }
    </style>
@endpush
@section('content')
    <!-- breadcrumbarea start -->
    <!-- breadcrumbarea End -->
    <main id="dc-main" class="dc-main dc-haslayout dc-innerbgcolor">
        <!--Register Form Start-->
        <div class="dc-haslayout dc-main-section">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="dc-registerformhold">
                            <div class="dc-registerformmain">
                                <div class="row">
                                    <div class="col-lg-6 col-md-8 col-12 mx-auto">
                                        <div class="sign-in-form">
                                            <!-- Small boxes (Stat box) -->
                                            <div class="row">
                                                <div class="col-lg-6 col-6">
                                                    <!-- small box -->
                                                    <a href="{{route('job.registration.employee')}}">
                                                        <div class="card border-primary mb-3" style="max-width: 18rem; margin: 10px; background-color: #f3f3f3">
                                                            <div class="card-body text-primary card_height">
                                                                <h5 class="text-center" style="color: #e70909"> <i class="fa fa-user"></i> </h5>
                                                                <div class="text-center">
                                                                    <h5 style="color: #e70909;">EMPLOYEE</h5> <hr style="color: #e70909;">
                                                                    <h5 style="color: #e70909;">চাকুরী প্রার্থী</h5>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="col-lg-6 col-6">
                                                    <!-- small box -->
                                                    <a href="{{route('job.registration.employer')}}">
                                                        <div class="card border-secondary mb-3" style="max-width: 18rem; margin: 10px; background-color: #f3f3f3;">
                                                            <div class="card-body text-secondary card_height">
                                                                <h5 class="text-center" style="color: purple;"> <i class="fa fa-user"></i> </h5>
                                                                <div class="text-center">
                                                                    <h5 style="color: purple;">EMPLOYER</h5> <hr style="color: purple;">
                                                                    <h5 style="color: purple;">চাকুরী দাতা</h5>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-8 col-12 mx-auto web_view_login">
                                        <div class="dc-joinforms">
                                            <h3>@lang('website.Login')</h3>
                                            <form class="dc-formtheme dc-formregister" method="POST" action="{{ route('login') }}">
                                                <br>
                                            @csrf
                                                <fieldset class="dc-registerformgroup">
                                                    <div class="form-group">
                                                        <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" placeholder="@lang('website.phone')" value="{{old('phone')}}" style="border: 1px solid #dddddd">
                                                        <input id="countyCodePrefix" type="hidden" name="country_code" {{old('country_code')}}>
                                                        @error('phone')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <span id="valid-msg" class="hide text-success">Valid</span>
                                                    <span id="error-msg" class="hide text-danger">Invalid number</span>
                                                    <div class="form-group input-group mb-3">
                                                        <input id="password-field" type="password" placeholder="@lang('website.Password')" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                                        @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                        <span toggle="#password-field" class="input-group-text toggle-password" id="basic-addon2"><i id="test" class="fa fa-eye"></i></span>
                                                    </div>
                                                    <div class="form-group text-center">
                                                        <button class="dc-btn" type="submit" value="Login" style="min-height: 44px;">@lang('website.Login')</button>
                                                    </div>
                                                </fieldset>
                                            </form>
                                            <div class="text-center">
                                                <p class="forget">
                                                    <span class="text-right"><a href="{{route('reset.password')}}" class="text-secondary">@lang('website.Forget Password?')</a></span>
                                                <p>
                                                <p class="forget">
                                                    @lang('website.Need an account?') <span><a href="{{route('register')}}">@lang('website.Register Now')</a></span>
                                                <p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Register Form End-->
    </main>
@endsection
@push('js')
    <script !src = "">
        @if($errors->any())
        @foreach($errors->all() as $error )
        toastr.error('{{$error}}','Error',{
            closeButton:true,
            progressBar:true
        });
        @endforeach
        @endif
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
            console.log(countyCodePrefix);
            //console.log(telInput)
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

        $(".toggle-password").click(function() {
            $('#test').toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>


@endpush


