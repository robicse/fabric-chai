
<style>
    .sign_in {
        width:135px;
        margin-top:5px;
    }
    .ecommerce-header .top-links > li {
        padding: 0 10px;
        border-right: 1px solid #e1e1e1;
    }
    .mobile_view_sidebar{
        display: none;
    }
    @media only screen and (max-width: 700px) {
        .web_menu{
            display: none;
        }
        .mobile_view_sidebar{
            display: flex;
        }
    }
</style>

@php
    $categories = categories();
@endphp
<header class="ecommerce-header">
    <div class="middle-header d-none d-lg-block py-2" style="background-color: white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-2 col-md-3 sm-mx-none">
                    <a class="navbar-brand d-flex align-items-center h-100" href="{{url('/')}}"><img class="nav-logo" src="{{asset('frontend/logo.png')}}" style="max-width: 154px;" alt="Image not found !"></a>
                </div>
                <div class="col-lg-5 col-md-9">
                    <div class="product-search-one">
                        <form class="form-inline search-pill-shape bg-white" action="{{ route('category.search') }}" method="GET">
                            <input type="text" class="form-control search-field search_value" name="q" placeholder="@lang('website.Search Products')">
                            <div class="select-appearance-none">
                                <select class="form-control" name="category" onchange="searchSubmit(this)">
                                    <option selected>@lang('website.All Categories')</option>
                                    @if(count($categories) > 0)
                                        @foreach($categories as $category)
                                            <option value="{{ $category->slug }}"
                                                    @isset($category_id)
                                                    @if ($category_id == $category->id)
                                                    selected
                                                @endif
                                                @endisset
                                            >{{getNameByBnEn($category)}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <button type="submit" name="submit" class="search-submit"><i class="flaticon-search flat-mini text-white"></i></button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5 col-md-3 xs-mx-none">
                    <div class="d-flex align-items-center justify-content-end h-100">
                        <a href="#" class="d-flex align-items-center text-dark text-decoration-none">
                            <div class="d-table">
                                <div class="font-500"><i class="fa fa-envelope" aria-hidden="true"></i> support@fabriclagbe.com</div>
                                <div class="font-600 text-dark"><i class="fa fa-phone" aria-hidden="true"></i>{{getNumberToBangla('09678')}}-{{getNumberToBangla('236236')}}</div>
                            </div>
                        </a>
                        <ul class="top-links ms-auto list-color-dark d-flex justify-content-end">
                            @if(Auth::guest())
                                <li class="my-account-dropdown sign_in">
                                    <a href="{{route('login')}}" class=""><i class="flaticon-user-3 flat-mini me-1"></i>@lang('website.SIGN IN')</a>
                                </li>
                            @elseif(Auth::user()->user_type == 'admin')
                                <li>
                                    <a href="{{route('admin.dashboard')}}" class=""><i class="flaticon-user-3 flat-mini me-1"></i>{{getNameByBnEn(Auth::user())}}</a>
                                    <form action="{{route('logout')}}" method="POST">
                                        @csrf
                                        <button>@lang('website.Logout')</button>
                                    </form>
                                </li>
                            @elseif(Auth::user()->user_type == 'buyer')
                                <li>
                                    <a href="{{route('buyer.dashboard')}}" class=""><i class="flaticon-user-3 flat-mini me-1"></i>{{getNameByBnEn(Auth::user())}}</a>
                                    <form action="{{route('logout')}}" method="POST">
                                        @csrf
                                        <button>@lang('website.Logout')</button>
                                    </form>
                                </li>
                            @elseif(Auth::user()->user_type == 'seller')
                                <li>
                                    <a href="{{route('seller.dashboard')}}" class=""><i class="flaticon-user-3 flat-mini me-1"></i>{{getNameByBnEn(Auth::user())}}</a>
                                    <form action="{{route('logout')}}" method="POST">
                                        @csrf
                                        <button>@lang('website.Logout')</button>
                                    </form>
                                </li>
                            @elseif(Auth::user()->user_type == 'employee')
                                <li>
                                    <a href="{{route('employee.dashboard')}}" class=""><i class="flaticon-user-3 flat-mini me-1"></i>{{getNameByBnEn(Auth::user())}}</a>
                                    <form action="{{route('logout')}}" method="POST">
                                        @csrf
                                        <button>@lang('website.Logout')</button>
                                    </form>
                                </li>
                            @endif
                            <li style="width: 105px">
                                <select class="form-control" name="category" id="currency-change">
                                    @foreach (\App\Model\Currency::where('status', 1)->get() as $key => $currency)
                                        <option value="{{ $currency->code }}"
                                                @if(currency()->code == $currency->code) selected @endif
                                        >{{ $currency->code }}({{ $currency->symbol }})</option>
                                    @endforeach
                                </select>
                            </li>
                            {{--                            @if(count($languages = \App\Model\Language::all()) > 1)--}}
                            {{--                                @foreach($languages as $language)--}}
                            {{--                                    <li class="nav-item p-0"--}}
                            {{--                                        @if(session('locale')==$language->code)--}}
                            {{--                                            style="background-color: #f89e20;"--}}
                            {{--                                        @elseif((session('locale')== null) && ('en'==$language->code))--}}
                            {{--                                            style="background-color: #f89e20;"--}}
                            {{--                                        @else--}}
                            {{--                                            style="background:lightgrey;"--}}
                            {{--                                        @endif>--}}
                            {{--                                        <button  onclick="myFunction1({{$language->id}})" class="btn" style="background:none;color: #ffffff;" href="#">--}}
                            {{--                                            <span>{{$language->name}}</span>--}}
                            {{--                                        </button>--}}
                            {{--                                    </li>--}}
                            {{--                                @endforeach--}}
                            {{--                            @endif--}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main-nav mb-2 d-none d-lg-block border-footer" style="background-color: #609b35;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg nav-dark nav-primary-hover">
                        <a class="navbar-brand d-lg-none" href="{{url('/')}}"><img class="nav-logo" src="{{asset('frontend/logo.png')}}" alt="Image not found !"></a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="flaticon-menu-2 flat-small text-primary"></i>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav">
                                <li class="nav-item"><a class="nav-link" href="{{url('/')}}">@lang('website.Home')</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{route('about-us')}}">@lang('website.About Us')</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{route('our-products')}}">@lang('website.Product & Service')</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{route('blog')}}">@lang('website.Media & Blog')</a></li>
                                <li class="nav-item navbar-right"><a class="nav-link" href="{{route('contact-us')}}">@lang('website.Contact Us')</a></li>
                                @php
                                    $lang = app()->getLocale('locale');
                                $en = \App\Model\Language::where('code','en')->first();
                                $bn = \App\Model\Language::where('code','bn')->first();
                                @endphp
                                @if($lang == 'en')
                                <li class="nav-item p-0" style="background-color: #f89e20;">
                                    <button  onclick="myFunction1({{$bn->id}})" class="btn" style="background:none;color: #ffffff;" href="#">
                                        <span>{{$bn->name}}</span>
                                    </button>
                                </li>
                                @else
                                    <li class="nav-item p-0" style="background-color: #f89e20;">
                                        <button  onclick="myFunction1({{$en->id}})" class="btn" style="background:none;color: #ffffff;" href="#">
                                            <span>{{$en->name}}</span>
                                        </button>
                                    </li>
                                @endif

                                {{--                                        @foreach($languages as $language)--}}
                                {{--                                            <li class="nav-item p-0"--}}
                                {{--                                                @if(session('locale')==$language->code)--}}
                                {{--                                                style="background-color: #f89e20;"--}}
                                {{--                                                @elseif((session('locale')== null) && ('en'==$language->code))--}}
                                {{--                                                style="background-color: #f89e20;"--}}
                                {{--                                                @else--}}
                                {{--                                                style="background:lightgrey;"--}}
                                {{--                                                @endif>--}}
                                {{--                                                <button  onclick="myFunction1({{$language->id}})" class="btn" style="background:none;color: #ffffff;" href="#">--}}
                                {{--                                                    <span>{{$language->name}}</span>--}}
                                {{--                                                </button>--}}
                                {{--                                            </li>--}}
                                {{--                                        @endforeach--}}

                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="header-sticky py-2" style="background-color: white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xxl-2 col-xl-2 col-lg-3 col-4 order-lg-1">
                    <div class="d-flex align-items-center h-100 md-py-10">
                        <div class="nav-leftpush-overlay">
                            <nav class="navbar navbar-expand-lg nav-general nav-primary-hover">
                                <button type="button" class="push-nav-toggle d-lg-none border-0">
                                    <i class="flaticon-menu-2 flat-small text-primary"></i>
                                </button>

                                <div class="navbar-slide-push transation-this">
                                    <div class="login-signup d-flex justify-content-between py-10 px-20 align-items-center" style="background-color: #008000;">
                                        @if(Auth::guest())
                                            <a href="{{route('login')}}" class="d-flex align-items-center text-white">
                                                <i class="flaticon-user flat-small me-1"></i>
                                                <span>Login/Signup</span>
                                            </a>
                                        @else
                                            <div class="row col-3">
                                                <a href="#" class="d-flex align-items-center text-white">
                                                    <img src="{{url(Auth::user()->avatar_original)}}" width="50" height="30">
                                                </a>
                                            </div>
                                            <div class="row col-9">
                                                <a href="#" class="d-flex align-items-center text-white">
                                                    <span>{{Auth::user()->name}}</span>
                                                </a>
                                            </div>
                                        @endif

                                        <span class="slide-nav-close"><i class="flaticon-cancel flat-mini text-white"></i></span>
                                    </div>
                                    <div class="menu-and-category">
                                        <ul class="nav nav-pills wc-tabs" id="menu-and-category" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="pills-push-menu-tab" data-bs-toggle="pill" href="#pills-push-menu" role="tab" aria-controls="pills-push-menu" aria-selected="true" style="background-color: #EF3D33;">Menu</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="menu-and-categoryContent">
                                            <div class="tab-pane fade show active woocommerce-Tabs-panel woocommerce-Tabs-panel--description " id="pills-push-menu" role="tabpanel" aria-labelledby="pills-push-menu-tab">
                                                <div class="push-navbar">
                                                    @if(Auth::check())
                                                        <ul class="navbar-nav mobile_view_sidebar">
                                                            @if(Auth::user()->user_type == 'seller')
                                                                @include('frontend.partials.mobile_view_seller_sidebar')
                                                            @elseif(Auth::user()->user_type == 'buyer')
                                                                @include('frontend.partials.mobile_view_buyer_sidebar')
                                                            @endif
                                                        </ul>
                                                    @else
                                                        <ul class="navbar-nav">
                                                            <li class="nav-item"><a class="nav-link" href="{{url('/')}}">Home</a></li>
                                                            <li class="nav-item"><a class="nav-link" href="{{route('about-us')}}">About Us</a></li>
                                                            <li class="nav-item"><a class="nav-link" href="{{route('our-products')}}">Product & Service</a></li>
                                                            <li class="nav-item"><a class="nav-link" href="{{route('blog')}}">Media & Blog</a></li>
                                                            <li class="nav-item"><a class="nav-link" href="{{route('contact-us')}}">Contact Us</a></li>
                                                        </ul>
                                                    @endif
                                                    <ul class="navbar-nav web_menu">
                                                        <li class="nav-item web_menu"><a class="nav-link" href="{{url('/')}}">Home</a></li>
                                                        <li class="nav-item web_menu"><a class="nav-link" href="{{route('about-us')}}">About Us</a></li>
                                                        <li class="nav-item web_menu"><a class="nav-link" href="{{route('our-products')}}">Product & Service</a></li>
                                                        <li class="nav-item web_menu"><a class="nav-link" href="{{route('blog')}}">Media & Blog</a></li>
                                                        <li class="nav-item web_menu"><a class="nav-link" href="{{route('contact-us')}}">Contact Us</a></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="pills-push-categories" role="tabpanel" aria-labelledby="pills-push-categories-tab">
                                                <div class="push-navbar">
                                                    <ul class="navbar-nav">
                                                        @if(count($categories) > 0)
                                                            @foreach($categories as $category)
                                                                <li class="nav-item dropdown">
                                                                    <a class="nav-link dropdown-toggle" href="#">{{$category->name}}</a>
                                                                    @php
                                                                        $subCategories = CategoryWiseSubCategories($category->id);
                                                                    @endphp
                                                                    @if(count($subCategories) > 0)
                                                                        <ul class="dropdown-menu">
                                                                            @foreach($subCategories as $subCategory)
                                                                                <li class="dropdown">
                                                                                    <a class="dropdown-toggle dropdown-item" >{{$subCategory->name}}</a>
                                                                                    @php
                                                                                        $SubCategoryWiseSubSubCategories = SubCategoryWiseSubSubCategories($subCategory->id);
                                                                                    @endphp
                                                                                    @if(count($SubCategoryWiseSubSubCategories) > 0)
                                                                                        <ul class="dropdown-menu">
                                                                                            @foreach($SubCategoryWiseSubSubCategories as $SubCategoryWiseSubSubCategory)
                                                                                                <li><a class="dropdown-item" >{{$SubCategoryWiseSubSubCategory->name}}</a></li>
                                                                                            @endforeach
                                                                                        </ul>
                                                                                    @endif
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @endif
                                                                </li>
                                                    @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </nav>
                        </div>
                        <a class="navbar-brand" href="{{url('/')}}"><img class="nav-logo" src="{{asset('frontend/logo.png')}}" style="max-width: 154px;" alt="Image not found !"></a>
                    </div>
                </div>

                <div class="col-xxl-3 col-xl-5 col-lg-5 col-8 order-lg-3">
                    <div class="d-flex align-items-center justify-content-end h-100">
                        <ul class="top-links ms-auto list-color-dark d-flex justify-content-end">
                            @if(Auth::guest())
                                <li class="my-account-dropdown sign_in">
                                    <a href="{{route('login')}}" class=""><i class="flaticon-user-3 flat-mini me-1"></i>@lang('website.SIGN IN')</a>
                                </li>
                            @elseif(Auth::user()->user_type == 'admin')
                                <li>
                                    <a href="{{route('admin.dashboard')}}" class=""><i class="flaticon-user-3 flat-mini me-1"></i>{{getNameByBnEn(Auth::user())}}</a>
                                </li>
                                <li>
                                    <form action="{{route('logout')}}" method="POST">
                                        @csrf
                                        <button>@lang('website.Logout')</button>
                                    </form>
                                </li>
                            @elseif(Auth::user()->user_type == 'buyer')
                                <li>
                                    <a href="{{route('buyer.dashboard')}}" class=""><i class="flaticon-user-3 flat-mini me-1"></i>{{getNameByBnEn(Auth::user())}}</a>
                                </li>
                                <li>
                                    <form action="{{route('logout')}}" method="POST">
                                        @csrf
                                        <button>@lang('website.Logout')</button>
                                    </form>
                                </li>
                            @elseif(Auth::user()->user_type == 'seller')
                                <li>
                                    <a href="{{route('seller.dashboard')}}" class=""><i class="flaticon-user-3 flat-mini me-1"></i>{{getNameByBnEn(Auth::user())}}</a>
                                </li>
                                <li>
                                    <form action="{{route('logout')}}" method="POST">
                                        @csrf
                                        <button>@lang('website.Logout')</button>
                                    </form>
                                </li>
                            @endif
                            <li style="width: 125px">
                                <select class="form-control" name="category" onchange="currency_changed(this)">
                                    @foreach (\App\Model\Currency::where('status', 1)->get() as $key => $currency)
                                        <option value="{{ $currency->code }}"
                                                @if(currency()->code == $currency->code) selected @endif
                                        >{{ $currency->code }}({{ $currency->symbol }})</option>
                                    @endforeach
                                </select>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xxl-7 col-xl-5 col-lg-5 col-12 order-lg-2">
                    <div class="product-search-one" id="placeholderInput">
                        <form class="form-inline search-pill-shape bg-white" action="{{ route('category.search') }}" method="GET">
                            <input type="text" class="form-control search-field search_value" name="q" placeholder="@lang('website.Search Products')">
                            <select class="form-control" name="category" onchange="searchSubmit(this)">
                                <option selected>@lang('website.All Categories')</option>
                                @if(count($categories) > 0)
                                    @foreach($categories as $category)
                                        <option value="{{ $category->slug }}"
                                                @isset($category_id)
                                                @if ($category_id == $category->id)
                                                selected
                                            @endif
                                            @endisset
                                        >{{ getNameByBnEn($category) }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <button type="submit" name="submit" class="search-submit"><i class="flaticon-search flat-mini text-white"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
