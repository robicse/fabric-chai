<?php


Route::group(['as'=>'buyer.','prefix' =>'buyer','namespace'=>'Buyer','middleware' => ['auth', 'buyer']], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/apply_for_seller', 'DashboardController@applyForSeller')->name('apply_for_seller');
    Route::post('/apply_for_seller/store', 'DashboardController@applyForSellerStore')->name('apply_for_seller.store');
    Route::get('/switch_to_seller', 'DashboardController@switchToSeller')->name('switch_to_seller');
    Route::get('/view-profile', 'ProfileController@viewProfile')->name('view-profile');
    Route::get('/edit-profile', 'ProfileController@editProfile')->name('edit-profile');
    Route::post('/profile/update', 'ProfileController@updateProfile')->name('profile-update');
    Route::get('/edit-password', 'ProfileController@editPassword')->name('edit-password');
    Route::post('/password/update', 'ProfileController@updatePassword')->name('password-update');

    // Buyer Product Management
    Route::resource('my-request','ProductController');
    Route::get('products/slug/{name}','ProductController@ajaxSlugMake')->name('products.slug');
    Route::post('products/get-subcategories-by-category','ProductController@ajaxSubCat')->name('products.get_subcategories_by_category');
    Route::post('products/get-subsubcategories-by-subcategory','ProductController@ajaxSubSubCat')->name('products.get_subsubcategories_by_subcategory');
    Route::post('products/get-subsub-childcategories-by-subsubcategory','ProductController@ajaxSubSubChldCat')->name('products.get_subsubchildcategories_by_subsubcategory');
    Route::post('products/get-subsub-childchildcategories-by-subsubchildcategory','ProductController@ajaxSubSubChldChildCat')->name('products.get_subsubchildchildcategories_by_subsubchildcategory');

    Route::get('dying-product/create','ProductController@dyingProductCreate')->name('dying-product.create');
    Route::post('dying-product/store','ProductController@dyingProductStore')->name('dying-product.store');
    Route::get('dying-products/edit/{id}','ProductController@dyingProductEdit')->name('dying-products.edit');
    Route::post('dying-products/update/{id}','ProductController@dyingProductUpdate')->name('dying-product.update');


    Route::get('sizing-product/create','ProductController@sizingProductCreate')->name('sizing-product.create');
    Route::post('sizing-product/store','ProductController@sizingProductStore')->name('sizing-product.store');
    Route::get('sizing-products/edit/{id}','ProductController@sizingProductEdit')->name('sizing-products.edit');
    Route::post('sizing-products/update/{id}','ProductController@sizingProductUpdate')->name('sizing-product.update');

    // Product Module
    Route::get('all-products-list','ProductController@allProducts')->name('all-products.list');
    Route::get('recent-product-list','DashboardController@allRecentProducts')->name('view-all-recent-product');
    Route::get('featured-product-list','DashboardController@allFeaturedProducts')->name('view-all-featured-product');


    //Buy Request Module
    Route::get('/accepted-bid-list', 'BidController@acceptedBidList')->name('accepted-bid-list');
    Route::get('/accepted-seller-details/{id}', 'BidController@getAcceptedSellerDetails')->name('accepted-seller-details');
    Route::get('/accepted-bid-request-list', 'BidController@acceptedBidRequest')->name('accepted-bid-request.list');
    Route::get('/requested-seller-details/{id}', 'BidController@getRequestedSellerDetails')->name('requested-seller-details');

    //Product Bid
    Route::get('my-bids/list','BidController@index')->name('product-bids.list');
    Route::get('/bidder-list/{slug}', 'BidController@getBidderList')->name('bidder-list');
    Route::get('/bidder-details/{id}', 'BidController@getBidderDetails')->name('bidder-details');
    Route::get('/bid-accept/{id}', 'BidController@bidAccept')->name('bid.accept');
    Route::post('/record-sale/store', 'BidController@saleRecordStore')->name('record-sale-store');

    //Bidders review
    Route::get('bidders-review/{id}','ReviewController@getBiddersReview')->name('bidders-review');

    //Sale Record
    Route::get('recorded-transaction/list','SaleRecordController@index')->name('recorded-transaction.list');
    Route::get('requested-recorded-transaction/list','SaleRecordController@requestedRecordTransaction')->name('requested-recorded-transaction.list');
    Route::get('recorded-transaction/print/{id}','SaleRecordController@recordedTransactionPrint')->name('recorded-transaction.print');


    //Notification
    Route::get('notification/list','NotificationController@index')->name('notification-list');
    Route::get('/notification-detail/{id}','NotificationController@details')->name('notification.detail');

    //Premium Membership
    Route::get('memberships-package-list','PremiumMembershipController@index')->name('memberships-package-list');
    Route::post('/pay-now-details','PremiumMembershipController@payNowDetails')->name('pay-now.details');
    Route::post('/pay-now-details-usd','PremiumMembershipController@payNowUsdDetails')->name('pay-now-usd.details');

    //Review
    Route::get('review/list','ReviewController@index')->name('review-list');

    // buy now
    Route::get('buy-now-stripe/{id}','PremiumMembershipController@buy_now_stripe')->name('buy-now-stripe');
    Route::get('/checkout/payment_select', 'PremiumMembershipController@get_payment_info')->name('checkout.payment_info');
    Route::get('buy-now/{id}','PremiumMembershipController@buy_now')->name('buy-now');


    //Work Order
    Route::get('work-order/dashboard','WorkOrder\DashboardController@index')->name('work-order.dashboard');
    Route::get('work-order/profile','WorkOrder\DashboardController@profile')->name('work-order.profile');
    Route::post('work-order/profile-update','WorkOrder\DashboardController@profileUpdate')->name('work-order.profile-update');
    Route::get('my-work-order/create','WorkOrder\WorkOrderController@create')->name('work-order.create');
    Route::post('my-work-order/store','WorkOrder\WorkOrderController@store')->name('work-order.store');
    Route::get('my-work-order/edit/{id}','WorkOrder\WorkOrderController@edit')->name('work-order.edit');
    Route::post('my-work-order/update/{id}','WorkOrder\WorkOrderController@update')->name('work-order.update');
    Route::get('my-work-orders/list','WorkOrder\WorkOrderController@index')->name('my-work-order.list');
    Route::get('my-work-orders/details/{slug}','WorkOrder\WorkOrderController@myWODetails')->name('my-work-order.details');
    Route::get('my-work-order/bidder-list/{id}','WorkOrder\WorkOrderController@myWOBidderList')->name('my-work-order.bidder-list');
    Route::get('my-work-order/bidder-details/{id}','WorkOrder\WorkOrderController@myWOBidderDetails')->name('my-work-order.bidder-details');
    Route::get('my-work-order/bid-accept/{id}','WorkOrder\WorkOrderController@myWOBidAccept')->name('my-work-order.bid-accept');
    Route::get('my-work-order/accepted-bid-list','WorkOrder\WorkOrderController@myWOAcceptedBidList')->name('my-work-order.accepted-bid-list');
    Route::post('my-work-order/review-store','WorkOrder\WorkOrderController@myWOReviewSubmit')->name('my-work-order.review-store');
    Route::get('my-work-order/recorded-transaction','WorkOrder\WorkOrderController@myWORecordedTransaction')->name('my-work-order.recorded-transaction');


    Route::get('work-order-product-details/{slug}','WorkOrder\WorkOrderController@WOProductDetails')->name('work-order-product-details');
    Route::get('work-order/company-details/{id}','WorkOrder\WorkOrderController@WOCompanyDetails')->name('work-order.company-details');

    Route::get('work-order/featured-products','WorkOrder\DashboardController@WOfeaturedProducts')->name('work-order.featured-products');
    Route::get('work-order/companies','WorkOrder\DashboardController@WOCompanies')->name('work-order.companies');
    Route::get('work-order/reviews','WorkOrder\WorkOrderReviewController@WOReviews')->name('work-order.review-list');
    Route::get('work-order/notifications','WorkOrder\WorkOrderNotificationController@index')->name('work-order.notifications');
    Route::get('work-order/notifications/details/{id}','WorkOrder\WorkOrderNotificationController@details')->name('work-order.notification.detail');

    Route::get('work-order/memberships-package-list','PremiumMembershipController@wo_Package')->name('work-order.memberships-package-list');



    //Quotation Request
    Route::get('seller-work-orders','WorkOrder\QuotationRequestController@sellerWorkOrderList')->name('seller-work-orders.list');
    Route::post('work-order/quotation-request/store','WorkOrder\QuotationRequestController@quotationStore')->name('work-order.quotation-request.store');
    Route::get('submitted-quotation/list','WorkOrder\QuotationRequestController@quotationList')->name('submitted-quotation');
    Route::get('work-order/accepted-quotation-list','WorkOrder\QuotationRequestController@acceptedQuotationList')->name('accepted-quotation-list');
    Route::get('work-order/accepted-quotation-details/{id}','WorkOrder\QuotationRequestController@acceptedQuotationDetails')->name('accepted-quotation-details');
    Route::get('work-order/quotation-recorded-transaction','WorkOrder\QuotationRequestController@quotationRecordedTransaction')->name('quotation-recorded-transaction');
    Route::get('work-order/recorded-transaction/print/{id}','WorkOrder\QuotationRequestController@quotationPrint')->name('work-order.recorded-transaction.print');
    Route::get('work-order/see-review/{id}','WorkOrder\WorkOrderReviewController@getWorkOrderBiddersReview')->name('work-order.see-review');

});
Route::get('buyer/buy_now_details/{id}','BkashController@pay')->name('buyer.buy_now_details')->middleware(['auth', 'buyer']);
