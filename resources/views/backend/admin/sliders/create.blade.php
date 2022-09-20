@extends('backend.layouts.master')
@section("title","Slider Add")
@push('css')

@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Slider Add</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Slider Add</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
<section class="content" style="padding-top: 20px;">
    <div class="row">
        <div class="col-8 offset-2">
            <!-- general form elements -->
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title float-left">Add Sliders</h3>
                    <div class="float-right">
                        <a href="{{route('admin.sliders.index')}}">
                            <button class="btn btn-success">
                                <i class="fa fa-backward"> </i>
                                Back
                            </button>
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" action="{{route('admin.sliders.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title"
                                   placeholder="Enter Title">
                        </div>
                        <div class="form-group">
                            <label for="image">Slider Image (@lang('website.Optional')) <small>(size: 1920 * 1170 pixel)</small></label>
                            <input type="file" class="form-control" name="image" id="image" >
                        </div>
                        <div class="form-group">
                            <label for="url">Url (@lang('website.Optional'))</label>
                            <input type="url" class="form-control" name="url" id="url"
                                   placeholder="Enter link">
                        </div>
                        <div class="form-group">
                            <label for="date_duration">Date Duration</label>
                            <input type="date" class="form-control" name="date_duration" id="date_duration" >
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

@endpush
