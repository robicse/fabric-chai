@extends('backend.layouts.master')
@section("title","Edit Admin Products")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/select2/select2.min.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Admin Products</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Edit Admin Products</li>
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
                        <h3 class="card-title float-left">Edit Admin Products</h3>
                        <div class="float-right">
                            <a href="{{route('admin.admin-products.index')}}">
                                <button class="btn btn-success">
                                    <i class="fa fa-backward"> </i>
                                    Back
                                </button>
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{route('admin.admin-products.update',$adminProduct->id)}}" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">Product Name (EN)</label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{$adminProduct->name}}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="name_bn">Product Name (BN) (@lang('website.Optional')) </label>
                                    <input type="text" class="form-control" name="name_bn" id="name_bn" value="{{$adminProduct->name_bn}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="slug">Slug (SEO Url) (@lang('website.Optional')) <small class="text-danger">Change slug
                                            <a href="#" data-toggle="modal" data-target="#exampleModal">Click Here</a></small>
                                    </label>
                                    <input type="text" id="slug" name="" class="form-control" value="{{$adminProduct->slug}}" readonly>
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group col-md-4" style="margin-top: 30px;">
                                    <label for="home_category_id">Category Name (@lang('website.Optional')) </label>
                                    <select name="home_category_id" id="home_category_id" class="form-control select2">
                                        @foreach($homeCategories as $homeCategory)
                                            <option value="{{$homeCategory->id}}" {{$homeCategory->id == $adminProduct->home_category_id ? 'selected' : ''}}>{{$homeCategory->category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <img src="{{url($adminProduct->image)}}" width="30" height="30"><br>
                                    <label for="image">Product Image (@lang('website.Optional')) </label>
                                    <input type="file" class="form-control" name="image" id="image" >
                                </div>
                                <div class="form-group col-md-4" style="margin-top: 30px;">
                                    <label for="image_alt">Image Alt (SEO Purpose) (@lang('website.Optional')) </label>
                                    <input type="text" class="form-control" name="image_alt" value="{{$adminProduct->image_alt}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="long_description">Product Description (EN) (@lang('website.Optional')) </label>
                                <textarea name="long_description" id="long_description" class="form-control"  rows="5">{!! $adminProduct->long_description !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="long_description_bn">Product Description (BN) (@lang('website.Optional')) </label>
                                <textarea name="long_description_bn" id="long_description_bn" class="form-control"  rows="5">{!! $adminProduct->long_description_bn !!}</textarea>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="phone">Meta Title (@lang('website.Optional')) </label>
                                    <input type="text" class="form-control" name="meta_title" id="meta_title" value="{{$adminProduct->meta_title}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="meta_desc">Meta Description (@lang('website.Optional')) </label>
                                    <textarea name="meta_description" id="meta_desc" class="form-control"  rows="3">{{$adminProduct->meta_description}}</textarea>
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
                    <h5 class="modal-title" id="exampleModalLabel">SEO URL (@lang('website.Optional')) </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Please Change it very carefully.</p>
                    <form action="{{route('admin.admin-products.slug-change')}}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{$adminProduct->id}}">
                        <div class="form-group">
                            <label for="slug">Slug Edit</label>
                            <input type="text" name="slug" class="form-control" value="{{$adminProduct->slug}}">
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
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script src="{{asset('backend/plugins/select2/select2.full.min.js')}}"></script>

    <script>
        CKEDITOR.replace( 'long_description' );
        CKEDITOR.replace( 'long_description_bn' );
        $('.select2').select2();
    </script>
@endpush
