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

<li class="nav-item"><a class="nav-link darkBlue font_20" href="{{route('seller.switch_to_buyer')}}" >Switch To Buyer</a></li>
<li class="nav-item"><a class="nav-link" href="{{url('/')}}">Home</a></li>
<li class="nav-item"><a class="nav-link" href="{{route('seller.dashboard')}}">Dashboard </a></li>
<li class="nav-item"><a class="nav-link" href="{{route('seller.view-profile')}}">Profile </a></li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle bg_green text-white font_18" href="#" >Products</a>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="{{route('seller.products.create')}}">Product Entry</a></li>
        <li><a class="dropdown-item" href="{{route('seller.products.index')}}">My Post</a></li>
        <li><a class="dropdown-item" href="{{route('seller.product-bids.list')}}">Accepted Bids</a></li>
        <li><a class="dropdown-item" href="{{route('seller.recorded-transaction.list')}}">Recorded Transactions</a></li>
    </ul>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#">Buy Requests</a>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="{{route('seller.all-requested-products')}}">All Request</a></li>
        <li><a class="dropdown-item" href="{{route('seller.my-bids-list')}}">My Bids</a></li>
        <li><a class="dropdown-item" href="{{route('seller.accepted-bid-list')}}">Accepted Requests</a></li>
        <li><a class="dropdown-item" href="{{route('seller.requested-recorded-transaction.list')}}">Recorded Transactions</a></li>
    </ul>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#">Accounts</a>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="{{route('seller.accounts')}}">Pay Now</a></li>
        <li><a class="dropdown-item" href="{{route('seller.payment.transaction.list')}}">Transaction List</a></li>
    </ul>
</li>
<li class="nav-item"><a class="nav-link" href="#">Merchandiser List <small>(Coming Soon)</small> </a></li>
<li class="nav-item"><a class="nav-link" href="{{route('seller.review-list')}}">Reviews </a></li>
<li class="nav-item"><a class="nav-link" href="{{route('seller.notification-list')}}">Notification
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

