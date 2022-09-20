@extends('backend.layouts.master')
@section("title","Education Degree Edit")
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
                        <li class="breadcrumb-item active">Education Degree Edit</li>
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
                        <h3 class="card-title float-left">Edit Education Degree</h3>
                        <div class="float-right">
                            <a href="{{route('admin.education-degrees.index')}}">
                                <button class="btn btn-success">
                                    <i class="fa fa-backward"> </i>
                                    Back
                                </button>
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{route('admin.education-degrees.update',$educationDegree->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="education_level_id">Education Levels (@lang('website.Optional')) </label>
                                <select name="education_level_id" id="education_level_id" class="form-control select2">
                                    @foreach(\App\Model\EducationLevel::all() as $educationLevel)
                                        <option value="{{$educationLevel->id}}" {{$educationDegree->education_level_id == $educationLevel->id? 'Selected':''}}>{{$educationLevel->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Degree Name</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{$educationDegree->name}}" required>
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
