@extends('frontend.layouts.master')

@section('title')
    @if($product->meta_title)
        {{$product->meta_title}}
    @else
        {{$product->name}}
    @endif
@endsection
@section('meta')
    @if( $product->meta_title)
        <meta name="meta_title" content="{{$product->meta_title}}"/>
    @endif
    @if( $product->meta_description)
        <meta name="meta_description" content="{{ $product->meta_description }}"/>
    @endif
@endsection

@section('content')
    <!-- breadcrumb -->
    <div class="full-row bg-light overlay-dark py-5">
        <div class="container">
            <div class="row text-center text-white">
                <div class="col-12">
                    <h3 class="mb-2 text-primary">@lang('website.Product Details')</h3>
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
                        <h3 class="mb-2 text-secondary">{{ getNameByBnEn($product) }}</h3>
                        <div class="post-meta mb-4">
                            <i class="flaticon-calendar flat-mini"></i> <span>{{getDateConvertByBnEn($product->created_at)}}</span>
                        </div>
                    </div>
                    <div class="post-image">
                        <img src="{{url($product->image)}}" alt="">
                    </div>
                    <div class="post-content pt-4 mb-5">
                        <p class="text-justify">{!! getLongDescriptionByBnEn($product) !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
