@extends('frontend.layouts.master')
@section('title')
    @if($blog->meta_title)
        {{$blog->meta_title}}
    @else
        {{$blog->title}}
    @endif
@endsection
@section('meta')
    @if( $blog->meta_title)
        <meta name="meta_title" content="{{$blog->meta_title}}"/>
    @endif
    @if( $blog->meta_description)
        <meta name="meta_description" content="{{ $blog->meta_description }}"/>
    @endif
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="full-row bg-light overlay-dark py-5">
        <div class="container">
            <div class="row text-center text-white">
                <div class="col-12">
                    <h3 class="mb-2 text-primary">@lang('website.Blog Details')</h3>
                </div>

            </div>
        </div>
    </div>
    <!-- breadcrumb -->

    <div class="full-row">
        <div class="container">
            <div class="row">

                <div class="single-post">
                    <div class="single-post-title">
                        <h3 class="mb-2 text-secondary">{{getTitleByBnEn($blog) }}</h3>
                        <div class="post-meta mb-4">
                            <i class="flaticon-user-silhouette flat-mini"></i> <span>By {{getAuthorByBnEn($blog)}}</span>
                            <i class="flaticon-calendar flat-mini"></i> <span>{{getDateConvertByBnEn($blog->created_at)}}</span>
                        </div>
                    </div>
                    <div class="post-image">
                        <img src="{{asset('uploads/blogs/'.$blog->image)}}" alt="">
                    </div>
                    <div class="post-content pt-4 mb-5">
                        <p class="text-justify">{!! getDescriptionByBnEn($blog) !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
