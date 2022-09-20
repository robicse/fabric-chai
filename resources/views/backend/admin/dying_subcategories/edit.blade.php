@extends('backend.layouts.master')
@section("title","Edit Dying Subcategory")
@push('css')
    <link rel="stylesheet" href="{{asset('backend/plugins/select2/select2.min.css')}}">
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
                        <li class="breadcrumb-item active">Edit Dying Subcategory</li>
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
                        <h3 class="card-title float-left">Edit Dying Subcategory</h3>
                        <div class="float-right">
                            <a href="{{route('admin.dying-sub-categories.index')}}">
                                <button class="btn btn-success">
                                    <i class="fa fa-backward"> </i>
                                    Back
                                </button>
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{route( 'admin.dying-sub-categories.update',$dyingSubcategory->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">Name (EN)</label>
                                    <input type="text" class="form-control" name="name" value="{{$dyingSubcategory->name}}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="name_bn">Name (BN)</label>
                                    <input type="text" class="form-control" name="name_bn" id="name_bn" value="{{$dyingSubcategory->name_bn}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="dying_category_id">Dying Category Name (@lang('website.Optional')) </label>
                                    <select name="dying_category_id" id="dying_category_id" class="form-control select2" required>
                                        @foreach(\App\Model\DyingCategory::all() as $category)
                                            <option value="{{$category->id}}" {{$dyingSubcategory->dying_category_id == $category->id ? 'Selected' : '' }}>{{$category->name}}</option>
                                        @endforeach
                                    </select>
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
