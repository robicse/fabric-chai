@extends('frontend.layouts.master')
@section('title', 'Seller Edit Profile')
@push('css')

@endpush
@section('content')

    <div class="full-row" style="background-color: #ffffff;">
        <div class="container">
            <div class="row">
                @include('frontend.seller.seller_breadcrumb')
                @include('frontend.seller.seller_sidebar')
                <div class="col-lg-9">
                    <h4>@lang('website.Edit Profile')</h4>
                    <form class="woocommerce-form-login" action="{{route('seller.profile-update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <p class="col-lg-6 col-md-6 col-12">
                                <label for="name">@lang('website.Name (English)') <span class="required">*</span></label>
                                <input type="text" class="form-control" name="name" value="{{Auth::User()->name}}" id="name"/>
                            </p>
                            <p class="col-lg-6 col-md-6 col-12">
                                <label for="name_bn">@lang('website.Name (Bangla)')<span class="required">*</span></label>
                                <input type="text" class="form-control" name="name_bn" value="{{Auth::User()->name_bn}}" id="name_bn"/>
                            </p>
                            <p class="col-lg-6 col-md-6 col-12">
                                <label for="company_name">@lang('website.Company Name (English)')<span class="required">*</span></label>
                                <input type="text" class="form-control" name="company_name" value="{{$seller->company_name}}" id="phone"/>
                            </p>
                            <p class="col-lg-6 col-md-6 col-12">
                                <label for="company_name_bn">@lang('website.Company Name (Bangla)')<span class="required">*</span></label>
                                <input type="text" class="form-control" name="company_name_bn" value="{{$seller->company_name_bn}}" id="phone"/>
                            </p>
                            <p class="col-lg-6 col-md-6 col-12">
                                <label for="company_address">@lang('website.Company Address (English)')<span class="required">*</span></label>
                                <input type="text" class="form-control" name="company_address" value="{{$seller->company_address}}" id="company_address"/>
                            </p>
                            <p class="col-lg-6 col-md-6 col-12">
                                <label for="company_address_bn">@lang('website.Company Address (Bangla)')<span class="required">*</span></label>
                                <input type="text" class="form-control" name="company_address_bn" value="{{$seller->company_address_bn}}" id="company_address_bn"/>
                            </p>
                            <p class="col-lg-6 col-md-6 col-12">
                                <label for="email"> @lang('website.Email Address')&nbsp; (@lang('website.Optional')) </label>
                                <input type="email" class="form-control" name="email" value="{{Auth::User()->email}}" id=""/>
                            </p>

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>@lang('website.Profile Image') </label>
                                    <input type="file"  name="avatar_original" class="form-control"  >
                                </div>
                            </div>
                            <div class="form-group col-7">
                                <label class="control-label ml-3">@lang('website.Trade Licence Image') <small class="text-danger">(jpg,jpeg,png file only)</small></label>
                                <div class="ml-3 mr-3">
                                    <div class="row" id="trade_licence" style="background-color: #fff;">
                                        @if ($seller->trade_licence != null)
                                            <div class="col-md-4 col-sm-4 col-xs-6">
                                                <div class="img-upload-preview">
                                                    <img loading="lazy"  src="{{ url($seller->trade_licence) }}" alt="" class="img-responsive">
                                                    <input type="hidden" name="previous_trade_licence" value="{{ $seller->trade_licence }}">
                                                    <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row" id="trade_licence_alt"></div>
                                </div>
                            </div>
                            <div class="form-group col-7" style="background-color: #fff;">
                                <label class="control-label ml-3">@lang('website.National ID Image') (@lang('website.Front')) <small class="text-danger">(jpg,jpeg,png file only)</small> </label>
                                <div class="ml-3 mr-3">
                                    <div class="row" id="nid_front">
                                        @if ($seller->nid_front != null)
                                            <div class="col-md-4 col-sm-4 col-xs-6">
                                                <div class="img-upload-preview">
                                                    <img loading="lazy"  src="{{ url($seller->nid_front) }}" alt="" class="img-responsive">
                                                    <input type="hidden" name="previous_nid" value="{{ $seller->nid_front }}">
                                                    <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row" id="nid_alt"></div>
                                </div>
                            </div>
                            <div class="form-group col-7" style="background-color: #fff;">
                                <label class="control-label ml-3">@lang('website.National ID Image') (@lang('website.Back'))<small class="text-danger">(jpg,jpeg,png file only)</small> </label>
                                <div class="ml-3 mr-3">
                                    <div class="row" id="nid_back">
                                        @if ($seller->nid_back != null)
                                            <div class="col-md-4 col-sm-4 col-xs-6">
                                                <div class="img-upload-preview">
                                                    <img loading="lazy"  src="{{ url($seller->nid_back) }}" alt="" class="img-responsive">
                                                    <input type="hidden" name="previous_nid" value="{{ $seller->nid_back }}">
                                                    <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row" id="nid_alt"></div>
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
    <script src="{{asset('backend/dist/js/spartan-multi-image-picker-min.js')}}"></script>
    <script>
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
            onAddRow:function(index){
                var altData = '<input type="text" placeholder="" name="trade_licence[]" class="form-control" required=""></div>'
                //var index = index + 1;
                //$('#photos_alt').append('<h4 id="abc_'+index+'">'+index+'</h4>')
                //$('#thumbnail_img_alt').append('<div class="col-md-4 col-sm-4 col-xs-6" id="abc_'+index+'">'+altData+'</div>')
            },
            onRemoveRow : function(index){
                var index = index + 1;
                $(`#abc_${index}`).remove()
            },
        });

        $('.remove-files').on('click', function(){
            $(this).parents(".col-md-4").remove();
        });
    </script>
@endpush

