@extends('backend.layouts.master')
@section("title","Pop-Ups")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/custom-datepicker.css')}}">
    <style>

    </style>
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pop-Ups Settings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Pop-Ups Settings</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content" style="margin-top: 50px">
        <div class="row">
            <div class="col-8 offset-2">
                <!-- general form elements -->
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title float-left">Pop-Ups Settings</h3>
                        <div class="float-right">
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                        <label>Pop Up Types <small class="text-info"> </small></label>
                        <div class="input-group">
                            <select name="type" id="type" onchange="getType()" class="form-control" required>
                                <option selected disabled>Choose One</option>
                                <option value="seller_product_entry">Seller Product Entry</option>
                                <option value="buyer_product_entry">Buyer Product Entry</option>
                                <option value="seller_bid_submit">Seller Bid Submit</option>
                                <option value="buyer_bid_submit">Buyer Bid Submit</option>

                            </select>
                        </div>
                        <div class="text-center" id="editorText" >
                            <h2 class="text-center text-info p-3"><i class="fa fa-info-circle"></i> Please select pop-up type first.</h2>
                        </div>
                        <div class="" id="editorDiv" style="display: none;">
                            <form id="pageSubmit" action="javascript:void(0)" enctype="multipart/form-data">
                                <div class="input-group-append" style="width: 100%;margin-top: 20px">
                                    <textarea name="description_en" id="description_en" class="form-control value"></textarea>
                                </div>
                                <div class="input-group-append" style="width: 100%;margin-top: 20px">
                                    <textarea name="description_bn" id="description_bn" class="form-control value"></textarea>
                                </div>
                                <div class="input-group-append pt-2">
                                    <button type="submit"  class="btn btn-info w-25">Update</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@stop
@push('js')
    <script src="//cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
    <script src="{{asset('backend/plugins/ckeditor/ckeditor.js')}}"></script>
    <script>
        {{--CKEDITOR.replace( 'value', {--}}
        {{--    filebrowserUploadUrl: "{{route('admin.ckeditor.upload', ['_token' => csrf_token() ])}}",--}}
        {{--    filebrowserUploadMethod: 'form'--}}
        {{--});--}}
        //get value
        function getType() {
            //alert('onchnged')
            var type = $('#type').val();
            if (type !== "") {
                $.post('{{route('admin.pop-ups.editor.show')}}', {
                    _token: '{{ csrf_token() }}',
                    type: type,
                }, function (data) {
                    CKEDITOR.instances.value.setData(data.description_en);
                    // CKEDITOR.instances.value.setData(data.description_bn);
                    $('#editorText').hide();
                    $('#editorDiv').show();
                    $("#description_en").val(data.description_en);
                    $("#description_bn").val(data.description_bn);
                });
            }
        }

        //value post
        //for Terms And Condition
        {{--$("#pageSubmit").submit(function(event){--}}
        {{--    event.preventDefault();--}}
        {{--    var updateData = CKEDITOR.instances.value.getData();--}}
        {{--    var updateValue = $('#type').val();--}}
        {{--    //var formData = {'type': 'about_us', 'value': 'klasdfjkasflasdflk'}--}}
        {{--    var formData = new FormData(this);--}}
        {{--    formData.append('value', updateData)--}}
        {{--    formData.append('type', updateValue)--}}
        {{--    console.log(formData)--}}
        {{--    $.ajaxSetup({--}}
        {{--        headers: {--}}
        {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        {{--        }--}}
        {{--    });--}}
        {{--    $.ajax({--}}
        {{--        url: "{{url('/admin/page/data/update')}}",--}}
        {{--        type: 'POST',--}}
        {{--        enctype: 'multipart/form-data',--}}
        {{--        data: formData,--}}
        {{--        cache:false,--}}
        {{--        contentType: false,--}}
        {{--        processData: false,--}}
        {{--        success: function(data) {--}}
        {{--            if (data){--}}
        {{--                $('.page_image').attr('src', "{{url('/')}}/"+ data.image);--}}
        {{--                toastr.success('Data Updated Successfully');--}}
        {{--            }else {--}}
        {{--                toastr.error('Something went wrong!!');--}}
        {{--            }--}}
        {{--        }--}}
        {{--    });--}}
        {{--})--}}

    </script>
@endpush
