@extends('frontend.layouts.master')
@section('title','About Us')
@section('content')
    <!--==================== About Owner Section Start ====================-->
    <div class="full-row bg-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 text-justify">
                   <p>{!! getDescriptionByBnEn($about_us) !!}</p>
                </div>
                <div class="col-lg-5 col-md-12">
                    <img class="sm-mb-30" src="{{url($about_us->image)}}" alt="Image not found!">
                </div>
            </div>
        </div>
    </div>
    <!--==================== About Owner Section End ====================-->
@endsection
