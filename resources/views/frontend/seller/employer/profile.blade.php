@extends('frontend.layouts.master')
@section('title', 'Employer Profile')
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
        form label{
            color: #737073;
        }
    </style>
@endpush
@section('content')
    <div class="full-row" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-3 mobile_view">
                    <h3 class="mb-2 text-secondary">@lang('website.Employer Dashboard')</h3>
                </div>
                @include('frontend.seller.seller_sidebar')
                <div class="col-lg-9 col-sm-9" style="background: #fff; padding: 10px;">
                    <h3 class="text-center">@lang('website.Employer Profile')</h3>
                    <form class="woocommerce-form-login" action="{{route('employee.profile.update')}}" method="POST" enctype="multipart/form-data" style="margin-left: 20px;">
                        @csrf
                        <div class="row">
                            <h4>@lang('website.Personal Information')</h4><hr>
                            <p class="col-7">
                                <label for="name">@lang('website.Name')<span class="required">*</span></label>
                                <input type="text" class="form-control" name="name" id="name" value="{{Auth::User()->name}}" required/>
                            </p>

                            <div class="col-7">
                                <label for="phone">@lang('website.Phone')</label>
                                <input type="text" class="form-control" name="phone" value="{{Auth::User()->country_code.Auth::User()->phone}}" readonly/>
                            </div>
                            <p class="col-7">
                                <label for="email">@lang('website.Email')&nbsp;<span class="required">*</span></label>
                                <input type="email" class="form-control" name="email" id="email" value="{{Auth::User()->email}}" />
                            </p>
                            <p class="col-7">
                                <label for="address">@lang('website.Employers Address')</label>
                                <input type="text" class="form-control" name="address" id="address" value="{{Auth::User()->address}}"/>
                            </p>
                            @php
                                $seller = \App\Model\Seller::where('user_id',Auth::id())->first();

                                $employer = \App\Model\Employer::where('user_id',Auth::id())->first();
                            @endphp
                            <h4>@lang('website.Company Information')</h4><hr>
                            <p class="col-7">
                                <label for="company_name">@lang('website.Company name')&nbsp;<span class="required">*</span></label>
                                <input type="text" class="form-control" name="company_name" id="company_name" value="{{$seller->company_name}}" required/>
                            </p>
                            <p class="col-7">
                                <label for="owner_name">@lang('website.Company owners name')&nbsp;<span class="required">*</span></label>
                                <input type="text" class="form-control" name="owner_name" id="owner_name" value="{{$employer->owner_name}}" required/>
                            </p>
                            <p class="col-7">
                                <label for="company_phone">@lang('website.Company phone Number')&nbsp;<span class="required">*</span></label>
                                <input type="number" class="form-control" name="company_phone" id="company_phone" value="{{$seller->company_phone}}" required/>
                            </p>
                            <p class="col-7">
                                <label for="company_phone">@lang('website.Company Email')&nbsp;<span class="required">*</span></label>
                                <input type="email" class="form-control" name="company_email" id="company_email" value="{{$seller->company_email}}" />
                            </p>
                            <p class="col-7">
                                <label for="company_address">@lang('website.Company Address')</label>
                                <input type="text" class="form-control" name="company_address" id="company_address" value="{{$seller->company_address}}" required/>
                            </p>

                            @php
                                $categories = \App\Model\IndustryCategory::all();
                            @endphp
                            <div class="form-group col-7">
                                <label for="selected_category">@lang('website.Looking to Hire')</label>
                                <select name="industry_category_id[]" id="selected_category" class="form-control demo-select2" multiple required>
                                    @foreach($categories as $category)
                                        @php
                                            $ids = json_decode($employer->industry_category_id)
                                        @endphp
                                        @if(!empty($ids))
                                            @foreach($ids as $id)
                                                <option value="{{$category->id}}" {{ $id == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                                            @endforeach
                                        @else
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <p class="col-7">
                                <label for="no_of_employee">@lang('website.Number of Employees')&nbsp;<span class="required">*</span></label>
                                <select name="no_of_employee" id="no_of_employee" class="form-control demo-select2" required>
                                    <option value="">@lang('website.Select')</option>
                                    <option value="0-10" {{$employer->no_of_employee == '0-10' ? 'Selected':''}}>@lang('website.0-10')</option>
                                    <option value="10-50" {{$employer->no_of_employee == '10-50' ? 'Selected':''}}>@lang('website.10-50')</option>
                                    <option value="50-100" {{$employer->no_of_employee == '50-100' ? 'Selected':''}}>@lang('website.50-100')</option>
                                    <option value="100-200" {{$employer->no_of_employee == '100-200' ? 'Selected':''}}>@lang('website.100-200')</option>
                                    <option value="200-500" {{$employer->no_of_employee == '200-500' ? 'Selected':''}}>@lang('website.200-500')</option>
                                    <option value="500-1,000" {{$employer->no_of_employee == '500-1,000' ? 'Selected':''}}>@lang('website.500-1,000')</option>
                                    <option value="1,000-2,000" {{$employer->no_of_employee == '1,000-2,000' ? 'Selected':''}}>@lang('website.1,000-2,000')</option>
                                    <option value="2,000-5,000" {{$employer->no_of_employee == '2,000-5,000' ? 'Selected':''}}>@lang('website.2,000-5,000')</option>
                                    <option value="5,000-10,000" {{$employer->no_of_employee == '5,000-10,000' ? 'Selected':''}}>@lang('website.5,000-10,000')</option>
                                    <option value="10,000+" {{$employer->no_of_employee == '10,000+' ? 'Selected':''}}>@lang('website.10,000+')</option>
                                </select>
                            </p>
                            <p class="col-7">
                                <label for="salary_type">@lang('website.Company Salary Type')<span class="required">*</span></label>
                                <select name="salary_type" id="salary_type" class="form-control demo-select2" required>
                                    <option value="">@lang('website.Select')</option>
                                    <option value="Production" {{$employer->salary_type == 'Production' ? 'Selected':''}}>@lang('website.Production')</option>
                                    <option value="Monthly" {{$employer->salary_type == 'Monthly' ? 'Selected':''}}>@lang('website.Monthly')</option>
                                    <option value="Bi-Weekly" {{$employer->salary_type == 'Bi-Weekly' ? 'Selected':''}}>@lang('website.Bi-Weekly')</option>
                                    <option value="Fixed" {{$employer->salary_type == 'Fixed' ? 'Selected':''}}>@lang('website.Fixed')</option>
                                    <option value="Contract" {{$employer->salary_type == 'Contract' ? 'Selected':''}}>@lang('website.Contract')</option>
                                    <option value="Other" {{$employer->salary_type == 'Other' ? 'Selected':''}}>@lang('website.Other')</option>
                                </select>
                            </p>
                            <p class="col-7">
                                <label for="established_year">@lang('website.Company Established Year')<span class="required">*</span></label>
                                <select name="established_year" id="established_year" class="form-control demo-select2" required>
                                    @php
                                        $now = date('Y');
                                        $last= date('Y')-50;
                                    @endphp
                                    <option value="">Select</option>
                                    @for($i=$now; $i>= $last; $i--)
                                        <option value="{{$i}}" {{$employer->established_year == $i ? 'Selected':''}}>{{$i}}</option>
                                    @endfor

                                </select>
                            </p>
                            <h4>@lang('website.Please Upload Required Documents')
                                <small class="text-danger">(jpg,jpeg,png file only)</small></h4><hr>
                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label ml-3 col-3">@lang('website.Trade Licence Image') </label>
                                    <div class="ml-3 mr-3 col-9">
                                        <div class="row" id="trade_licence">
                                            @if ($seller->trade_licence != null)
                                                <div class="col-md-3 col-sm-4 col-xs-6">
                                                    <div class="img-upload-preview">
                                                        <img loading="lazy"  src="{{ url($seller->trade_licence) }}" alt="" class="img-responsive">
                                                        <input type="hidden" name="previous_trade_licence" value="{{ $seller->trade_licence }}">
                                                        <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label ml-3 col-3">@lang('website.VAT')</label>
                                    <div class="ml-3 mr-3 col-9">
                                        <div class="row" id="vat">
                                            @if ($employer->vat != null)
                                                <div class="col-md-3 col-sm-4 col-xs-6">
                                                    <div class="img-upload-preview">
                                                        <img loading="lazy"  src="{{ url($employer->vat) }}" alt="" class="img-responsive">
                                                        <input type="hidden" name="previous_vat" value="{{ $employer->vat }}">
                                                        <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label ml-3 col-3">@lang('website.NID of Owner (Front)')</label>
                                    <div class="ml-3 mr-3 col-9">
                                        <div class="row" id="owner_nid_front">
                                            @if ($employer->owner_nid_front != null)
                                                <div class="col-md-3 col-sm-4 col-xs-6">
                                                    <div class="img-upload-preview">
                                                        <img loading="lazy"  src="{{ url($employer->owner_nid_front) }}" alt="" class="img-responsive">
                                                        <input type="hidden" name="previous_nid" value="{{ $employer->owner_nid_front }}">
                                                        <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label ml-3 col-3">@lang('website.NID of Owner (Back)')</label>
                                    <div class="ml-3 mr-3 col-9">
                                        <div class="row" id="owner_nid_back">
                                            @if ($employer->owner_nid_back != null)
                                                <div class="col-md-3 col-sm-4 col-xs-6">
                                                    <div class="img-upload-preview">
                                                        <img loading="lazy"  src="{{ url($employer->owner_nid_back) }}" alt="" class="img-responsive">
                                                        <input type="hidden" name="previous_nid" value="{{ $employer->owner_nid_back }}">
                                                        <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label ml-3 col-3">@lang('website.Factory Certificate')</label>
                                    <div class="ml-3 mr-3 col-9">
                                        <div class="row" id="factory_certificate">
                                            @if ($employer->factory_certificate != null)
                                                <div class="col-md-3 col-sm-4 col-xs-6">
                                                    <div class="img-upload-preview">
                                                        <img loading="lazy"  src="{{ url($employer->factory_certificate) }}" alt="" class="img-responsive">
                                                        <input type="hidden" name="previous_factory_certificate" value="{{ $employer->factory_certificate }}">
                                                        <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label ml-3 col-3">@lang('website.Fire Licence')</label>
                                    <div class="ml-3 mr-3 col-9">
                                        <div class="row" id="fire_licence">
                                            @if ($employer->fire_licence != null)
                                                <div class="col-md-3 col-sm-4 col-xs-6">
                                                    <div class="img-upload-preview">
                                                        <img loading="lazy"  src="{{ url($employer->fire_licence) }}" alt="" class="img-responsive">
                                                        <input type="hidden" name="previous_fire_licence" value="{{ $employer->fire_licence }}">
                                                        <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label ml-3 col-3">@lang('website.Membership') <small class="text-danger">(BTMA/BGMEA/BKMEA/BGBA/BAPA /BTTLMEA/BGAPMEA/BEMEA/BGWIA/BHA/BKDOA/BTDPIA/BTMOA/Others)</small></label>
                                    <div class="ml-3 mr-3 col-9">
                                        <div class="row" id="membership_image">
                                            @if ($employer->membership_image != null)
                                                <div class="col-md-3 col-sm-4 col-xs-6">
                                                    <div class="img-upload-preview">
                                                        <img loading="lazy"  src="{{ url($employer->membership_image) }}" alt="" class="img-responsive">
                                                        <input type="hidden" name="previous_membership_image" value="{{ $employer->membership_image }}">
                                                        <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
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
            //get_district_by_division();
            $('.demo-select2').select2();

            $("#owner_nid_front").spartanMultiImagePicker({
                fieldName: 'owner_nid_front',
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

                onRemoveRow : function(index){
                    var index = index + 1;
                    $(`#abc_${index}`).remove()
                },
            });
            $("#owner_nid_back").spartanMultiImagePicker({
                fieldName: 'owner_nid_back',
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

                onRemoveRow : function(index){
                    var index = index + 1;
                    $(`#abc_${index}`).remove()
                },
            });

            $("#trade_licence").spartanMultiImagePicker({
                fieldName: 'trade_licence',
                maxCount: 1,
                rowHeight: '200px',
                groupClassName: 'col-md-3 col-sm-3 col-xs-6',
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
            $("#vat").spartanMultiImagePicker({
                fieldName: 'vat',
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

                onRemoveRow : function(index){
                    var index = index + 1;
                    $(`#abc_${index}`).remove()
                },
            });
            $("#factory_certificate").spartanMultiImagePicker({
                fieldName: 'factory_certificate',
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
            $("#fire_licence").spartanMultiImagePicker({
                fieldName: 'fire_licence',
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

                onRemoveRow : function(index){
                    var index = index + 1;
                    $(`#abc_${index}`).remove()
                },
            });
            $("#membership_image").spartanMultiImagePicker({
                fieldName: 'membership_image',
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
                onRemoveRow : function(index){
                    var index = index + 1;
                    $(`#abc_${index}`).remove()
                },
            });
        });
        $('.remove-files').on('click', function(){
            $(this).parents(".col-md-3").remove();
        });
    </script>
@endpush

