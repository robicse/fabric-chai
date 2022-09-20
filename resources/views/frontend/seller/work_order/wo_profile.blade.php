@extends('frontend.layouts.master')
@section('title', 'Company & Factory Profile')
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
        form label {
            color: #212529;
        }
        a, a:hover {
            color: #212529;
        }
    </style>
@endpush
@section('content')
    <div class="full-row" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-3 mobile_view">
                    <h3 class="mb-2 text-secondary">@lang('website.Manufacturer Work Order')</h3>
                </div>
                @include('frontend.seller.work_order_sidebar')
                <div class="col-lg-9 col-sm-9" style="background: #fff; padding: 10px;">
                    <h3 class="text-center">@lang('website.Company & Factory Profile')</h3>
                    <form class="woocommerce-form-login" action="{{route('seller.work-order-profile.update')}}" method="POST" enctype="multipart/form-data" style="margin-left: 20px;">
                        @csrf
                        <div class="row">
                            @php
                                $seller = \App\Model\Seller::where('user_id',Auth::id())->first();
                                $employer = \App\Model\Employer::where('user_id',Auth::id())->first();
                                $factory = \App\Model\WorkorderFactory::where('user_id',Auth::id())->first();
                            @endphp
                            <h4>@lang('website.Company Information')</h4><hr>
                            <p class="col-md-6">
                                <label for="company_name">@lang('website.Company Name')&nbsp;<span class="required">*</span></label>
                                <input type="text" class="form-control" name="company_name" id="company_name" value="{{$seller->company_name}}" required/>
                            </p>
{{--                            <p class="col-md-6">--}}
{{--                                <label for="company_name_bn">@lang('website.Company Name (Bangla)')</label>--}}
{{--                                <input type="text" class="form-control" name="company_name_bn" id="company_name" value="{{$seller->company_name_bn}}" />--}}
{{--                            </p>--}}
                            <p class="col-md-6">
                                <label for="company_address">@lang('website.Company Address')</label>
                                <input type="text" class="form-control" name="company_address" id="company_address" value="{{$seller->company_address}}" required/>
                            </p>
{{--                            <p class="col-md-6">--}}
{{--                                <label for="company_address_bn">@lang('website.Company Address (Bangla)')</label>--}}
{{--                                <input type="text" class="form-control" name="company_address_bn" id="company_address_bn" value="{{$seller->company_address_bn}}" required/>--}}
{{--                            </p>--}}
                            <p class="col-md-6">
                                <label for="company_owner_name">@lang('website.Company Owners Name')&nbsp;<span class="required">*</span></label>
                                <input type="text" class="form-control" name="company_owner_name" id="company_owner_name" value="{{$seller->company_owner_name}}" required/>
                            </p>

                            <p class="col-md-6">
                                <label for="company_phone">@lang('website.Company phone Number')&nbsp;<span class="required">*</span></label>
                                <input type="number" class="form-control" name="company_phone" id="company_phone" value="{{$seller->company_phone}}" required/>
                            </p>
                            <p class="col-md-6">
                                <label for="company_email">@lang('website.Company Email')&nbsp;<span class="required">*</span></label>
                                <input type="email" class="form-control" name="company_email" id="company_email" value="{{$seller->company_email}}" />
                            </p>

                            <p class="col-md-6">
                                <label for="company_no_of_employee">@lang('website.Number of Employees')&nbsp;<span class="required">*</span></label>
                                <select name="company_no_of_employee" id="company_no_of_employee" class="form-control demo-select2" required>
                                    <option disabled selected>@lang('website.Select')</option>
                                    <option value="0-10" {{$seller->company_no_of_employee  == '0-10' ? 'selected' : ''}}>@lang('website.0-10')</option>
                                    <option value="10-50" {{$seller->company_no_of_employee  == '10-50'? 'selected' : ''}}>@lang('website.10-50')</option>
                                    <option value="50-100" {{$seller->company_no_of_employee  == '50-100' ? 'selected' : ''}}>@lang('website.50-100')</option>
                                    <option value="100-200" {{$seller->company_no_of_employee  == '100-200' ? 'selected' : ''}}>@lang('website.100-200')</option>
                                    <option value="200-500" {{$seller->company_no_of_employee  == '200-500' ? 'selected' : ''}}>@lang('website.200-500')</option>
                                    <option value="500-1,000" {{$seller->company_no_of_employee  == '500-1,000' ? 'selected' : ''}}>@lang('website.500-1,000')</option>
                                    <option value="1,000-2,000" {{$seller->company_no_of_employee  == '1,000-2,000' ? 'selected' : ''}}>@lang('website.1,000-2,000')</option>
                                    <option value="2,000-5,000" {{$seller->company_no_of_employee  == '2,000-5,000' ? 'selected' : ''}}>@lang('website.2,000-5,000')</option>
                                    <option value="5,000-10,000" {{$seller->company_no_of_employee  == '5,000-10,000' ? 'selected' : ''}}>@lang('website.5,000-10,000')</option>
                                    <option value="10,000+" {{$seller->company_no_of_employee  == '10,000+' ? 'selected' : ''}}>@lang('website.10,000+')</option>
                                </select>
                            </p>
                            <p class="col-md-6">
                                <label for="membership_package">@lang('website.Membership Package')</label>
                                <input type="text" class="form-control" name="membership_package" id="membership_package" value="{{$seller->user->membershipPackage->package_name}}" readonly/>
                            </p>

                            <h4>@lang('website.Factory Profile')</h4><hr>

                            <p class="col-md-6">
                                <label for="mill_representative_name_1">@lang('website.Mill Representative Name 1')&nbsp;<span class="required">*</span></label>
                                <input type="text" class="form-control" name="mill_representative_name_1" id="mill_representative_name_1" value="{{$factory->mill_representative_name_1}}" required/>
                            </p>
                            <p class="col-md-6">
                                <label for="mill_representative_name_2">@lang('website.Mill Representative Name 2')&nbsp;</label>
                                <input type="text" class="form-control" name="mill_representative_name_2" id="mill_representative_name_2" value="{{$factory->mill_representative_name_2}}" />
                            </p>
                            <p class="col-md-6">
                                <label for="mill_representative_phone_1">@lang('website.Mill Representative Phone 1')&nbsp;<span class="required">*</span></label>
                                <input type="text" class="form-control" name="mill_representative_phone_1" id="mill_representative_phone_1" value="{{$factory->mill_representative_phone_1}}" required/>
                            </p>
                            <p class="col-md-6">
                                <label for="mill_representative_phone_2">@lang('website.Mill Representative Phone 2')</label>
                                <input type="text" class="form-control" name="mill_representative_phone_2" id="mill_representative_phone_2" value="{{$factory->mill_representative_phone_2}}" />
                            </p>
                            <p class="col-md-6">
                                <label for="ownership_of_the_factory">@lang('website.Ownership Of The Factory')<span class="required">*</span></label>
                                <select name="ownership_of_the_factory" id="ownership_of_the_factory" class="form-control demo-select2" required>
                                    <option disabled selected>@lang('website.Select')</option>
                                    <option value="Own" {{$factory->ownership_of_the_factory == 'Own' ? 'selected' : ''}}>@lang('website.Own')</option>
                                    <option value="Rent" {{$factory->ownership_of_the_factory == 'Rent' ? 'selected' : ''}}>@lang('website.Rent')</option>
                                    <option value="Lease" {{$factory->ownership_of_the_factory == 'Lease' ? 'selected' : ''}}>@lang('website.Lease')</option>
                                    <option value="Others" {{$factory->ownership_of_the_factory == 'Others' ? 'selected' : ''}}>@lang('website.Others')</option>
                                </select>
                            </p>
                            <p class="col-md-6">
                                <label for="mill_production_strength">@lang('website.Mill Production Strength')<span class="required">*</span></label>
                                <select name="mill_production_strength" id="mill_production_strength" class="form-control demo-select2" required>
                                    <option disabled selected>@lang('website.Select')</option>
                                    <option value="Composite" {{$factory->mill_production_strength == 'Composite' ? 'selected' : ''}}>@lang('website.Composite')</option>
                                    <option value="Semi Composite" {{$factory->mill_production_strength == 'Semi Composite' ? 'selected' : ''}}>@lang('website.Semi Composite')</option>
                                    <option value="Partial" {{$factory->mill_production_strength == 'Partial' ? 'selected' : ''}}>@lang('website.Partial')</option>
                                </select>
                            </p>
                            @php
                                $membershipArray = explode(',', $factory->membership);
                                $certificateArray = explode(',', $factory->certificate);
                            @endphp
                            <p class="col-md-6">
                                <label for="membership">@lang('website.Membership')<span class="required">*</span></label>
                                <select name="membership[]" id="membership" class="form-control demo-select2" multiple required>
                                    <option disabled selected>@lang('website.Select')</option>
                                    <option value="BGBA" {{in_array("BGBA", $membershipArray) ? 'selected' : ''}}>BGBA</option>
                                    <option value="BTTLMEA" {{in_array("BTTLMEA", $membershipArray) ? 'selected' : ''}}>BTTLMEA</option>
                                    <option value="BGAPMFA" {{in_array("BGAPMFA", $membershipArray) ? 'selected' : ''}}>BGAPMFA</option>
                                    <option value="BGMEA" {{in_array("BGMEA", $membershipArray) ? 'selected' : ''}}>BGMEA</option>
                                    <option value="BGWIA" {{in_array("BGWIA", $membershipArray) ? 'selected' : ''}}>BGWIA</option>
                                    <option value="BHA" {{in_array("BHA", $membershipArray) ? 'selected' : ''}}>BHA</option>
                                    <option value="BKDOA" {{in_array("BKDOA", $membershipArray) ? 'selected' : ''}}>BKDOA</option>
                                    <option value="BTDPIO" {{in_array("BTDPIO", $membershipArray) ? 'selected' : ''}}>BTDPIO</option>
                                    <option value="BTMOA" {{in_array("BTMOA", $membershipArray) ? 'selected' : ''}}>BTMOA</option>
                                </select>
                            </p>
                            <p class="col-md-6">
                                <label for="bank_name_and_address">@lang('website.Bank Name And Address')&nbsp;<span class="required">*</span></label>
                                <input type="text" class="form-control" name="bank_name_and_address" id="bank_name_and_address" value="{{$factory->bank_name_and_address}}" required/>
                            </p>
                            <p class="col-md-6">
                                <label for="certificate">@lang('website.Certificate')<span class="required">*</span></label>
                                <select name="certificate[]" id="certificate" class="form-control demo-select2" multiple required>
                                    <option disabled selected>@lang('website.Select')</option>
                                    <option value="ISO" {{in_array("ISO", $certificateArray) ? 'selected' : ''}}>ISO</option>
                                    <option value="OEKO-Tex" {{in_array("OEKO-Tex", $certificateArray) ? 'selected' : ''}}>OEKO-Tex</option>
                                    <option value="High Index" {{in_array("High Index", $certificateArray) ? 'selected' : ''}}>High Index</option>
                                    <option value="ZDHC" {{in_array("ZDHC", $certificateArray) ? 'selected' : ''}}>ZDHC</option>
                                    <option value="LEED" {{in_array("LEED", $certificateArray) ? 'selected' : ''}}>LEED</option>
                                    <option value="Organic cotton" {{in_array("Organic cotton", $certificateArray) ? 'selected' : ''}}>Organic cotton</option>
                                    <option value="GOTS" {{in_array("GOTS", $certificateArray) ? 'selected' : ''}}>GOTS</option>
                                    <option value="BSCI" {{in_array("BSCI", $certificateArray) ? 'selected' : ''}}>BSCI</option>
                                    <option value="P.R" {{in_array("P.R", $certificateArray) ? 'selected' : ''}}>P.R</option>
                                    <option value="Others" {{in_array("Others", $certificateArray) ? 'selected' : ''}}>Others</option>
                                </select>
                            </p>
                            <p class="col-md-6">
                                <label for="source_of_gas_and_electricity">@lang('website.Source Of Gas And Electricity')<span class="required">*</span></label>
                                <select name="source_of_gas_and_electricity" id="source_of_gas_and_electricity" class="form-control demo-select2" required>
                                    <option disabled selected>@lang('website.Select')</option>
                                    <option value="Stand By Generator" {{$factory->source_of_gas_and_electricity == 'Stand By Generator' ? 'selected' : ''}}>@lang('website.Stand By Generator')</option>
                                    <option value="Govt.Line" {{$factory->source_of_gas_and_electricity == 'Govt.Line' ? 'selected' : ''}}>@lang('website.Govt.Line')</option>
                                </select>
                            </p>
                            <p class="col-md-6">
                                <label for="total_no_of_worker">@lang('website.Total No Of Workers')<span class="required">*</span></label>
                                <select name="total_no_of_worker" id="total_no_of_worker" class="form-control demo-select2" required>
                                    <option disabled selected>@lang('website.Select')</option>
                                    <option value="0-10" {{$factory->total_no_of_worker == '0-10' ? 'selected' : ''}}>@lang('website.0-10')</option>
                                    <option value="10-50" {{$factory->total_no_of_worker == '10-50' ? 'selected' : ''}}>@lang('website.10-50')</option>
                                    <option value="50-100" {{$factory->total_no_of_worker == '50-100' ? 'selected' :  ''}}>@lang('website.50-100')</option>
                                    <option value="100-200" {{$factory->total_no_of_worker == '100-200' ? 'selected' : ''}}>@lang('website.100-200')</option>
                                    <option value="200-500" {{$factory->total_no_of_worker == '200-500' ? 'selected' : ''}}>@lang('website.200-500')</option>
                                    <option value="500-1,000" {{$factory->total_no_of_worker == '500-1,000' ? 'selected' : ''}}>@lang('website.500-1,000')</option>
                                    <option value="1,000-2,000" {{$factory->total_no_of_worker == '1,000-2,000' ? 'selected' : ''}}>@lang('website.1,000-2,000')</option>
                                    <option value="2,000-5,000" {{$factory->total_no_of_worker == '2,000-5,000' ? 'selected' : ''}}>@lang('website.2,000-5,000')</option>
                                    <option value="5,000-10,000" {{$factory->total_no_of_worker == '5,000-10,000' ? 'selected' : ''}}>@lang('website.5,000-10,000')</option>
                                    <option value="10,000+" {{$factory->total_no_of_worker == '10,000+' ? 'selected' : ''}}>@lang('website.10,000+')</option>
                                </select>
                            </p>
                            <p class="col-md-6">
                                <label for="location_of_the_mill">@lang('website.Location Of The Mill')<span class="required">*</span></label>
                                <input type="text" class="form-control" name="location_of_the_mill" id="location_of_the_mill" value="{{$factory->location_of_the_mill}}" required/>
                            </p>
                            <p class="col-md-6">
                                <label for="trade_license_authority">@lang('website.Trade License Authority')<span class="required">*</span></label>
                                <select name="trade_license_authority" id="trade_license_authority" class="form-control demo-select2" required>
                                    <option disabled selected>@lang('website.Select')</option>
                                    <option value="Union Parishod" {{$factory->trade_license_authority == 'Union Parishod' ? 'selected' : ''}}>@lang('website.Union Parishod')</option>
                                    <option value="City Corporation" {{$factory->trade_license_authority == 'City Corporation' ? 'selected' : ''}}>@lang('website.City Corporation')</option>
                                    <option value="Pouroshova" {{$factory->trade_license_authority == 'Pouroshova' ? 'selected' : ''}}>@lang('website.Pouroshova')</option>
                                    <option value="Others" {{$factory->trade_license_authority == 'Others' ? 'selected' : ''}}>@lang('website.Others')</option>
                                </select>
                            </p>
                            <p class="col-md-6">
                                <label for="country_of_origin">@lang('website.Country Of Origin')<span class="required">*</span></label>
                                <select name="country_of_origin" id="country_of_origin" class="form-control demo-select2" required>
                                    <option disabled selected>@lang('website.Select')</option>
                                    @foreach($countries as $country_of_origin)
                                        <option value="{{$country_of_origin->country_name}}" {{$factory->country_of_origin == $country_of_origin->country_name ? 'selected' : ''}}>{{$country_of_origin->country_name}}</option>
                                    @endforeach
                                </select>
                            </p>

                            <h4>@lang('website.Please Upload Required Documents')<small class="text-danger">*</small></h4><hr>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label class="control-label">@lang('website.Factory Image') </label>
                                    <input type="file" class="form-control" name="factory_image" required/>
                                </div>
                                @if($factory->factory_image)
                                    <div class="col-6" style="margin-top: 38px">
                                        <a href="{{url($factory->factory_image)}}" target="_blank"> @lang('website.Previous file'): <i class="fa fa-file text-success"></i></a>
                                    </div>
                                @endif
                            </div>
                            <div class="row mt-3">
                                <div class="form-group col-6">
                                    <label class="control-label">@lang('website.VAT/Local Govt Applicable Certificate') </label>
                                    <input type="file" class="form-control" name="vat_certificate" required/>
                                </div>
                                @if($factory->vat_certificate)
                                    <div class="col-6" style="margin-top: 38px">
                                        <a href="{{url($factory->vat_certificate)}}" target="_blank"> @lang('website.Previous file'): <i class="fa fa-file text-success"></i></a>
                                    </div>
                                @endif
                            </div>
                            <div class="row mt-3">
                                <div class="form-group col-6">
                                    <label class="control-label">@lang('website.TIN/Local Govt Applicable Certificate') </label>
                                    <input type="file" class="form-control" name="tin_certificate" required/>
                                </div>
                                @if($factory->tin_certificate)
                                    <div class="col-6" style="margin-top: 38px">
                                        <a href="{{url($factory->tin_certificate)}}" target="_blank"> @lang('website.Previous file'): <i class="fa fa-file text-success"></i></a>
                                    </div>
                                @endif
                            </div>

                            <div class="row mt-3">
                                <div class="form-group col-6">
                                    <label class="control-label">@lang('website.Environment Certificate') </label>
                                    <input type="file" class="form-control" name="environment_certificate" required/>
                                </div>
                                @if($factory->environment_certificate)
                                    <div class="col-6" style="margin-top: 38px">
                                        <a href="{{url($factory->environment_certificate)}}" target="_blank"> @lang('website.Previous file'): <i class="fa fa-file text-success"></i></a>
                                    </div>
                                @endif
                            </div>
                            <div class="row mt-3 mb-3">
                                <div class="form-group col-6">
                                    <label class="control-label">@lang('website.Industrial Certificate') </label>
                                    <input type="file" class="form-control" name="industrial_certificate" required/>
                                </div>
                                @if($factory->industrial_certificate)
                                    <div class="col-6" style="margin-top: 38px">
                                        <a href="{{url($factory->industrial_certificate)}}" target="_blank">@lang('website.Previous file'): <i class="fa fa-file text-success"></i></a>
                                    </div>
                                @endif
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


            $("#vat_certificate").spartanMultiImagePicker({
                fieldName: 'vat_certificate',
                maxCount: 1,
                rowHeight: '200px',
                groupClassName: 'col-md-3 col-sm-4 col-xs-6',
                maxFileSize: '1000000',
                dropFileLabel: "Drop Here",
                allowedExt: 'webp|jpeg|png|pdf',
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

            $("#tin_certificate").spartanMultiImagePicker({
                fieldName: 'tin_certificate',
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

            $("#environment_certificate").spartanMultiImagePicker({
                fieldName: 'environment_certificate',
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

            $("#industrial_certificate").spartanMultiImagePicker({
                fieldName: 'industrial_certificate',
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

            $("#factory_image").spartanMultiImagePicker({
                fieldName: 'factory_image',
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

