@extends('frontend.layouts.master')
@section('title','Product Details')

@push('css')
    <link rel="stylesheet" href="{{asset('frontend/assets/x-zoom/css/xzoom.min.css')}}">

    <style>
        .padding_bottom{
            padding-bottom: 20px;
        }
        .img_size{
            height: 400px; width: 350px;
        }
        .fp_top{
            margin-top: 20px;
        }
        .p_top_20{
            padding-top: 20px;
        }
        .border_st{
            border: 1px solid #dddddd;
        }
        .currency_bdt{
            display: {{currency()->code == 'BDT' ? 'block' : 'none'}}
        }
        .currency_usd{
            display: {{currency()->code == 'USD' ? 'block' : 'none'}}
        }
        .font_20{
            font-size: 20px!important;
        }
        .font_14{
            font-size: 14px!important;
        }
        .m_top_30{
            margin-top: 30px;
        }
        .m_l_20{
            margin-left: 20px;
        }
        .m_t_10{
            margin-top: -10px;
        }
        .text-bold{
            font-weight: bold;
        }
        @media (max-width:700px){
            .xzoom-gallery3{
                width: 80px;
            }
        }
    </style>
@endpush

@section('content')

    <div class="full-row bg-white" >
        <div class="container">
            <div class="padding_bottom">
                <h5 class="d-inline">@lang('website.Category'): <a class="" href="#"> {{allCategoryPrint($detailedProduct)}} </a></h5>
            </div>
            <div class="row single-product-wrapper">
                <div class="col-12 col-md-6 col-lg-5">
                    <div class="xzoom-container">
                        <img class="img-fluid xzoom3 img_size" src="{{url($detailedProduct->thumbnail_img)}}" xoriginal="{{url($detailedProduct->thumbnail_img)}}" />
                        <div class="xzoom-thumbs">
                            @if(count($photos) > 0)
                                @foreach($photos as $key2 => $photo)
                                    <a href="{{url($photo)}}">
                                        <img class="xzoom-gallery3" width="80" src="{{url($photo)}}" @if($key2 == 0) xpreview="{{url($photo)}}" @endif title="">
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-7">
                    <div class="summary entry-summary">
                        <div class="summary-inner">
                            <h1 class="product_title entry-title">{{getNameByBnEn($detailedProduct)}}</h1>
                            <div class="woocommerce-product-rating">
                                <div class="fancy-star-rating">
                                    <div class="rating-wrap">
                                        <div class="star-rating star-rating-sm mt-1">
                                            {{ renderStarRating($detailedProduct->rating) }}
                                        </div>
                                    </div>
                                    <div class="rating-counts-wrap">
                                        <a href="#reviews" class="bigbazar-rating-review-link" rel="nofollow"> <span
                                                class="rating-counts">({{$detailedProduct->rating > 0 ? getNumberToBangla($detailedProduct->rating) : getNumberToBangla(0)}} of {{getNumberToBangla(5)}})</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <span class="d-inline">@lang('website.Category'): <a class="" href="#">{{allCategoryPrint($detailedProduct)}} </a></span>
                            </div>
                            <hr class="border-dark">
                            @if($detailedProduct->category_id == 9 && $detailedProduct->sizingProduct)
                                {{sizingProductDetails($detailedProduct)}}
                            @elseif($detailedProduct->category_id == 7 && $detailedProduct->dyingProduct)
                                {{dyingProductDetails($detailedProduct)}}
                            @else
                                <div>
                                    @lang('website.Quantity'):
                                    <span class="stock-availability in-stock text-success font-500">
                                        <strong class="">{{ getNumberToBangla($detailedProduct->quantity) }} {{$detailedProduct->unit ? getNameByBnEn($detailedProduct->unit) : ''}}</strong>
                                </span>
                                </div>

                                <div class="">
                                    @lang('website.Unit Price'):
                                    <span>
                                        <span class="text-danger text-bold font-500">
                                            @if(currency()->code == 'BDT')
                                                <strong class="text-danger">{{ getNumberWithCurrencyByBnEn($detailedProduct->unit_price) }}</strong>
                                            @else
                                                <strong class="text-danger">{{ getNumberWithCurrencyByBnEn($detailedProduct->unit_price) }}</strong>
                                            @endif
                                        </span>
                                    </span>
                                </div>

                                <div class="">
                                    @lang('website.Total Price'):
                                    <span>
                                        <span class="text-danger text-bold font-500">
                                            @if(currency()->code == 'BDT')
                                                <strong class="text-danger">{{ getNumberWithCurrencyByBnEn($detailedProduct->expected_price) }}</strong>
                                            @else
                                                <strong class="text-danger">{{ getNumberWithCurrencyByBnEn($detailedProduct->expected_price) }}</strong>
                                            @endif
                                        </span>
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if(!empty(productAuthCheck($detailedProduct->id)))
                        <div class="row fp_top">
                            @if(Auth::user()->user_type == 'seller')
                                <div class="col-md-6 col-6">
                                    <a class="btn btn-info" href="{{route('seller.bidder-list',$detailedProduct->slug)}}"> @lang('website.Bidder List')</a>
                                </div>
                                <div class="col-md-6 col-6">
                                    <a class="btn btn-success" href="{{route('seller.dashboard')}}"> @lang('website.Close')</a>
                                </div>
                            @else

                                <div class="col-md-6 col-6">
                                    <a class="btn btn-info" href="{{route('buyer.bidder-list',$detailedProduct->slug)}}"> @lang('website.Bidder List')</a>

                                </div>
                                <div class="col-md-6 col-6">
                                    <a class="btn btn-success" href="{{route('buyer.dashboard')}}"> @lang('website.Close')</a>
                                </div>
                            @endif
                        </div>

                    @else
                        @php
                            $checkMembershipStatus = checkMembershipStatus(Auth::User()->id);
                            $checkBidder = \App\Model\ProductBid::where('product_id',$detailedProduct->id)->where('sender_user_id',Auth::id())->first();
                        @endphp
                        @if(!empty($checkBidder))
                            <h4 class="p_top_20">You have already bidden for this product</h4>
                        @else
                            <form action="{{route('product-bid.store')}}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" id="product_id" value="{{$detailedProduct->id}}">
                                <div class="mt-3">
                                    <div class="row">
                                        <div class="col-3">
                                            <h5>@lang('website.Bid Price') (@lang('website.Unit')) (@lang('website.'.currency()->code)):</h5>
                                        </div>
                                        <div class="col-md-6 col-9">
                                            <div class="form-group d-inline">
                                                <input type="hidden" class="form-control" name="qty" id="qty" value="{{$detailedProduct->quantity}}">
                                                <input type="number" class="form-control border_st" name="bid_price" id="bid_price" min="0" step="0.00001" placeholder="({{currency_symbol()}}) @lang('website.Enter Your Bid Amount by Unit Price')" onkeyup="get_bid_price(this)" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <h5>@lang('website.Bid Price') (@lang('website.Total')) (@lang('website.'.currency()->code)):</h5>
                                        </div>
                                        <div class="col-md-6 col-9">
                                            <div class="form-group d-inline">
                                                <input type="number" class="form-control bg-gray-light" name="" id="bid_total_price" min="0" step="0.00001" placeholder="0" readonly required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-3">
                                            <h5>@lang('website.Bid Price') (@lang('website.Unit')) (@lang('website.'.currency()->code == 'BDT' ? 'USD' : 'BDT')):</h5>
                                        </div>
                                        <div class="col-md-6 col-9">
                                            <div class="form-group d-inline">
                                                <input type="number" class="form-control bg-gray-light" name="" id="bid_convert_unit_price" min="0" step="0.00001" placeholder="0" readonly required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <h5>@lang('website.Bid Price') (@lang('website.Total')) (@lang('website.'.currency()->code == 'BDT' ? 'USD' : 'BDT')):</h5>
                                        </div>
                                        <div class="col-md-6 col-9">
                                            <div class="form-group d-inline">
                                                <input type="number" class="form-control bg-gray-light" name="" id="bid_convert_total_price" min="0" step="0.00001" placeholder="0" readonly required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">&nbsp;</div>
                                        <div class="col-6">
                                            <div class="form-group d-inline pb-2 mb-2">
                                                <div>&nbsp;</div>
                                                <button type="button" class="btn btn-success" data-bs-toggle="modal" onclick="get_bidPrice()" data-bs-target="#staticBackdrop">
                                                    @lang('website.Bid for Trade')
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-center" id="staticBackdropLabel">@lang('website.Are you sure?')</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div>
                                                    <p>@lang('website.Are you sure you want to Place the following bid?')</p>
                                                </div>
                                                <div>
                                                    <p><span class="text-black ">@lang('website.Name'):</span> {{getNameByBnEn($detailedProduct->user)}}<br>
                                                        <span class="text-black ">@lang('website.Total Amount'):</span>
                                                        @if($detailedProduct->category_id == 9 && $detailedProduct->sizingProduct)
                                                            {{getNumberWithCurrencyByBnEn($detailedProduct->sizingProduct->total_price)}}
                                                        @else
                                                            {{getNumberWithCurrencyByBnEn($detailedProduct->expected_price)}}
                                                        @endif
                                                        <br>
                                                        <span class="text-black ">@lang('website.Product Name'):</span> {{getNameByBnEn($detailedProduct)}}
                                                    </p>
                                                </div>
                                                @php
                                                    $popUp = \App\Model\PopUp::where('type','bid_submit')->first();
                                                @endphp
                                                <div class="currency_bdt">
                                                    <div class="font_20">
                                                        {!! $popUp->description_bn !!}
{{--                                                        <p>--}}
{{--                                                            ১. আপনি এই বিডে অংশগ্রহণ বা সম্মতি দেওয়া মানে আপনি ১০০% নিশ্চিত যে, পণ্যটি আপনি ক্রয় করবেন।--}}
{{--                                                        </p>--}}
{{--                                                        <p>--}}
{{--                                                            ২. বিডটি সেলার দ্বারা একসেপ্ট হওয়ার পর, আপনার নাম, ফোন নম্বর,সেলার এর ডেশবোর্ড এ প্রদর্শন হবে এবং সেলার আপনার সাথে পরবর্তী লেনদেনের জন্য যোগাযোগ করবে তখন আপনার রেসপন্স আবশ্যক।--}}
{{--                                                        </p>--}}
{{--                                                        <p>--}}
{{--                                                            ৩. অ্যাপ কর্তৃপক্ষ  কোন লেনদেন বা পণ্য সম্পর্কিত সমস্যার জন্য কোন দায় নিবে না। এই পণ্যটির মূল্য প্রদান, বিতরণ, গুণগতমান, পরিমান, পরিমাপ, পরীক্ষার প্যারামিটার ক্রেতা এবং বিক্রেতা ম্যানুয়ালি পরিচানলা করবে। Fabric Lagbe কর্তৃপক্ষ উপরোক্ত বিষয়গুলির জন্য দায়বদ্ধ থাকবে না।--}}
{{--                                                        </p>--}}
{{--                                                        <p>--}}
{{--                                                            ৪. যদি কোন কারণে লেনদেন অথবা ডেলিভারি  অসম্পূর্ণ থাকে, তাহলে অবশ্যই  দুই পক্ষকেই (বায়ার & সেলার) পরবর্তী ২ দিনের মধ্যে  FLL কর্তৃপক্ষকে বিষয়টি লিখিত ভাবে জানাতে হবে।--}}
{{--                                                        </p>--}}
                                                    </div>
                                                    <div class="font_14">
                                                        {!! $popUp->description !!}
{{--                                                        <p>--}}
{{--                                                            1. By participating or agreeing to this bid, you are 100% sure that you will purchase the product.--}}
{{--                                                        </p>--}}
{{--                                                        <p>--}}
{{--                                                            2. Once the bid is accepted by the seller, your name, phone number, will be displayed on the seller's--}}
{{--                                                            dashboard and your response is required when the seller will contact you for the next transaction.--}}
{{--                                                        </p>--}}
{{--                                                        <p>--}}
{{--                                                            3. App Authority will not take any responsibility for any transaction or product related issues. The price,--}}
{{--                                                            delivery, quality, quantity, measurement, test parameters of this product will be manually guided by the--}}
{{--                                                            buyer and seller. The Fabric Lagbe Authority shall not be liable for any of the above.--}}
{{--                                                        </p>--}}
{{--                                                        <p>--}}
{{--                                                            4. If for any reason the transaction or delivery is incomplete, both parties (buyer & seller) must notify the--}}
{{--                                                            FLL authorities in writing within the next 2 days.--}}
{{--                                                        </p>--}}
                                                    </div>
                                                </div>
                                                <div class="currency_usd">
                                                    <div class="font_20">
                                                        {!! $popUp->description !!}
{{--                                                        <p>--}}
{{--                                                            1. By participating or agreeing to this bid, you are 100% sure that you will purchase the product.--}}
{{--                                                        </p>--}}
{{--                                                        <p>--}}
{{--                                                            2. Once the bid is accepted by the seller, your name, phone number, will be displayed on the seller's--}}
{{--                                                            dashboard and your response is required when the seller will contact you for the next transaction.--}}
{{--                                                        </p>--}}
{{--                                                        <p>--}}
{{--                                                            3. App Authority will not take any responsibility for any transaction or product related issues. The price,--}}
{{--                                                            delivery, quality, quantity, measurement, test parameters of this product will be manually guided by the--}}
{{--                                                            buyer and seller. The Fabric Lagbe Authority shall not be liable for any of the above.--}}
{{--                                                        </p>--}}
{{--                                                        <p>--}}
{{--                                                            4. If for any reason the transaction or delivery is incomplete, both parties (buyer & seller) must notify the--}}
{{--                                                            FLL authorities in writing within the next 2 days.--}}
{{--                                                        </p>--}}
                                                    </div>
                                                    <div class="font_14">
                                                        {!! $popUp->description_bn !!}
{{--                                                        <p>--}}
{{--                                                            ১. আপনি এই বিডে অংশগ্রহণ বা সম্মতি দেওয়া মানে আপনি ১০০% নিশ্চিত যে, পণ্যটি আপনি ক্রয় করবেন।--}}
{{--                                                        </p>--}}
{{--                                                        <p>--}}
{{--                                                            ২. বিডটি সেলার দ্বারা একসেপ্ট হওয়ার পর, আপনার নাম, ফোন নম্বর,সেলার এর ডেশবোর্ড এ প্রদর্শন হবে এবং সেলার আপনার সাথে পরবর্তী লেনদেনের জন্য যোগাযোগ করবে তখন আপনার রেসপন্স আবশ্যক।--}}
{{--                                                        </p>--}}
{{--                                                        <p>--}}
{{--                                                            ৩. অ্যাপ কর্তৃপক্ষ  কোন লেনদেন বা পণ্য সম্পর্কিত সমস্যার জন্য কোন দায় নিবে না। এই পণ্যটির মূল্য প্রদান, বিতরণ, গুণগতমান, পরিমান, পরিমাপ, পরীক্ষার প্যারামিটার ক্রেতা এবং বিক্রেতা ম্যানুয়ালি পরিচানলা করবে। Fabric Lagbe কর্তৃপক্ষ উপরোক্ত বিষয়গুলির জন্য দায়বদ্ধ থাকবে না।--}}
{{--                                                        </p>--}}
{{--                                                        <p>--}}
{{--                                                            ৪. যদি কোন কারণে লেনদেন অথবা ডেলিভারি  অসম্পূর্ণ থাকে, তাহলে অবশ্যই  দুই পক্ষকেই (বায়ার & সেলার) পরবর্তী ২ দিনের মধ্যে  FLL কর্তৃপক্ষকে বিষয়টি লিখিত ভাবে জানাতে হবে।--}}
{{--                                                        </p>--}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-success" data-bs-dismiss="modal">@lang('website.Close')</button>
                                                @php
                                                    $membership_package_id = checkMembershipStatus(Auth::id());
                                                    $user_type = checkUserType(Auth::id());
                                                @endphp

                                                @if($user_type == 'seller' && $membership_package_id == 1)
                                                    <button class="btn btn-success" type="button"
                                                            onclick="upgradePackage({{$detailedProduct->id}})">
                                                        Submit Bid
                                                    </button>
                                                @else
                                                    <button type="submit" class="btn btn-success">@lang('website.Submit Bid')</button>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row no-gutters mt-4">
                                <div class="col-2">
                                    <div class="product-description-label mt-2">@lang('website.Share'):</div>
                                </div>
                                <div class="col-10">
                                    <div id="share"></div>
                                </div>
                            </div>
                        @endif
                    @endif

                    <div class="row m_top_30" >
                        @php
                            $reviews = \App\Model\Review::where('receiver_user_id',$detailedProduct->user_id)->get();
                        @endphp
                        <div class="col-12">
                            <div class="section-head border-bottom">
                                <div class="woocommerce-tabs wc-tabs-wrapper ps-0">
                                    <ul class="nav nav-pills wc-tabs" id="pills-tab-one" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active font_20 text-bold" id="pills-description-one-tab" data-bs-toggle="pill"
                                               href="#pills-description-one" role="tab" aria-controls="pills-description-one"
                                               aria-selected="true">@lang('website.Description')</a>
                                        </li>
                                        <li class="nav-item m_l_20" role="presentation">
                                            <a class="nav-link font_20" id="pills-reviews-one-tab" data-bs-toggle="pill"
                                               href="#pills-reviews-one" role="tab" aria-controls="pills-reviews-one"
                                               aria-selected="true"> @lang('website.Reviews')({{$reviews->count()}})</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="woocommerce-tabs wc-tabs-wrapper ps-0 mt-0">
                                <div class="tab-content" id="pills-tabContent-one">
                                    <div
                                        class="tab-pane fade show active woocommerce-Tabs-panel woocommerce-Tabs-panel--description"
                                        id="pills-description-one" role="tabpanel" aria-labelledby="pills-description-one-tab">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h5 class="my-3">@lang('website.Product Description')</h5>
                                                <p class="text-justify" style="font-size: 18px;">{!! $detailedProduct->description !!}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="pills-reviews-one" role="tabpanel"
                                         aria-labelledby="pills-reviews-one-tab">
                                        <div class="row">
                                            <div class="col-8">
                                                <div id="comments">
                                                    <h5 class="woocommerce-Reviews-title my-3">({{getNumberToBangla($reviews->count())}}) @lang('website.Reviews')</h5>
                                                    <ol class="commentlist">

                                                        @foreach($reviews as $review)

                                                            <li>
                                                                <div class="comment_container">
                                                                    {{--                                                                <img src="{{asset('frontend/assets/images/avatar.png')}}"--}}
                                                                    <img src="{{url($review->sender->avatar_original)}}"
                                                                         class="avatar" alt="Image not found!">
                                                                    <div class="comment-text">
                                                                        <div class="star-rating" role="img"
                                                                             aria-label="Rated 5 out of 5">
                                                                            <i class="flaticon-star-1"></i>
                                                                            <i class="flaticon-star-1"></i>
                                                                            <i class="flaticon-star-1"></i>
                                                                            <i class="flaticon-star-1"></i>
                                                                            <i class="flaticon-star-1"></i>
                                                                        </div>
                                                                        <p class="meta">
                                                                            <strong
                                                                                class="woocommerce-review__author">{{$review->sender->name}} </strong>
                                                                            <span class="woocommerce-review__dash">–</span>
                                                                            <span class="woocommerce-review__published-date">{{getDateConvertByBnEn($detailedProduct->created_at)}}</span>

                                                                        </p>
                                                                        <div class="description m_t_10">
                                                                            <p>{!! $review->comment !!}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ol>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="bigbazar-wc-message"></div>
                </div>
            </div>
        </div>
    </div>





@endsection
@push('js')
    <script src="{{asset('frontend/assets/x-zoom/dist/xzoom.min.js')}}"></script>
    <script src="{{asset('frontend/assets/x-zoom/setup.js')}}"></script>
    <script>
        function get_bidPrice() {
            var bid_price = $('#bid_price').val();
            console.log(bid_price)
            $('#bidPrice').val(bid_price);
        }

        function get_bid_price(el){
            var bid_price = el.value;
            var qty = $('#qty').val();
            //console.log(el.value)
            $.post('{{ route('bid.price.convert') }}',
                {
                    _token:'{{ csrf_token() }}',
                    bid_price:bid_price,
                    qty:qty
                },
                function(data){
                    // location.reload();
                    console.log(data);
                    $('#bid_total_price').val(data.bid_total_price);
                    $('#bid_convert_unit_price').val(data.bid_convert_unit_price);
                    $('#bid_convert_total_price').val(data.bid_convert_total_price);
                });
        }
    </script>

    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script>
        $(function () {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });

        //sweet alert
        function upgradePackage(id) {
            swal({
                title: 'Package Upgrade?',
                text: "You won't be able to bid without upgrade package!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, upgrade it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    //document.getElementById('upgrade-form').submit();
                    let url =  "{{ route('seller.memberships-package-list') }}";
                    window.location = url;
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelled',
                        'Your Data is save :)',
                        'error'
                    )
                }
            })
        }
    </script>
@endpush
