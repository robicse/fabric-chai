@extends('backend.layouts.master')
@section("title","Add Industry Sub Category")
@push('css')

@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Industry Sub Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Add Industry Sub Category</li>
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
                        <h3 class="card-title float-left">Add Industry Sub Category</h3>
                        <div class="float-right">
                            <a href="{{route('admin.industry-sub-categories.index')}}">
                                <button class="btn btn-success">
                                    <i class="fa fa-backward"> </i>
                                    Back
                                </button>
                            </a>
                        </div>
                    </div>



                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{route('admin.industry-sub-categories.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="industry_category_id">Industry Category Name</label>
                                <select name="industry_category_id" id="industry_category_id" class="form-control select2">
                                    @foreach($industryCategories as $industryCategory)
                                        <option value="{{$industryCategory->id}}">{{$industryCategory->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">Name EN</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name English" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="name_bn">Name BN (@lang('website.Optional'))</label>
                                    <input type="text" class="form-control" name="name_bn" id="name_bn"
                                           placeholder="Enter Name Bangla">
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

@endpush
