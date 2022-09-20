@extends('backend.layouts.master')
@section("title","Create Admin Products")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/select2/select2.min.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Admin Products</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Create Admin Products</li>
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
                        <h3 class="card-title float-left">Create Admin Products</h3>
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
                    <form role="form" action="{{route('admin.admin-products.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Product Name (EN) </label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter Product Name" required>
                            </div>
                            <div class="form-group">
                                <label for="name_bn">Product Name (BN) (@lang('website.Optional')) </label>
                                <input type="text" class="form-control" name="name_bn" id="name_bn" placeholder="Enter Product Name (BN)">
                            </div>
                            <div class="form-group">
                                <label for="home_category_id">Category Name (@lang('website.Optional')) </label>
                                <select name="home_category_id" id="home_category_id" class="form-control select2">
                                    @foreach($homeCategories as $homeCategory)
                                        <option value="{{$homeCategory->id}}">{{$homeCategory->category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="image">Product Image (@lang('website.Optional')) <small>(596px * 350px )*</small></label>
                                <input type="file" class="form-control" name="image" id="image" >
                            </div>
                            <div class="form-group">
                                <label for="long_description">Product Description (EN) (@lang('website.Optional')) </label>
                                <textarea name="long_description" id="long_description" class="form-control"  rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="long_description_bn">Product Description (BN) (@lang('website.Optional')) </label>
                                <textarea name="long_description_bn" id="long_description_bn" class="form-control"  rows="5"></textarea>
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
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script src="{{asset('backend/plugins/select2/select2.full.min.js')}}"></script>

    <script>
        CKEDITOR.replace( 'long_description' );
        CKEDITOR.replace( 'long_description_bn' );
        $('.select2').select2();
    </script>
@endpush
