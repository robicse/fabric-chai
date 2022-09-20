<?php

use App\Model\WorkOrderSaleRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('encryption/auth')->group(function () {
    Route::post('/seller-login','Api\AuthController@sellerLogin');
    Route::post('/buyer-login','Api\AuthController@buyerLogin');
    Route::post('/employer-login','Api\AuthController@employerLogin');
    Route::post('/employee-login','Api\AuthController@employeeLogin');
    Route::post('/receiver-login','Api\AuthController@receiverLogin');
    Route::post('/provider-login','Api\AuthController@providerLogin');
    Route::post('/register','Api\AuthController@register');
    Route::post('/employee/register','Api\AuthController@employeeRegister');
    Route::post('otp/send', 'Api\OtpVerificationController@OtpSend');
    Route::post('otp/checked', 'Api\OtpVerificationController@OtpCheck');
    Route::post('resend/otp', 'Api\OtpVerificationController@resendOtp');
    Route::post('phone-number/check', 'Api\AuthController@checkPhoneNumber');
    Route::post('change-password', 'Api\AuthController@changePass');

    Route::middleware('auth:api')->group(function () {
        Route::get('logout', 'Api\AuthController@logout');
        Route::get('user/profile/details', 'Api\AuthController@userDetails'); //======== user profile details ==========//
        Route::post('/profile-image/update', 'Api\AuthController@profileImageUpdate');

        // buyer...

        Route::post('buyer/apply-for-seller', 'Api\DashboardController@applyForSellerStore');
        Route::get('switch/to/seller', 'Api\DashboardController@switchToSeller');
        Route::post('buyer/profile/update', 'Api\ProfileController@buyerProfileUpdate');
        Route::post('buyer/password/update', 'Api\ProfileController@passwordUpdate');



        Route::middleware("language")->group(function () {
            //Buyer.....
            Route::get('buyer/recent/products', 'Api\ProductController@buyerRecentProduct');
            Route::get('buyer/recent/products-new/page_size={page_size}', 'Api\ProductController@buyerRecentProductPaginate');
            Route::get('buyer/recent/products-new-v2/page_size={page_size}', 'Api\ProductController@buyerRecentProductPaginateV2');
            Route::get('buyer/product/show/{id}', 'Api\ProductController@show')->name('buyer.products.show');
            Route::get('products/related/{id}', 'Api\ProductController@related')->name('products.related');
            Route::get('buyer/featured/products-new/page_size={page_size}', 'Api\ProductController@buyerFeaturedProductPaginate');
            Route::get('buyer/featured/products-new-v2/page_size={page_size}', 'Api\ProductController@buyerFeaturedProductPaginateV2');
            Route::get('buyer/my-products', 'Api\ProductController@buyerMyProducts');
            Route::get('buyer/profile/details', 'Api\ProfileController@buyerDetails');
            Route::get('buyer/all-products-list', 'Api\ProductController@buyerAllProducts');


            Route::get('buyer/all-products-list-new/page_size={page_size}', 'Api\ProductController@buyerAllProductsPagination');


            Route::get('buyer/my-bids', 'Api\ProductBidController@buyerMyBids');
            Route::get('buyer/accepted-bids', 'Api\ProductBidController@buyerAcceptedBids');
            Route::get('buyer/recorded-transaction', 'Api\ProductBidController@buyerRecordedTransaction');
            Route::get('buyer/requested-recorded-transaction', 'Api\ProductBidController@buyerRequestedRecordedTransaction');
            Route::get('buyer/accepted-bid-request', 'Api\ProductBidController@buyerAcceptedBidRequests');

            // seller...
            Route::get('seller/my-posts', 'Api\ProductController@sellerMyProducts');
            Route::get('seller/recent/products', 'Api\ProductController@sellerRecentProduct');
            Route::get('seller/featured/products', 'Api\ProductController@sellerFeaturedProduct');

            Route::get('seller/recent/products-new/page_size={page_size}', 'Api\ProductController@sellerRecentProductPagination');
            Route::get('seller/featured/products-new/page_size={page_size}', 'Api\ProductController@sellerFeaturedProductPagination');
            Route::get('seller/recent/products-new-v2/page_size={page_size}', 'Api\ProductController@sellerRecentProductPaginationV2');
            Route::get('seller/featured/products-new-v2/page_size={page_size}', 'Api\ProductController@sellerFeaturedProductPaginationV2');


            Route::get('seller/accepted-bids', 'Api\ProductBidController@sellerAcceptedBids');
            Route::get('accepted-bidder-details/{id}', 'Api\ProductBidController@AcceptedBidderDetails')->name('accepted-bidder-details');
            Route::get('accepted-buyer-details/{id}', 'Api\ProductBidController@AcceptedBuyerDetails')->name('accepted-buyer-details');
            Route::get('seller/my-bids', 'Api\ProductBidController@sellerMyBids');
            Route::get('seller/recorded-transaction', 'Api\ProductBidController@sellerRecordedTransaction');
            Route::get('seller/requested-recorded-transaction', 'Api\ProductBidController@sellerRequestedRecordedTransaction');
            Route::get('seller/transaction-list', 'Api\ProductBidController@sellerTransactionList');

            //Seller Buy request
            Route::get('seller/accepted-bid-request', 'Api\ProductBidController@sellerAcceptedBidRequests');
            Route::get('seller/all-requested-products', 'Api\ProductController@sellerAllRequests');
            Route::get('seller/all-requested-products-new/page_size={page_size}', 'Api\ProductController@sellerAllRequestsPaginate');

            Route::get('seller/all-sell-record', 'Api\AccountController@allSellRecord');
            Route::get('seller/all-sell-record-details', 'Api\AccountController@allSellRecordDetails');
            Route::get('seller/profile/details', 'Api\ProfileController@sellerDetails');

            //Review Api....
            Route::get('see-review/{id}', 'Api\ReviewController@seeReview')->name('see-review');
            Route::get('reviews', 'Api\ReviewController@index')->name('reviews.index');

            //Product Bids...
            Route::get('bidder-list/{id}', 'Api\ProductBidController@bidderList')->name('bidderList.index');
            Route::get('bidder-details/{id}', 'Api\ProductBidController@getBidderDetails')->name('bidders-details');

            //Notification get api...
            Route::get('/notifications', 'Api\NotificationController@index');
            Route::get('/notifications/count', 'Api\NotificationController@count');

            // seller => employer
            Route::get('employer/profile/details', 'Api\EmployerController@profileDetails');
            Route::get('employer/employee-details/{id}', 'Api\EmployerController@employeeDetails')->name('employee.details');
            Route::get('employer/offer-send/list', 'Api\EmployerOfferController@offerSendList');
            Route::get('employer/offer/details/{id}', 'Api\EmployerOfferController@offerDetail')->name('employer.offer.details');
            Route::get('employer/candidate-list/{id}', 'Api\EmployerOfferController@candidatesList');

            Route::get('employer/message/log/list', 'Api\EmployerMessageController@messageLogList');
            Route::get('employer/message-payment-history', 'Api\EmployerMessageController@messagePaymentHistory');
            Route::get('employer/shortlist', 'Api\ShortlistController@shortlist');
            Route::post('employer/search-employee', 'Api\EmployerController@searchEmployee');



            //Employee
            Route::get('employee/offer/list', 'Api\EmployeeOfferController@offerList');
            Route::get('employee/offer/details/{id}', 'Api\EmployeeOfferController@offerDetail')->name('offer.details');
            Route::get('employee/profile/details', 'Api\EmployeeController@profileDetails');

            Route::get('employee/education/details-list', 'Api\EmployeeController@educationDetails');
            Route::get('employee/job-experience/details-list', 'Api\EmployeeController@jobExperienceDetails');

            // seller => work order
            Route::get('work-order/seller-my-production-capability/list','Api\WorkOrderController@sellerWorkOrderProductList');
            Route::get('work-order/seller-my-production-capability/details/{id}','Api\WorkOrderController@sellerWorkOrderProductDetails');
            Route::get('work-order/seller-accept-quotation/{id}','Api\WorkOrderQuotationController@sellerAcceptQuotation');

            Route::get('work-order/seller-profile-details','Api\WorkOrderSellerProfileController@profileDetails');
            Route::get('work-order/seller-quotation-list/{id}','Api\WorkOrderQuotationController@sellerQuotationList');
            Route::get('work-order/seller-quotation-details/{id}','Api\WorkOrderQuotationController@sellerQuotationDetails');

            Route::get('work-order/seller-accepted-rfqs-list','Api\WorkOrderQuotationController@sellerAcceptedQuotationList');
            Route::get('work-order/seller-accepted-rfqs-details/{id}','Api\WorkOrderQuotationController@sellerAcceptedQuotationDetails');
            Route::get('work-order/see-review/{id}','Api\WorkOrderReviewController@seeReview');
            Route::get('work-order/seller-recorded-transaction','Api\WorkOrderReviewController@sellerRecordedTransaction');
            Route::get('work-order/notifications','Api\WorkOrderNotificationController@notificationList');
            Route::get('work-order/notifications-count','Api\WorkOrderNotificationController@notificationCount');
            Route::get('work-order/notifications-details/{id}','Api\WorkOrderNotificationController@notificationDetails');
            Route::get('work-order/reviews','Api\WorkOrderReviewController@workOrderReviewLists');

            // buyer => work order
            Route::get('work-order/buyer-all-work-order/list','Api\WorkOrderController@buyerWorkOrderProductList');
            Route::get('work-order/buyer-work-order/details/{id}','Api\WorkOrderController@buyerWorkOrderProductDetails');
            Route::get('work-order/buyer-featured-company/list','Api\WorkOrderController@buyerCompanyList');
            Route::get('work-order/buyer-featured-company/details/{id}','Api\WorkOrderController@buyerCompanyDetails');
            Route::get('work-order/buyer-featured-company-products/{id}','Api\WorkOrderController@buyerCompanyProducts');
            Route::get('work-order/buyer-submitted-rfqs/list','Api\WorkOrderQuotationController@buyerSubmittedRFQ');
            Route::get('work-order/buyer-accepted-rfqs/list','Api\WorkOrderQuotationController@buyerAcceptedRFQ');
            Route::get('work-order/buyer-accepted-rfqs/details/{id}','Api\WorkOrderQuotationController@buyerAcceptedRFQDetails');
            Route::get('work-order/buyer-recorded-transaction','Api\WorkOrderReviewController@buyerecordedTransaction');

        });


        // seller...
        Route::get('seller/verification-status', 'Api\ProfileController@sellerVerificationStatus');
        Route::get('seller/check-seller-current-commission-due-status','Api\ProductController@checkSellerCurrentCommissionDueStatus');


        Route::get('switch/to/buyer', 'Api\DashboardController@switchToBuyer');
        Route::post('seller/profile/update', 'Api\ProfileController@sellerProfileUpdate');
        Route::post('seller/password/update', 'Api\ProfileController@passwordUpdate');

        Route::post('for-review/{id}', 'Api\ReviewController@reviewSubmit')->name('for-review');
        Route::get('check-review/{id}', 'Api\ReviewController@checkReview')->name('check-review');
        Route::get('/bid-accept/{id}', 'Api\ProductBidController@bidAccept');


        //Product api...
        Route::post('product/create', 'Api\ProductController@productStore');
        Route::post('product/edit/{id}', 'Api\ProductController@productUpdate');
        Route::post('sizing-product/create', 'Api\ProductController@sizingProductStore');
        Route::post('sizing-product/edit/{id}', 'Api\ProductController@sizingProductUpdate');
        Route::post('dying-product/create', 'Api\ProductController@dyingProductStore');
        Route::post('dying-product/edit/{id}', 'Api\ProductController@dyingProductUpdate');
        //Product Bids...
        Route::post('product-bid/submit', 'Api\ProductBidController@productBidSubmit');
        Route::get('/notification-status/update/{id}', 'Api\NotificationController@statusUpdate');


        // SSLCOMMERZ Start
        // buy now membership package
        Route::get('buy-now/{id}', 'Api\PremiumMembershipController@buy_now');
        Route::get('/pay/{id}', 'Api\PublicSslCommerzPaymentController@index')->name('pay');
        Route::POST('/success', 'Api\PublicSslCommerzPaymentController@success');
        Route::POST('/fail', 'Api\PublicSslCommerzPaymentController@fail');
        Route::POST('/cancel', 'Api\PublicSslCommerzPaymentController@cancel');
        Route::POST('/ipn', 'Api\PublicSslCommerzPaymentController@ipn');
        // Pay commission ssl
        //Route::POST('pay-now/{id}','Api\AccountController@pay_now');
        Route::POST('pay-now','Api\AccountController@pay_now');
        Route::get('/commission-pay-ssl/{id}', 'Api\PublicSslCommerzPayment2Controller@index2');
        Route::POST('/success2', 'Api\PublicSslCommerzPayment2Controller@success2');
        Route::POST('/fail2', 'Api\PublicSslCommerzPayment2Controller@fail2');
        Route::POST('/cancel2', 'Api\PublicSslCommerzPayment2Controller@cancel2');
        Route::POST('/ipn2', 'Api\PublicSslCommerzPayment2Controller@ipn2');
        //SSL COMMERZ END

        // Stripe Start
        // buy now
        Route::get('buy-now-stripe/{id}','Api\PremiumMembershipController@buy_now_stripe');
        Route::post('buy-now-stripe','Api\PremiumMembershipController@buy_now_stripe_post');
        // pay now
        Route::get('pay-now-stripe/{id}','Api\StripePaymentController@stripe2');
        Route::post('pay-now-stripe','Api\StripePaymentController@stripe2Post');
        // Stripe End

        // seller => employer
        Route::post('/employer/register','Api\AuthController@employerRegister');
        Route::get('/switch-to-employer','Api\EmployerController@switchToEmployer');

        //Route::get('employer/profile/details', 'Api\EmployerController@profileDetails');
        Route::post('employer/profile/update', 'Api\EmployerController@profileUpdate');

        //Route::get('employer/employee-details/{id}', 'Api\EmployerController@employeeDetails')->name('employee.details');
        Route::post('employer/send-message/{id}', 'Api\EmployerController@employeeSendMessage')->name('employee.send-message');
        Route::get('employer/employee-shortlist/{id}', 'Api\EmployerController@employeeShortList')->name('employee.shortlist');
        Route::post('employer/employer_to_employee_multiple_message','Api\EmployerController@employerToEmployeeMultipleMessage');
        Route::post('pay-now-sms-cost','Api\EmployerMessageController@pay_now_sms_cost');
        Route::get('pay-now-sms-cost-ssl/{id}','Api\PublicSslCommerzPayment2Controller@index2');
//      Route::get('pay-now-sms-cost-strip/{id}','Api\StripePaymentController@stripe2Post');

        // employee

        Route::post('employee/profile/update', 'Api\EmployeeController@profileUpdate');
        Route::get('employee/current-job-status/update', 'Api\EmployeeController@jobStatusUpdate');
        Route::post('employee/reply-message', 'Api\EmployeeOfferController@offerReplyMessage');
        Route::get('employee/get-reply-message/{id}', 'Api\EmployeeOfferController@getReplyMessage');
        Route::post('employee/education/store', 'Api\EmployeeController@educationStore');
        Route::post('employee/education/update/{id}', 'Api\EmployeeController@educationUpdate');
        Route::delete('employee/education/destroy/{id}', 'Api\EmployeeController@educationDelete');

        Route::post('employee/job-experience/store', 'Api\EmployeeController@jobExperienceStore');
        Route::post('employee/job-experience/update/{id}', 'Api\EmployeeController@jobExperienceUpdate');
        Route::delete('employee/job-experience/destroy/{id}', 'Api\EmployeeController@jobExperienceDelete');


        // seller => work order

        Route::post('work-order/seller-production-capability/create', 'Api\WorkOrderController@sellerWorkOrderProductStore');
        Route::post('work-order/seller-production-capability/update/{id}', 'Api\WorkOrderController@sellerWorkOrderProductUpdate');
        Route::post('work-order/seller-profile-update','Api\WorkOrderSellerProfileController@profileUpdate');
        Route::post('work-order/review-submit','Api\WorkOrderReviewController@reviewSubmit');

        // buyer => work order
        Route::post('work-order/buyer-quotation-submit','Api\WorkOrderQuotationController@buyerQuotationSubmit');


        //Payment for IOS
        Route::post('ios-membership-package-payment','Api\PaymentController@iosMembershipPackagePayment');
        Route::post('ios-commission-payment','Api\PaymentController@iosCommissionPayment');
    });
});


Route::get('/our-products','Api\ProductController@ourProduct');

Route::get('/sliders','Api\SliderController@getSliders');
Route::get('/salary-ranges','Api\AuthController@getSalaryRanges');

Route::get('/selected-categories','Api\AuthController@getCategories');

Route::get('/home-page-ads','Api\SliderController@getHomeAds');
Route::get('/home-page-categories','Api\CategoryController@getHomeCategories');
Route::get('/priority-buyers','Api\FrontendController@priorityBuyers');
Route::get('/employer-dashboard-ads','Api\SliderController@getEmployerAds');




// BN EN
//Categories related api..
Route::middleware("language")->group(function () {
    // website related
    Route::get('/website-bn-en','Api\WebsiteController@getWebsiteBnEn');
    Route::get('/contact','Api\FrontendController@getContactBnEn');
    // categories related
    Route::get('/all-categories','Api\CategoryController@getAllCategories');
    Route::get('/categories','Api\CategoryController@getCategories');
    Route::get('sub-categories/{id}', 'Api\CategoryController@getSubCategories')->name('subCategories.index');
    Route::get('sub-sub-categories/{id}', 'Api\CategoryController@getSubSubCategories')->name('subSubCategories.index');
    Route::get('sub-sub-child-categories/{id}', 'Api\CategoryController@getsubSubChildCategories')->name('subSubChildCategories.index');
    Route::get('sub-sub-child-child-categories/{id}', 'Api\CategoryController@getsubSubChildChildCategories')->name('subSubChildChildCategories.index');
    Route::get('category-six/{id}', 'Api\CategoryController@getCategorySix')->name('categorySix.index');
    Route::get('category-seven/{id}', 'Api\CategoryController@getCategorySeven')->name('categorySeven.index');
    Route::get('category-eight/{id}', 'Api\CategoryController@getCategoryEight')->name('categoryEight.index');
    Route::get('category-nine/{id}', 'Api\CategoryController@getCategoryNine')->name('categoryNine.index');
    Route::get('category-ten/{id}', 'Api\CategoryController@getCategoryTen')->name('categoryTen.index');
    Route::get('/units','Api\ProductController@getUnit');
    Route::get('/dying-categories','Api\ProductController@getDyningCategories');
    Route::get('/dying-sub-categories/{id}','Api\ProductController@getDyningSubcategories')->name('dyingSubCategories.index');

    Route::get('/product-details/{id}','Api\ProductController@getProductDetails')->name('product.details');
    Route::get('product-details/reviews/{id}', 'Api\ReviewController@reviewLists')->name('reviews');

    // Frontend Products..
    Route::post('/frontend/seller-recent-products','Api\SearchProductController@getSellerRecentProducts');
    Route::post('/frontend/buyer-recent-products','Api\SearchProductController@getBuyerRecentProducts');

    Route::post('/frontend/seller-featured-products','Api\SearchProductController@getSellerFeaturedProducts');
    Route::post('/frontend/buyer-featured-products','Api\SearchProductController@getBuyerFeaturedProducts');

    // Frontend Products Pagination..
    Route::post('/frontend/seller-recent-products-new/page_size={page_size}','Api\SearchProductController@getSellerRecentProductsPagination');
    Route::post('/frontend/buyer-recent-products-new/page_size={page_size}','Api\SearchProductController@getBuyerRecentProductsPagination');
    Route::post('/frontend/buyer-recent-products-new-v2/page_size={page_size}','Api\SearchProductController@getBuyerRecentProductsPaginationV2');
    Route::post('/frontend/seller-recent-products-new-v2/page_size={page_size}','Api\SearchProductController@getSellerRecentProductsPaginationV2');

    Route::post('/frontend/seller-featured-products-new/page_size={page_size}','Api\SearchProductController@getSellerFeaturedProductsPagination');
    Route::post('/frontend/buyer-featured-products-new/page_size={page_size}','Api\SearchProductController@getBuyerFeaturedProductsPagination');
    Route::post('/frontend/seller-featured-products-new-v2/page_size={page_size}','Api\SearchProductController@getSellerFeaturedProductsPaginationV2');
    Route::post('/frontend/buyer-featured-products-new-v2/page_size={page_size}','Api\SearchProductController@getBuyerFeaturedProductsPaginationV2');

    Route::post('/search-products','Api\SearchProductController@getSearchProducts');
    Route::post('/search-products-new/page_size={page_size}','Api\SearchProductController@getSearchProductsPagination');
    Route::post('/search-products-v2/page_size={page_size}','Api\SearchProductController@getSearchProductsPaginationV2');



    Route::get('/industry-categories','Api\IndustryCategoryController@getIndustryCategories');
    Route::get('industry-sub-categories/{id}', 'Api\IndustryCategoryController@getIndustrySubCategories')->name('industrySubCategories.index');
    Route::get('industry-employee-type/{id}', 'Api\IndustryCategoryController@getIndustryEmployeeTypes')->name('industryEmployeeTypes.index');

    Route::get('/countries','Api\ProductController@getCountries');
    Route::get('/divisions','Api\AuthController@getDivisions');
    Route::get('/districts/{id}','Api\AuthController@getDistricts');
    Route::get('/upazila/{id}','Api\AuthController@getThanas');
    Route::get('/union/{id}','Api\AuthController@getPostOffices');
    Route::get('/city-corporations','Api\EmployeeController@getCityCorporation');

    Route::get('/membership-packages','Api\MembershipPackageController@packageLists');
    Route::get('/about-us','Api\AboutController@about_us');
    Route::get('/dynamic-pages','Api\AboutController@dynamic_pages');
    Route::get('/our-products-v2','Api\ProductController@ourProductV2');
    Route::get('/product-and-services','Api\ProductController@productAndServices');
    Route::get('/product-and-services-details/{slug}','Api\ProductController@productAndServicesDetails');

});


//membership package Api...

Route::get('/membership-packages-details','Api\MembershipPackageController@packageDetails');
Route::get('/membership-packages-other-benefits','Api\MembershipPackageController@packageOtherBenefits');

//Work Order Categories related api..
Route::get('/work-order/categories','Api\CategoryController@getCategories');

//Industry  Categories related api..

//Currency api..
Route::get('/currencies','Api\ProductController@getCurrency');
Route::get('/colors','Api\ProductController@getColors');

Route::get('/education-levels','Api\EmployeeController@geteducationLevels');
Route::get('/education-degree/{id}','Api\EmployeeController@getEducationDegree');

Route::fallback(function() {
    return response()->json([
        'data' => [],
        'success' => false,
        'status' => 404,
        'message' => 'Invalid Route plz check in route file'
    ]);
});


