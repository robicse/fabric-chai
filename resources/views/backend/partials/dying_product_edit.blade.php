@extends('backend.layouts.master')
@section("title","Edit Dyeing Products")
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
                    <h1>Edit Dyeing Products</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Edit Dyeing Products</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <form role="form" id="choice_form" action="{{route('admin.dying-products.update',$product->id)}}" method="post"
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
                                    <select name="name" id="name" class="form-control demo-select2" required>
                                        <option value="Dyeing" {{$product->name == 'Dyeing' ? 'selected':''}}>Dyeing</option>
                                        <option value="Printing" {{$product->name == 'Printing' ? 'selected':''}}>Printing</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6" >
                                    <label for="product_of_fabric">Product Of Fabric <span class="required">*</span></label>
                                    <select name="product_of_fabric" id="product_of_fabric" class="form-control demo-select2" required>
                                        <option value="Solid Dyeing" {{$dyingProduct->product_of_fabric == 'Solid Dyeing' ? 'selected':''}}>Solid Dyeing</option>
                                        <option value="AOP" {{$dyingProduct->product_of_fabric == 'AOP' ? 'selected':''}}>AOP</option>
                                        <option value="PFD" {{$dyingProduct->product_of_fabric == 'PFD"' ? 'selected':''}}>PFD</option>
                                        <option value="Others" {{$dyingProduct->product_of_fabric == 'Others' ? 'selected':''}}>Others</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="dying_category_id">Types Of Fabrics<span class="required">*</span></label>
                                    <select name="dying_category_id" id="dying_category_id" class="form-control demo-select2" required>
                                        @foreach(\App\Model\DyingCategory::all() as $dyingCategory)
                                            <option value="{{$dyingCategory->id}}" {{$dyingProduct->dying_category_id == $dyingCategory->id ? 'selected':''}}>{{$dyingCategory->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="dying_category_id"></label>
                                    <select name="dying_sub_category_id" id="dying_sub_category_id" class="form-control demo-select2">

                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="quantity">Quantity of Fabric<span class="required">*</span></label>
                                    <input type="number" class="form-control price_summation" name="quantity" id="quantity" min="1" value="{{$product->quantity}}" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="unit_price">Unit Price<span class="required">*</span></label>
                                    <input type="number" class="form-control" name="unit_price" id="unit_price" value="{{$product->unit_price}}" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="color">Colors of Fabric<span class="required">*</span></label>
                                    <select name="color" id="color" class="form-control demo-select2" required>
                                        @foreach(\App\Model\Color::all() as $color)
                                            <option value="{{$color->name}}" {{$dyingProduct->color == $color->name ? 'selected':''}}>{{$color->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="fabrics_construction">Fabrics Construction<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="fabrics_construction" value="{{$dyingProduct->fabrics_construction}}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="fabrics_composition">Fabrics Composition<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="fabrics_composition" value="{{$dyingProduct->fabrics_composition}}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="grey_width">Grey Width<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="grey_width" value="{{$dyingProduct->grey_width}}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="grey_unit">Unit<span class="required">*</span></label>
                                    <select name="grey_unit" id="grey_unit" class="form-control demo-select2" required>
                                        @foreach(\App\Model\Unit::all() as $unit)
                                            <option value="{{$unit->name}}" {{$dyingProduct->grey_unit == $unit->name ? 'selected':''}}>{{$unit->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="finished_width">Finished Width<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="finished_width" value="{{$dyingProduct->finished_width}}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="finished_unit">Unit<span class="required">*</span></label>
                                    <select name="finished_unit" id="finished_unit" class="form-control demo-select2" required>
                                        @foreach(\App\Model\Unit::all() as $unit)
                                            <option value="{{$unit->name}}" {{$dyingProduct->finished_unit == $unit->name ? 'selected':''}}>{{$unit->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="color_test_parameter">Color Test Parameter<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="color_test_parameter" value="{{$dyingProduct->color_test_parameter}}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="rubbing">Rubbing<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="rubbing" value="{{$dyingProduct->rubbing}}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="tearing_strange">Tearing Strange<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="tearing_strange" value="{{$dyingProduct->tearing_strange}}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="shining_receive">Shining Receive<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="shining_receive" value="{{$dyingProduct->shining_receive}}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="price_validity">Price Validate Till</label>
                                    <input type="date" class="form-control" name="price_validity" value="{{$product->price_validity}}" style="background-color: #f3f3f3">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="made_in">Made In</label>
                                    <select name="made_in" id="made_in" class="form-control demo-select2" required>
                                        <option >Select</option>
                                        @foreach(\App\Model\Countries::all() as $country)
                                            <option value="{{$country->country_name}}" {{$product->made_in == $country->name ? 'selected':''}}>{{$country->country_name}}</option>
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

        });
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
