@extends('backend.layouts.master')
@section("title","Edit About Us Content")
@push('css')

@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit About Us Content</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Edit About Us Content</li>
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
                        <h3 class="card-title float-left">Edit About Us Content</h3>
                        <div class="float-right">
                            <a href="{{route('admin.about-us.index')}}">
                                <button class="btn btn-success">
                                    <i class="fa fa-backward"> </i>
                                    Back
                                </button>
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{route('admin.about-us.update',$about_us->id)}}" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="card-body">
                            <img src="{{url($about_us->image)}}" width="100" height="100">
                            <div class="form-group">
                                <label for="image">Image (@lang('website.Optional'))  </label>
                                <input type="file" class="form-control" name="image" value="{{$about_us->image}}" id="image" >
                            </div>
                            <div class="form-group">
                                <label for="description">Description (EN) (@lang('website.Optional')) </label>
                                <textarea name="description" id="description" class="form-control" >{!! $about_us->description !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="description_bn">Description (BN) (@lang('website.Optional')) </label>
                                <textarea name="description_bn" id="description_bn" class="form-control">{!! $about_us->description_bn !!}</textarea>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@stop
@push('js')
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace( 'description' );
        CKEDITOR.replace( 'description_bn' );
    </script>
@endpush
