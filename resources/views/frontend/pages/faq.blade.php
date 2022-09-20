@extends('frontend.layouts.master')
@section('title', 'Faqs')
@push('css')
    <style>
        .collapsible {
            background-color: #777;
            color: white;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
        }

        .active, .collapsible:hover {
            background-color: #555;
        }

        .content {
            padding: 0 18px;
            display: none;
            overflow: hidden;
            background-color: #f1f1f1;
        }
        .faq_content{
            padding: 50px; margin-top: -20px
        }
        .font_18{
            font-size: 18px;
        }
        .plus_icon{
            float: right!important;
        }
    </style>
@endpush
@section('content')
    <main id="content" role="main" class="bg-white">
        <div class="container">
            <div class="mb-12 text-center">
                <img src="{{asset('frontend/photos/faq.webp')}}" width="340" height="248">
                <h3>@lang('website.FAQ')</h3>
                <p>@lang('website.Get answers to the most frequently asked questions.')</p>
            </div>
            <div class="mb-5 faq_content">
                @foreach(\App\Model\Faq::all() as $key => $faq)
                <div class="mb-3">
                    <button type="button" class="collapsible font_18">{{$key+1}}. {{getQuestionByBnEn($faq)}}<i class="fa fa-plus plus_icon" ></i></button>
                    <div class="content">
                        <p>{!! getAnswerByBnEn($faq) !!}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
@push('js')
    <script>
        var coll = document.getElementsByClassName("collapsible");
        var i;

        for (i = 0; i < coll.length; i++) {
            coll[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var content = this.nextElementSibling;
                if (content.style.display === "block") {
                    content.style.display = "none";
                } else {
                    content.style.display = "block";
                }
            });
        }
    </script>

@endpush
