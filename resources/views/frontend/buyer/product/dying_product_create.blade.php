@extends('frontend.layouts.master')
@section("title","Dyeing Product Entry")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/select2/select2.min.css')}}">F
    <link rel="stylesheet" href="{{asset('frontend/assets/css/product-page.css')}}">

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
        .required{
            color: red;
        }
    </style>
@endpush
@section('content')
    <!-- Main content -->
    <div class="full-row m_t_30">
        <div class="container">
            <div class="row">
                @include('frontend.buyer.buyer_breadcrumb')
                @include('frontend.buyer.buyer_sidebar')
                <div class="col-lg-9">
                    <form class="woocommerce-form-login" action="{{route('buyer.dying-product.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-5 col-md-5 col-5">
                                        <h3 class="card-title float-left">
                                            @lang('website.Dyeing Product Entry')
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
                                    <div class="col-md-12">
                                        <h4 class="pl-2 pb-0 mb-2 bg-info"><span style="margin-left: 10px !important;">@lang('website.Product Information') <span class="required">*</span></span></h4>
                                        <div class="row">
                                            <div class="form-group col-md-6" >
                                                <label for="name">@lang('website.Product Type') <span class="required">*</span></label>
                                                <select name="name" id="name" class="form-control demo-select2" required>
                                                    <option value="Dyeing">@lang('website.Dyeing')</option>
                                                    <option value="Printing">@lang('website.Printing')</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6" >
                                                <label for="product_of_fabric">@lang('website.Product Of Fabric') <span class="required">*</span></label>
                                                <select name="product_of_fabric" id="product_of_fabric" class="form-control demo-select2" required>
                                                    <option value="Solid Dyeing">@lang('website.Solid Dyeing')</option>
                                                    <option value="AOP">@lang('website.AOP')</option>
                                                    <option value="PFD">@lang('website.PFD')</option>
                                                    <option value="Others">@lang('website.Others')</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="dying_category_id">@lang('website.Types Of Fabrics')<span class="required">*</span></label>
                                                <select name="dying_category_id" id="dying_category_id" class="form-control demo-select2" required>
                                                    @foreach(\App\Model\DyingCategory::all() as $dyingCategory)
                                                        <option value="{{$dyingCategory->id}}">{{getNameByBnEn($dyingCategory)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="dying_category_id"></label>
                                                <select name="dying_sub_category_id" id="dying_sub_category_id" class="form-control demo-select2">

                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="quantity">@lang('website.Quantity of Fabric')<span class="required">*</span></label>
                                                <input type="number" class="form-control price_summation" name="quantity" id="quantity" min="1" value="" placeholder="@lang('website.Quantity must be greater than 0') " required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="unit_price">@lang('website.Unit Price')<span class="required">*</span></label>
                                                <input type="number" class="form-control" name="unit_price" id="unit_price" value="" placeholder="@lang('website.Enter Unit Price')" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="color">@lang('website.Colors of Fabric')<span class="required">*</span></label>
                                                <select name="color" id="color" class="form-control demo-select2" required>
                                                    @foreach(\App\Model\Color::all() as $color)
                                                        <option value="{{$color->name}}">{{$color->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="fabrics_construction">@lang('website.Fabrics Construction')<span class="required">*</span></label>
                                                <input type="text" class="form-control" name="fabrics_construction" id="fabrics_construction" placeholder="@lang('website.Enter Fabrics Construction')" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="fabrics_composition">@lang('website.Fabrics Composition')<span class="required">*</span></label>
                                                <input type="text" class="form-control" name="fabrics_composition" id="fabrics_composition" placeholder="@lang('website.Enter Fabrics Composition')">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="grey_unit">@lang('website.Unit')<span class="required">*</span></label>
                                                <select name="grey_unit" id="grey_unit" class="form-control demo-select2" required>
                                                    @foreach(\App\Model\Unit::all() as $unit)
                                                        <option value="{{$unit->name}}">{{getNameByBnEn($unit)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="grey_width">@lang('website.Grey Width')<span class="required">*</span></label>
                                                <input type="number" class="form-control" name="grey_width" id="grey_width" placeholder="@lang('website.Enter Grey Width')" required>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="finished_unit">@lang('website.Unit')<span class="required">*</span></label>
                                                <select name="finished_unit" id="finished_unit" class="form-control demo-select2" required>
                                                    @foreach(\App\Model\Unit::all() as $unit)
                                                        <option value="{{$unit->name}}">{{getNameByBnEn($unit)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="finished_width">@lang('website.Finished Width')<span class="required">*</span></label>
                                                <input type="number" class="form-control" name="finished_width" id="finished_width" placeholder="@lang('website.Enter Finished Width')" required>
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
                                                        <option value="{{$country_of_origin->country_name}}">{{getCountryNameByBnEn($country_of_origin)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-12" style="padding-top: 20px;">
                                                <!-- general form elements -->
                                                <h4 class="pl-2 pb-0 mb-2 bg-info"><span class="pt-3 pb-3" style="margin-left: 10px !important;">@lang('website.Test Parameter Form') <span class="required">*</span></span></h4>
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>Test Name</th>
                                                        <th>Method Name</th>
                                                        <th>Description</th>
                                                        <th>Req</th>
                                                        <th>Result</th>
                                                        <th>Remark</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach(\App\Model\TestParameter::where('status',1)->get() as $testParameter)
                                                        <input type="hidden" name="test_parameter_id[]" value="{{$testParameter->id}}">
                                                        <tr>
                                                            <td width="20%">{{$testParameter->name}}</td>
                                                            <td width="20%">
                                                                <select class="form-control demo-select2" name="test_method_id[]">
                                                                    @foreach(\App\Model\Method::all() as $method)
                                                                        <option value="{{$method->id}}">{{$method->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td width="20%">{{$testParameter->description}}</td>
                                                            <td>
                                                                <input type="text" name="test_req[]" class="form-control">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="test_result[]" class="form-control">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="test_remark[]" class="form-control">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                <table class="table table-bordered mt-2">
                                                    <tr>
                                                        <th rowspan="3" colspan="2">Color Fastness to</th>
                                                        @foreach(\App\Model\ColorFastness::all() as $colorFastness)
                                                            <th colspan="2">{{$colorFastness->name}}</th>
                                                        @endforeach
                                                        <th>Remark</th>
                                                    </tr>
                                                    <tr>
                                                        @foreach(\App\Model\ColorFastness::all() as $colorFastness)
                                                            <input type="hidden" name="color_fastness_id[]" value="{{$colorFastness->id}}">
                                                            <td colspan="2">
                                                                <select class="form-control demo-select2" name="fastness_method_id[]">
                                                                    @foreach(\App\Model\Method::all() as $method)
                                                                        <option value="{{$method->id}}">{{$method->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                        @endforeach
                                                        <td>
                                                            <input type="text" name="fastness_remark[]" class="form-control">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        @foreach(\App\Model\ColorFastness::all() as $colorFastness)
                                                            <td>Req</td>
                                                            <td>Result</td>
                                                        @endforeach
                                                        <td>
                                                            <input type="text" name="remark[]" class="form-control" readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">Shade Change</td>
                                                        @foreach(\App\Model\ColorFastness::all() as $colorFastness)
                                                            <td><input type="text" name="shade_req[]" class="form-control"></td>
                                                            <td><input type="text" name="shade_result[]" class="form-control"></td>
                                                        @endforeach
                                                        <td>
                                                            <input type="text" name="shade_remark[]" class="form-control">
                                                        </td>
                                                    </tr>

                                                    {{--                                                </table>--}}
                                                    {{--                                                <table class="table table-bordered mt-2">--}}
                                                    {{--                                                    <tr>--}}
                                                    {{--                                                        <td>Color Staining</td>--}}
                                                    {{--                                                        @foreach(\App\Model\ColorFastness::all() as $colorFastness)--}}
                                                    {{--                                                            <td>Req</td>--}}
                                                    {{--                                                            <td>Result</td>--}}
                                                    {{--                                                        @endforeach--}}
                                                    {{--                                                    </tr>--}}
                                                    @foreach(\App\Model\ColorStain::all() as $key=> $colorStain)
                                                        <input type="hidden" name="color_stain_id[]" value="{{$colorStain->id}}">
                                                        <tr>
                                                            <td>{{$key==2 ? 'Color Staining' :''}}</td>
                                                            <td>{{$colorStain->name}}</td>
                                                            @foreach(\App\Model\ColorFastness::all() as $colorFastness)
                                                                <input type="hidden" name="color_stain_id1[]" value="{{$colorStain->id}}">
                                                                <input type="hidden" name="color_fast_id1[]" value="{{$colorFastness->id}}">
                                                                <td><input type="text" name="staining_req[]" class="form-control"></td>
                                                                <td><input type="text" name="staining_result[]" class="form-control"></td>
                                                            @endforeach
                                                            <td><input type="text" name="staining_remark[]" class="form-control"></td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="2">Cross Staining</td>
                                                        @foreach(\App\Model\ColorFastness::all() as $colorFastness)
                                                            <td><input type="text" name="cross_req[]" class="form-control"></td>
                                                            <td><input type="text" name="cross_result[]"
                                                                       class="form-control"></td>
                                                        @endforeach
                                                        <td><input type="text" name="cross_remark[]" class="form-control"></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="padding-top: 20px;">
                                        <!-- general form elements -->
                                        <h4 class="pl-2 pb-0 mb-2 bg-info"><span style="margin-left: 10px !important;">@lang('website.Product Image') <span class="required">*</span></span></h4>
                                        <div class="form-group row">
                                            <label class="control-label ml-3 col-12">@lang('website.Gallery Images') <span class="required">*</span> <small class="text-danger">(Size: 290 * 300px)</small></label>
                                            <div class="ml-3 mr-3 col-10">
                                                <div class="row" id="photos"></div>
                                                <div class="row" id="photos_alt"></div>
                                            </div>
                                            <div class="col-2">
                                                <a href="https://tinypng.com/" target="_blank" class="btn btn-primary" style="padding: 0 15px;"><i class="fa fa-edit"></i></a> @lang('website.Resize')
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="padding-top: 20px;">
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
                                                    1. আমি {{Auth::user()->name}}, ভালোভাবে জেনে, বুঝে, দেখে উপরেল্লিখিত পণ্যের বিজ্ঞাপনের তথ্য ( সঠিক মাপ, পরিমান, গুণগত মান, দাম, মেয়াদ, পণ্যের অবস্থান সহ অন্যান্য সকল তথ্য ) সঠিক ও নির্ভুল প্রদান করেছি এবং ভুল তথ্য ও ভুল পণ্যের জন্য আমিই দায়ী থাকিবো।
                                                </p>
                                                <p>
                                                    2. আমার প্রদেয় পণ্যের বিজ্ঞাপন, কোম্পানী ও ব্যাক্তিগত দেওয়া সমস্ত তথ্য ফেব্রিক লাগবে কর্তৃপক্ষ বিজ্ঞাপনের পণ্যের বিক্রির সুবিধার্থে কিংবা সরকারী সংস্থার প্রয়োজনে যাচাই, বাছাই, সংশোধনের এখতিয়ার রাখে এবং আমার এতে কোন দ্বি-মত থাকিবে না।
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
    <script src="{{asset('backend/plugins/select2/select2.full.min.js')}}"></script>
    <script src="//cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
    <script src="{{asset('backend/plugins/ckeditor/ckeditor.js')}}"></script>

    <script>
        CKEDITOR.replace( 'description');
        $(document).ready(function () {
            $('.demo-select2').select2();
            get_dying_subcategories();

            $('#dying_category_id').on('change', function () {
                get_dying_subcategories();
            })
            function get_dying_subcategories() {
                var dying_category_id = $('#dying_category_id').val();
                $.post('{{ route('products.get_dying_subcategories') }}', {
                    _token: '{{ csrf_token() }}',
                    dying_category_id: dying_category_id
                }, function (data) {
                    $('#dying_sub_category_id').html(null);
                    if(data.length > 0){
                        for (var i = 0; i < data.length; i++) {
                            $('#dying_sub_category_id').append($('<option>', {
                                value: data[i].id,
                                text: data[i].name
                            }));
                        }
                        $('.demo-select2').select2();
                    }else{
                        $("#category_two").hide()
                    }
                });
            }
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
        })


    </script>
@endpush
