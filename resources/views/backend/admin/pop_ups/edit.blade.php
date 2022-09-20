@extends('backend.layouts.master')
@section("title","Pop-Ups")
@push('css')

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
                        <li class="breadcrumb-item active">Edit Pop-Up</li>
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
                        <h3 class="card-title float-left">Edit Pop-Up</h3>
                        <div class="float-right">
                            <a href="{{route('admin.dying-categories.index')}}">
                                <button class="btn btn-success">
                                    <i class="fa fa-backward"> </i>
                                    Back
                                </button>
                            </a>
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{route('admin.pop-ups.update',$popUp->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="description">Description (EN)</label>
                                <textarea name="description" id="description_en" class="form-control"  rows="5">{!! $popUp->description !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="description_bn">Description (BN)</label>
                                <textarea name="description_bn" id="description_bn" class="form-control"  rows="5">{!! $popUp->description_bn !!}</textarea>
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

    <script>
        CKEDITOR.replace( 'description_en' );
        CKEDITOR.replace( 'description_bn' );
    </script>
@endpush
