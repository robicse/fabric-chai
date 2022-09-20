@extends('frontend.layouts.master')
@section('title', 'Return Refund Policy')
@push('css')
{{--    <link rel="stylesheet" href="{{asset('frontend-shop/assets/css/style.css')}}">--}}
    <style>
        .p_top_20{
            padding-top: 20px;
        }
    </style>
@endpush
@section('content')
    <main id="content" role="main" class="bg-white">
        <div class="container p_top_20">
            <div class="mb-12 text-center">
                <h1>@lang('website.Return Refund Policy')</h1>
            </div>

            <div class="mb-10">
                @if(!empty($return_refund_policy))
                    {!! getDescriptionByBnEn($return_refund_policy) !!}
                @endif
            </div>
        </div>
    </main>
@endsection
@push('js')
@endpush
