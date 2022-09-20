@extends('backend.layouts.master')
@section("title","FAQ Add")
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
                        <li class="breadcrumb-item active">FAQ Add</li>
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
                        <h3 class="card-title float-left">Add FAQ</h3>
                        <div class="float-right">
                            <a href="{{route('admin.faqs.index')}}">
                                <button class="btn btn-success">
                                    <i class="fa fa-backward"> </i>
                                    Back
                                </button>
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{route('admin.faqs.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="question">Question (EN)</label>
                                <input type="text" class="form-control" name="question" placeholder="Enter Question (EN)" required>
                            </div>
                            <div class="form-group">
                                <label for="question_bn">Question (BN)</label>
                                <input type="text" class="form-control" name="question_bn" placeholder="Enter Question (BN)" required>
                            </div>
                            <div class="form-group">
                                <label for="answer">Answer (EN)</label>
                                <textarea name="answer" class="form-control" rows="3" placeholder="Enter Answer (EN)" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="answer_bn">Answer (BN)</label>
                                <textarea name="answer_bn" class="form-control" rows="3" placeholder="Enter Answer (BN)" required></textarea>
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
        CKEDITOR.replace( 'answer' );
        CKEDITOR.replace( 'answer_bn' );
    </script>
@endpush
