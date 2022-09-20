@extends('frontend.layouts.master')
@section('title','Jobs')

@push('css')
    <style>
        .job_card{
            max-width: 18rem;
            margin: 10px;
        }
        .text_purple{
            color: purple;
        }
    </style>
@endpush
@section('content')

    <!-- breadcrumb -->
    <div class="full-row">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <a href="{{route('become-an-employee')}}">
                        <div class="card border-secondary mb-3 bg-gray-light job_card">
                            <div class="card-body text-secondary">
                                <h5 class="text-center text_purple"> <i class="fa fa-user-graduate"></i> </h5>
                                <div class="text-center">
                                    <h5 class="text_purple">Become an Employee</h5> <hr class="text_purple">

                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <a href="#">
                        <div class="card border-secondary mb-3 bg-gray-light job_card">
                            <div class="card-body text-secondary">
                                <h5 class="text-center text_purple"> <i class="fa fa-industry"></i> </h5>
                                <div class="text-center">
                                    <h5 class="text_purple">Become an Employer</h5> <hr class="text_purple">

                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
