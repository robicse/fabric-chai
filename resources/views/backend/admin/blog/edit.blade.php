@extends('backend.layouts.master')
@section("title","Edit Blog")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/custom-datepicker.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Blog</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Edit Blog</li>
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
                        <h3 class="card-title float-left">Edit Blog</h3>
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
                    <form role="form" action="{{route('admin.blogs.update',$blog->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body ">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="title">Title EN (@lang('website.Optional')) </label>
                                    <input type="text" class="form-control" name="title" id="title" value="{{$blog->title}}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="slug">Slug (SEO Url) (@lang('website.Optional')) <small class="text-danger">Change slug
                                            <a href="#" data-toggle="modal" data-target="#exampleModal">Click Here</a></small>
                                    </label>
                                    <input type="text" id="slug" name="" class="form-control" value="{{$blog->slug}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="title_bn">Title BN (@lang('website.Optional')) </label>
                                <input type="text" class="form-control" name="title_bn" id="title_bn" value="{{$blog->title_bn}}" required>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="author">Author Name EN (@lang('website.Optional')) </label>
                                    <input type="text" class="form-control" name="author" id="author" value="{{$blog->author}}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="author_bn">Author Name BN (@lang('website.Optional')) </label>
                                    <input type="text" class="form-control" name="author_bn" id="author_bn"  value="{{$blog->author_bn}}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <img src="{{asset('uploads/blogs/'.$blog->image)}}" alt="" width="50" height="50"><br>
                                    <label for="image">Blog Image (@lang('website.Optional')) </label>
                                    <input type="file" class="form-control" name="image" id="image" >
                                </div>
                                <div class="form-group col-md-6" style="margin-top: 50px;">
                                    <label for="image_alt">Image Alt (SEO Purpose) (@lang('website.Optional')) </label>
                                    <input type="text" class="form-control" name="image_alt" value="{{$blog->image_alt}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description">Description EN (@lang('website.Optional')) </label>
                                <textarea name="description" id="description" class="form-control"  rows="3">{!! $blog->description !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="description_bn">Description BN (@lang('website.Optional')) </label>
                                <textarea name="description_bn" id="description_bn" class="form-control"  rows="3">{!! $blog->description_bn !!}</textarea>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="meta_title">Meta Title (@lang('website.Optional')) </label>
                                    <input type="text" class="form-control" name="meta_title" id="meta_title" value="{{$blog->meta_title}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="meta_description">Meta Description (@lang('website.Optional')) </label>
                                    <textarea name="meta_description" id="meta_description" class="form-control"  rows="3">{{$blog->meta_description}}</textarea>
                                </div>
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
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">SEO URL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Please Change it very carefully.</p>
                    <form action="{{route('admin.blogs.slug-change')}}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{$blog->id}}">
                        <div class="form-gorup">
                            <label for="slug">Slug Edit</label>
                            <input type="text" name="slug" class="form-control" value="{{$blog->slug}}">
                        </div>
                        <br>
                        <button class="btn btn-success" type="submit">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@push('js')
    {{--    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>--}}
{{--    <script src="//cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>--}}
    <script src="https://cdn.ckeditor.com/4.19.1/standard-all/ckeditor.js"></script>
    <script src="{{asset('backend/plugins/ckeditor/ckeditor.js')}}"></script>
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
{{--    <script>--}}
{{--        CKEDITOR.replace( 'description', {--}}
{{--            filebrowserUploadUrl: "{{route('admin.ckeditor.upload', ['_token' => csrf_token() ])}}",--}}
{{--            filebrowserUploadMethod: 'form'--}}
{{--        });--}}
{{--        CKEDITOR.replace( 'description_bn', {--}}
{{--            filebrowserUploadUrl: "{{route('admin.ckeditor.upload', ['_token' => csrf_token() ])}}",--}}
{{--            filebrowserUploadMethod: 'form'--}}
{{--        });--}}
{{--        CKEDITOR.replace( 'description' );--}}
{{--        CKEDITOR.replace( 'description_bn' );--}}

{{--    </script>--}}
@endpush
