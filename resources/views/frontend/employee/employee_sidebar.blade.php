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
    .line_height{
        padding: 10px 0px;
        font-size: 20px;
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

    .mobile_view_sidebar{
        display: none;
    }
    @media only screen and (max-width: 700px) {
        .web_view_sidebar{
            display: none;
        }
    }

</style>
@php
    $employee = \App\Model\Employee::where('user_id',Auth::id())->first();
@endphp
<div class="col-lg-3 col-sm-3 web_view_sidebar">
    <div class="card" style="width: 18rem;border-radius: 10px; background-color: #4b3f6d; height: 400px;">
        <div class="row">
            <div class="col-4" style="margin-top: 20px;">
                @if(checkEmployeePic(Auth::User()->id) != NULL)
                    <img src="{{ url($employee->employee_pic) }}" class="rounded-circle" width="80" height="80" style="border-style: solid; margin-left:10px; border-color: white;">
                @else
                    <img src="{{url(Auth::User()->avatar_original)}}" class="rounded-circle" width="80" height="80" style="border-style: solid; margin-left:10px; border-color: white;">
                @endif
            </div>
            <div class="col-8">
                <p style="margin-top: 30px; color: white"> <strong>{{Auth::User()->name}}</strong></p>
            </div>
        </div>

        <div id="jquery-accordion-menu" class="jquery-accordion-menu">
            <ul>
                <li class="{{(Request::is('employee/dashboard') ? 'active' : '')}}"><a href="{{route('employee.dashboard')}}"><i class="flaticon-home"></i>হোম </a></li>
                <li class="{{(Request::is('employee/view-profile') ? 'active' : '')}}"><a href="{{route('employee.view-profile')}}"><i class="flaticon-user-1"></i> প্রোফাইল</a></li>
                <li class="{{(Request::is('employee/offer*') ? 'active' : '')}}"><a href="{{route('employee.offer-list')}}"><i class="flaticon-list"></i>অফার</a></li>
                <li class="{{(Request::is('employee/notification*') ? 'active' : '')}}"><a href="{{route('employee.notification')}}"><i class="flaticon-chat"></i>নোটিফিকেশন</a>
                    <span class="jquery-accordion-menu-label">
                        @php
                            $notViewNotificationCount = notViewNotificationCount();
                        @endphp
                        {{getNumberToBangla($notViewNotificationCount->count)}}
                    </span>
                </li>
{{--                <li class=""><a href="#"><i class="flaticon-chat"></i>নোটিফিকেশন</a></li>--}}
{{--                <li class=""><a href="#"><i class="flaticon-idea"></i>সাহায্য</a></li>--}}
            </ul>
            <form action="{{route('logout')}}" method="POST">
                @csrf
            <div class="jquery-accordion-menu-footer">
                <button class="submit text-white">
                <i class="flaticon-warning text-white"></i> লগ আউট
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
@push('js')
    <script src="{{asset('frontend/assets/js/jquery-accordion-menu.js')}}"></script>
@endpush
