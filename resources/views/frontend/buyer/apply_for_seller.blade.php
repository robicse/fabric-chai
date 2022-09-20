@extends('frontend.layouts.master')
@section('title', 'Apply for Seller')
@push('css')
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
@endpush
@section('content')
    <div class="full-row" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                @include('frontend.buyer.buyer_breadcrumb')
                @include('frontend.buyer.buyer_sidebar')
                <div class="col-lg-9">
                    <h4>@lang('website.Apply for Seller')</h4>
                    <form class="woocommerce-form-login" action="{{route('buyer.apply_for_seller.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h3>@lang('website.Company Information')</h3>
                        <div class="row">
                            <p class="col-md-6">
                                <label for="company_name">@lang('website.Company Name (English)')&nbsp;<span class="required">*</span></label>
                                <input type="text" class="form-control" name="company_name" id="company_name" style="background-color: #fff" required/>
                            </p>
                            <p class="col-md-6">
                                <label for="company_name_bn">@lang('website.Company Name (Bangla)')&nbsp;<span class="required">*</span></label>
                                <input type="text" class="form-control" name="company_name_bn" id="company_name_bn" style="background-color: #fff" required/>
                            </p>
                            <p class="col-md-6">
                                <label for="designation">@lang('website.Your Designation')</label>
                                <input type="text" class="form-control" name="designation" id="designation" style="background-color: #fff"/>
                            </p>
                            <p class="col-md-6">
                                <label for="company_phone">@lang('website.Company phone Number')&nbsp;<span class="required">*</span></label>
                                <input type="number" class="form-control" name="company_phone" id="company_phone" style="background-color: #fff" required/>
                            </p>

                            <p class="col-md-6">
                                <label for="company_address">@lang('website.Company Address (English)')</label>
                                <input type="text" class="form-control" name="company_address" id="company_address" style="background-color: #fff"/>
                            </p>
                            <p class="col-md-6">
                                <label for="company_address_bn">@lang('website.Company Address (Bangla)')</label>
                                <input type="text" class="form-control" name="company_address_bn" id="company_address_bn" style="background-color: #fff"/>
                            </p>
                            <p class="col-md-6">
                                <label for="company_phone">@lang('website.Company Email')&nbsp;<span class="required">*</span></label>
                                <input type="email" class="form-control" name="company_email" id="company_email" style="background-color: #fff" />
                            </p>
                            @php
                                $divisions = \App\Model\Division::all();
                            @endphp
                            <p class="col-7">
                                <label for="division_id">@lang('website.Division')</label>
                                <select name="division_id" id="division_id" class="form-control demo-select2" style="background-color: #fff;" required>
                                    <option value=""></option>
                                    @foreach($divisions as $division)
                                        <option value="{{$division->id}}">{{$division->name}}</option>
                                    @endforeach
                                </select>
                            </p>
                            <p class="col-7">
                                <label for="district_id">@lang('website.District')</label>
                                <select name="district_id" id="district_id" class="form-control demo-select2"
                                        style="background-color: #fff;">
                                </select>
                            </p>
                            @php
                                $categories = \App\Model\Category::all();
                            @endphp
                            <div class="form-group col-7">
                                <label for="selected_category">@lang('website.Type your Product willing to sell')</label>
{{--                                <select name="selected_category" id="selected_category" class="form-control demo-select2" style="background-color: #fff;" required>--}}
{{--                                    @foreach($categories as $categories)--}}
{{--                                        <option value="{{$categories->id}}">{{$categories->name}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
                                <select name="selected_category[]" id="selected_category" class="form-control demo-select2" style="background-color: #f3f3f3" multiple required>
                                    @foreach($categories as $categories)
                                        <option value="{{$categories->id}}">{{$categories->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-7">
                                <label class="control-label ml-3">@lang('website.Trade Licence Image') <small class="text-danger">(jpg,jpeg,png file only)</small></label>
                                <div class="ml-3 mr-3">
                                    <div class="row" id="trade_licence" style="background-color: #fff;"></div>
                                    <div class="row" id="trade_licence_alt"></div>
                                </div>
                            </div>
                            <div class="form-group col-7" style="background-color: #fff;">
                                <label class="control-label ml-3">@lang('website.National ID Image') (@lang('website.Front')) <small class="text-danger">(jpg,jpeg,png file only)</small> </label>
                                <div class="ml-3 mr-3">
                                    <div class="row" id="nid_front"></div>

                                </div>
                            </div>
                            <div class="form-group col-7" style="background-color: #fff;">
                                <label class="control-label ml-3">@lang('website.National ID Image') (@lang('website.Back')) <small class="text-danger">(jpg,jpeg,png file only)</small> </label>
                                <div class="ml-3 mr-3">
                                    <div class="row" id="nid_back"></div>

                                </div>
                            </div>
                        </div>

                        <button type="submit" class="woocommerce-form-login__submit btn btn-primary rounded-0" >@lang('website.Submit')</button>

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
            //get_district_by_division();
            $('.demo-select2').select2();

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
                            text: data[i].name
                        }));
                        $('.demo-select2').select2();
                    }
                });
            }
            $('#division_id').on('change', function () {
                get_district_by_division();
            });


            $("#nid_front").spartanMultiImagePicker({
                fieldName: 'nid_front',
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

                onRemoveRow : function(index){
                    var index = index + 1;
                    $(`#abc_${index}`).remove()
                },
            });
            $("#trade_licence").spartanMultiImagePicker({
                fieldName: 'trade_licence',
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

                onRemoveRow : function(index){
                    var index = index + 1;
                    $(`#abc_${index}`).remove()
                },
            });
        });
    </script>
@endpush

