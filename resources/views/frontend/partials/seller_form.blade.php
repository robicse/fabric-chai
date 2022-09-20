
<link rel="stylesheet" href="{{asset('backend/plugins/select2/select2.min.css')}}">

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

<h3 class="mt-3">@lang('website.Company Info')</h3>
<div class="row">
    @php
        $lang = app()->getLocale('locale');
    @endphp
    <div class="col-md-6">
        <label for="company_name">@lang('website.Company Name') <span class="required">*</span></label>
        <input type="text" class="form-control" name="company_name" id="company_name" required/>
    </div>
{{--    <div class="col-md-6">--}}
{{--        <label for="company_name_bn">@lang('website.Company Name (Bangla)') </label>--}}
{{--        <input type="text" class="form-control" name="company_name_bn" id="company_name_bn" required/>--}}
{{--    </div>--}}
    <div class="col-md-6 @if($lang !== 'en') d-none @endif">
        <label for="designation">@lang('website.Your Designation (English)')</label>
        <input type="text" class="form-control" name="designation" id="designation"/>
    </div>
    <div class="col-md-6 @if($lang !== 'bn') d-none @endif">
        <label for="designation_bn">@lang('website.Your Designation (Bangla)')</label>
        <input type="text" class="form-control" name="designation_bn" id="designation_bn"/>
    </div>
    <div class="col-md-6">
        <label for="company_phone">@lang('website.Company phone Number')&nbsp;<span class="required">*</span></label>
        <input type="number" class="form-control" name="company_phone" id="company_phone" required/>
    </div>
    <div class="col-md-6">
        <label for="company_email">@lang('website.Company Email')&nbsp;<span class="required">*</span></label>
        <input type="email" class="form-control" name="company_email" id="company_email" required/>
    </div>
    <div class="col-md-6 @if($lang !== 'en') d-none @endif">
        <label for="company_address">@lang('website.Company Address (English)')</label>
        <input type="text" class="form-control" name="company_address" id="company_address"/>
    </div>
    <div class="col-md-6 @if($lang !== 'bn') d-none @endif">
        <label for="company_address_bn">@lang('website.Company Address (Bangla)')</label>
        <input type="text" class="form-control" name="company_address_bn" id="company_address_bn"/>
    </div>
    @php
        $divisions = \App\Model\Division::all();
    @endphp
    <div class="col-md-6" id="division_area">
        <label for="division_id">@lang('website.Division') <span class="required">*</span>  </label>
        <select name="division_id" id="division_id" class="form-control demo-select2 bg-gray-light" >
            <option value="">@lang('website.Select')</option>
            @foreach($divisions as $division)
                <option value="{{$division->id}}">{{getNameByBnEn($division)}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6" id="district_area">
        <label for="district_id">@lang('website.District') <span class="required">*</span> </label>
        <select name="district_id" id="district_id" class="form-control demo-select2 bg-gray-light" >
        </select>
    </div>
</div>

<div id="seller_categories">
    @include('frontend.includes.seller_categories_html')
</div>

{{--@php--}}
{{--    $categories = \App\Model\Category::all();--}}
{{--@endphp--}}
{{--<p id="category_area">--}}
{{--    <label for="selected_category">@lang('website.Select your Product willing to sell') </label>--}}
{{--    <select name="selected_category[]" id="selected_category" class="form-control demo-select2 bg-gray-light"  multiple>--}}
{{--        @foreach($categories as $categories)--}}
{{--            <option value="{{$categories->id}}">{{getNameByBnEn($categories)}}</option>--}}
{{--        @endforeach--}}
{{--    </select>--}}
{{--</p>--}}
<div class="form-group">
    <label class="control-label ml-3">@lang('website.Trade Licence Image') <small class="text-danger">(jpg,jpeg,png file only)</small></label>
    <div class="ml-3 mr-3">
        <div class="row" id="trade_licence"></div>
        <div class="row" id="trade_licence_alt"></div>
    </div>
</div>
{{--<div class="form-group">--}}
{{--    <label class="control-label ml-3">@lang('website.National ID Image') (@lang('website.Front')) <small class="text-danger">(jpg,jpeg,png file only)</small></label>--}}
{{--    <div class="ml-3 mr-3">--}}
{{--        <div class="row" id="nid_front"></div>--}}

{{--    </div>--}}
{{--</div>--}}
{{--<div class="form-group">--}}
{{--    <label class="control-label ml-3">@lang('website.National ID Image') (@lang('website.Back')) <small class="text-danger">(jpg,jpeg,png file only)</small></label>--}}
{{--    <div class="ml-3 mr-3">--}}
{{--        <div class="row" id="nid_back"></div>--}}

{{--    </div>--}}
{{--</div>--}}


<script src="{{asset('backend/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{asset('backend/dist/js/spartan-multi-image-picker-min.js')}}"></script>

<script>
    $(document).ready(function () {
        $("#buyer_category_2").hide()
        $("#buyer_category_3").hide()
        $("#buyer_category_4").hide()
        $("#buyer_category_5").hide()
        $("#buyer_category_6").hide()
        $("#buyer_category_7").hide()
        $("#buyer_category_8").hide()
        $("#buyer_category_9").hide()
        $("#buyer_category_10").hide()
        //get_district_by_division();
        $('.demo-select2').select2();

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

        function get_district_by_division() {
            var division_id = $('#division_id').val();

            $.post('{{ route('get_district_by_division') }}', {
                _token: '{{ csrf_token() }}',
                division_id: division_id
            }, function (data) {
                $('#district_id').html(null);
                $('#district_id').append($('<option>', {
                    value: null,
                    text: null
                }));
                //console.log(data)
                for (var i = 0; i < data.length; i++) {
                    $('#district_id').append($('<option>', {
                        value: data[i].id,
                        text: getNameBnEn(data[i].name,data[i].name_bn)
                    }));
                    $('.demo-select2').select2();
                }
            });
        }
        $('#division_id').on('change', function () {
            get_district_by_division();
        });


        // $("#nid_front").spartanMultiImagePicker({
        //     fieldName: 'nid_front',
        //     maxCount: 1,
        //     rowHeight: '200px',
        //     groupClassName: 'col-md-4 col-sm-4 col-xs-6',
        //     maxFileSize: '5000000',
        //     dropFileLabel: "Drop Here",
        //     onExtensionErr: function (index, file) {
        //         console.log(index, file, 'extension err');
        //         alert('Please only input png or jpg type file')
        //     },
        //     onSizeErr: function (index, file) {
        //         console.log(index, file, 'file size too big');
        //         alert('Image size too big. Please upload below 500kb');
        //     },
        //     onAddRow:function(index){
        //         var altData = '<input type="text" placeholder="" name="nid[]" class="form-control" required=""></div>'
        //         //var index = index + 1;
        //         //$('#photos_alt').append('<h4 id="abc_'+index+'">'+index+'</h4>')
        //         //$('#thumbnail_img_alt').append('<div class="col-md-4 col-sm-4 col-xs-6" id="abc_'+index+'">'+altData+'</div>')
        //     },
        //     onRemoveRow : function(index){
        //         var index = index + 1;
        //         $(`#abc_${index}`).remove()
        //     },
        // });
        // $("#nid_back").spartanMultiImagePicker({
        //     fieldName: 'nid_back',
        //     maxCount: 1,
        //     rowHeight: '200px',
        //     groupClassName: 'col-md-4 col-sm-4 col-xs-6',
        //     maxFileSize: '5000000',
        //     dropFileLabel: "Drop Here",
        //     onExtensionErr: function (index, file) {
        //         console.log(index, file, 'extension err');
        //         alert('Please only input png or jpg type file')
        //     },
        //     onSizeErr: function (index, file) {
        //         console.log(index, file, 'file size too big');
        //         alert('Image size too big. Please upload below 500kb');
        //     },
        //
        //     onRemoveRow : function(index){
        //         var index = index + 1;
        //         $(`#abc_${index}`).remove()
        //     },
        // });

        $("#trade_licence").spartanMultiImagePicker({
            fieldName: 'trade_licence',
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

