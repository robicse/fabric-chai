@extends('frontend.layouts.master')
@section("title","Dyeing Product Edit")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/select2/select2.min.css')}}">
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
    <div class="full-row m_t_30" >
        <div class="container">
            <div class="row">
                @include('frontend.buyer.buyer_breadcrumb')
                @include('frontend.buyer.buyer_sidebar')
                <div class="col-lg-9">
                    <form class="woocommerce-form-login" action="{{route('buyer.dying-product.update',$product->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-5 col-md-5 col-5">
                                        <h3 class="card-title float-left">
                                            @lang('website.Dyeing Product Edit')
                                        </h3>
                                    </div>
                                    <div style="float: left;width: 15%;">
                                        <input type="hidden" name="lang" id="lang" value="{{app()->getLocale('locale')}}">
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
                                                    <option value="Dyeing" {{$product->name == 'Dyeing' ? 'selected':''}}>@lang('website.Dyeing')</option>
                                                    <option value="Printing" {{$product->name == 'Printing' ? 'selected':''}}>@lang('website.Printing')</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6" >
                                                <label for="product_of_fabric">@lang('website.Product Of Fabric') <span class="required">*</span></label>
                                                <select name="product_of_fabric" id="product_of_fabric" class="form-control demo-select2" required>
                                                    <option value="Solid Dyeing" {{$dyingProduct->product_of_fabric == 'Solid Dyeing' ? 'selected':''}}>@lang('website.Solid Dyeing')</option>
                                                    <option value="AOP" {{$dyingProduct->product_of_fabric == 'AOP' ? 'selected':''}}>@lang('website.AOP')</option>
                                                    <option value="PFD" {{$dyingProduct->product_of_fabric == 'PFD"' ? 'selected':''}}>@lang('website.PFD')</option>
                                                    <option value="Others" {{$dyingProduct->product_of_fabric == 'Others' ? 'selected':''}}>@lang('website.Others')</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="dying_category_id">@lang('website.Types Of Fabrics')<span class="required">*</span></label>
                                                <select name="dying_category_id" id="dying_category_id" class="form-control demo-select2" required>
                                                    @foreach(\App\Model\DyingCategory::all() as $dyingCategory)
                                                        <option value="{{$dyingCategory->id}}" {{$dyingProduct->dying_category_id == $dyingCategory->id ? 'selected':''}}>{{getNameByBnEn($dyingCategory)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="dying_sub_category_id"></label>
                                                <select name="dying_sub_category_id" id="dying_sub_category_id" class="form-control demo-select2">

                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="quantity">@lang('website.Quantity of Fabric')<span class="required">*</span></label>
                                                <input type="number" class="form-control price_summation" name="quantity" id="quantity" min="1" value="{{$product->quantity}}" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="unit_price">@lang('website.Unit Price')<span class="required">*</span></label>
                                                <input type="number" class="form-control" name="unit_price" id="unit_price" value="{{$product->unit_price}}" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="color">@lang('website.Colors of Fabric')<span class="required">*</span></label>
                                                <select name="color" id="color" class="form-control demo-select2" required>
                                                    @foreach(\App\Model\Color::all() as $color)
                                                        <option value="{{$color->name}}" {{$dyingProduct->color == $color->name ? 'selected':''}}>{{$color->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="fabrics_construction">@lang('website.Fabrics Construction')<span class="required">*</span></label>
                                                <input type="text" class="form-control" name="fabrics_construction" value="{{$dyingProduct->fabrics_construction}}" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="fabrics_composition">@lang('website.Fabrics Composition')<span class="required">*</span></label>
                                                <input type="text" class="form-control" name="fabrics_composition" value="{{$dyingProduct->fabrics_composition}}" required>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="grey_unit">@lang('website.Unit')<span class="required">*</span></label>
                                                <select name="grey_unit" id="grey_unit" class="form-control demo-select2" required>
                                                    @foreach(\App\Model\Unit::all() as $unit)
                                                        <option value="{{$unit->name}}" {{$dyingProduct->grey_unit == $unit->name ? 'selected':''}}>{{getNameByBnEn($unit)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="grey_width">@lang('website.Grey Width')<span class="required">*</span></label>
                                                <input type="text" class="form-control" name="grey_width" value="{{$dyingProduct->grey_width}}" required>
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="finished_unit">@lang('website.Unit')<span class="required">*</span></label>
                                                <select name="finished_unit" id="finished_unit" class="form-control demo-select2" required>
                                                    @foreach(\App\Model\Unit::all() as $unit)
                                                        <option value="{{$unit->name}}" {{$dyingProduct->finished_unit == $unit->name ? 'selected':''}}>{{getNameByBnEn($unit)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="finished_width">@lang('website.Finished Width')<span class="required">*</span></label>
                                                <input type="text" class="form-control" name="finished_width" value="{{$dyingProduct->finished_width}}" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="price_validity">@lang('website.Price Validate Till')</label>
                                                <input type="date" class="form-control" name="price_validity" value="{{$product->price_validity}}" style="background-color: #f3f3f3">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="made_in">@lang('website.Made In')</label>
                                                <select name="made_in" id="made_in" class="form-control demo-select2" required>
                                                    <option >@lang('website.Select')</option>
                                                    @foreach(\App\Model\Countries::all() as $country)
                                                        <option value="{{$country->country_name}}" {{$product->made_in == $country->country_name ? 'selected':''}}>{{getCountryNameByBnEn($country)}}</option>
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
                                                    @php
                                                        $testInfos = json_decode($dyingProduct->test_parameter_info);
                                                    @endphp
                                                    @if($testInfos)
                                                        @foreach( $testInfos as $testInfo)
                                                            @php
                                                                $testParameter = \App\Model\TestParameter::find($testInfo->test_parameter_id);
                                                            @endphp

                                                            <input type="hidden" name="test_parameter_id[]" value="{{$testParameter->id}}">

                                                            <tr>
                                                                <td width="20%">{{$testParameter->name}}</td>
                                                                <td width="20%">
                                                                    <select class="form-control demo-select2" name="test_method_id[]">
                                                                        <option disabled selected>Select</option>
                                                                        @foreach(\App\Model\Method::all() as $method)
                                                                            <option value="{{$method->id}}" {{$testInfo->method_id == $method->id?'selected':''}}>{{$method->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td width="20%">{{$testParameter->description}}</td>
                                                                <td>
                                                                    <input type="text" name="test_req[]" value="{{$testInfo->req}}" class="form-control">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="test_result[]" value="{{$testInfo->result}}" class="form-control">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="test_remark[]" value="{{$testInfo->remark}}" class="form-control">
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        @foreach(\App\Model\TestParameter::where('status',1)->get() as $testParameter)
                                                            <input type="hidden" name="test_parameter_id[]" value="{{$testParameter->id}}">
                                                            <tr>
                                                                <td width="20%">{{$testParameter->name}}</td>
                                                                <td width="20%">
                                                                    <select class="form-control demo-select2" name="test_method_id[]">
                                                                        <option disabled selected>Select</option>
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
                                                    @endif
                                                    </tbody>
                                                </table>
                                                @php
                                                    $fastnessInfos = json_decode($dyingProduct->color_fastness_info);
                                                @endphp
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
                                                                    <option disabled selected>Select</option>
                                                                    @if($fastnessInfos)
                                                                        @foreach($fastnessInfos as $fastnessInfo)
                                                                            @php
                                                                                $method = \App\Model\Method::find($fastnessInfo->method_id);
                                                                            @endphp
                                                                            <option value="{{$method->id}}" {{$fastnessInfo->method_id == $method->id ? 'selected' : ''}}>{{$method->name}}</option>
                                                                        @endforeach
                                                                    @else
                                                                        @foreach(\App\Model\Method::all() as $method)
                                                                            <option value="{{$method->id}}">{{$method->name}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </td>
                                                        @endforeach
                                                        <td>
                                                            @if($fastnessInfos)
                                                                <input type="text" name="fastness_remark[]" value="{{$fastnessInfos[0]->remark}}" class="form-control">
                                                            @else
                                                                <input type="text" name="fastness_remark[]" class="form-control">
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        @foreach(\App\Model\ColorFastness::all() as $colorFastness)
                                                            <td>Req</td>
                                                            <td>Result</td>
                                                        @endforeach
                                                        <td>
                                                            <input type="text" name="remark[]" class="form-control">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">Shade Change</td>
                                                        @if($fastnessInfos)
                                                            @foreach($fastnessInfos as $fastnessInfo)
                                                                <td><input type="text" name="shade_req[]" value="{{$fastnessInfo->req}}" class="form-control"></td>
                                                                <td><input type="text" name="shade_result[]"  value="{{$fastnessInfo->result}}" class="form-control"></td>
                                                            @endforeach
                                                        @else
                                                            @foreach(\App\Model\ColorFastness::all() as $colorFastness)
                                                                <td><input type="text" name="shade_req[]" class="form-control"></td>
                                                                <td><input type="text" name="shade_result[]" class="form-control"></td>
                                                            @endforeach
                                                        @endif
                                                        <td>
                                                            <input type="text" name="shade_remark[]" class="form-control">
                                                        </td>
                                                    </tr>
                                                    <div class="form-group col-md-6">
                                                        @foreach(\App\Model\ColorStain::all() as $key => $colorStain)

                                                            <input type="hidden" name="color_stain_id[]" value="{{$colorStain->id}}">
                                                            <tr>
                                                                <td>{{$key == 2 ? 'Color Staining' :''}}</td>
                                                                <td>{{$colorStain->name}}</td>
                                                                @php
                                                                    $colorStainingInfos =  \App\Model\ColorStainingInfo::where('dying_product_id',$dyingProduct->id)->get();
                                                                @endphp

                                                                @if(!empty($colorStainingInfos))
                                                                    {{--                                                                    @foreach($colorStainingInfos as $colorStainingInfo)--}}
                                                                    {{--                                                                    <input type="hidden" name="color_staining_info_id[]" value="{{$colorStainingInfo->id}}">--}}
                                                                    @foreach(\App\Model\ColorFastness::all() as $colorFastness)
                                                                        @php
                                                                            $test =
                                                                            \App\Model\ColorStainingInfo::where ('color_fastness_id',$colorFastness->id)
                                                                            ->where('color_stain_id',$colorStain->id)
                                                                            ->where('dying_product_id',$dyingProduct->id)
                                                                            ->first();
                                                                        @endphp
                                                                        <td><input type="text" name="staining_req[]" value="{{$test->req}}" class="form-control"></td>
                                                                        <td><input type="text" name="staining_result[]" value="{{$test->result}}" class="form-control"></td>
                                                                    @endforeach
                                                                    @php
                                                                        $staining_remark =  \App\Model\ColorStainingInfo::where('dying_product_id',$dyingProduct->id)->where('color_stain_id',$colorStain->id)->first();
                                                                    @endphp
                                                                    <td><input type="text" name="staining_remark[]" value="{{$staining_remark->remark}}" class="form-control"></td>
                                                                    {{--                                                                    @endforeach--}}
                                                                @else
                                                                    @foreach(\App\Model\ColorFastness::all() as $colorFastness)
                                                                        <td><input type="text" name="staining_req[]" class="form-control"></td>
                                                                        <td><input type="text" name="staining_result[]" class="form-control"></td>
                                                                    @endforeach
                                                                    <td><input type="text" name="staining_remark[]" class="form-control"></td>
                                                                @endif

                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            @php
                                                                $crossStainingInfos = json_decode($dyingProduct->cross_staining_info);
                                                            @endphp

                                                            <td colspan="2">Cross Staining</td>
                                                            {{--                                                            @if($crossStainingInfos)--}}
                                                            {{--                                                                @foreach(\App\Model\ColorFastness::all() as $colorFastness)--}}
                                                            {{--                                                                    <td><input type="text" name="cross_req[]" class="form-control"></td>--}}
                                                            {{--                                                                    <td><input type="text" name="cross_result[]" class="form-control"></td>--}}

                                                            @if($colorStainingInfos)
                                                                {{--                                                                <input type="hidden" name="color_staining_info_id[]" value="{{$colorStainingInfo->id}}">--}}
                                                                @php
                                                                    $infos = json_decode($dyingProduct->cross_staining_info);
                                                                @endphp
                                                                @foreach($infos as $info)
                                                                    <td><input type="text" name="staining_req[]" value="{{$info->req}}" class="form-control"></td>
                                                                    <td><input type="text" name="staining_result[]" value="{{$info->result}}" class="form-control"></td>
                                                                @endforeach
                                                            @else
                                                                @foreach(\App\Model\ColorFastness::all() as $colorFastness)
                                                                    <td><input type="text" name="cross_req[]" class="form-control"></td>
                                                                    <td><input type="text" name="cross_result[]" class="form-control"></td>
                                                                @endforeach
                                                            @endif
                                                            <td><input type="text" name="cross_remark[]" class="form-control"></td>
                                                        </tr>
                                                </table>
                                            </div>

                                            {{--                                            <div class="form-group col-md-6">--}}
                                            {{--                                                <label for="color_test_parameter">Color Test Parameter<span class="required">*</span></label>--}}
                                            {{--                                                <input type="text" class="form-control" name="color_test_parameter" value="{{$dyingProduct->color_test_parameter}}" required>--}}
                                            {{--                                            </div>--}}
                                            {{--                                            <div class="form-group col-md-6">--}}
                                            {{--                                                <label for="rubbing">Rubbing<span class="required">*</span></label>--}}
                                            {{--                                                <input type="text" class="form-control" name="rubbing" value="{{$dyingProduct->rubbing}}" required>--}}
                                            {{--                                            </div>--}}
                                            {{--                                            <div class="form-group col-md-6">--}}
                                            {{--                                                <label for="tearing_strange">Tearing Strange<span class="required">*</span></label>--}}
                                            {{--                                                <input type="text" class="form-control" name="tearing_strange" value="{{$dyingProduct->tearing_strange}}" required>--}}
                                            {{--                                            </div>--}}
                                            {{--                                            <div class="form-group col-md-6">--}}
                                            {{--                                                <label for="shining_receive">Shining Receive<span class="required">*</span></label>--}}
                                            {{--                                                <input type="text" class="form-control" name="shining_receive" value="{{$dyingProduct->shining_receive}}" required>--}}
                                            {{--                                            </div>--}}
                                            {{--                                            <div class="form-group col-md-6">--}}
                                            {{--                                                <label for="shining_receive_bn">Shining Receive (BN)</label>--}}
                                            {{--                                                <input type="text" class="form-control" name="shining_receive_bn" id="shining_receive_bn" value="{{$dyingProduct->shining_receive_bn}}">--}}
                                            {{--                                            </div>--}}

                                        </div>
                                    </div>
                                    <div class="col-md-12" style="padding-top: 20px;">
                                        <!-- general form elements -->
                                        <h4 class="pl-2 pb-0 mb-2 bg-info"><span style="margin-left: 10px !important;">@lang('website.Product Image') <span class="required">*</span></span></h4>
                                        <div class="form-group row">
                                            <label class="control-label ml-3 col-12">@lang('website.Gallery Images') <span class="required">*</span> <small class="text-danger">(Size: 290 * 300px)</small></label>
                                            <div class="ml-3 mr-3 col-10">
                                                <div class="row" id="photos">
                                                    @if(is_array(json_decode($product->photos)))
                                                        @foreach (json_decode($product->photos) as $key => $photo)
                                                            <div class="col-md-4 col-sm-4 col-xs-6">
                                                                <div class="img-upload-preview">
                                                                    <img loading="lazy"  src="{{url($photo)}}" alt="" class="img-responsive">
                                                                    <input type="hidden" name="previous_photos[]" value="{{$photo}}">
                                                                    <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <div class="row" id="photos_alt"></div>
                                            </div>
                                            <div class="col-2">
                                                <a href="https://tinypng.com/" target="_blank" class="btn btn-primary" style="padding: 0 15px;"><i class="fa fa-edit"></i></a> @lang('website.Resize')
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="padding-top: 20px;">
                                        <div class="form-group">
                                            <label for="description">@lang('website.Product Description')<span class="required">*</span></label>
                                            <textarea name="description" id="description"  class="form-control" style="background-color: #f3f3f3">{!! $product->description !!}</textarea>
                                        </div>
                                    </div>
                                    {{--                                    <div class="col-md-10" style="padding-top: 20px;">--}}
                                    {{--                                        <div class="form-group">--}}
                                    {{--                                            <label for="description_bn">Product Description (BN)<span class="required">*</span></label>--}}
                                    {{--                                            <textarea name="description_bn" id="description_bn"  class="form-control" style="background-color: #f3f3f3">{!! $product->description_bn !!}</textarea>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}
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
                        $("#dying_sub_category_id > option").each(function() {
                            if(this.value == '{{$dyingProduct->dying_sub_category_id}}'){
                                $("#dying_sub_category_id").val(this.value).change();
                            }
                        });
                        $('.demo-select2').select2();
                    }else{
                        $("#category_two").hide()
                    }
                });
            }
        })
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
        $('.remove-files').on('click', function(){
            $(this).parents(".col-md-4").remove();
        });


    </script>
@endpush
