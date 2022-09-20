@extends('backend.layouts.master')
@section("title","Create Yarn Products")
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
                    {{--                    <h1>Add Products</h1>--}}
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Create Yarn Products</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <form action="{{route('admin.yarn-product.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <section>
            <div class="row m-3" id="phone_area">
                <div class="col-md-8 offset-2">
                    <!-- general form elements -->
                    <div class="card card-info card-outline">
                        <p class="pl-2 pb-0 mb-0 bg-info">Seller Phone Verification</p>
                        <div class="row m-5">
                            <div class="form-group col-8">
                                <label class="control-label">Phone Verification</label>
                                <div class="input-group">
                                    <input type="number" class="form-control " name="phone" id="phone" placeholder="Enter Seller Phone">
                                    <input type="hidden" name="user_id" id="user_id">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-info" type="button" id="button-addon2" onclick="phoneVerification()" >Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <section class="content" id="main_content">

            <div class="row m-2" >
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-info card-outline">
                        <p class="pl-2 pb-0 mb-0 bg-info">Product Information</p>
                        <div class="card-body">
                            <div class="form-group ">
                                <label for="name">Product Type</label>
                                <input type="text" class="form-control " name="name" id="name" placeholder="Enter Name" required>
                                <input type="hidden" id="slug" name="slug" class="form-control">
                            </div>

                            <div class="form-group mt-2">
                                <label for="category_id">Select Category</label>
                                <select name="category_id" id="category_id" class="form-control demo-select2" required>
                                    @foreach(\App\Model\Category::where('id',4)->get() as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mt-2" id="category_two">
                                <select name="sub_category_id" id="sub_category_id" class="form-control demo-select2">

                                </select>
                            </div>
                            <div class="form-group mt-2" id="category_three">
                                <select name="sub_sub_category_id" id="sub_sub_category_id"
                                        class="form-control demo-select2">

                                </select>
                            </div>
                            <div class="form-group mt-2" id="category_four">
                                <select name="sub_sub_child_category_id" id="sub_sub_child_category_id"
                                        class="form-control demo-select2">

                                </select>
                            </div>
                            <div class="form-group mt-2" id="category_five">
                                <select name="sub_sub_child_child_category_id" id="sub_sub_child_child_category_id"
                                        class="form-control demo-select2">

                                </select>
                            </div>
                            <div class="form-group mt-2" id="category_six">

                                <select name="category_six_id" id="category_six_id"
                                        class="form-control ">

                                </select>
                            </div>
                            <div class="form-group mt-2" id="category_seven">
                                <select name="category_seven_id" id="category_seven_id"
                                        class="form-control">

                                </select>
                            </div>
                            <div class="form-group mt-2" id="category_eight">
                                <select name="category_eight_id" id="category_eight_id"
                                        class="form-control">

                                </select>
                            </div>
                            <div class="form-group mt-2" id="category_nine">
                                <select name="category_nine_id" id="category_nine_id"
                                        class="form-control">

                                </select>
                            </div>
                            <div class="form-group mt-2" id="category_ten">
                                <select name="category_ten_id" id="category_ten_id"
                                        class="form-control ">

                                </select>
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
                                </div>
                                <div class="row" id="photos_alt"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row m-2">
                <div class="col-md-12">
                    <div class="card card-info card-outline" style="padding: 20px;">
                        <p class="pl-2 pb-0 mb-0 bg-info">Product Price Details</p>
                        <div class="row" style="border-right: 1px solid #ddd;">
                            <div class="form-group col-3">
                                <label for="quantity">Quantity</label>
                                <input type="text" class="form-control price_summation" name="quantity" id="quantity" required>
                            </div>
                            <div class="form-group col-3">
                                <label for="unit_id">Unit</label>
                                <select name="unit_id" id="unit_id" class="form-control demo-select2" required>
                                    <option value="">Select</option>
                                    @foreach(\App\Model\Unit::all() as $unit)
                                        <option value="{{$unit->id}}">{{$unit->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-3">
                                <label for="unit_price">Unit price</label>
                                <input type="number" min="0" step="0.00001" placeholder="Unit price" name="unit_price" id="unit_price" class="form-control price_summation" required="">
                            </div>
                            <div class="form-group col-3">
                                <label for="expected_price">Total price</label>
                                <input type="number" min="0" step="0.00001"
                                       name="expected_price"
                                       class="form-control" id="expected_price" required readonly>
                            </div>
                        </div>

                        <div class="row" style="border-right: 1px solid #ddd;">
                            <div class="form-group col-md-3">
                                <label for="price_validity">Price Validate Till</label>
                                <input type="date" class="form-control" name="price_validity" id="price_validity" style="background-color: #f3f3f3">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="made_in">Made In</label>
                                <select name="made_in" id="made_in" class="form-control demo-select2" required>
                                    <option >Select</option>
                                    @foreach(\App\Model\Countries::all() as $country_of_origin)
                                        <option value="{{$country_of_origin->country_name}}">{{$country_of_origin->country_name}}</option>
                                    @endforeach
                                </select>
                                {{--                                <input type="text" class="form-control" name="made_in" id="made_in" value="Bangladesh"  style="background-color: #f3f3f3">--}}
                            </div>

                            <div class="form-group col-3">
                                <label for="expected_price">Featured</label>
                                <div class="row">
                                    <div class="col-4">
                                        <input type="radio" name="featured_product" value="1" class="shipping_method" >
                                        <label>Yes</label>
                                    </div>
                                    <div class="col-4">
                                        <input type="radio" name="featured_product" value="0" class="shipping_method">
                                        <label>No</label>
                                    </div>
                                </div>
                            </div>
{{--                            <div class="form-group col-3 d-none">--}}
{{--                                <label for="currency_id">Currency</label>--}}
{{--                                <select name="currency_id" id="currency_id" class="form-control demo-select2" style="background-color: #f3f3f3" required>--}}
{{--                                    <option value="">Select</option>--}}
{{--                                    @foreach(\App\Model\Currency::where('status',1)->get() as $currency)--}}
{{--                                        <option value="{{$currency->id}}">{{$currency->name}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}

                        </div>

                        <div class="form-group">
                            <label for="description">Product Description</label>
                            <textarea name="description" id="description"  class="form-control"></textarea>
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
        var category_two = $("#sub_category_id").val();
        var category_three = $("#sub_sub_category_id").val();
        var category_four = $("#sub_sub_child_category_id").val();
        var category_five = $("#sub_sub_child_child_category_id").val();
        var category_six = $('#category_six_id').val();
        var category_seven = $('#category_seven_id').val();
        var category_eight = $('#category_eight_id').val();
        var category_nine = $('#category_nine_id').val();
        var category_ten = $('#category_ten_id').val();

        function phoneVerification(){
            var phone = $('#phone').val();
            $.ajax({
                url: "{{URL('/admin/phone/verification')}}/" + phone,
                method: "get",
                success: function (data) {
                    console.log(data)
                    if(data != 0){
                        toastr.success('success', 'Phone Number Verified Successfully');
                        console.log(data)
                        $('#user_id').val(data);
                        $("#phone_area").hide();
                        $("#main_content").show();
                    }
                    else{
                        toastr.error('danger', "Phone number doesn't match to database");
                    }
                }
            });
        }

        $(document).ready(function () {
            $("#main_content").hide()


            $("#category_three").hide()
            $("#category_four").hide()
            $("#category_five").hide()
            $("#category_six").hide()
            $("#category_seven").hide()
            $("#category_eight").hide()
            $("#category_nine").hide()
            $("#category_ten").hide()

            get_subcategories();
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

            function get_subcategories() {
                var category_id = $('#category_id').val();
                //console.log(category_id)
                $.post('{{ route('products.get_subcategories_by_category') }}', {
                    _token: '{{ csrf_token() }}',
                    category_id: category_id
                }, function (data) {
                    $('#sub_category_id').html(null);
                    $('#sub_category_id').append($('<option>', {
                        value: null,
                        text: 'Select Product'
                    }));
                    // console.log(data)
                    for (var i = 0; i < data.length; i++) {
                        $('#sub_category_id').append($('<option>', {
                            value: data[i].id,
                            text: data[i].name
                        }));
                    }
                });
            }
            function get_subsubcategories() {
                var sub_category_id = $('#sub_category_id').val();
                console.log(sub_category_id)
                $.post('{{ route('products.get_subsubcategories_by_subcategory') }}', {
                    _token: '{{ csrf_token() }}',
                    sub_category_id: sub_category_id
                }, function (data) {
                    $('#sub_sub_category_id').html(null);
                    $('#sub_sub_category_id').append($('<option>', {
                        value: null,
                        text: 'Select Product'
                    }));
                    for (var i = 0; i < data.length; i++) {
                        $('#sub_sub_category_id').append($('<option>', {
                            value: data[i].id,
                            text: data[i].name
                        }));
                    }
                });
            }

            function get_sub_sub_child_categories() {
                var sub_sub_category_id = $('#sub_sub_category_id').val();
                console.log(sub_sub_category_id)
                $.post('{{ route('products.get_subsubchildcategories_by_subsubcategory') }}', {
                    _token: '{{ csrf_token() }}',
                    sub_sub_category_id: sub_sub_category_id
                }, function (data) {
                    $('#sub_sub_child_category_id').html(null);
                    $('#sub_sub_child_category_id').append($('<option>', {
                        value: null,
                        text: 'Select Product'
                    }));
                    for (var i = 0; i < data.length; i++) {
                        $('#sub_sub_child_category_id').append($('<option>', {
                            value: data[i].id,
                            text: data[i].name
                        }));
                    }

                });
            }
            function get_sub_sub_child_child_categories() {
                var sub_sub_child_category_id = $('#sub_sub_child_category_id').val();
                console.log(sub_sub_category_id)
                $.post('{{ route('products.get_subsubchildchildcategories_by_subsubchildcategory') }}', {
                    _token: '{{ csrf_token() }}',
                    sub_sub_child_category_id: sub_sub_child_category_id
                }, function (data) {
                    //console.log(data)
                    $('#sub_sub_child_child_category_id').html(null);
                    $('#sub_sub_child_child_category_id').append($('<option>', {
                        value: null,
                        text: 'Select Product'
                    }));
                    for (var i = 0; i < data.length; i++) {
                        $('#sub_sub_child_child_category_id').append($('<option>', {
                            value: data[i].id,
                            text: data[i].name
                        }));
                    }
                });
            }

            function get_category_six() {
                var sub_sub_child_child_category_id = $('#sub_sub_child_child_category_id').val();
                console.log(sub_sub_child_child_category_id)
                $.post('{{ route('products.get_category_six') }}', {
                    _token: '{{ csrf_token() }}',
                    sub_sub_child_child_category_id: sub_sub_child_child_category_id
                }, function (data) {
                    //console.log(data)
                    $('#category_six_id').html(null);
                    $('#category_six_id').append($('<option>', {
                        value: null,
                        text: 'Select Product'
                    }));
                    for (var i = 0; i < data.length; i++) {
                        $('#category_six_id').append($('<option>', {
                            value: data[i].id,
                            text: data[i].name
                        }));
                    }
                });
            }
            function get_category_seven() {
                var category_six_id = $('#category_six_id').val();
                console.log(category_six_id)
                $.post('{{ route('products.get_category_seven') }}', {
                    _token: '{{ csrf_token() }}',
                    category_six_id: category_six_id
                }, function (data) {
                    //console.log(data)
                    $('#category_seven_id').html(null);
                    $('#category_seven_id').append($('<option>', {
                        value: null,
                        text: 'Select Product'
                    }));
                    for (var i = 0; i < data.length; i++) {
                        $('#category_seven_id').append($('<option>', {
                            value: data[i].id,
                            text: data[i].name
                        }));
                    }

                });
            }
            function get_category_eight() {
                var category_seven_id = $('#category_seven_id').val();
                console.log(category_seven_id)
                $.post('{{ route('products.get_category_eight') }}', {
                    _token: '{{ csrf_token() }}',
                    category_seven_id: category_seven_id
                }, function (data) {
                    //console.log(data)
                    $('#category_eight_id').html(null);
                    $('#category_eight_id').append($('<option>', {
                        value: null,
                        text: 'Select Product'
                    }));
                    for (var i = 0; i < data.length; i++) {
                        $('#category_eight_id').append($('<option>', {
                            value: data[i].id,
                            text: data[i].name
                        }));
                    }
                });
            }
            function get_category_nine() {
                var category_eight_id = $('#category_eight_id').val();
                console.log(category_eight_id)
                $.post('{{ route('products.get_category_nine') }}', {
                    _token: '{{ csrf_token() }}',
                    category_eight_id: category_eight_id
                }, function (data) {
                    //console.log(data)
                    $('#category_nine_id').html(null);
                    $('#category_nine_id').append($('<option>', {
                        value: null,
                        text: 'Select Product'
                    }));
                    for (var i = 0; i < data.length; i++) {
                        $('#category_nine_id').append($('<option>', {
                            value: data[i].id,
                            text: data[i].name
                        }));
                    }
                });
            }
            function get_category_ten() {
                var category_nine_id = $('#category_nine_id').val();
                console.log(category_nine_id)
                $.post('{{ route('products.get_category_ten') }}', {
                    _token: '{{ csrf_token() }}',
                    category_nine_id: category_nine_id
                }, function (data) {
                    //console.log(data)
                    $('#category_ten_id').html(null);
                    $('#category_ten_id').append($('<option>', {
                        value: null,
                        text: 'Select Product'
                    }));
                    for (var i = 0; i < data.length; i++) {
                        $('#category_ten_id').append($('<option>', {
                            value: data[i].id,
                            text: data[i].name
                        }));
                    }
                });
            }


            $('#category_id').on('change', function () {
                $("#category_two").show()
                $("#category_three").hide()
                $("#category_four").hide()
                $("#category_five").hide()
                $("#category_six").hide()
                $("#category_seven").hide()
                $("#category_eight").hide()
                $("#category_nine").hide()
                $("#category_ten").hide()
                get_subcategories();

            });
            $('#sub_category_id').on('change', function () {
                $("#category_three").show()
                $("#category_four").hide()
                $("#category_five").hide()
                $("#category_six").hide()
                $("#category_seven").hide()
                $("#category_eight").hide()
                $("#category_nine").hide()
                $("#category_ten").hide()
                get_subsubcategories();
            });
            $('#sub_sub_category_id').on('change', function () {
                $("#category_four").show()
                $("#category_five").hide()
                $("#category_six").hide()
                $("#category_seven").hide()
                $("#category_eight").hide()
                $("#category_nine").hide()
                $("#category_ten").hide()
                get_sub_sub_child_categories();
            });
            $('#sub_sub_child_category_id').on('change', function () {
                $("#category_five").show()
                $("#category_six").hide()
                $("#category_seven").hide()
                $("#category_eight").hide()
                $("#category_nine").hide()
                $("#category_ten").hide()
                get_sub_sub_child_child_categories();
            });
            $('#sub_sub_child_child_category_id').on('change', function () {
                $("#category_six").show()
                $("#category_seven").hide()
                $("#category_eight").hide()
                $("#category_nine").hide()
                $("#category_ten").hide()
                get_category_six();
            });
            $('#category_six_id').on('change', function () {
                $("#category_seven").show()
                $("#category_eight").hide()
                $("#category_nine").hide()
                $("#category_ten").hide()
                get_category_seven();
            });
            $('#category_seven_id').on('change', function () {
                $("#category_eight").show()
                $("#category_nine").hide()
                $("#category_ten").hide()
                get_category_eight();
            });
            $('#category_eight_id').on('change', function () {
                $("#category_nine").show()
                $("#category_ten").hide()
                get_category_nine();
            });
            $('#category_nine_id').on('change', function () {
                $("#category_ten").show()
                get_category_ten();
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

        });

    </script>
@endpush
