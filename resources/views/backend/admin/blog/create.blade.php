@extends('backend.layouts.master')
@section("title","Create Blog")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/custom-datepicker.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Blog</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Create Blog</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-8 offset-2">
                <!-- general form elements -->
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title float-left">Create Blog</h3>
                        <div class="float-right">
                            <a href="{{route('admin.blogs.index')}}">
                                <button class="btn btn-success">
                                    <i class="fa fa-backward"> </i>
                                    Back
                                </button>
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{route('admin.blogs.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Title EN</label>
                                <input type="text" class="form-control" name="title" id="title" placeholder="Enter Blog Title English" required>
                            </div>
                            <div class="form-group">
                                <label for="title_bn">Title BN (@lang('website.Optional')) </label>
                                <input type="text" class="form-control" name="title_bn" id="title_bn" placeholder="Enter Blog Title Bangla" required>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="author">Author Name EN (@lang('website.Optional')) </label>
                                    <input type="text" class="form-control" name="author" id="author" placeholder="Enter Blog Author Name English" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="author_bn">Author Name BN (@lang('website.Optional')) </label>
                                    <input type="text" class="form-control" name="author_bn" id="author_bn" placeholder="Enter Blog Author Name Bangla" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="image">Blog Image (@lang('website.Optional')) </label>
                                <input type="file" class="form-control" name="image" id="image" >
                            </div>
                            <div class="form-group">
                                <label for="description">Description EN (@lang('website.Optional')) </label>
                                <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="description_bn">Description BN (@lang('website.Optional')) </label>
                                <textarea name="description_bn" id="description_bn" class="form-control" rows="3"></textarea>
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@stop
@push('js')
    {{--    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>--}}
{{--    <script src="//cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>--}}
    <script src="https://cdn.ckeditor.com/4.19.1/standard-all/ckeditor.js"></script>
{{--    <script src="{{asset('backend/plugins/ckeditor/ckeditor.js')}}"></script>--}}
{{--    <script src="{{asset('backend/plugins/ckeditor/plugins/image2/plugin.js')}}"></script>--}}
    <script>
        CKEDITOR.replace('description', {
            extraPlugins: 'image2,uploadimage',
            filebrowserUploadUrl: "{{route('admin.ckeditor.upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form',

        });
        CKEDITOR.replace('description_bn', {
            extraPlugins: 'image2,uploadimage',
            filebrowserUploadUrl: "{{route('admin.ckeditor.upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form',

        });
    </script>
    <script>

        {{--CKEDITOR.replace( 'description', {--}}
        {{--    filebrowserUploadUrl: "{{route('admin.ckeditor.upload', ['_token' => csrf_token() ])}}",--}}
        {{--    filebrowserUploadMethod: 'form',--}}

        {{--});--}}
        // CKEDITOR.replace( 'description', {
        //     extraPlugins: 'image2'
        // } );
        {{--CKEDITOR.replace( 'description_bn', {--}}
        {{--    filebrowserUploadUrl: "{{route('admin.ckeditor.upload', ['_token' => csrf_token() ])}}",--}}
        {{--    filebrowserUploadMethod: 'form'--}}
        {{--});--}}
        {{--CKEDITOR.replace( 'description' );--}}
        {{--CKEDITOR.replace( 'description_bn' );--}}

        // CKEDITOR.extraPlugins('image2');

    </script>
@endpush
