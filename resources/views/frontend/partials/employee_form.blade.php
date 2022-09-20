
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

<h3 class="mt-5">@lang('website.Job Info')</h3>
@php
    $divisions = \App\Model\Division::all();
    $salary_ranges = \App\Model\SalaryRange::all();
    $industryCategories = \App\Model\IndustryCategory::all();
@endphp
<p id="division_area">
    <label for="division_id">@lang('website.Division')</label>
    <select name="division_id" id="division_id" class="form-control demo-select2" required>
        <option disabled selected>@lang('website.Select')</option>
        @foreach($divisions as $division)
            <option value="{{$division->id}}">{{getNameByBnEn($division)}}</option>
        @endforeach
    </select>
</p>
<p id="district_area">
    <label for="district_id">@lang('website.District')</label>
    <select name="district_id" id="district_id" class="form-control demo-select2" required>
    </select>
</p>
<p id="upazila_area">
    <label for="upazila_id">@lang('website.Thana'):&nbsp;<span class="required">*</span></label>
    <select name="upazila_id" id="upazila_id" class="form-control demo-select2 bg-gray-light" required>
    </select >
</p>
<p id="union_area">
    <label for="union_id">@lang('website.Post Office'):&nbsp;<span class="required">*</span></label>
    <select name="union_id" id="union_id" class="form-control demo-select2 bg-gray-light" required>
    </select>
</p>

<p>
    <label for="village_or_area">@lang('website.Village Or Area'):&nbsp;<span class="required">*</span></label>
    <input type="text" class="form-control" name="village_or_area" id="village_or_area" required/>
</p>
<p>
    <label for="marital_status">@lang('website.Marital Status'):&nbsp;<span class="required">*</span></label>
    <select name="marital_status" id="marital_status" class="form-control demo-select2" required>
        <option disabled selected>@lang('website.Select')</option>
        <option value="Married">@lang('website.Married')</option>
        <option value="Unmarried">@lang('website.Unmarried')</option>
        <option value="Widowed">@lang('website.Widowed')</option>
    </select>
</p>
<p>
    <label for="gender">@lang('website.Gender'):&nbsp;<span class="required">*</span></label>
    <select name="gender" id="gender" class="form-control demo-select2" required>
        <option disabled selected>@lang('website.Select')</option>
        <option value="Male">@lang('website.Male')</option>
        <option value="Female">@lang('website.Female')</option>
        <option value="Neutral">@lang('website.Neutral')</option>
        <option value="Common">@lang('website.Common')</option>
    </select>
</p>
<p>
    <label for="age">@lang('website.Age'):<span class="required">*</span></label>
    <select name="age" id="age" class="form-control demo-select2" required>
        <option disabled selected>@lang('website.Select')</option>
        @for($i=16;$i<=60;$i++)
            <option value="{{$i}}">{{getNumberToBangla($i)}}</option>
        @endfor
    </select>
</p>
<p>
    <label for="current_salary">@lang('website.Current Salary'):&nbsp;<span class="required">*</span></label>
    <select name="current_salary" id="current_salary" class="form-control demo-select2" required>
        <option disabled selected>@lang('website.Select')</option>
        @foreach($salary_ranges as $salary_range)
            <option value="{{$salary_range->start}} - {{$salary_range->end}}">{{getNumberWithCurrencyByBnEn($salary_range->start)}} - {{getNumberWithCurrencyByBnEn($salary_range->end)}}</option>
        @endforeach
    </select>
</p>
<p>
    <label for="expected_salary">@lang('website.Expected Salary'):&nbsp;<span class="required">*</span></label>
    <select name="expected_salary" id="expected_salary" class="form-control demo-select2" required >
        <option disabled selected>@lang('website.Select')</option>
        @foreach($salary_ranges as $salary_range)
            <option value="{{$salary_range->start}} - {{$salary_range->end}}">{{getNumberWithCurrencyByBnEn($salary_range->start)}} - {{getNumberWithCurrencyByBnEn($salary_range->end)}}</option>
        @endforeach
    </select>
</p>
<div  id="looking_job_industry_category_area">
    <label for="looking_job_industry_category_id">@lang('website.Looking For Job In'):&nbsp;<span class="required">*</span></label>
    <select name="looking_job_industry_category_id" id="looking_job_industry_category_id" class="form-control demo-select2" required>
        <option disabled selected>@lang('website.Select')</option>
        @foreach($industryCategories as $industryCategory)
            <option value="{{$industryCategory->id}}">{{getNameByBnEn($industryCategory)}}</option>
        @endforeach
    </select>
</div>
<p>
    <label for="joining_duration">@lang('website.Duration For Joining To New Job'):</label>
    <select name="joining_duration" id="joining_duration" class="form-control demo-select2" required >
        <option disabled selected>@lang('website.Select')</option>
        <option value="Immediately">@lang('website.Immediately')</option>
        <option value="1 Week">@lang('website.1 Week')</option>
        <option value="2 Weeks">@lang('website.2 Weeks')</option>
        <option value="1 Month">@lang('website.1 Month')</option>
        <option value="2 Months">@lang('website.2 Months')</option>
    </select>
</p>
<div id="industry_category_area">
    <label for="industry_category_id">@lang('website.Choose Your Expertise'):&nbsp;<span class="required">*</span></label>
    <select name="industry_category_id" id="industry_category_id" class="form-control demo-select2" required>
        <option disabled selected>@lang('website.Select')</option>
        @foreach($industryCategories as $industryCategory)
            <option value="{{$industryCategory->id}}">{{getNameByBnEn($industryCategory)}}</option>
        @endforeach
    </select>
</div>
<div id="industry_sub_category_area">
    <label for="industry_sub_category_id">@lang('website.Industry Sub Category')</label>
    <select name="industry_sub_category_id" id="industry_sub_category_id" class="form-control demo-select2" required>
    </select>
</div>
<div id="industry_employee_type_area">
    <label for="industry_employee_type_id">@lang('website.Industry Employee Type')</label>
    <select name="industry_employee_type_id" id="industry_employee_type_id" class="form-control demo-select2" required>
    </select>
</div>
<p>
    <label for="experience">@lang('website.Years Of Experience In Above Expertise') &nbsp;<span class="required">*</span></label>
    <input type="text" class="form-control" name="experience" id="experience" required>
</p>
{{--<div class="form-group">--}}
{{--    <label class="control-label ml-3">@lang('website.')NID Front Side:&nbsp;<span class="required">*</span> <small class="text-danger">(jpg,jpeg,png file only)</small></label>--}}
{{--    <div class="ml-3 mr-3">--}}
{{--        <div class="row" id="nid_front_side"></div>--}}
{{--        <div class="row" id="nid_front_side_alt"></div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--<div class="form-group">--}}
{{--    <label class="control-label ml-3">@lang('website.')এনআইডি পিছনের দিক / NID Back Side:&nbsp;<span class="required">*</span> <small class="text-danger">(jpg,jpeg,png file only)</small></label>--}}
{{--    <div class="ml-3 mr-3">--}}
{{--        <div class="row" id="nid_back_side"></div>--}}
{{--        <div class="row" id="nid_back_side_alt"></div>--}}
{{--    </div>--}}
{{--</div>--}}
<div class="form-group">
    <label class="control-label ml-3">@lang('website.Upload Your Picture'):&nbsp;<span class="required">*</span> <small class="text-danger">(jpg,jpeg,png file only)</small></label>
    <div class="ml-3 mr-3">
        <div class="row" id="employee_pic"></div>
        <div class="row" id="employee_pic_alt"></div>
    </div>
</div>

<script src="{{asset('backend/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{asset('backend/dist/js/spartan-multi-image-picker-min.js')}}"></script>

<script>
    $(document).ready(function () {
        //get_district_by_division();
        $('.demo-select2').select2();

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

        function get_district_by_division() {
            var division_id = $('#division_id').val();
            //console.log(category_id)
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
                        text: getNameBnEn(data[i].name,data[i].name_bn)
                    }));
                    $('.demo-select2').select2();
                }
            });
        }
        $('#industry_sub_category_id').on('change', function () {
            get_industry_employee_type_by_industry_sub_category();
        });

        $("#nid_front_side").spartanMultiImagePicker({
            fieldName: 'nid_front_side',
            maxCount: 1,
            rowHeight: '200px',
            groupClassName: 'col-md-4 col-sm-4 col-xs-6',
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
                //var index = index + 1;
                //$('#photos_alt').append('<h4 id="abc_'+index+'">'+index+'</h4>')
                //$('#thumbnail_img_alt').append('<div class="col-md-4 col-sm-4 col-xs-6" id="abc_'+index+'">'+altData+'</div>')
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
            groupClassName: 'col-md-4 col-sm-4 col-xs-6',
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
                //var index = index + 1;
                //$('#photos_alt').append('<h4 id="abc_'+index+'">'+index+'</h4>')
                //$('#thumbnail_img_alt').append('<div class="col-md-4 col-sm-4 col-xs-6" id="abc_'+index+'">'+altData+'</div>')
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
            groupClassName: 'col-md-4 col-sm-4 col-xs-6',
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
                //var index = index + 1;
                //$('#photos_alt').append('<h4 id="abc_'+index+'">'+index+'</h4>')
                //$('#thumbnail_img_alt').append('<div class="col-md-4 col-sm-4 col-xs-6" id="abc_'+index+'">'+altData+'</div>')
            },
            onRemoveRow : function(index){
                var index = index + 1;
                $(`#abc_${index}`).remove()
            },
        });

    });

</script>

