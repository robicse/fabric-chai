<style>
    .darkBlue{
        color: darkblue!important;
    }
    .bg_green{
        background-color: #008000;
    }
    .font_20{
        font-size: 20px;
    }
    .font_18{
        font-size: 18px;
    }
    .redColor{
        color: red;
    }
</style>
<ul class="navbar-nav">
    @php
        $check_buyer_also_seller = checkBuyerAlsoSeller();
    @endphp
    @if($check_buyer_also_seller == null)
        <li class="nav-item"><a class="nav-link darkBlue font_20" href="{{route('buyer.apply_for_seller')}}">Apply for Seller</a></li>
    @else
        <li class="nav-item"><a class="nav-link darkBlue font_20" href="{{route('buyer.switch_to_seller')}}" >Switch To Seller</a></li>
    @endif
    <li class="nav-item"><a class="nav-link" href="{{url('/')}}">Home</a></li>
    <li class="nav-item"><a class="nav-link" href="{{route('buyer.dashboard')}}">Dashboard </a></li>
    <li class="nav-item"><a class="nav-link" href="{{route('buyer.view-profile')}}">Profile </a></li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle bg_green text-white font_18" href="#" >Products</a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{route('buyer.all-products.list')}}">All Products</a></li>
            <li><a class="dropdown-item" href="{{route('buyer.product-bids.list')}}">My Bids</a></li>
            <li><a class="dropdown-item" href="{{route('buyer.accepted-bid-list')}}">Accepted Bids</a></li>
            <li><a class="dropdown-item" href="{{route('buyer.recorded-transaction.list')}}">Recorded Transactions</a></li>
        </ul>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#">Buy Requests</a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{route('buyer.my-request.create')}}">Product Requests</a></li>
            <li><a class="dropdown-item" href="{{route('buyer.my-request.index')}}">My Requested Products</a></li>
            <li><a class="dropdown-item" href="{{route('buyer.accepted-bid-request.list')}}">Accepted Requests</a></li>
            <li><a class="dropdown-item" href="{{route('buyer.requested-recorded-transaction.list')}}">Recorded Transactions</a></li>

        </ul>
    </li>
    <li class="nav-item"><a class="nav-link" href="#">Merchandiser List <small>(Coming Soon)</small> </a></li>
    <li class="nav-item"><a class="nav-link" href="{{route('buyer.review-list')}}">Reviews </a></li>
    <li class="nav-item"><a class="nav-link" href="{{route('buyer.notification-list')}}">Notification
            <span class="redColor">
                        @php
                            $notViewNotificationCount = notViewNotificationCount();
                        @endphp
                    ({{$notViewNotificationCount->count}})
                </span>
        </a>
    </li>
    <li class="nav-item"><a class="nav-link" href="{{route('seller.memberships-package-list')}}">Premium Membership</a></li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#">About</a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{route('about-us')}}">About Us</a></li>
            <li><a class="dropdown-item" href="{{route('cookies-policy')}}">Cookies Policy</a></li>
            <li><a class="dropdown-item" href="{{route('terms-conditions')}}">Term and Condition Policy</a></li>
            <li><a class="dropdown-item" href="{{route('privacy-and-policy')}}">Privacy Policy</a></li>
        </ul>
    </li>
    <li class="nav-item">
        <form action="{{route('logout')}}" method="POST">
            @csrf
            <button class="nav-link">Logout</button>
        </form>
    </li>
</ul>

