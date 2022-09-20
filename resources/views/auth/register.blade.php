@extends('frontend.layouts.master')
@section('title', 'Registration')
@push('css')
    <link href="{{asset('frontend/css/intlTelInput.min.css')}}" rel="stylesheet">
    {{--    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/css/intlTelInput.css" rel="stylesheet"--}}
    {{--          media="screen">--}}
    <link href="https://fonts.googleapis.com/css?family=Alatsi&display=swap" rel="stylesheet">
    {{--this section for custom css only for this page--}}
    <link rel="stylesheet" href="{{asset('frontend/css/doctor-reg.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/select2/select2.min.css')}}">
    <script src="{{asset('backend/plugins/select2/select2.full.min.js')}}"></script>
    <style>
        select+.select2-container {
            z-index: 98;
            width: 100% !important;
        }
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
    <!-- breadcrumbarea start -->
    <!-- breadcrumbarea End -->
    <main id="dc-main" class="dc-main dc-haslayout dc-innerbgcolor">
        <!--Register Form Start-->
        <div class="dc-haslayout dc-main-section">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 push-lg-2">
                        <div class="dc-registerformhold">
                            <div class="dc-registerformmain">
                                <div class="dc-joinforms">
                                    <h3>@lang('website.Registration')</h3>
                                    @php
                                        //$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                                        //$uri_segments = explode('/', $uri_path);
                                        //$segment = $uri_segments[3];
                                    @endphp
                                    {{--                                    {{ Request::segment(3) }}--}}
                                    <input type="hidden" class="form-control" name="segment" id="segment" value="{{Request::segment(3)}}"/>

                                    <form class="dc-formtheme dc-formregister" method="POST" action="{{route('user.register')}}" enctype="multipart/form-data">
                                        <br>
                                    @csrf
                                    <!--  <label for="phone_number">Phone Number</label> -->
                                        <fieldset class="dc-registerformgroup">
                                            <div class="row">
                                                @php
                                                    $lang = app()->getLocale('locale');
                                                @endphp
                                                <div class="col-md-6 @if($lang !== 'en') d-none @endif">
                                                    <label for="name">@lang('website.Enter Full Name EN')
                                                        @if($lang == 'en')
                                                            <span class="required">*</span>
                                                        @else
                                                        (@lang('website.Optional'))
                                                        @endif
                                                    </label>
                                                    <input type="text" class="form-control" name="name" id="name"
                                                        {{$lang == 'en' ? 'required' : '' }} />
                                                </div>
                                                <div class="col-md-6 @if($lang !== 'bn') d-none @endif">
                                                    <label for="name_bn">@lang('website.Enter Full Name BN')
                                                        @if($lang == 'bn')
                                                            <span class="required">*</span>
                                                        @else
                                                        (@lang('website.Optional'))
                                                        @endif
                                                    </label>
                                                    <input type="text" class="form-control" name="name_bn"
                                                           id="name_bn" {{$lang == 'bn' ? 'required' : '' }} />
                                                </div>

                                                <div class="col-md-6">
                                                    <div>
                                                        <label for="phone">@lang('website.Mobile Phone')<span class="required">*</span></label>
                                                    </div>
                                                    <input id="phone1" type="tel" class="phone_val" name="phone" placeholder="@lang('website.phone')" required>
                                                    <input id="countyCodePrefix1" type="hidden" name="countyCodePrefix" required>
                                                    <span id="valid-msg1" class="hide text-success">Valid</span>
                                                    <span id="error-msg1" class="hide text-danger">Invalid number</span>
                                                    <span id="error-msg2" class="hide text-danger">This Phone number already Exists </span>
                                                </div>
                                                <div class="col-md-6" id="email_1">
{{--                                                    <label for="email">@lang('website.Email')&nbsp;  (@lang('website.Optional'))  </label>--}}
                                                  <div id="emailLebel">
                                                      <label for="email">@lang('website.Email') (@lang('website.Optional'))  </label>
                                                  </div>
                                                    <input type="email" class="form-control" name="email" id="email"/>
                                                </div>
{{--                                                <div class="col-md-6 d-none" id="email_2">--}}
{{--                                                    <label for="email">@lang('website.Email')&nbsp;  (@lang('website.Required'))<span class="required">*</span>  </label>--}}
{{--                                                    <input type="email" class="form-control" name="email" id="email2" required />--}}
{{--                                                </div>--}}

                                                <div class="col-md-6">
                                                    <label for="address">@lang('website.My Business Address')</label>
                                                    <input type="text" class="form-control" name="address" id="address"/>
                                                </div>
{{--                                                <div class="col-md-6 @if($lang !== 'bn') d-none @endif">--}}
{{--                                                    <label for="address_bn">@lang('website.My Business Address')&nbsp; </label>--}}
{{--                                                    <input type="text" class="form-control" name="address_bn" id="address_bn"/>--}}
{{--                                                </div>--}}
                                                <div class="col-md-6">
                                                    <label for="password">@lang('website.Password')&nbsp;<span class="required">*</span></label>
                                                    <div class="form-group input-group mb-3" style="padding: 0px;">
                                                        <input id="password-field1" type="password" minlength="8" class="form-control" name="password" placeholder="@lang('website.Must be minimum 8 digit')" required >
                                                        <span toggle="#password-field1" class="input-group-text toggle-password1" id="basic-addon2" title="@lang('website.Eye Open')"><i id="test1" class="fa fa-eye"></i></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="confirm_password">@lang('website.Confirm Password')&nbsp;<span class="required">*</span></label>
                                                    <div class="form-group input-group mb-3" style="padding: 0px;">
                                                        <input id="password-field2" type="password" minlength="8" class="form-control" name="confirm_password" required >
                                                        <span toggle="#password-field2" class="input-group-text toggle-password2" id="basic-addon2" title="@lang('website.Eye Open')"><i id="test2" class="fa fa-eye"></i></span>
                                                    </div>
                                                </div>
                                                <div id="buyer_categories" >
                                                    @include('frontend.includes.buyer_categories_html')
                                                </div>

{{--                                                <div id="gender" class="col-md-6">--}}
{{--                                                    <label for="gender">@lang('website.Gender')&nbsp; (@lang('website.Optional'))</label>--}}
{{--                                                    <div style="font-size: 16px">--}}
{{--                                                        <select class="form-control" name="gender" style="font-size: 16px" >--}}
{{--                                                            <option>@lang('website.Select')</option>--}}
{{--                                                            <option value="Male">@lang('website.Male')</option>--}}
{{--                                                            <option value="Female">@lang('website.Female')</option>--}}
{{--                                                            <option value="Neutral">@lang('website.Neutral')</option>--}}
{{--                                                            <option value="Common">@lang('website.Common')</option>--}}
{{--                                                        </select>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}

                                                <div class="form-group">
                                                    <label class="control-label ml-3">@lang('website.National ID Image') (@lang('website.Front')) <small class="text-danger">(jpg,jpeg,png file only)</small></label>
                                                    <div class="ml-3 mr-3">
                                                        <div class="row" id="nid_front"></div>

                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label ml-3">@lang('website.National ID Image') (@lang('website.Back')) <small class="text-danger">(jpg,jpeg,png file only)</small></label>
                                                    <div class="ml-3 mr-3">
                                                        <div class="row" id="nid_back"></div>

                                                    </div>
                                                </div>
{{--                                                <div class="col-md-12 mb-2">--}}
{{--                                                    <label>@lang('website.Referral Code') (@lang('website.Optional'))<span class="small" style="color: green;">(@lang("website.Enter your friend's referral code"))</span></label>--}}
{{--                                                    <input class="form-control form_height" type="number" name="referred_by" placeholder="@lang('website.Referral Code (Optional)')">--}}
{{--                                                </div>--}}
                                            </div>

                                            <div class="row pb-2 mt-2" >
                                                @if(Request::segment(1) == 'work-order')
                                                    <div class="col-4" style="font-size: 18px">
                                                        <input type="radio" name="user_type" data-index="0" id="buyer" value="buyer" class="shipping_method" @if(Request::segment(3) == 'buyer') checked @endif> @lang('website.Buyer')
                                                    </div>
                                                    <div class="col-4" style="font-size: 18px">
                                                        <input type="radio" name="user_type" data-index="0" id="seller" value="seller" class="shipping_method" @if(Request::segment(3) == 'seller') checked @endif> @lang('website.Manufacturer')
                                                    </div>
                                                @else
                                                    <div class="col-4">
                                                        <input type="radio" name="user_type" data-index="0" id="buyer" value="buyer" class="shipping_method" @if(Request::segment(3) == '') checked @endif> @lang('website.Buyer')
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="radio" name="user_type" data-index="0" id="seller" value="seller" class="shipping_method" @if(Request::segment(3) == 'employer') checked @endif> @lang('website.Seller/Employer')
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="radio" name="user_type" data-index="0" id="employee" value="employee" class="shipping_method" @if(Request::segment(3) == 'employee') checked @endif> @lang('website.Job')

                                                    </div>
                                                @endif
                                            </div>
                                            <div id="seller_form">

                                            </div>
                                            <div id="employee_form">

                                            </div>
                                            <div class="form-group text-center">
                                                <button class="dc-btn" type="submit" value="Sign-up" style="min-height: 44px;margin-bottom: 10px;">@lang('website.Submit')</button>
                                            </div>
                                        </fieldset>
                                    </form>
                                    <div class="dc-registerformfooter text-center">
                                        <span>@lang('website.Already Have an Account?') <a href="{{route('login')}}">@lang('website.Login Now')</a></span>
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
    <script src="{{asset('backend/plugins/select2/select2.full.min.js')}}"></script>
    <script>
        $(document).ready(function () {

            $('#gender').hide();
            $('.demo-select2').select2();

            var segment = $('#segment').val();
            // alert(segment);
            if(segment == 'employee'){

                $('#seller_form').html('');
                $('#gender').show();
                $('#buyer_selected_category').hide();
                $('#buyer_categories').html('');

            }else if(segment == 'employer' || segment == 'seller2'){
                $('#employee_form').html('');
                $('#gender').hide();
                $('#buyer_selected_category').hide();
                $('#buyer_categories').html(null);
                var user_type = $('#seller').val();
                $.post('{{ route('get_seller_form') }}',{_token:'{{ csrf_token() }}', user_type:user_type}, function(data){
                    $('#seller_form').html(data);
                    $('#category_area').hide()
                    var email = $("#email").val();
                    //console.log(email);
                    $('#company_email').val(email);
                    var phone = $("#phone1").val();
                    //console.log(phone);
                    $('#company_phone').val(phone);

                    var countyCodePrefix1 = $(".flag-container").find('.selected-dial-code').html();
                    if(countyCodePrefix1 != '+880'){
                        alert(countyCodePrefix1);
                        $("#division_area").hide();
                        $("#district_area").hide();
                        $("#email_1").addClass('d-none');
                        $("#email_2").removeClass('d-none');
                    }else{
                        $("#division_area").show();
                        $("#district_area").show();
                    }
                });
            }
        });

        $(function () {
            $("input[name='user_type']").click(function () {
                if ($("#buyer").is(":checked")) {
                    location.reload();
                    $('#seller_form').html(null);
                    $('#employee_form').html('');
                    // $('#buyer_selected_category').show();
                    $('#gender').hide();
                    $('#seller_categories').html(null);
                    $('#buyer_categories').html('');
                    $('#buyer_categories').html(`@include('frontend.includes.buyer_categories_html')`);

                } else if($("#seller").is(":checked"))  {
                    $('#employee_form').html('');
                    $('#gender').hide();
                    // $('#buyer_selected_category').hide();
                    $('#buyer_categories').html(null);


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
                            alert(countyCodePrefix1);
                            $("#division_area").hide();
                            $("#district_area").hide();
                            $("#email_1").addClass('d-none');
                            $("#email_2").removeClass('d-none');
                        }else{
                            $("#division_area").show();
                            $("#district_area").show();
                        }
                    });
                }else if($("#employee").is(":checked")) {
                    $('#seller_form').html('');
                    $('#gender').show();
                    $('#buyer_selected_category').hide();
                    $('#buyer_categories').html(null);
                    var user_type = $('#employee').val();
                    $.post('{{ route('get_employee_form') }}',{_token:'{{ csrf_token() }}', user_type:user_type}, function(data){
                        $('#employee_form').html(data);
                    });

                }else{
                    console.log('others');
                }
            });
        });
    </script>

    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"></script>
    <script src="{{asset('backend/dist/js/spartan-multi-image-picker-min.js')}}"></script>
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

        // telInput1.click(function () {
        //     alert('hiiigiif')
        //     var countyCodePrefix1 = $(".flag-container").find('.selected-dial-code').html();
        //     if(countyCodePrefix1 != '+880') {
        //         $("#email_1").addClass('d-none');
        //         $("#email_2").removeClass('d-none');
        //     }
        // });
        telInput1.blur(function () {
            var countyCodePrefix1 = $(".flag-container").find('.selected-dial-code').html();
            console.log(countyCodePrefix1)
            if(countyCodePrefix1 != '+880'){
                // alert(countyCodePrefix1);
                $("#division_area").hide();
                $("#district_area").hide();
                $("#email").prop('required',true);
                $("#emailLebel").html("<label>@lang('website.Email')&nbsp;  (@lang('website.Required')) <span class='required'>*</span> </label>");

            }else{
                $("#division_area").show();
                $("#district_area").show();
                $("#emailLebel").html("<label>@lang('website.Email')&nbsp;  (@lang('website.Optional')) </label>");
                $("#email").prop('required',false);

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

        $(".toggle-password1").click(function() {
            $('#test1').toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $(".toggle-password2").click(function() {
            $('#test2').toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $("#nid_front").spartanMultiImagePicker({
            fieldName: 'nid_front',
            maxCount: 1,
            rowHeight: '200px',
            groupClassName: 'col-md-4 col-sm-4 col-xs-6',
            maxFileSize: '5000000',
            dropFileLabel: "Drop Here",
            onExtensionErr: function (index, file) {
                console.log(index, file, 'extension err');
                alert('Please only input png or jpg type file')
            },
            onSizeErr: function (index, file) {
                console.log(index, file, 'file size too big');
                alert('Image size too big. Please upload below 500kb');
            },
            onAddRow:function(index){
                var altData = '<input type="text" placeholder="" name="nid[]" class="form-control" required=""></div>'
                //var index = index + 1;
                //$('#photos_alt').append('<h4 id="abc_'+index+'">'+index+'</h4>')
                //$('#thumbnail_img_alt').append('<div class="col-md-4 col-sm-4 col-xs-6" id="abc_'+index+'">'+altData+'</div>')
            },
            onRemoveRow : function(index){
                var index = index + 1;
                $(`#abc_${index}`).remove()
            },
        });
        $("#nid_back").spartanMultiImagePicker({
            fieldName: 'nid_back',
            maxCount: 1,
            rowHeight: '200px',
            groupClassName: 'col-md-4 col-sm-4 col-xs-6',
            maxFileSize: '5000000',
            dropFileLabel: "Drop Here",
            onExtensionErr: function (index, file) {
                console.log(index, file, 'extension err');
                alert('Please only input png or jpg type file')
            },
            onSizeErr: function (index, file) {
                console.log(index, file, 'file size too big');
                alert('Image size too big. Please upload below 500kb');
            },

            onRemoveRow : function(index){
                var index = index + 1;
                $(`#abc_${index}`).remove()
            },
        });
    </script>
    <script>
        $("#buyer_category_2").hide()
        $("#buyer_category_3").hide()
        $("#buyer_category_4").hide()
        $("#buyer_category_5").hide()
        $("#buyer_category_6").hide()
        $("#buyer_category_7").hide()
        $("#buyer_category_8").hide()
        $("#buyer_category_9").hide()
        $("#buyer_category_10").hide()
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
        // $(document).ready(function () {

        $('#category_id').on('change', function () {

            $("#buyer_category_2").show()
            $("#buyer_category_3").hide()
            $("#buyer_category_4").hide()
            $("#buyer_category_5").hide()
            $("#buyer_category_6").hide()
            $("#buyer_category_7").hide()
            $("#buyer_category_8").hide()
            $("#buyer_category_9").hide()
            $("#buyer_category_10").hide()
            get_category_2();

        });
        $('#sub_category_id').on('change', function () {
            $("#buyer_category_3").show()
            $("#buyer_category_4").hide()
            $("#buyer_category_5").hide()
            $("#buyer_category_6").hide()
            $("#buyer_category_7").hide()
            $("#buyer_category_8").hide()
            $("#buyer_category_9").hide()
            $("#buyer_category_10").hide()
            get_category_3();

        });
        $('#sub_sub_category_id').on('change', function () {
            $("#buyer_category_4").show()
            $("#buyer_category_5").hide()
            $("#buyer_category_6").hide()
            $("#buyer_category_7").hide()
            $("#buyer_category_8").hide()
            $("#buyer_category_9").hide()
            $("#buyer_category_10").hide()
            get_category_4();

        });
        $('#sub_sub_child_category_id').on('change', function () {
            $("#buyer_category_5").show()
            $("#buyer_category_6").hide()
            $("#buyer_category_7").hide()
            $("#buyer_category_8").hide()
            $("#buyer_category_9").hide()
            $("#buyer_category_10").hide()
            get_category_5();
        });
        $('#sub_sub_child_child_category_id').on('change', function () {

            $("#buyer_category_6").show()
            $("#buyer_category_7").hide()
            $("#buyer_category_8").hide()
            $("#buyer_category_9").hide()
            $("#buyer_category_10").hide()
            get_category_6();
        });
        $('#category_six_id').on('change', function () {
            $("#buyer_category_7").show()
            $("#buyer_category_8").hide()
            $("#buyer_category_9").hide()
            $("#buyer_category_10").hide()
            get_category_7();
        });
        $('#category_seven_id').on('change', function () {
            $("#buyer_category_8").show()
            $("#buyer_category_9").hide()
            $("#buyer_category_10").hide()
            get_category_8();
        });
        $('#category_eight_id').on('change', function () {
            $("#buyer_category_9").show()
            $("#buyer_category_10").hide()
            get_category_9();
        });
        $('#category_nine_id').on('change', function () {
            $("#buyer_category_10").show()
            get_category_10();
        });
        function get_category_2() {
            var category_id = $('#category_id').val();

            $.post('{{ route('products.get_subcategories_by_category') }}', {
                _token: '{{ csrf_token() }}',
                category_id: category_id
            }, function (data) {
                if(data.length > 0){
                    $('#sub_category_id').html(null);
                    $('#sub_category_id').append($('<option selected disabled>@lang('website.Select Product')</option>'));
                    for (var i = 0; i < data.length; i++) {
                        $('#sub_category_id').append($('<option>', {
                            value: data[i].id,
                            text: getNameBnEn(data[i].name,data[i].name_bn)
                        }));
                    }
                    $('.demo-select2').select2();
                }else{
                    $("#buyer_category_2").hide()
                }
                get_category_3();
            });
        }
        function get_category_3() {
            var sub_category_id = $('#sub_category_id').val();
            $.post('{{ route('products.get_subsubcategories_by_subcategory') }}', {
                _token: '{{ csrf_token() }}',
                sub_category_id: sub_category_id
            }, function (data) {
                if(data.length > 0) {
                    $('#sub_sub_category_id').html(null);
                    $('#sub_sub_category_id').append($('<option selected disabled>@lang('website.Select Product')</option>'));
                    for (var i = 0; i < data.length; i++) {
                        $('#sub_sub_category_id').append($('<option>', {
                            value: data[i].id,
                            text: getNameBnEn(data[i].name,data[i].name_bn)
                        }));
                    }
                    $('.demo-select2').select2();
                }else{
                    $("#buyer_category_3").hide()
                }
                get_category_4();
            });
        }
        function get_category_4() {
            var sub_sub_category_id = $('#sub_sub_category_id').val();

            $.post('{{ route('products.get_subsubchildcategories_by_subsubcategory') }}', {
                _token: '{{ csrf_token() }}',
                sub_sub_category_id: sub_sub_category_id
            }, function (data) {

                if(data.length > 0) {
                    $('#sub_sub_child_category_id').html(null);
                    $('#sub_sub_child_category_id').append($('<option selected disabled>@lang('website.Select Product')</option>'));
                    for (var i = 0; i < data.length; i++) {
                        $('#sub_sub_child_category_id').append($('<option>', {
                            value: data[i].id,
                            text: getNameBnEn(data[i].name,data[i].name_bn)
                        }));
                    }
                    $('.demo-select2').select2();
                }else{
                    $("#buyer_category_4").hide()
                }
                get_category_5();

            });
        }
        function get_category_5() {
            var sub_sub_child_category_id = $('#sub_sub_child_category_id').val();
            $.post('{{ route('products.get_subsubchildchildcategories_by_subsubchildcategory') }}', {
                _token: '{{ csrf_token() }}',
                sub_sub_child_category_id: sub_sub_child_category_id
            }, function (data) {
                if(data.length > 0) {
                    $('#sub_sub_child_child_category_id').html(null);
                    $('#sub_sub_child_child_category_id').append($('<option selected disabled>@lang('website.Select Product')</option>'));
                    for (var i = 0; i < data.length; i++) {
                        $('#sub_sub_child_child_category_id').append($('<option>', {
                            value: data[i].id,
                            text: getNameBnEn(data[i].name,data[i].name_bn)
                        }));
                    }
                    $('.demo-select2').select2();
                }else{
                    $("#buyer_category_5").hide()
                }
                get_category_6();

            });
        }
        function get_category_6() {
            var sub_sub_child_child_category_id = $('#sub_sub_child_child_category_id').val();
            $.post('{{ route('products.get_category_six') }}', {
                _token: '{{ csrf_token() }}',
                sub_sub_child_child_category_id: sub_sub_child_child_category_id
            }, function (data) {
                //console.log(data)
                if(data.length > 0) {
                    $('#category_six_id').html(null);
                    $('#category_six_id').append($('<option selected disabled>@lang('website.Select Product')</option>'));
                    for (var i = 0; i < data.length; i++) {
                        $('#category_six_id').append($('<option>', {
                            value: data[i].id,
                            text: getNameBnEn(data[i].name,data[i].name_bn)
                        }));
                    }
                    $('.demo-select2').select2();
                }else{
                    $("#buyer_category_6").hide()
                }
                get_category_7();

            });
        }
        function get_category_7() {
            var category_six_id = $('#category_six_id').val();
            $.post('{{ route('products.get_category_seven') }}', {
                _token: '{{ csrf_token() }}',
                category_six_id: category_six_id
            }, function (data) {
                //console.log(data)
                if(data.length > 0) {
                    $('#category_seven_id').html(null);
                    $('#category_seven_id').append($('<option selected disabled>@lang('website.Select Product')</option>'));
                    for (var i = 0; i < data.length; i++) {
                        $('#category_seven_id').append($('<option>', {
                            value: data[i].id,
                            text: getNameBnEn(data[i].name,data[i].name_bn)
                        }));
                    }
                    $('.demo-select2').select2();
                }else{
                    $("#buyer_category_7").hide()
                }
                get_category_8();
            });
        }
        function get_category_8() {
            var category_seven_id = $('#category_seven_id').val();
            $.post('{{ route('products.get_category_eight') }}', {
                _token: '{{ csrf_token() }}',
                category_seven_id: category_seven_id
            }, function (data) {
                if(data.length > 0) {
                    $('#category_eight_id').html(null);
                    $('#category_eight_id').append($('<option selected disabled>@lang('website.Select Product')</option>'));
                    for (var i = 0; i < data.length; i++) {
                        $('#category_eight_id').append($('<option>', {
                            value: data[i].id,
                            text: getNameBnEn(data[i].name,data[i].name_bn)
                        }));
                    }
                    $('.demo-select2').select2();
                }else{
                    $("#buyer_category_8").hide()
                }
                get_category_9()
            });
        }
        function get_category_9() {
            var category_eight_id = $('#category_eight_id').val();
            $.post('{{ route('products.get_category_nine') }}', {
                _token: '{{ csrf_token() }}',
                category_eight_id: category_eight_id
            }, function (data) {
                if(data.length > 0) {
                    $('#category_nine_id').html(null);
                    $('#category_nine_id').append($('<option selected disabled>@lang('website.Select Product')</option>'));
                    for (var i = 0; i < data.length; i++) {
                        $('#category_nine_id').append($('<option>', {
                            value: data[i].id,
                            text: getNameBnEn(data[i].name,data[i].name_bn)
                        }));
                    }
                    $('.demo-select2').select2();
                }else{
                    $("#buyer_category_9").hide()
                }
                get_category_10()
            });
        }
        function get_category_10() {
            var category_nine_id = $('#category_nine_id').val();
            $.post('{{ route('products.get_category_ten') }}', {
                _token: '{{ csrf_token() }}',
                category_nine_id: category_nine_id
            }, function (data) {
                if(data.length > 0) {
                    $('#category_ten_id').html(null);
                    $('#category_ten_id').append($('<option selected disabled>@lang('website.Select Product')</option>'));
                    for (var i = 0; i < data.length; i++) {
                        $('#category_ten_id').append($('<option>', {
                            value: data[i].id,
                            text: getNameBnEn(data[i].name,data[i].name_bn)
                        }));
                    }
                    $('.demo-select2').select2();
                }else{
                    $("#buyer_category_10").hide()
                }

            });
        }
        // })
    </script>
@endpush


