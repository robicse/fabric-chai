@extends('frontend.layouts.master')
@section("title","Sizing Product Entry")
@push('css')
    {{--    <link rel="stylesheet" href="{{asset('backend/plugins/select2/select2.min.css')}}">--}}
    <style>
        .required{
            color: red;
        }
    </style>

@endpush
@section('content')
    <!-- Main content -->
    <div class="full-row" style="margin-top: -30px;">
        <div class="container">
            <div class="row">
                @include('frontend.buyer.buyer_breadcrumb')
                @include('frontend.buyer.buyer_sidebar')
                <div class="col-lg-9">
                    <form class="woocommerce-form-login" action="{{route('buyer.sizing-product.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-5 col-md-5 col-5">
                                        <h3 class="card-title float-left">
                                            @lang('website.Sizing Product Entry')
                                        </h3>
                                    </div>
                                    <div style="float: left;width: 15%;">
                                        <input type="radio" name="payment_with" value="BDT" id="bdt" class="CurrencyChange" onchange="currency_changed(this)" @if(currency()->code == 'BDT') checked @endif>
                                        <label for="bdt">@lang('website.BDT')</label>
                                    </div>

                                    <div style="float: right;width: 15%;">
                                        <input type="radio" name="payment_with" value="USD" id="usd" class="CurrencyChange" onchange="currency_changed(this)" @if(currency()->code == 'USD') checked @endif>
                                        <label for="usd">@lang('website.USD')</label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row m-2">
                                    <div class="col-md-10">
                                        <h4 class="pl-2 pb-0 mb-2 bg-info"><span style="margin-left: 10px !important;">@lang('website.Product Information') <span class="required">*</span></span></h4>
                                        <div class="row">
                                            <div class="form-group col-md-6" >
                                                <label for="name">@lang('website.Product Type') <span class="required">*</span></label>
                                                <input type="text" class="form-control " name="name" id="name" placeholder="@lang('website.Enter Product Type')"  required>
                                                <input type="hidden" id="slug" name="slug" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6" >
                                                <label for="total_length">@lang('website.Total Lengths') <span class="required">*</span></label>
                                                <input type="number" class="form-control " name="total_length" id="total_length" placeholder="@lang('website.Enter Total Length')" required>
                                            </div>
                                            <div class="form-group col-md-6" >
                                                <label for="yarn_count">@lang('website.Yarn Count') <span class="required">*</span></label>
                                                <input type="number" class="form-control" name="yarn_count" id="yarn_count" placeholder="@lang('website.Enter Yarn Count')" required>
                                            </div>
                                            <div class="form-group col-md-6" >
                                                <label for="yarn_csp">@lang('website.Yarn CSP') <span class="required">*</span></label>
                                                <input type="text" class="form-control" name="yarn_csp" id="yarn_csp" placeholder="@lang('website.Enter Yarn CSP')" required>
                                            </div>
                                            <div class="form-group col-md-6" >
                                                <label for="ipi">@lang('website.IPI') <span class="required">*</span></label>
                                                <input type="text" class="form-control" name="ipi" id="ipi" placeholder="@lang('website.Enter IPI')" required>
                                            </div>
                                            <div class="form-group col-md-6" >
                                                <label for="lengths_of">@lang('website.Lengths Of') <span class="required">*</span></label>
                                                <input type="text" class="form-control" name="lengths_of" id="lengths_of" placeholder="@lang('website.Enter Lengths Of')" required>
                                            </div>
                                            <div class="form-group col-md-6" >
                                                <label for="price">@lang('website.Price per Meter/Yards')  <span class="required">*</span></label>
                                                <input type="number" class="form-control" name="price" id="price" placeholder="@lang('website.Enter Price per Meter/Yards')"  required>
                                            </div>
                                            <div class="form-group col-md-6" >
                                                <label for="warping_lengths">@lang('website.Warping Lengths Meter/Yards')  <span class="required">*</span></label>
                                                <input type="text" class="form-control" name="warping_lengths" id="warping_lengths" placeholder="@lang('website.Enter Warping Lengths')" required>
                                            </div>
                                            <div class="form-group col-md-6" >
                                                <label for="sizing_lengths">@lang('website.Sizing Lengths Meter/Yards')  <span class="required">*</span></label>
                                                <input type="text" class="form-control" name="sizing_lengths" id="sizing_lengths" placeholder="@lang('website.Enter Sizing Lengths')" required>
                                            </div>
                                            <div class="form-group col-md-6" >
                                                <label for="wastage_percentage">@lang('website.Wastage Percentage') <span class="required">*</span></label>
                                                <input type="text" class="form-control" name="wastage_percentage" id="wastage_percentage" placeholder="@lang('website.Enter Wastage Percentage')"  required>
                                            </div>
                                            <div class="form-group col-md-6" >
                                                <label for="gera">@lang('website.Gera') <span class="required">*</span></label>
                                                <input type="text" class="form-control" name="gera" id="gera" placeholder="@lang('website.Enter Gera')" required>
                                            </div>
                                            <div class="form-group col-md-6" >
                                                <label for="sizing_time">@lang('website.Sizing Time') <span class="required">*</span></label>
                                                <input type="text" class="form-control" name="sizing_time" id="sizing_time" placeholder="@lang('website.Enter Sizing Time')"  required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="price_validity">@lang('website.Price Validate Till')</label>
                                                <input type="date" class="form-control" name="price_validity" id="price_validity"  style="background-color: #f3f3f3">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="made_in">@lang('website.Made In')</label>
                                                <select name="made_in" id="made_in" class="form-control demo-select2" required>
                                                    <option >@lang('website.Select')</option>
                                                    @foreach(\App\Model\Countries::all() as $country_of_origin)
                                                        <option value="{{$country_of_origin->country_name}}">{{$country_of_origin->country_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-10" style="padding-top: 20px;">
                                        <!-- general form elements -->
                                        <h4 class="pl-2 pb-0 mb-2 bg-info"><span style="margin-left: 10px !important;">@lang('website.Product Image') <span class="required">*</span></span></h4>
                                        <div class="form-group row">
                                            <label class="control-label ml-3 col-12">@lang('website.Gallery Images') <span class="required">*</span> <small class="text-danger">(Size: 290 * 300px)</small></label>
                                            <div class="ml-3 mr-3 col-md-9">
                                                <div class="row" id="photos"></div>
                                                <div class="row" id="photos_alt"></div>
                                            </div>
                                            <div class="col-md-3">
                                                <a href="https://tinypng.com/" target="_blank" class="btn btn-primary" style="padding: 0 15px;"><i class="fa fa-edit"></i></a> @lang('website.Resize')
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-10" style="padding-top: 20px;">
                                        <!-- general form elements -->

                                        <h4 class="pl-2 pb-0 mb-2 bg-info"><span style="margin-left: 10px !important;">@lang('website.Product Price Details') <span class="required">*</span></span></h4>
                                        <div class="form-group">
                                            <label for="description">@lang('website.Product Description') <span class="required">*</span></label>
                                            <textarea name="description" id="description"  class="form-control" style="background-color: #f3f3f3"></textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="woocommerce-form-login__submit btn btn-primary rounded-0" data-bs-toggle="modal" data-bs-target="#staticBackdrop2">Submit</button>
                        <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog ">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-center" id="staticBackdropLabel">@lang('website.Are you sure?')</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div >
                                            <div style="font-size: 16px">
                                                <p>
                                                    1. আমি {{Auth::user()->name}}, ভালোভাবে জেনে, বুঝে, দেখে উপরেল্লিখিত পণ্যের বিজ্ঞাপনের তথ্য  ( সঠিক মাপ, পরিমান, গুণগত মান, দাম, মেয়াদ, পণ্যের অবস্থান সহ অন্যান্য সকল তথ্য ) সঠিক ও নির্ভুল প্রদান করেছি এবং ভুল তথ্য ও ভুল পণ্যের জন্য আমিই দায়ী থাকিবো।
                                                </p>
                                                <p>
                                                    2. আমার প্রদেয় পণ্যের বিজ্ঞাপন, কোম্পানী ও ব্যাক্তিগত দেওয়া সমস্ত তথ্য ফেব্রিক লাগবে কর্তৃপক্ষ বিজ্ঞাপনের পণ্যের বিক্রির সুবিধার্থে কিংবা সরকারী সংস্থার প্রয়োজনে যাচাই, বাছাই, সংশোধনের এখতিয়ার রাখে এবং আমার এতে কোন দ্বি-মত থাকিবে না।
                                                </p>
                                                <p>
                                                    3. আমার প্রদেয় পণ্যের অনুরোধের বিপরীতে যে কোন সরবরাহকারী বিড করতে পারবে এবং আমি বিজ্ঞাপনদাতা বিড একসেপ্ট করার অর্থ হলো আমি নিশ্চয়তা প্রদান করছি বিডার পণ্যের অর্ডার পাবেন।
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">@lang('website.Close')</button>
                                        <button type="submit" class="btn btn-success">@lang('website.Submit')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop
@push('js')
    <script src="{{asset('backend/dist/js/spartan-multi-image-picker-min.js')}}"></script>
    {{--    <script src="{{asset('backend/plugins/select2/select2.full.min.js')}}"></script>--}}
    <script src="//cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
    <script src="{{asset('backend/plugins/ckeditor/ckeditor.js')}}"></script>

    <script>
        CKEDITOR.replace( 'description');

        $("#photos").spartanMultiImagePicker({
            fieldName: 'photos[]',
            maxCount: 10,
            rowHeight: '200px',
            groupClassName: 'col-md-4 col-sm-4 col-xs-6',
            maxFileSize: '150000',
            dropFileLabel: "Drop Here",
            onExtensionErr: function (index, file) {
                console.log(index, file, 'extension err');
                alert('Please only input png or jpg type file')
            },
            onSizeErr: function (index, file) {
                console.log(index, file, 'file size too big');
                alert('Image size too big. Please upload below 150kb');
            },
            onAddRow:function(index){
                var altData = '<input type="text" placeholder="Image Alt" name="photos_alt[]" class="form-control" required=""></div>'
                //var index = index + 1;
                //$('#photos_alt').append('<h4 id="abc_'+index+'">'+index+'</h4>')
                //$('#photos_alt').append('<div class="col-md-4 col-sm-4 col-xs-6" id="abc_'+index+'">'+altData+'</div>')
            },
            onRemoveRow : function(index){
                var index = index + 1;
                $(`#abc_${index}`).remove()
            },
        });
    </script>
@endpush
