@extends('backend.layouts.master')
@section("title","Edit Category")
@push('css')

@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Edit Category</li>
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
                        <h3 class="card-title float-left">Edit Category</h3>
                        <div class="float-right">
                            <a href="{{route('admin.categories.index')}}">
                                <button class="btn btn-success">
                                    <i class="fa fa-backward"> </i>
                                    Back
                                </button>
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{route('admin.categories.update',$category->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{$category->name}}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="name_bn">নাম (@lang('website.Optional')) </label>
                                    <input type="text" class="form-control" name="name_bn" id="name_bn" value="{{$category->name_bn}}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="slug">Slug (SEO Url) (@lang('website.Optional')) <small class="text-danger">Change slug
                                            <a href="#" data-toggle="modal" data-target="#exampleModal">Click Here</a></small>
                                    </label>
                                    <input type="text" id="slug" name="" class="form-control" value="{{$category->slug}}" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <img src="{{asset('uploads/categories/'.$category->icon)}}" width="30" height="30" alt=""><br>
                                    <label for="icon">Image (@lang('website.Optional')) <small>(size: 300 * 300 pixel)</small></label>
                                    <input type="file" class="form-control" name="icon" id="icon" >
                                </div>
                                <div class="form-group col-md-6" style="margin-top: 30px;">
                                    <label for="image_alt">Image Alt (SEO Purpose) (@lang('website.Optional')) </label>
                                    <input type="text" class="form-control" name="image_alt" value="{{$category->image_alt}}">
                                </div>

{{--                                <div class="form-group col-md-4">--}}
{{--                                    <img src="{{asset('uploads/categories/banner/'.$category->banner_image)}}" width="30" height="30" alt="">--}}
{{--                                    <label for="banner_image">Banner Image <small>(size: 930 * 180 pixel)</small></label>--}}
{{--                                    <input type="file" class="form-control" name="banner_image" id="banner_image" >--}}
{{--                                </div>--}}
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="phone">Meta Title (@lang('website.Optional')) </label>
                                    <input type="text" class="form-control" name="meta_title" id="meta_title" value="{{$category->meta_title}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="meta_desc">Meta Description (@lang('website.Optional')) </label>
                                    <textarea name="meta_description" id="meta_desc" class="form-control"  rows="3">{{$category->meta_description}}</textarea>
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
                    <form action="{{route('admin.categories.slug-change')}}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{$category->id}}">
                        <div class="form-gorup">
                            <label for="slug">Slug Edit</label>
                            <input type="text" name="slug" class="form-control" value="{{$category->slug}}">
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

@endpush
