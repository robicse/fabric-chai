<style>
    .footer_link{
        display: inline-block;
        float: left;
        width: 35px;
        height: 35px;
        font-size: 16px;
        color: #FFF;
        text-decoration: none;
        cursor: pointer;
        text-align: center;
        line-height: 34px;
        background: #000;
        position: relative;
        transition: 0.5s;
    }
    .instagram{
        background: #f09433;
        background: -moz-linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        background: -webkit-linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%);
        background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f09433', endColorstr='#bc1888',GradientType=1 );
    }
   .h6{
       color: white;
       font-size: 18px;
       font-weight: 600;
   }

    element.style {
        color: #CACACC;
    }
    .footer-widget li a {
        color: #818181;
        line-height: 28px;
        font-weight: 400;
        font-size: 16px;
    }
    .footer-widget li a {
        display: inline-block;
    }
    body, .nav-general .navbar-nav .nav-link, .list-color-general li a, .footer-widget li a, .list-color-general a, .footer-widget.quick-links a, .footer-widget.contact-us a {
        color: var(--theme-general-color);
    }
    @media only screen and (min-width: 700px) {
        .app-info{
            margin-left: 80px;
        }

    }

</style>

<footer class="full-row bg-light" style="background-color: #2e2e54!important; margin-bottom: -40px;">
    <div class="container" style="margin-top: -2%;">
        <div class="row">
                    <div class="col-lg-4 col-md-6" >
                <div class="footer-widget category-widget mb-5" style="margin-left: 60px">
                    <h3 class="widget-title mb-1" style="color: white">@lang('website.About Fabric Lagbe')</h3>
                    <ul>
                        <li><a href="{{route('about-us')}}" style="color:#CACACC; font-size: 18px;">@lang('website.About Us')</a></li>
                        <li><a href="{{route('terms-conditions')}}" style="color:#CACACC; font-size: 18px;">@lang('website.Terms & Conditions')</a></li>
                        <li><a href="{{route('privacy-and-policy')}}" style="color:#CACACC; font-size: 18px;">@lang('website.Privacy and Policy')</a></li>
                        <li><a href="{{route('cookies-policy')}}" style="color:#CACACC; font-size: 18px;">@lang('website.Cookies Policy')</a></li>
                        <li><a href="{{route('return-refund-policy')}}" style="color:#CACACC; font-size: 18px;">@lang('website.Return & Refund Policy')</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="footer-widget category-widget mb-5" style="margin-left: 70px">
                    <h3 class="widget-title mb-1" style="color: white">@lang('website.Help & Support')</h3>
                    <ul>
                        <li><a href="{{route('faq')}}" style="color:#CACACC; font-size: 18px;">@lang('website.FAQ')</a></li>
                        <li><a href="{{route('contact-us')}}" style="color:#CACACC; font-size: 18px;">@lang('website.Contact Us')</a></li>
                        <li><a href="{{route('stay-safe')}}" style="color:#CACACC; font-size: 18px;">@lang('website.Stay Safe')</a></li>
                        <li style="color:#CACACC; font-size: 18px;">
                            @lang('website.Total Visits'):
                            <span style="color:green; font-size: 18px;">{{$total_visits}}</span>
                        </li>
{{--                        <li style="color:#CACACC; font-size: 18px;">--}}
{{--                            Today Visits:--}}
{{--                            <span style="color:green; font-size: 18px;">{{today_visits()}}</span>--}}
{{--                        </li>--}}
                      <li style="color:#CACACC; font-size: 18px;">
                          @lang('website.Monthly Visits'):
                       <span style="color:green; font-size: 18px;">{{permonth_visits()}}</span>
                       </li>
                    </ul>
                </div>
            </div>


            <div class="col-lg-3 col-md-5">
                <div class="footer-widget widget-nav mb-1 app-info" style="">
                    <h3 class="widget-title mb-4" style="color: white">@lang('website.Download App')</h3>
                    <a href="https://apps.apple.com/us/app/fabrics-lagbe/id1602076325" target="_blank"><img class="mb-1" src="{{asset('frontend/app_store.png')}}" alt="App Store" width="200" height="auto"></a>
                    <a href="https://play.google.com/store/apps/details?id=com.apps.fabricslagbe" target="_blank"><img src="{{asset('frontend/google_play.png')}}" alt="Play Store" width="200" height="auto"></a>
                </div>

                <div class="footer-widget media-widget mt-5" style="margin-left: 80px">
                    <h3 class="widget-title mb-4" style="color: white">@lang('website.Follow Us')</h3>
                    <a href="https://www.facebook.com/Fabriclagbe/" class="footer_link" target="_blank" style="background: #3b579d;"><i class="fab fa-facebook-f" style="color: white"></i></a>
                    <a href="https://twitter.com/FabricLagbe" class="footer_link" target="_blank" style="background: #50ABF1;"><i class="fab fa-twitter" style="color: white"></i></a>
                    <a href="https://www.linkedin.com/company/73799287/admin/" class="footer_link" target="_blank" style="background: #0278B0;"><i class="fab fa-linkedin-in" style="color: white"></i></a>
                    <a href="https://www.instagram.com/fabriclagbe/" class="footer_link instagram" target="_blank" ><i class="fab fa-instagram" style="color: white"></i></a>
                    <a href="https://www.youtube.com/channel/UCzOU8eOKckZDimZOxgQ5dWg" class="footer_link instagram" target="_blank" ><i class="fab fa-youtube" style="color: white"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!--==================== Copyright Section Start ====================-->
<div class="full-row copyright bg-gray py-3" style="border-top: 1px solid #dddddd">
    <div class="container">
        <div class="row">
            <div  id="google_translate_element"></div>
            <div class="col-md-4">
                <span class="text-dark sm-mb-10 d-block">© {{getNumberToBangla(date('Y'))}} @lang('website.Fabric Lagbe'), @lang('website.All right reserved.')</span>
            </div>
            <div class="col-md-4">
                @lang('website.Powered by')
                <img src="{{asset('frontend/ssl.png')}}" width="100" height="20">
                <img src="{{asset('frontend/basis.svg')}}" width="100" height="20">
                <img src="{{asset('frontend/ecab.png')}}" width="100" height="30">
            </div>
            <div class="col-md-4">
                <ul class="list-ml-30 d-flex align-items-center justify-content-md-end">
                    <li>
                 <img src="{{asset('frontend/payment2.jfif')}}" alt="" height="40px;" width="700">
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!--==================== Copyright Section End ====================-->

<!-- Scroll to top -->
<a href="#" class="bg-danger text-white" id="scroll"><i class="fa fa-angle-up"></i></a>
<!-- End Scroll To top -->
{{--<script type="text/javascript"> //<![CDATA[--}}
{{--    var tlJsHost = ((window.location.protocol == "https:") ? "https://secure.trust-provider.com/" : "http://www.trustlogo.com/");--}}
{{--    document.write(unescape("%3Cscript src='" + tlJsHost + "trustlogo/javascript/trustlogo.js' type='text/javascript'%3E%3C/script%3E"));--}}
{{--    //]]></script>--}}
{{--<script language="JavaScript" type="text/javascript">--}}
{{--    TrustLogo("https://www.positivessl.com/images/seals/positivessl_trust_seal_lg_222x54.png", "POSDV", "none");--}}
{{--</script>--}}

