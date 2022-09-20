@extends('frontend.layouts.master')
@section('title', 'Cookies Policy')
@push('css')
{{--    <link rel="stylesheet" href="{{asset('frontend-shop/assets/css/style.css')}}">--}}
@endpush
@section('content')
    <main id="content" role="main">
        <div class="container">
            <div class="mb-12 text-center">
                <h1>@lang('website.Cookies Policy')</h1>
            </div>

            <div class="mb-10">
                @if(!empty($cookies_policy))
                    {!! getDescriptionByBnEn($cookies_policy) !!}
                @endif
            </div>
        </div>
    </main>
@endsection
@push('js')
@endpush
