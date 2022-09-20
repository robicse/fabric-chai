@extends('frontend.layouts.master')
@section('title', 'Stay Safe')
@push('css')
{{--    <link rel="stylesheet" href="{{asset('frontend-shop/assets/css/style.css')}}">--}}
@endpush
@section('content')
    <main id="content" role="main">
        <div class="container">
            <div class="mb-12 text-center">
                <h1>@lang('website.Stay Safe')</h1>
            </div>

            <div class="mb-10">
                @if(!empty($staySafe))
                    {!! getDescriptionByBnEn($staySafe) !!}
                @endif
            </div>
        </div>
    </main>
@endsection
@push('js')
@endpush
