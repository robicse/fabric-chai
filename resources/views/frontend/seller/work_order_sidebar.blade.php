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
                <p style="margin-top: 30px; color: white"> <strong>{{Auth::User()->name}}</strong></p>
                <p style="margin-top: -20px; color: white"> @lang('website.Membership'): <span style="color: white; font-weight: bold;">{{checkCurrentMembershipName(Auth::User()->id)}}</span></p>
                <p style="margin-top: -25px; color: white">@lang('website.Referral Code'): <span>{{Auth::User()->referral_code}}</span></p>
{{--                <p style="margin-top: -25px;"><a href="{{route('seller.memberships-package-list')}}" style="color: #ffca2b;">Upgrade Package</a></p>--}}
            </div>
        </div>

        <div id="jquery-accordion-menu" class="jquery-accordion-menu">
            <div class="jquery-accordion-menu-header"><a href="#" data-bs-toggle="modal" data-bs-target="#Seller" style="color: #ffca2b!important; font-weight: 900;">@lang('website.Switch To Seller')</a> </div>
            <ul>
                    <li class="{{(Request::is('seller/dashboard') ? 'active' : '')}}"><a href="{{route('seller.work-order.dashboard')}}"><i class="flaticon-home"></i>@lang('website.Home') </a></li>
                    <li class="{{(Request::is('seller/work-order-profile') ? 'active' : '')}}"><a href="{{route('seller.work-order-profile')}}"><i class="flaticon-user-1"></i>@lang('website.Profile') </a></li>
                    <li ><a href="#" style=""><i class="flaticon-shopping-list"></i>@lang('website.WO Products')  </a>
                        <ul class="submenu" style="display: {{(Request::is('seller/work-order-products*')
                        || Request::is('seller/my-work-order-products/list')
                        || Request::is('seller/my-work-order*')
                        || Request::is('seller/recorded-transaction/list'))
                        ? 'block' : ''}}">
                            <li><a style="color:{{(Request::is('seller/work-order-products/create') ? 'red' : '')}}" href="{{route('seller.work-order-products.create')}}"><i class="flaticon-cart"></i> @lang('website.Production Capability') </a></li>
                            <li><a style="color:{{(Request::is('seller/my-work-order-products/list') ? 'red' : '')}}" href="{{route('seller.my-work-order-product.list')}}"><i class="flaticon-list"></i>@lang('website.My Production Capability') </a></li>
                            <li><a style="color:{{(Request::is('seller/my-work-order/accepted-quotation-list') ? 'red' : '')}}" href="{{route('seller.my-work-order.accepted-quotation-list')}}"><i class="flaticon-approved-signal"></i>@lang('website.Accepted RFQs') </a></li>
                            <li><a style="color:{{(Request::is('seller/my-work-order/recorded-transaction') ? 'red' : '')}}" href="{{route('seller.my-work-order.recorded-transaction')}}"><i class="flaticon-reload"></i>@lang('website.RFQ Recorded Transaction') </a></li>
                        </ul>
                    </li>
{{--                    <li><a href="#"><i class="flaticon-shopping-cart-1"></i>Requested Work Order </a>--}}
{{--                        <ul class="submenu" style="display: {{(Request::is('seller/all-work-orders/list')--}}
{{--                        || Request::is('seller/work-order/bid-history')--}}
{{--                        || Request::is('seller/work-order/accepted-bid-list')--}}
{{--                        || Request::is('seller/work-order/recorded-transaction'))--}}
{{--                        ? 'block' : ''}}">--}}
{{--                            <li><a style="color:{{(Request::is('seller/all-work-orders/list') ? 'red' : '')}}" href="{{route('seller.all-work-order.list')}}"><i class="flaticon-list"></i>All Work Orders </a></li>--}}
{{--                            <li><a style="color:{{(Request::is('seller/work-order/bid-history') ? 'red' : '')}}" href="{{route('seller.work-order.bid-history')}}"><i class="flaticon-list"></i>Bids History</a></li>--}}
{{--                            <li><a style="color:{{(Request::is('seller/work-order/accepted-bid-list') ? 'red' : '')}}" href="{{route('seller.work-order.accepted-bid-list')}}"><i class="flaticon-approved-signal"></i>Accepted Bids </a></li>--}}
{{--                            <li><a style="color:{{(Request::is('seller/work-order/recorded-transaction') ? 'red' : '')}}" href="{{route('seller.work-order.recorded-transaction')}}"><i class="flaticon-reload"></i>Recorded Transactions </a></li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
                <li class="{{(Request::is('seller/work-order/reviews') ? 'active' : '')}}"><a href="{{route('seller.work-order.review-list')}}"><i class="flaticon-star"></i>@lang('website.Reviews')</a></li>
                    <li class="{{(Request::is('seller/work-order/notifications') ? 'active' : '')}}">
                        <a href="{{route('seller.work-order.notifications')}}"><i class="flaticon-chat"></i>@lang('website.Notification') </a>
                        <span class="jquery-accordion-menu-label">
                        @php
                            $notViewNotificationCount = notViewWONotificationCount();
                        @endphp
                            {{getNumberToBangla($notViewNotificationCount->count)}}
                    </span>
                    </li>
                    <li class="{{(Request::is('seller/memberships-package-list') ? 'active' : '')}}"><a href="{{route('seller.work-order.memberships-package-list')}}"><i class="flaticon-medal"></i>@lang('website.Premium Membership')</a></li>
                    <li><a href="#"><i class="flaticon-newsletter"></i>@lang('website.About') </a>
                        <ul class="submenu">
                            <li><a href="{{route('about-us')}}"><i class="flaticon-newsletter"></i>@lang('website.About Us') </a></li>
                            <li><a href="{{route('cookies-policy')}}"><i class="flaticon-reload"></i>@lang('website.Cookies Policy') </a></li>
                            <li><a href="{{route('terms-conditions')}}"><i class="flaticon-reload"></i>@lang('website.Term and Condition Policy') </a></li>
                            <li><a href="{{route('privacy-and-policy')}}"><i class="flaticon-reload"></i>@lang('website.Privacy Policy') </a></li>
                        </ul>
                    </li>
            </ul>
            @csrf
            <div class="jquery-accordion-menu-footer">
                <form action="{{route('logout')}}" method="POST">
                    @csrf
                    <button class="submit" style="color: white; font-weight: 800">
                        <i class="flaticon-warning"></i> @lang('website.Log Out')
                    </button>
                </form>
            </div>
            <div class="jquery-accordion-menu-footer">

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
