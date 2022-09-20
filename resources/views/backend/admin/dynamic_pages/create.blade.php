@extends('backend.layouts.master')
@section('title','Dynamic Pages Create')
@push('css')

@endpush
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="page-title">Dynamic Pages Blog</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Dynamic Pages Blog</li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-right">
                            <a href="{{route('admin.dynamic_pages.index')}}">
                                <button class="btn btn-success">
                                    <i class="fa fa-backward"> </i>
                                    Back
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body custom-edit-service">
                            <!-- Add Medicine -->
                            <form role="form" class="dc-formtheme dc-userform" method="post" action="{{route('admin.dynamic_pages.store')}}" enctype="multipart/form-data">
                                @csrf
                                <fieldset>
                                    <div class="form-group">
                                        <label for="name">Name (EN)</label>
                                        <input type="text" name="name" class="form-control" placeholder="Page Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="name_bn">Name (BN) (@lang('website.Optional')) </label>
                                        <input type="text" name="name_bn" class="form-control" placeholder="Page Name BN">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description (EN) (@lang('website.Optional')) </label>
                                        <textarea name="description" id="description" class="form-control"  rows="5"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="description_bn">Description (BN) (@lang('website.Optional')) </label>
                                        <textarea name="description_bn" id="description_bn" class="form-control"  rows="5"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_title">Meta Title (@lang('website.Optional')) </label>
                                        <input type="text" name="meta_title" class="form-control" placeholder="Meta Title">
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_description">Meta Description (@lang('website.Optional')) </label>
                                        <textarea name="meta_description" id="meta_description" class="form-control"  rows="3"></textarea>
                                    </div>

                                    <div class="form-group dc-btnarea">
                                        <input type="submit" class="dc-btn btn-info" value="Save">
                                    </div>
                                </fieldset>
                            </form>
                            <!-- /Add Medicine -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Wrapper -->

@endsection
@push('js')
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace( 'description' );
        CKEDITOR.replace( 'description_bn' );
    </script>
@endpush
