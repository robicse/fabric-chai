@extends('frontend.layouts.master')
@section('title','Blogs')
@push('css')
    <style>
       .font_18{
         font-size: 18px!important;
       }
       .read_color{
           color: #2E9546;
       }
       h1{
           font-size: 20px;
       }

    </style>
@endpush
@section('content')
    <!-- breadcrumb -->
    <div class="full-row bg-light overlay-dark py-5">
        <div class="container">
            <div class="row text-center text-white">
                <div class="col-12">
                    <h3 class="mb-2 text-primary">@lang('website.Blogs')</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
    <div class="full-row">
        <div class="container">
            <div class="row row-cols-md-3 row-cols-1 g-4">
                @foreach( $blogs as $blog)
                    <div class="col">
                        <div class="thumb-blog-simple transation hover-img-zoom">
                            <div class="post-image overflow-hidden">
                                <a href="{{route('blog-details',$blog->slug)}}"> <img class="lazyload" src="{{ asset('frontend/assets/images/placeholder.jpg') }}"  data-src="{{asset('uploads/blogs/'.$blog->image)}}" alt="Image not found!"> </a>
                            </div>
                            <div class="post-content py-3">
                                <div class="post-meta font-mini text-uppercase list-color-light mb-1">
                                    <a href="{{route('blog-details',$blog->slug)}}"><span>{{getAuthorByBnEn($blog)}}</span></a>
                                </div>
                                <h1><a href="{{route('blog-details',$blog->slug)}}" class="transation text-dark hover-text-primary d-block">{{getTitleByBnEn($blog)}}</a></h1>
                                <p>{!! Str::limit(getShortDescriptionByBnEn($blog), 150) !!} <span class="text-bold font_18" ><a class="read_color" href="{{route('blog-details',$blog->slug)}}">@lang('website.Read More')</a></span></p>
                                <div class="date text-primary font-small text-uppercase"><span>{{getDateConvertByBnEn($blog->created_at)}}</span></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
