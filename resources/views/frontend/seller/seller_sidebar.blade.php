@push('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/jquery-accordion-menu.css')}}">
@endpush
<style>
    .jquery-accordion-menu ul li a {
        width: 100%;
        padding: 14px 22px;
        float: left;
        color: white;
        font-size: 14px;
        white-space: nowrap;
        position: relative;
        overflow: hidden;
        -o-transition: color .2s linear,background .2s linear;
        -moz-transition: color .2s linear,background .2s linear;
        -webkit-transition: color .2s linear,background .2s linear;
        transition: color .2s linear,background .2s linear;
    }
    .a{
        color: #000;
    }
    .list-group-item:hover{
        background-color: #26AB3D;
    }
    .list-group-item:active{
        background-color: #26AB3D;
    }
    .jquery-accordion-menu>ul>li.active>a, .jquery-accordion-menu>ul>li:hover>a {
        color: #ffcb30;
    }
    .mobile_view_sidebar{
        display: none;
    }
    @media only screen and (max-width: 700px) {
        .web_view_sidebar{
            display: none;
        }
    }

</style>
<div class="col-lg-3 col-sm-3 web_view_sidebar">
    <div class="card" style="width: 18rem;border-radius: 10px; background-color: #4b3f6d;">
        <div class="row">
            <div class="col-4" style="margin-top: 20px;">
                <img src="{{url(Auth::User()->avatar_original)}}" class="rounded-circle" width="80" height="80" style="border-style: solid;margin-left:10px; border-color: white;">
            </div>
            <div class="col-8">
                <p style="margin-top: 30px; color: white"> <strong>{{getNameByBnEn(Auth::User())}}</strong></p>
                <p style="margin-top: -20px; color: white"> @lang('website.Membership'): <span style="color: white; font-weight: bold;">{{checkCurrentMembershipName(Auth::User()->id)}}</span></p>
                <p style="margin-top: -25px;"><a href="{{route('seller.memberships-package-list')}}" style="color: #ffca2b;">@lang('website.Upgrade Package')</a></p>
{{--                <p style="margin-top: -25px; color: white">@lang('website.Referral Code'): <span>{{Auth::User()->referral_code}}</span></p>--}}
            </div>
        </div>

        <div id="jquery-accordion-menu" class="jquery-accordion-menu">

            @if(Auth::user()->seller->employer_status == 0)
                <div class="jquery-accordion-menu-header"><a href="#" style="color: #ffca2b!important; font-weight: 900;" data-bs-toggle="modal" data-bs-target="#Buyer">@lang('website.Switch To Buyer')</a> </div>
                <div class="jquery-accordion-menu-header" style="margin-top: -15px"><a href="#" style="color: #ffca2b!important; font-weight: 900;" data-bs-toggle="modal" data-bs-target="#Employer">@lang('website.Switch To Employer')</a> </div>
            @else
                <div class="jquery-accordion-menu-header"><a href="#" style="color: #ffca2b!important; font-weight: 900;" data-bs-toggle="modal" data-bs-target="#Seller">@lang('website.Switch To Seller')</a> </div>
            @endif
            <ul>
                @if(Auth::user()->seller->employer_status == 0)
                    <li class="{{(Request::is('seller/dashboard') ? 'active' : '')}}"><a href="{{route('seller.dashboard')}}"><i class="flaticon-home"></i>@lang('website.Home') </a></li>
                    <li class="{{(Request::is('seller/view-profile') ? 'active' : '')}}"><a href="{{route('seller.view-profile')}}"><i class="flaticon-user-1"></i>@lang('website.Profile') </a></li>
                    <li ><a href="#" style="background-color: #81211c; font-size: 18px; color: #fff;"><i class="flaticon-shopping-list"></i>@lang('website.Products')  </a>
                        <ul class="submenu" style="display: {{(Request::is('seller/products/create')
                        || Request::is('seller/products')
                        || Request::is('seller/product-bids/list')
                        || Request::is('seller/recorded-transaction/list'))
                        ? 'block' : ''}}">
                            <li><a style="color:{{(Request::is('seller/products/create') ? 'red' : '')}}" href="{{route('seller.products.create')}}"><i class="flaticon-cart"></i> @lang('website.Product Entry') </a></li>
                            <li><a style="color:{{(Request::is('seller/products') ? 'red' : '')}}" href="{{route('seller.products.index')}}"><i class="flaticon-list"></i>@lang('website.My Post') </a></li>
                            <li><a style="color:{{(Request::is('seller/product-bids/list') ? 'red' : '')}}" href="{{route('seller.product-bids.list')}}"><i class="flaticon-approved-signal"></i>@lang('website.My Accepted Bids') </a></li>
                            <li><a style="color:{{(Request::is('seller/recorded-transaction/list') ? 'red' : '')}}" href="{{route('seller.recorded-transaction.list')}}"><i class="flaticon-reload"></i>@lang('website.Recorded Transactions') </a></li>
                        </ul>
                    </li>
                    <li><a href="#" style="background-color: #81211c; font-size: 18px; color: #fff;"><i class="flaticon-shopping-cart-1"></i>@lang('website.Buy Requests') </a>
                        <ul class="submenu" style="display: {{(Request::is('seller/all-requested-products')
                        || Request::is('seller/my-bids')
                        || Request::is('seller/accepted-bid-list')
                        || Request::is('seller/requested-recorded-transaction/list'))
                        ? 'block' : ''}}">
                            <li><a style="color:{{(Request::is('seller/all-requested-products') ? 'red' : '')}}" href="{{route('seller.all-requested-products')}}"><i class="flaticon-list"></i>@lang('website.All Requests') </a></li>
                            <li><a style="color:{{(Request::is('seller/my-bids') ? 'red' : '')}}" href="{{route('seller.my-bids-list')}}"><i class="flaticon-list"></i>@lang('website.My Bids')</a></li>
                            <li><a style="color:{{(Request::is('seller/accepted-bid-list') ? 'red' : '')}}" href="{{route('seller.accepted-bid-list')}}"><i class="flaticon-approved-signal"></i>@lang('website.My Accepted Requests') </a></li>
                            <li><a style="color:{{(Request::is('seller/requested-recorded-transaction/list') ? 'red' : '')}}" href="{{route('seller.requested-recorded-transaction.list')}}"><i class="flaticon-reload"></i>@lang('website.Recorded Transactions') </a></li>
                        </ul>
                    </li>
                    <li><a href="#"><i class="flaticon-star"></i>@lang('website.Merchandiser List') <small>@lang('website.(Coming Soon)')</small> </a></li>
                    <li class="{{(Request::is('seller/review/list') ? 'active' : '')}}"><a href="{{route('seller.review-list')}}"><i class="flaticon-star"></i>@lang('website.Reviews')</a></li>
                    <li class="{{(Request::is('seller/notification/list') ? 'active' : '')}}">
                        <a href="{{route('seller.notification-list')}}"><i class="flaticon-chat"></i>@lang('website.Notification') </a>
                        <span class="jquery-accordion-menu-label">
                        @php
                            $notViewNotificationCount = notViewNotificationCount();
                        @endphp
                            {{getNumberToBangla($notViewNotificationCount->count)}}
                    </span>
                    </li>
                    <li class="{{(Request::is('seller/memberships-package-list') ? 'active' : '')}}"><a href="{{route('seller.memberships-package-list')}}"><i class="flaticon-medal"></i>@lang('website.Premium Membership')</a></li>

                    <li><a href="#"><i class="flaticon-shopping-cart-1"></i>@lang('website.Accounts') </a>
                        <ul class="submenu" style="display: {{(Request::is('seller/accounts')
                        || Request::is('seller/payment-transaction-list'))
                        ? 'block' : ''}}">
                            <li><a style="color:{{(Request::is('seller/accounts') ? 'red' : '')}}" href="{{route('seller.accounts')}}"><i class="flaticon-list"></i>@lang('website.Pay Now') </a></li>
                            <li><a style="color:{{(Request::is('seller/payment-transaction-list') ? 'red' : '')}}" href="{{route('seller.payment.transaction.list')}}"><i class="flaticon-approved-signal"></i>@lang('website.Transaction List') </a></li>
                        </ul>
                    </li>
                    <li><a href="#"><i class="flaticon-newsletter"></i>@lang('website.About') </a>
                        <ul class="submenu">
                            <li><a href="{{route('about-us')}}"><i class="flaticon-newsletter"></i>@lang('website.About Us') </a></li>
                            <li><a href="{{route('cookies-policy')}}"><i class="flaticon-reload"></i>@lang('website.Cookies Policy') </a></li>
                            <li><a href="{{route('terms-conditions')}}"><i class="flaticon-reload"></i>@lang('website.Term and Condition Policy') </a></li>
                            <li><a href="{{route('privacy-and-policy')}}"><i class="flaticon-reload"></i>@lang('website.Privacy Policy') </a></li>
                        </ul>
                    </li>
                    <li class="">
                        <a href="{{route('seller.work-order.dashboard')}}" class="text-primary" style="font-size: 16px"><i class="flaticon-list text-primary" style="font-size: 16px"></i> @lang('website.Work Order') </a>
                    </li>
                @else
                    <li class="{{(Request::is('employer/dashboard') ? 'active' : '')}}"><a href="{{route('employer-dashboard')}}"><i class="flaticon-home"></i>@lang('website.Home') </a></li>
                    <li class="{{(Request::is('seller/employer-profile') ? 'active' : '')}}"><a href="{{route('employer-profile')}}"><i class="flaticon-user-1"></i>@lang('website.Profile')</a></li>
                    <li class="{{(Request::is('seller/employer/offer-send') ? 'active' : '')}}"><a href="{{route('employer.offer-send')}}"><i class="flaticon-list"></i>@lang('website.Offers Sent') </a></li>
                    <li class="{{(Request::is('seller/employer/shortlist') ? 'active' : '')}}"><a href="{{route('employer.shortlist')}}"><i class="flaticon-list"></i>@lang('website.Short Listed') </a></li>
                    <li class="{{(Request::is('seller/employer/message-log') ? 'active' : '')}}"><a href="{{route('employer.message-log')}}"><i class="flaticon-list"></i>@lang('website.Message Log') </a></li>

                @endif


            </ul>
            <div class="jquery-accordion-menu-footer">

                <div>
                    <form action="{{route('logout')}}" method="POST">
                        @csrf
                        <button class="submit" style="color: white; font-weight: 800">
                            <i class="flaticon-warning"></i> @lang('website.Log Out')
                        </button>
                    </form>
                </div>
            </div>
            <div class="jquery-accordion-menu-footer">

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="Buyer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>@lang('website.Are you really want to switch?')</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('website.No')</button>
                <a type="button" class="btn btn-success text-white" href="{{route('seller.switch_to_buyer')}}">@lang('website.Yes')</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="Employer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>@lang('website.Are you really want to switch?')</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('website.No')</button>
                <a type="button" class="btn btn-success text-white" href="{{route('employer-dashboard')}}">@lang('website.Yes')</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="Seller" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>@lang('website.Are you really want to switch?')</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('website.No')</button>
                <a type="button" class="btn btn-success text-white" href="{{route('seller.dashboard')}}">@lang('website.Yes')</a>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script src="{{asset('frontend/assets/js/jquery-accordion-menu.js')}}"></script>
@endpush
