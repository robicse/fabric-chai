@extends('backend.layouts.master')
@section("title","Edit Seller Profile")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #212529;
            border: 1px solid #aaa;
            border-radius: 4px;
            cursor: default;
            float: left;
            margin-right: 5px;
            margin-top: 5px;
            padding: 0 5px;
        }
    </style>
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Edit Seller Profile</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-10 offset-1">
                <!-- general form elements -->
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title float-left">Edit Seller Profile</h3>
                        <div class="float-right">
                            <a href="{{route('admin.seller.profile.show',encrypt($sellerInfo->id))}}">
                                <button class="btn btn-success">
                                    <i class="fa fa-backward"> </i>
                                    Back
                                </button>
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" class="" action="{{route('admin.seller.profile.update',$sellerInfo->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name" class="">Name</label>
                                    <input type="text" value="{{$sellerInfo->name}}" name="name" class="form-control" id="name" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="phone">Phone (@lang('website.Optional'))</label>
                                    <input type="number" value="{{$sellerInfo->phone}}" name="phone" class="form-control" id="phone" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">Email (@lang('website.Optional'))</label>
                                    <input type="email" value="{{$sellerInfo->email}}" name="email" class="form-control" id="email" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="address">Address (@lang('website.Optional'))</label>
                                    <input type="text" value="{{$sellerInfo->address}}" name="address" class="form-control" id="address" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="company_name">Company Name (@lang('website.Optional'))</label>
                                    <input type="text" value="{{$sellerInfo->seller->company_name}}" name="company_name" class="form-control" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="designation">Designation</label>
                                    <input type="text" value="{{$sellerInfo->seller->designation}}" name="designation" class="form-control" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="company_phone">Company Phone (@lang('website.Optional'))</label>
                                    <input type="text" value="{{$sellerInfo->seller->company_phone}}" name="company_phone" class="form-control" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="company_email">Company Email (@lang('website.Optional'))</label>
                                    <input type="email" value="{{$sellerInfo->seller->company_email}}" name="company_email" class="form-control" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="company_address">Company Address (@lang('website.Optional'))</label>
                                    <input type="text" value="{{$sellerInfo->seller->company_address}}" name="company_address" class="form-control">
                                </div>
                                @php
                                    $divisions = \App\Model\Division::all();
                                @endphp
                                <div class="form-group col-md-6" id="division_area">
                                    <label for="division_id">Division (@lang('website.Optional')) <span class="required">*</span>  </label>
                                    <select name="division_id" id="division_id" class="form-control select2" >
                                        <option value="">Select</option>
                                        @foreach($divisions as $division)
                                            <option value="{{$division->id}}" {{$sellerInfo->seller->division_id ==$division->id ? 'selected':''}}>{{$division->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6" id="district_area">
                                    <label for="district_id">District <span class="required">*</span> </label>
                                    <select name="district_id" id="district_id" class="form-control select2" >
                                    </select>
                                </div>
                                @php
                                    $categories = \App\Model\Category::all();
                                @endphp
                                <div id="category_area" class="form-group col-md-6">
                                    <label for="selected_category">Type your Product willing to sell (@lang('website.Optional'))</label>
                                    <select name="selected_category[]" id="selected_category" class="form-control select2" multiple>
                                        @foreach($categories as $category)
                                            @php
                                                $ids = explode(',',$sellerInfo->seller->selected_category)
                                            @endphp
                                            @if(!empty($ids))
                                                @foreach($ids as $id)
                                                    <option value="{{$category->id}}" {{ $id == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                                                @endforeach
                                            @else
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row" style="background-color: #fff;">
                                <label class="control-label ml-3">Trade Licence Image (@lang('website.Optional'))</label>
                                <div class="col-sm-10">
                                    <div class="row" id="trade_licence" style="background-color: #fff;">
                                        @if ($sellerInfo->seller->trade_licence)
                                            <div class="col-md-4 col-sm-4 col-xs-6">
                                                <div class="img-upload-preview">
                                                    <a href="{{ url($sellerInfo->seller->trade_licence) }}"> <img loading="lazy"  src="{{ url($sellerInfo->seller->trade_licence) }}" alt="" class="img-responsive"> </a>
                                                    <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row" id="trade_licence_alt"></div>
                                </div>
                            </div>

                            <div class="form-group row" style="background-color: #fff;">
                                <label class="control-label ml-3">National ID Image (Front) (@lang('website.Optional'))</label>
                                <div class="col-sm-10">
                                    <div class="row" id="nid_front">
                                        @if ($sellerInfo->seller->nid_front != null)
                                            <div class="col-md-4 col-sm-4 col-xs-6">
                                                <div class="img-upload-preview">
                                                    <a href="{{ url($sellerInfo->seller->nid_front) }}"> <img loading="lazy"  src="{{ url($sellerInfo->seller->nid_front) }}" alt="" class="img-responsive"></a>
                                                    <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row" id="nid_alt"></div>
                                </div>
                            </div>
                            <div class="form-group row" style="background-color: #fff;">
                                <label class="control-label ml-3">National ID Image (Back) (@lang('website.Optional'))</label>
                                <div class="col-sm-10">
                                    <div class="row" id="nid_back">
                                        @if ($sellerInfo->seller->nid_back != null)
                                            <div class="col-md-4 col-sm-4 col-xs-6">
                                                <div class="img-upload-preview">
                                                    <a href="{{ url($sellerInfo->seller->nid_back) }}"> <img loading="lazy"  src="{{ url($sellerInfo->seller->nid_back) }}" alt="" class="img-responsive"></a>
                                                    <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row" id="nid_alt"></div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>

@stop
@push('js')
    <script src="{{asset('backend/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
    <script src="{{asset('backend/dist/js/spartan-multi-image-picker-min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2();
            get_district_by_division();
        });
        $('#division_id').on('change', function () {
            get_district_by_division();
        });
        function get_district_by_division() {
            var division_id = $('#division_id').val();
            //console.log(category_id)
            $.post('{{ route('get_district_by_division') }}', {
                _token: '{{ csrf_token() }}',
                division_id: division_id
            }, function (data) {
                $('#district_id').html(null);
                $('#district_id').append($('<option>', {
                    value: null,
                    text: null
                }));
                for (var i = 0; i < data.length; i++) {
                    $('#district_id').append($('<option>', {
                        value: data[i].id,
                        text: data[i].name
                    }));
                }
                $("#district_id > option").each(function() {
                    if(this.value == '{{$sellerInfo->seller->district_id}}'){
                        $("#district_id").val(this.value).change();
                    }
                });
            });
        }

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
