@extends('backend.layouts.master')
@section("title","Add Subcategory")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/select2/select2.min.css')}}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Subcategory</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Add Subcategory</li>
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
                    <h3 class="card-title float-left">Add Subcategory</h3>
                    <div class="float-right">
                        <a href="{{route('admin.sub-categories.index')}}">
                            <button class="btn btn-success">
                                <i class="fa fa-backward"> </i>
                                Back
                            </button>
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" action="{{route( Request::segment(2) == 'sub-categories'? 'admin.sub-categories.store':'admin.work-order-sub-categories.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="name_bn">নাম (@lang('website.Optional'))</label>
                                <input type="text" class="form-control" name="name_bn" id="name_bn" placeholder="বাংলা নাম লিখুন" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category_id">Category Name (@lang('website.Optional'))</label>
                            <select name="category_id" id="category_id" class="form-control select2">
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="phone">Meta Title (@lang('website.Optional'))</label>
                            <input type="text" class="form-control" name="meta_title" id="phone" placeholder="Enter meta title">
                        </div>
                        <div class="form-group">
                            <label for="meta_desc">Meta Description (@lang('website.Optional'))</label>
                            <textarea name="meta_description" id="meta_desc" class="form-control"  rows="3"></textarea>
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
    <script src="{{asset('backend/plugins/select2/select2.full.min.js')}}"></script>
    <script>
        //Initialize Select2 Elements
        $('.select2').select2();
        /*$('.textarea').wysihtml5({
            toolbar: { fa: true }
        })*/
    </script>
@endpush
