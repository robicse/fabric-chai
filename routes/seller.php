<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// SSLCOMMERZ Start
Route::get('/pay2', 'PublicSslCommerzPayment2Controller@index2')->name('pay2');
Route::POST('/success2', 'PublicSslCommerzPayment2Controller@success2');
Route::POST('/fail2', 'PublicSslCommerzPayment2Controller@fail2');
Route::POST('/cancel2', 'PublicSslCommerzPayment2Controller@cancel2');
Route::POST('/ipn2', 'PublicSslCommerzPayment2Controller@ipn2');
// SSLCOMMERZ END

// Stipe Start
// pay commission
Route::get('stripe2', 'StripePaymentController@stripe2');
Route::post('stripe2', 'StripePaymentController@stripe2Post')->name('stripe2.post');
Route::get('stripe3', 'StripePaymentController@stripe3');
Route::post('stripe3', 'StripePaymentController@stripe3Post')->name('stripe3.post');
// Stripe END


Route::group(['as'=>'seller.','prefix' =>'seller', 'middleware' => ['auth', 'seller']], function(){

    Route::get('dashboard','Seller\DashboardController@index')->name('dashboard');
    Route::get('/switch_to_buyer', 'Seller\DashboardController@switchToBuyer')->name('switch_to_buyer');

    Route::get('recent-product-list','Seller\DashboardController@allRecentProducts')->name('view-all-recent-product');
    Route::get('featured-product-list','Seller\DashboardController@allFeaturedProducts')->name('view-all-featured-product');

    //Seller Profile management....
    Route::get('/view-profile', 'Seller\ProfileController@viewProfile')->name('view-profile');
    Route::get('/edit-profile', 'Seller\ProfileController@editProfile')->name('edit-profile');
    Route::post('/profile/update', 'Seller\ProfileController@updateProfile')->name('profile-update');
    Route::get('/edit-password', 'Seller\ProfileController@editPassword')->name('edit-password');
    Route::post('/password/update', 'Seller\ProfileController@updatePassword')->name('password-update');

    // Seller Product Management....
    Route::resource('products','Seller\ProductController');
    Route::get('products/slug/{name}','Seller\ProductController@ajaxSlugMake')->name('products.slug');
    Route::post('products/get-subcategories-by-category','Seller\ProductController@ajaxSubCat')->name('products.get_subcategories_by_category');
    Route::post('products/get-subsubcategories-by-subcategory','Seller\ProductController@ajaxSubSubCat')->name('products.get_subsubcategories_by_subcategory');
    Route::post('products/get-subsub-childcategories-by-subsubcategory','Seller\ProductController@ajaxSubSubChldCat')->name('products.get_subsubchildcategories_by_subsubcategory');
    Route::post('products/get-subsub-childchildcategories-by-subsubchildcategory','Seller\ProductController@ajaxSubSubChldChildCat')->name('products.get_subsubchildchildcategories_by_subsubchildcategory');

    Route::get('dying-product/create','Seller\ProductController@dyingProductCreate')->name('dying-product.create');
    Route::post('dying-product/store','Seller\ProductController@dyingProductStore')->name('dying-product.store');
    Route::get('dying-products/edit/{id}','Seller\ProductController@dyingProductEdit')->name('dying-products.edit');
    Route::post('dying-products/update/{id}','Seller\ProductController@dyingProductUpdate')->name('dying-product.update');


    Route::get('sizing-product/create','Seller\ProductController@sizingProductCreate')->name('sizing-product.create');
    Route::post('sizing-product/store','Seller\ProductController@sizingProductStore')->name('sizing-product.store');
    Route::get('sizing-products/edit/{id}','Seller\ProductController@sizingProductEdit')->name('sizing-products.edit');
    Route::post('sizing-products/update/{id}','Seller\ProductController@sizingProductUpdate')->name('sizing-product.update');

    //Product Bid
    Route::get('product-bids/list','Seller\BidController@index')->name('product-bids.list');
    Route::get('/bidder-list/{slug}', 'Seller\BidController@getBidderList')->name('bidder-list');
    Route::get('/bidder-details/{id}', 'Seller\BidController@getBidderDetails')->name('bidder-details');
    Route::get('/bid-accept/{id}', 'Seller\BidController@bidAccept')->name('bid.accept');
    Route::get('/accepted-bidders-details/{id}', 'Seller\BidController@getAcceptedBidderDetails')->name('accepted-bidders-details');
    Route::post('/record-sale/store', 'Seller\BidController@saleRecordStore')->name('record-sale-store');
    Route::get('/my-bids', 'Seller\BidController@myBids')->name('my-bids-list');

    //Bidders review
    Route::get('bidders-review/{id}','Seller\ReviewController@getBiddersReview')->name('bidders-review');

    //Buy Request Module
    Route::get('all-requested-products','Seller\ProductController@allRequestedProduct')->name('all-requested-products');
    Route::get('/accepted-bid-list', 'Seller\BidController@acceptedBidList')->name('accepted-bid-list');
    Route::get('/requested-buyer-details/{id}', 'Seller\BidController@getRequestedBuyersDetails')->name('requested-buyer-details');

    //Sale Record
    Route::get('recorded-transaction/list','Seller\SaleRecordController@index')->name('recorded-transaction.list');
    Route::get('requested-recorded-transaction/list','Seller\SaleRecordController@requestedRecordTransaction')->name('requested-recorded-transaction.list');
    Route::get('recorded-transaction/print/{id}','Seller\SaleRecordController@recordedTransactionPrint')->name('recorded-transaction.print');

    //Accounts
    Route::get('accounts','Seller\AccountController@index')->name('accounts');
    Route::get('payment-transaction-list','Seller\AccountController@paymentTransactionList')->name('payment.transaction.list');

    //Notification
    Route::get('notification/list','Seller\NotificationController@index')->name('notification-list');
    Route::get('/notification-detail/{id}','Seller\NotificationController@details')->name('notification.detail');

    //Premium Membership
    Route::post('/pay-now-details','Seller\PremiumMembershipController@payNowDetails')->name('pay-now.details');
    Route::post('/pay-now-details-usd','Seller\PremiumMembershipController@payNowUsdDetails')->name('pay-now-usd.details');
    Route::get('memberships-package-list','Seller\PremiumMembershipController@index')->name('memberships-package-list');
//    Route::get('buy_now_details/{id}','Seller\PremiumMembershipController@buyNowDetails')->name('buy_now_details');
    Route::get('buy_now_details/{id}','BkashController@pay')->name('buy_now_details');

    // buy now
    Route::get('buy-now-stripe/{id}','Seller\PremiumMembershipController@buy_now_stripe')->name('buy-now-stripe');
    Route::get('/checkout/payment_select', 'Seller\PremiumMembershipController@get_payment_info')->name('checkout.payment_info');
    Route::get('buy-now/{id}','Seller\PremiumMembershipController@buy_now')->name('buy-now');

    // pay now
    Route::post('/sale-report-details','Seller\AccountController@salesReportDetails')->name('sale-report.details');
//    Route::get('commission_pay/{id}','Seller\AccountController@commission_pay')->name('commission_pay');
    Route::get('commission_pay/{id}','BkashController@payCommission')->name('commission_pay');
    Route::post('pay-now','Seller\AccountController@pay_now')->name('pay-now');

    //Review
    Route::get('review/list','Seller\ReviewController@index')->name('review-list');

    //Work Order
    Route::get('work-order/dashboard','Seller\WorkOrder\DashboardController@index')->name('work-order.dashboard');
    Route::get('work-order/all-products','Seller\WorkOrder\DashboardController@allProducts')->name('work-order.all-products');

    Route::get('work-order-products/create','Seller\WorkOrder\WorkOrderController@createWOProduct')->name('work-order-products.create');
    Route::post('work-order-products/store','Seller\WorkOrder\WorkOrderController@storeWOProduct')->name('work-order-products.store');
    Route::get('work-order-products/edit/{id}','Seller\WorkOrder\WorkOrderController@editWOProduct')->name('work-order-products.edit');
    Route::post('work-order-products/update/{id}','Seller\WorkOrder\WorkOrderController@updateWOProduct')->name('work-order-products.update');
    Route::get('my-work-order-products/list','Seller\WorkOrder\WorkOrderController@WOProductList')->name('my-work-order-product.list');
    Route::get('work-order-product-details/{slug}','Seller\WorkOrder\WorkOrderController@WOProductDetails')->name('work-order-product-details');
    Route::get('work-order/buyer-details/{id}','Seller\WorkOrder\WorkOrderController@WOBuyerDetails')->name('work-order.buyer-details');

    Route::post('work-order-bid/store/{id}','Seller\WorkOrder\WorkOrderBidController@WOBidStore')->name('work-order-bid.store');
    Route::get('work-order/bid-history','Seller\WorkOrder\WorkOrderBidController@WOBidBidHistory')->name('work-order.bid-history');
    Route::get('work-order/accepted-bid-list', 'Seller\WorkOrder\WorkOrderBidController@WOAcceptedBidList')->name('work-order.accepted-bid-list');
    Route::get('work-order/accepted-buyer-details/{id}', 'Seller\WorkOrder\WorkOrderBidController@getAcceptedBuyerDetails')->name('work-order.accepted-buyer-details');
    Route::post('work-order/work-order-review/store', 'Seller\WorkOrder\WorkOrderReviewController@workOrderReviewStore')->name('work-order-review-store');
    Route::get('work-order/recorded-transaction','Seller\WorkOrder\WorkOrderController@workOrderRecordedTransaction')->name('work-order.recorded-transaction');
    Route::get('work-order/bidders-review/{id}','Seller\WorkOrder\WorkOrderReviewController@getWorkOrderBiddersReview')->name('work-order.bidders-review');
    Route::get('work-order/product-review/{id}','Seller\WorkOrder\WorkOrderController@getWorkOrderProductReview')->name('work-order.product-review');


    Route::get('all-work-orders/list','Seller\WorkOrder\WorkOrderController@index')->name('all-work-order.list');
    Route::get('work-order-profile','Seller\WorkOrder\DashboardController@woProfile')->name('work-order-profile');
    Route::post('work-order-profile/update','Seller\WorkOrder\DashboardController@woProfileUpdate')->name('work-order-profile.update');

    //My work order
    Route::get('my-work-order/details/{slug}','Seller\WorkOrder\WorkOrderController@myWODetails')->name('my-work-order.details');
    Route::get('my-work-order/quotation-list/{id}','Seller\WorkOrder\WorkOrderController@myWOQuotationList')->name('my-work-order.quotation-list');
    Route::get('my-work-order/quotation-details/{id}','Seller\WorkOrder\WorkOrderController@myWOQuotationDetails')->name('my-work-order.quotation-details');
    Route::get('my-work-order/quotation-accept/{id}','Seller\WorkOrder\WorkOrderController@myWOQuotationAccept')->name('my-work-order.quotation-accept');
    Route::post('my-work-order/review-store','Seller\WorkOrder\WorkOrderController@myWOReviewSubmit')->name('my-work-order.review-store');
    Route::get('my-work-order/accepted-quotation-list','Seller\WorkOrder\WorkOrderController@myWOAcceptedQuotationList')->name('my-work-order.accepted-quotation-list');
    Route::get('my-work-order/recorded-transaction','Seller\WorkOrder\WorkOrderController@myWORecordedTransaction')->name('my-work-order.recorded-transaction');
    Route::get('work-order/recorded-transaction/print/{id}','Seller\WorkOrder\WorkOrderController@woTransactionPrint')->name('work-order.recorded-transaction.print');

    Route::get('work-order/reviews','Seller\WorkOrder\WorkOrderReviewController@WOReviews')->name('work-order.review-list');
    Route::get('work-order/notifications','Seller\WorkOrder\WorkOrderNotificationController@index')->name('work-order.notifications');
    Route::get('work-order/notifications/details/{id}','Seller\WorkOrder\WorkOrderNotificationController@details')->name('work-order.notification.detail');
    Route::get('work-order/memberships-package-list','Seller\PremiumMembershipController@wo_Package')->name('work-order.memberships-package-list');



});

Route::group(['middleware' => ['auth', 'seller']], function(){
    Route::get('employer/dashboard','Seller\EmployerController@index')->name('employer-dashboard');
    Route::get('employer/profile','Seller\EmployerController@profile')->name('employer-profile');
    Route::post('employer/profile/update','Seller\EmployerController@profileUpdate')->name('employee.profile.update');
    Route::post('employer/get_industry_subcategories','Seller\EmployerController@get_industry_subcategories')->name('employee.get_industry_subcategories');
    Route::post('employer/get_industry_employee_type','Seller\EmployerController@get_industry_employee_type')->name('employee.get_industry_employee_type');
    Route::post('employer/search_candidate','Seller\EmployerController@searchCandidate')->name('employee.search_candidate');
    Route::get('employer/view_employee_details/{id}','Seller\EmployerController@viewEmployeeDetails')->name('employee.view_employee_details');
    Route::get('employer/view_offer_details/{id}','Seller\OfferController@viewOfferDetails')->name('employee.view_offer_details');
    Route::get('employer/candidates-list/{id}','Seller\OfferController@candidatesList')->name('employer.candidates-list');
    Route::get('employer/employee_shortlist_unshortlist/{id}','Seller\EmployerController@employeeShortlistUnshortlist')->name('employee.employee_shortlist_unshortlist');
    Route::post('employer/employer_to_employee_message','Seller\EmployerController@employerToEmployeeMessage')->name('employee.employer_to_employee_message');
    Route::post('employer/employer_to_employee_multiple_message','Seller\EmployerController@employerToEmployeeMultipleMessage')->name('employer.employer_to_employee_multiple_message');
    Route::get('employer/offer-send','Seller\OfferController@index')->name('employer.offer-send');
    Route::get('employer/shortlist','Seller\ShortlistController@index')->name('employer.shortlist');
    Route::get('employer/message-log','Seller\MessageController@index')->name('employer.message-log');

    // pay now sms cost
    Route::post('pay-now-sms-cost','Seller\MessageController@pay_now_sms_cost')->name('pay-now-sms-cost');


});
