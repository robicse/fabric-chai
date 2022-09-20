@extends('frontend.layouts.master')
@section("title","Edit Work Order Product")
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
                <div class="col-lg-12 pt-3">
                    <h3 class="mb-2 text-secondary">Buyer Work Order</h3>
                </div>
                @include('frontend.buyer.work_order_sidebar')
                <div class="col-lg-9">
                    <form class="woocommerce-form-login" action="{{route('buyer.work-order.update',$workOrderProduct->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-4">
                                        <h4 class="card-title float-left">
                                            Edit Work Order
                                        </h4>
                                    </div>
                                    <div style="float: left;width: 10%;padding-top: 8px;">
                                        <input type="radio" name="payment_with" value="BDT" id="bdt" class="CurrencyChange" onchange="currency_changed(this)" @if(currency()->code == 'BDT') checked @endif>
                                        <label for="bdt">BDT</label>
                                    </div>

                                    <div style="float: right;width: 10%;padding-top: 8px;">
                                        <input type="radio" name="payment_with" value="USD" id="usd" class="CurrencyChange" onchange="currency_changed(this)" @if(currency()->code == 'USD') checked @endif>
                                        <label for="usd">USD</label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row m-2">
                                    <div class="col-md-10">
                                        <div class="form-group" >
                                            <label for="name">Work Order Type <span class="required">*</span></label>
                                            <input type="text" class="form-control" name="name" id="name" value="{{$workOrderProduct->name}}"  onchange="update_sku()" required>
                                            <input type="hidden" id="slug" name="slug" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="category_id">Select Category <span class="required">*</span></label>
                                            <select name="category_id" id="category_id" class="form-control demo-select2" required>
                                                <option>Select Product</option>
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}" {{$workOrderProduct->category_id == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
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
                                                <option>Select Product</option>
                                            </select>
                                        </div>
                                        <div class="form-group mt-2" id="category_six">
                                            <select name="category_six_id" id="category_six_id"
                                                    class="form-control demo-select2">

                                            </select>
                                        </div>
                                        <div class="form-group mt-2" id="category_seven">
                                            <select name="category_seven_id" id="category_seven_id"
                                                    class="form-control demo-select2">

                                            </select>
                                        </div>

                                        <div class="form-group mt-2" id="category_eight">
                                            <select name="category_eight_id" id="category_eight_id"
                                                    class="form-control demo-select2">

                                            </select>
                                        </div>
                                        <div class="form-group mt-2" id="category_nine">
                                            <select name="category_nine_id" id="category_nine_id"
                                                    class="form-control demo-select2">

                                            </select>
                                        </div>
                                        <div class="form-group mt-2" id="category_ten">
                                            <select name="category_ten_id" id="category_ten_id"
                                                    class="form-control demo-select2">

                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-md-10" style="padding-top: 20px;">
                                        <!-- general form elements -->
                                        <div class="row">
                                            <div class="form-group col-4">
                                                <label for="currency_id">Currency (Active) <span class="required">*</span></label>
                                                <input type="text" class="form-control" value="{{currency()->code == 'BDT' ? 'BDT(৳)' : 'USD($)'}}" style="background-color: #f3f3f3" required="" readonly>
                                                <input type="hidden" name="currency_id" id="currency_id" class="form-control" value="{{currency()->id}}" style="background-color: #f3f3f3" required="">
                                            </div>
                                            <div class="form-group col-4">
                                                <label for="unit_id">Unit <span class="required">*</span></label>
                                                <select name="unit_id" id="unit_id" class="form-control demo-select2" required>
                                                    @foreach($units as $unit)
                                                        <option value="{{$unit->id}}" {{$workOrderProduct->unit_id == $unit->id ? 'selected':''}}>{{$unit->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-4">
                                                <label for="unit_price">Unit price<span class="required">*</span></label>
                                                <input type="text" name="unit_price" class="form-control" value="{{$workOrderProduct->unit_price}}" required>
                                            </div>
                                        </div>


                                        <div class="row mt-4">
                                            <div class="form-group col-6">
                                                <label for="machine_type">Machine Type <span class="required">*</span></label>
                                                <select name="machine_type[]" id="machine_type" class="form-control demo-select2" multiple required>
                                                    <option value="">Select</option>
                                                    @foreach(\App\Model\MachineType::all() as $machine_type)
                                                        @php
                                                            $ids = json_decode($workOrderProduct->machine_type)
                                                        @endphp
                                                        @if(!empty($ids))
                                                            @foreach($ids as $id)
                                                                <option value="{{$machine_type->id}}" {{$id == $machine_type->id ? 'selected':''}}>{{$machine_type->name}}</option>
                                                            @endforeach
                                                        @else
                                                            <option value="{{$machine_type->id}}">{{$machine_type->name}}</option>
                                                        @endif
                                                        @endforeach

                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="no_of_machines">No of Machines<span class="required">*</span></label>
                                                <input type="number" name="no_of_machines" id="nom" value="{{$workOrderProduct->no_of_machines}}" onkeyup="get_total_pc_1(this)" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="form-group col-6">
                                                <label for="pc_per_day">Production Capacity Per Day/Machine<span class="required">*</span></label>
                                                <input type="number" name="pc_per_day" id="pc_per_day" class="form-control" value="{{$workOrderProduct->pc_per_day}}" onkeyup="get_total_pc(this)" required>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="total_pc_per_day">Total Production Capacity Per Day <span class="required">*</span></label>
                                                <input type="number" name="total_pc_per_day" id="total_pc_per_day" class="form-control" value="{{$workOrderProduct->total_pc_per_day}}" onkeyup="get_production_time_1(this)" readonly>
                                            </div>

                                        </div>

                                        <div class="row mt-4">
                                            <div class="form-group col-4">
                                                <label for="moq">Minimum Order Quantity <span class="required">*  </span> <br></label>
                                                <input type="number" name="moq" id="moq" class="form-control" value="{{$workOrderProduct->moq}}" readonly>
                                            </div>
                                            <div class="form-group col-4">
                                                <label for="max_oq">Required Order Quantity <span class="required">*  </span> <br></label>
                                                <input type="number" name="max_oq" id="max_oq" class="form-control" value="{{$workOrderProduct->max_oq}}" onkeyup="get_production_time(this)" required>
                                            </div>
                                            <div class="form-group col-4">
                                                <label for="production_time">Production Time (Days)<span class="required">*</span></label>
                                                <input type="number" name="production_time" id="production_time" value="{{$workOrderProduct->production_time}}" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="row mt-4">

                                            <div class="form-group col-6">
                                                <label for="finishing_time">Finishing Time (Days)<span class="required">*</span></label>
                                                <input type="number" name="finishing_time" id="finishing_time" value="{{$workOrderProduct->finishing_time}}" class="form-control" onkeyup="get_delivery_time(this)" required>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="delivery_time">Delivery Time (Days)<br></label>
                                                <input type="number" name="delivery_time" id="delivery_time" value="{{$workOrderProduct->production_time}}" class="form-control"  readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Work Order Description <span class="required">*</span></label>
                                            <textarea name="description" id="description"  class="form-control" style="background-color: #f3f3f3" required>{!! $workOrderProduct->description !!}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-10" style="padding-top: 20px;">
                                        <!-- general form elements -->
                                        <div class="form-group row">
                                            <label class="control-label ml-3 col-12">Attach Images <span class="required">*</span> <small class="text-danger">(Size: 290 * 300px)</small></label>
                                            <div class="ml-3 mr-3 col-10">
                                                <div class="row" id="photos">
                                                    @if(is_array(json_decode($workOrderProduct->photos)))
                                                        @foreach (json_decode($workOrderProduct->photos) as $key => $photo)
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
                                                <a href="https://tinypng.com/" target="_blank" class="btn btn-primary" style="padding: 0 15px;"><i class="fa fa-edit"></i></a> Resize
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="woocommerce-form-login__submit btn btn-primary rounded-0" >Submit</button>
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
        // $("#category_two").hide()
        $('.demo-select2').select2();

        var category_two = $("#sub_category_id").val();
        var category_three = $("#sub_sub_category_id").val();
        var category_four = $("#sub_sub_child_category_id").val();
        var category_five = $("#sub_sub_child_child_category_id").val();
        var category_six = $('#category_six_id').val();
        var category_seven = $('#category_seven_id').val();
        var category_eight = $('#category_eight_id').val();
        var category_nine = $('#category_nine_id').val();
        var category_ten = $('#category_ten_id').val();

        $(document).ready(function () {
            $("#category_three").hide()
            $("#category_four").hide()
            $("#category_five").hide()
            $("#category_six").hide()
            $("#category_seven").hide()
            $("#category_eight").hide()
            $("#category_nine").hide()
            $("#category_ten").hide()

            get_loading_bid_price();

            get_subcategories();
            //title to slug make
            $("#name").keyup(function () {
                var name = $("#name").val();
                //console.log(name);
                $.ajax({
                    url: "{{URL('/seller/products/slug')}}/" + name,
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
                if(quantity > 0 && unit_price > 0){
                    var expected_price = parseFloat(quantity) * parseFloat(unit_price);
                    $('#expected_price').val(expected_price);

                    $.post('{{ route('bid.price.convert') }}',
                        {
                            _token:'{{ csrf_token() }}',
                            bid_price:unit_price,
                            qty:quantity
                        },
                        function(data){
                            // location.reload();
                            console.log(data);
                            $('#bid_convert_unit_price').val(data.bid_convert_unit_price);
                            $('#bid_convert_total_price').val(data.bid_convert_total_price);
                        });
                }else{
                    $('#expected_price').val('');
                    $('#bid_convert_unit_price').val('');
                    $('#bid_convert_total_price').val('');
                }
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

                        //$('.demo-select2').select2();
                    }
                    $("#sub_category_id > option").each(function() {
                        if(this.value == '{{$workOrderProduct->sub_category_id}}'){
                            $("#sub_category_id").val(this.value).change();
                        }
                    });
                    get_subsubcategories();
                });
            }
            function get_subsubcategories() {
                var sub_category_id = $('#sub_category_id').val();
                console.log(sub_category_id)
                $.post('{{ route('products.get_subsubcategories_by_subcategory') }}', {
                    _token: '{{ csrf_token() }}',
                    sub_category_id: sub_category_id
                }, function (data) {
                    //console.log(data)
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
                    $("#sub_sub_category_id > option").each(function() {
                        if(this.value == '{{$workOrderProduct->sub_sub_category_id}}'){
                            $("#sub_sub_category_id").val(this.value).change();
                        }
                    });
                    $('.demo-select2').select2();
                    get_sub_sub_child_categories();
                });
            }

            function get_sub_sub_child_categories() {
                var sub_sub_category_id = $('#sub_sub_category_id').val();
                console.log(sub_sub_category_id)
                $.post('{{ route('products.get_subsubchildcategories_by_subsubcategory') }}', {
                    _token: '{{ csrf_token() }}',
                    sub_sub_category_id: sub_sub_category_id
                }, function (data) {
                    //console.log(data)
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
                    $("#sub_sub_child_category_id > option").each(function() {
                        if(this.value == '{{$workOrderProduct->sub_sub_child_category_id}}'){
                            $("#sub_sub_child_category_id").val(this.value).change();
                        }
                    });
                    $('.demo-select2').select2();
                    get_sub_sub_child_child_categories();

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
                    $("#sub_sub_child_child_category_id > option").each(function() {
                        if(this.value == '{{$workOrderProduct->sub_sub_child_child_category_id}}'){
                            $("#sub_sub_child_child_category_id").val(this.value).change();
                        }
                    });
                    $('.demo-select2').select2();
                    get_category_six();

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
                    $("#category_six_id > option").each(function() {
                        if(this.value == '{{$workOrderProduct->category_six_id}}'){
                            $("#category_six_id").val(this.value).change();
                        }
                    });
                    $('.demo-select2').select2();
                    get_category_seven();

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
                    $("#category_seven_id > option").each(function() {
                        if(this.value == '{{$workOrderProduct->category_seven_id}}'){
                            $("#category_seven_id").val(this.value).change();
                        }
                    });

                    get_category_eight();

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
                    $("#category_eight_id > option").each(function() {
                        if(this.value == '{{$workOrderProduct->category_eight_id}}'){
                            $("#category_eight_id").val(this.value).change();
                        }
                    });

                    get_category_nine();

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
                    $("#category_nine_id > option").each(function() {
                        if(this.value == '{{$workOrderProduct->category_nine_id}}'){
                            $("#category_nine_id").val(this.value).change();
                        }
                    });
                    get_category_ten();
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
                    $("#category_ten_id > option").each(function() {
                        if(this.value == '{{$workOrderProduct->category_ten_id}}'){
                            $("#category_ten_id").val(this.value).change();
                        }
                    });
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

            $("#thumbnail_img").spartanMultiImagePicker({
                fieldName: 'thumbnail_img',
                maxCount: 1,
                rowHeight: '200px',
                groupClassName: 'col-md-4 col-sm-4 col-xs-6',
                maxFileSize: '100000',
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
                    var altData = '<input type="text" placeholder="Thumbnails Alt" name="thumbnail_img_alt[]" class="form-control" required=""></div>'
                    //var index = index + 1;
                    //$('#photos_alt').append('<h4 id="abc_'+index+'">'+index+'</h4>')
                    //$('#thumbnail_img_alt').append('<div class="col-md-4 col-sm-4 col-xs-6" id="abc_'+index+'">'+altData+'</div>')
                },
                onRemoveRow : function(index){
                    var index = index + 1;
                    $(`#abc_${index}`).remove()
                },
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

            $('.remove-files').on('click', function() {
                $(this).parents(".col-md-4").remove();
            });

        });
        function get_total_pc_1(el){
            var nom = el.value;
            var pc_per_day = $('#pc_per_day').val();
            if(nom == ''){
                // alert('Number of machine must be greater than 0')
                // $('#pc_per_day').val('');
                $('#total_pc_per_day').val('');
                return false;
            }

            if (nom > 0 && pc_per_day > 0){
                var total_pc_per_day = nom * pc_per_day;
                $('#total_pc_per_day').val(total_pc_per_day);

            }
        }
        function get_total_pc(el){
            var pc_per_day = el.value;
            var nom = $('#nom').val();
            if(nom == ''){
                // alert('Number of machine must be greater than 0')
                // $('#pc_per_day').val('');
                $('#total_pc_per_day').val('');
                return false;
            }

            console.log(pc_per_day)
            if (nom > 0 && pc_per_day > 0){
                var total_pc_per_day = nom * pc_per_day;
                $('#total_pc_per_day').val(total_pc_per_day);

            }
        }
        function get_no_of_machine(el){
            var no_of_machine = el.value;
            var pc_per_day =  $('#pc_per_day').val();
            var multiply_total_pc_per_day = no_of_machine * pc_per_day;
            $('#total_pc_per_day').val(multiply_total_pc_per_day);
            var total_pc_per_day = $('#total_pc_per_day').val();
            var max_oq =  $('#max_oq').val();
            if (max_oq > 0 && pc_per_day > 0){

                var production_time =Math.round(max_oq / total_pc_per_day) ;
                $('#production_time').val(production_time);

                var finishing_time =  $('#finishing_time').val();
                if (finishing_time > 0){
                    var delivery_time = parseInt(production_time) + parseInt(finishing_time);
                    $('#delivery_time').val(delivery_time);
                }
            }


        }
        function get_production_time_1(el){
            var total_pc_per_day = el.value;
            var max_oq =  $('#max_oq').val();
            if(max_oq == ''){
                alert('Minimum order must be greater than 0')
                // $('#moq').val('');
                return false;
            }
            console.log(total_pc_per_day)
            if (max_oq > 0 && total_pc_per_day > 0){
                var production_time =Math.round(max_oq / total_pc_per_day) ;
                $('#production_time').val(production_time);
            }
        }
        function get_production_time(el){
            var max_oq = el.value;
            var total_pc_per_day =  $('#total_pc_per_day').val();
            if(max_oq == ''){
                // alert('Minimum order must be greater than 0')
                return false;
            }

            console.log(total_pc_per_day)
            if (max_oq > 0 && total_pc_per_day > 0){
                var production_time =Math.ceil(max_oq / total_pc_per_day) ;
                $('#production_time').val(production_time);
            }
            var finishing_time =  $('#finishing_time').val();
            if (finishing_time > 0){
                var delivery_time = parseInt(production_time) + parseInt(finishing_time);
                $('#delivery_time').val(delivery_time);
            }


        }

        $('#max_oq').on('blur',function () {
            var max_oq = $('#max_oq').val();
            var moq = $('#moq').val();
            //alert(max_oq);
            if (parseInt(max_oq) < parseInt(moq)){
                alert('Required order quantity must be greater than '+moq)
                $('#max_oq').val(null);
                $('#production_time').val(null);
                // get_production_time_1();
            }
        });
        function get_delivery_time(el){
            var finishing_time = el.value;
            var production_time =  $('#production_time').val();
            if(moq == ''){
                alert('Finishing time must be greater than 0')
                $('#finishing_time').val('');
                return false;
            }
            if (finishing_time > 0 && production_time > 0){
                var delivery_time = parseInt(production_time) + parseInt(finishing_time);
                $('#delivery_time').val(delivery_time);
            }
        }
        function get_bid_price(el){
            var bid_price = el.value;
            var qty = $('#quantity').val();
            if(qty == ''){
                alert('Quantity must be greater than 0')
                $('#unit_price').val('');
                $('#expected_price').val('');
                $('#bid_convert_unit_price').val('');
                $('#bid_convert_total_price').val('');
                return false;
            }
            console.log(bid_price)
            if(qty > 0 && bid_price > 0) {
                $.post('{{ route('bid.price.convert') }}',
                    {
                        _token: '{{ csrf_token() }}',
                        bid_price: bid_price,
                        qty: qty
                    },
                    function (data) {
                        // location.reload();
                        console.log(data);
                        $('#bid_convert_unit_price').val(data.bid_convert_unit_price);
                        $('#bid_convert_total_price').val(data.bid_convert_total_price);
                    });
            }else{
                $('#expected_price').val('');
                $('#bid_convert_unit_price').val('');
                $('#bid_convert_total_price').val('');
            }
        }

        function get_loading_bid_price(){
            var bid_price = $('#unit_price').val();
            var qty = $('#quantity').val();
            console.log(bid_price)
            $.post('{{ route('bid.price.convert') }}',
                {
                    _token:'{{ csrf_token() }}',
                    bid_price:bid_price,
                    qty:qty
                },
                function(data){
                    // location.reload();
                    console.log(data);
                    $('#bid_convert_unit_price').val(data.bid_convert_unit_price);
                    $('#bid_convert_total_price').val(data.bid_convert_total_price);
                });
        }

    </script>
@endpush
