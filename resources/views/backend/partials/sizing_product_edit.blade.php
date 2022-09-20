@extends('backend.layouts.master')
@section("title","Edit Sizing Products")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
    <style>
        .select2-container--default .color-preview {
            height: 12px;
            width: 12px;
            display: inline-block;
            margin-right: 5px;
            margin-top: 2px;
        }
    </style>
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Sizing Products</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Edit Sizing Products</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <form role="form" id="choice_form" action="{{route('admin.sizing-products.update',$product->id)}}" method="post"
          enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $product->id }}">
        <section class="content">
            <div class="row m-2">
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-info card-outline">
                        <p class="pl-2 pb-0 mb-0 bg-info">Product Information</p>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6" >
                                    <label for="name">Product Type <span class="required">*</span></label>
                                    <input type="text" class="form-control " name="name" id="name" value="{{$product->name}}" required>
                                    <input type="hidden" id="slug" name="slug" class="form-control">
                                </div>
                                <div class="form-group col-md-6" >
                                    <label for="total_length">Total Lengths <span class="required">*</span></label>
                                    <input type="number" class="form-control" name="total_length" id="total_length" value="{{$sizingProduct->total_length}}" required>
                                </div>
                                <div class="form-group col-md-6" >
                                    <label for="yarn_count">Yarn Count <span class="required">*</span></label>
                                    <input type="number" class="form-control" name="yarn_count" id="yarn_count" value="{{$sizingProduct->yarn_count}}" required>
                                </div>
                                <div class="form-group col-md-6" >
                                    <label for="yarn_csp">Yarn CSP <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="yarn_csp" id="yarn_csp" value="{{$sizingProduct->yarn_csp}}" required>
                                </div>
                                <div class="form-group col-md-6" >
                                    <label for="ipi">IPI <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="ipi" id="ipi" value="{{$sizingProduct->ipi}}" required>
                                </div>
                                <div class="form-group col-md-6" >
                                    <label for="lengths_of">Lengths Of <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="lengths_of" id="lengths_of" value="{{$sizingProduct->lengths_of}}" required>
                                </div>
                                <div class="form-group col-md-6" >
                                    <label for="price">Price per Meter/Yards  <span class="required">*</span></label>
                                    <input type="number" class="form-control" name="price" id="price" value="{{$sizingProduct->price}}"  required>
                                </div>
                                <div class="form-group col-md-6" >
                                    <label for="warping_lengths">Warping Lengths Meter/Yards  <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="warping_lengths" id="warping_lengths" value="{{$sizingProduct->warping_lengths}}" required>
                                </div>
                                <div class="form-group col-md-6" >
                                    <label for="sizing_lengths">Sizing Lengths Meter/Yards  <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="sizing_lengths" id="sizing_lengths" value="{{$sizingProduct->sizing_lengths}}" required>
                                </div>
                                <div class="form-group col-md-6" >
                                    <label for="wastage_percentage">Wastage Percentage <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="wastage_percentage" id="wastage_percentage" value="{{$sizingProduct->wastage_percentage}}" required>
                                </div>
                                <div class="form-group col-md-6" >
                                    <label for="gera">Gera <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="gera" id="gera" value="{{$sizingProduct->gera}}" required>
                                </div>
                                <div class="form-group col-md-6" >
                                    <label for="sizing_time">Sizing Time <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="sizing_time" id="sizing_time" value="{{$sizingProduct->sizing_time}}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="price_validity">Price Validate Till</label>
                                    <input type="date" class="form-control" name="price_validity" id="price_validity" value="{{$product->price_validity}}"  style="background-color: #f3f3f3">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="made_in">Made In</label>
                                    <select name="made_in" id="made_in" class="form-control demo-select2" required>
                                        <option >Select</option>
                                        @foreach(\App\Model\Countries::all() as $country_of_origin)
                                            <option value="{{$country_of_origin->country_name}}" {{$product->made_in == $country_of_origin->country_name ? 'selected' : '' }}>{{$country_of_origin->country_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-info card-outline">
                        <p class="pl-2 pb-0 mb-0 bg-info">Product Image</p>
                        <div class="form-group">
                            <label class="control-label ml-3">Gallery Images <span class="required">*</span> <small class="text-danger">(Size: 290 * 300px)</small></label>
                            <div class="ml-3 mr-3">
                                <div class="row" id="photos">
                                    @if(is_array(json_decode($product->photos)))
                                        @foreach (json_decode($product->photos) as $key => $photo)
                                            <div class="col-md-4 col-sm-3 col-xs-6">
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
                        </div>
                        <div class="form-group ml-3 mr-3">
                            <label for="description">Product Description</label>
                            <textarea name="description" id="description"  class="form-control">{!! $product->description !!}</textarea>
                        </div>
                    </div>
                </div>
            </div>
{{--            <div class="row m-2">--}}
{{--                <div class="col-md-12">--}}
{{--                    <div class="card card-info card-outline" style="padding: 20px;">--}}
{{--                        <p class="pl-2 pb-0 mb-0 bg-info">Product Price Details</p>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="row m-2">
                <div class="col-md-12">
                    <div class="float-right">
                        <button class="btn btn-success" type="submit">Save</button>
                    </div>
                </div>
            </div>
        </section>
    </form>
@stop
@push('js')
    <script src="{{asset('backend/dist/js/spartan-multi-image-picker-min.js')}}"></script>
    {{--    <script src="{{asset('backend/plugins/select2/select2.full.min.js')}}"></script>--}}
    <script src="{{asset('backend/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
    <script src="//cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
    <script src="{{asset('backend/plugins/ckeditor/ckeditor.js')}}"></script>
    <script>
        CKEDITOR.replace( 'description');

        $(document).ready(function () {
            //title to slug make
            $("#name").keyup(function () {
                var name = $("#name").val();
                console.log(name);
                $.ajax({
                    url: "{{URL('/admin/products/slug')}}/" + name,
                    method: "get",
                    success: function (data) {
                        //console.log(data.response)
                        $('#slug').val(data.response);
                    }
                });
            })

            $(".price_summation").keyup(function () {
                var quantity = $("#quantity").val();
                var unit_price = $("#unit_price").val();
                var expected_price = parseFloat(quantity) * parseFloat(unit_price);
                $('#expected_price').val(expected_price);
            })
        });
        $("#photos").spartanMultiImagePicker({
            fieldName: 'photos[]',
            maxCount: 10,
            rowHeight: '200px',
            groupClassName: 'col-md-4 col-sm-3 col-xs-6',
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
