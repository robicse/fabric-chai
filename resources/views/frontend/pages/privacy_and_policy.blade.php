@extends('frontend.layouts.master')
@section('title', 'Privacy And Policy')
@push('css')
{{--    <link rel="stylesheet" href="{{asset('frontend-shop/assets/css/style.css')}}">--}}
    <style>
        .p_top{
            padding-top: 20px;
        }
    </style>
@endpush
@section('content')
    <main id="content" role="main" class="bg-white">
        <!-- breadcrumb -->
        <div class="bg-gray-13 bg-md-transparent">
            <div class="container">
            </div>
        </div>

        <div class="container p_top" >
            <div class="mb-12 text-center">
                <h1>@lang('website.Privacy and Policy')</h1>
            </div>

            <div class="mb-10">
                @if(!empty($privacy_and_policy))
                    {!! getDescriptionByBnEn($privacy_and_policy) !!}
                @endif
            </div>

        </div>
    </main>
@endsection
@push('js')
@endpush
