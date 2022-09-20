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

use App\Model\MembershipPackage;

Route::get('/admin/login', 'Admin\AuthController@ShowLoginForm')->name('admin.login');
Route::post('/admin/login', 'Admin\AuthController@LoginCheck')->name('admin.login.check');
Route::post('/admin/otp-verification', 'Admin\AuthController@otpVerification')->name('admin.otp-verification');
Route::group(['as'=>'admin.','prefix' =>'admin','namespace'=>'Admin', 'middleware' => ['auth', 'admin']], function(){
    Route::get('dashboard','DashboardController@index')->name('dashboard');
    Route::get('visitor-report','DashboardController@visitor_report')->name('visitor_report');
    Route::resource('roles','RoleController');
    Route::post('/roles/permission','RoleController@create_permission');
    Route::resource('departments','DepartmentController');
    Route::resource('staffs','StaffController');
    Route::post('get_role','StaffController@getRole')->name('get_role');
    Route::resource('brands','BrandController');

    Route::resource('categories','CategoryController');
    Route::resource('work-order-categories','CategoryController');

    Route::resource('sub-categories','SubCategoryController');
    Route::resource('work-order-sub-categories','SubCategoryController');
    Route::post('categories/is_home', 'CategoryController@updateIsHome')->name('categories.is_home');

    Route::resource('sub-sub-categories','SubSubCategoryController');
    Route::resource('work-order-sub-sub-categories','SubSubCategoryController');

    Route::resource('sub-sub-child-categories','SubSubChildCategoryController');
    Route::resource('wo-sub-sub-child-categories','SubSubChildCategoryController');

    Route::resource('sub-sub-child-child-categories','SubSubChildChildCategoryController');
    Route::resource('wo-sub-sub-child-child-categories','SubSubChildChildCategoryController');

    Route::resource('category-six','CategorySixController');
    Route::resource('wo-category-six','CategorySixController');

    Route::resource('category-seven','CategorySevenController');
    Route::resource('wo-category-seven','CategorySevenController');

    Route::resource('category-eight','CategoryEightController');
    Route::resource('wo-category-eight','CategoryEightController');

    Route::resource('category-nine','CategoryNineController');
    Route::resource('wo-category-nine','CategoryNineController');

    Route::resource('category-ten','CategoryTenController');
    Route::resource('wo-category-ten','CategoryTenController');

    Route::post('categories/slug-change','CategoryController@slugChange')->name('categories.slug-change');

    Route::resource('dying-categories','DyingCategoryController');
    Route::resource('dying-sub-categories','DyingSubcategoryController');

    Route::resource('test-parameters','TestParameterController');
    Route::post('test-parameters/status', 'TestParameterController@updateStatus')->name('test-parameters.status');

    Route::resource('methods','MethodController');
    Route::resource('color-fastness','ColorFastnessController');
    Route::resource('color-staining','ColorStainController');


    Route::resource('units','UnitController');
    Route::resource('currencies','CurrencyController');
    Route::resource('yarn-product','YarnProductController');
    Route::get('phone/verification/{phone}','YarnProductController@phoneVerification');
    Route::resource('dynamic_pages','DynamicPageController');
    Route::resource('about-us','AboutController');
    Route::resource('faqs','FaqController');
    Route::resource('membership_packages','MembershipPackageController');
    Route::resource('membership-package-details','MembershipPackageDetailController');
    Route::resource('membership-package-other-benefit','MembershipPackageOtherBenefitController');
    Route::resource('advertisements', 'AdvertisementController');
    Route::resource('machine-type', 'MachineTypeController');
    Route::resource('priority-buyers', 'PriorityBuyerController');
    Route::get('/advertisements/create/{position}', 'AdvertisementController@create')->name('advertisements.create');

    //MemberShip Users
    Route::get('membership-users','MembershipUsersController@index')->name('membership-users.index');

    //Frontend Home Setting
    Route::resource('generalsettings','GeneralSettingController');
    Route::get('/logo','GeneralSettingController@logo')->name('generalsettings.logo');
    Route::post('/logo','GeneralSettingController@storeLogo')->name('generalsettings.logo.store');
    Route::resource('banners','BannerController');


    // product
    Route::get('/seller-product-list','ProductController@sellerProductList')->name('seller-product-list');
    Route::get('/seller-product-list/ajax','ProductController@sellerProductListAjax')->name('seller-product-list.ajax');
    Route::get('/seller-product-individual/{seller_id}/{product_id}','ProductController@sellerProductIndividual');
    Route::get('/seller-product/edit/{id}','ProductController@sellerProductEdit')->name('seller-product.edit');
    Route::get('/seller-unapproved-product-list','ProductController@sellerUnApprovedProductList')->name('seller-unapproved-product-list');
    Route::get('/seller-unapproved-product-list/ajax','ProductController@sellerUnapprovedProductListAjax')->name('seller-unapproved-product-list.ajax');



    Route::post('/seller-product/update/{id}','ProductController@SellerProductUpdate')->name('seller-product.update');
    Route::get('products/slug/{name}','ProductController@ajaxSlugMake')->name('products.slug');
    Route::post('products/get-subcategories-by-category','ProductController@ajaxSubCat')->name('products.get_subcategories_by_category');
    Route::post('products/get-subsubcategories-by-subcategory','ProductController@ajaxSubSubCat')->name('products.get_subsubcategories_by_subcategory');
    Route::post('products/get-subsub-childcategories-by-subsubcategory','ProductController@ajaxSubSubChldCat')->name('products.get_subsubchildcategories_by_subsubcategory');
    Route::post('products/get-subsub-childchildcategories-by-subsubchildcategory','ProductController@ajaxSubSubChldChildCat')->name('products.get_subsubchildchildcategories_by_subsubchildcategory');


    Route::get('/sizing-products/edit/{id}','ProductController@sizingProductEdit')->name('sizing-products.edit');
    Route::post('/sizing-products/update/{id}','ProductController@sizingProductUpdate')->name('sizing-products.update');
    Route::get('/dying-products/edit/{id}','ProductController@dyingProductEdit ')->name('dying-products.edit');
    Route::post('/dying-products/update/{id}','ProductController@dyingProductUpdate')->name('dying-products.update');

    //Route::get('seller-product/verification-status-change/{id}','ProductController@sellerProductVerificationStatusChange')->name('seller-product.verification-status');
    Route::post('seller-product/status', 'ProductController@sellerProductUpdateStatus')->name('seller-product.status');
    Route::post('/products/get_products_by_subcategory', 'ProductController@get_products_by_subcategory')->name('products.get_products_by_subcategory');


    //Admin Products...
    //Home Category...
    Route::resource('home-categories','HomeCategoryController');
    Route::resource('admin-products','AdminProductController');
    Route::post('admin-products/slug-change','AdminProductController@slugChange')->name('admin-products.slug-change');

    //seller
    Route::get('/seller-list','SellerController@index')->name('seller-list');
    Route::get('/seller-due-list','ExportExcelController@exportSellerDueReport')->name('seller-due-list');
    Route::get('/seller-list/ajax/{start}/{end}','SellerController@sellerListAjax')->name('seller-list.ajax');
    Route::get('/individual-seller/{id}','SellerController@individualSeller')->name('individual-seller');
    Route::post('sellers/verification','SellerController@verification')->name('seller.verification');
    Route::get('seller/show/profile/{id}','SellerController@profileShow')->name('seller.profile.show');
    Route::get('seller-profile-edit/{id}','SellerController@profileEdit')->name('seller-profile-edit');
    Route::put('seller/update/profile/{id}','SellerController@updateProfile')->name('seller.profile.update');
    Route::put('seller/password/update/{id}','SellerController@updatePassword')->name('seller.password.update');
    Route::get('seller/ban/{id}','SellerController@banSeller')->name('seller.ban');
    Route::post('seller/payment-status','SellerController@paymentStatusUpdate')->name('seller.payment.status');


    Route::post('featured-product/status','ProductController@featuredStatusUpdate')->name('featured-product.status');

    //Buyer
    Route::get('/buyer-list','BuyerController@index')->name('buyer-list');
    Route::get('/buyer-due-list','ExportExcelController@exportBuyerDueReport')->name('buyer-due-list');
    Route::get('/buyer-list/ajax/{start}/{end}','BuyerController@buyerListAjax')->name('buyer-list.ajax');
    Route::get('/buyer-profile/{id}','BuyerController@buyerProfile')->name('buyer-profile');
    Route::post('/buyer/verification','BuyerController@verification')->name('buyer.verification');
    Route::get('/individual-buyer/{id}','BuyerController@individualBuyer')->name('individual-buyer');
    Route::post('/buyer/status-edit','BuyerController@statusEdit')->name('buyer.status-edit');
    Route::get('/buyer/status-update/{id}','BuyerController@statusUpdate')->name('buyer.status-update');
    Route::get('/buyer/profile-edit/{id}','BuyerController@profileEdit')->name('buyer.profile-edit');
    Route::post('/buyer/profile-update/{id}','BuyerController@profileUpdate')->name('buyer.profile-update');
    Route::post('/buyer/password-update/{id}','BuyerController@updatePassword')->name('buyer.password.update');
    Route::get('buyer/ban/{id}','BuyerController@ban')->name('buyer.ban');
    Route::get('buyer/activate/{id}','BuyerController@activate')->name('buyer.activate');


    //Buyer Product
    Route::get('/buyer-product-list','ProductController@buyerProductList')->name('buyer-product-list');
    Route::get('/buyer-product-list/ajax','ProductController@buyerProductListAjax')->name('buyer-product-list.ajax');
    Route::get('/buyer-product-individual/{seller_id}/{product_id}','ProductController@buyerProductIndividual');
    Route::get('/buyer-requested-product/edit/{id}','ProductController@buyerProductEdit')->name('buyer-requested-product.edit');
    Route::post('/buyer-requested-product/update/{id}','ProductController@buyerProductUpdate')->name('buyer-requested-product.update');
    Route::get('product/delete/{id}','ProductController@productDelete')->name('product.delete');
    Route::get('/buyer-unapproved-product-list','ProductController@buyerUnapprovedProductList')->name('buyer-unapproved-product-list');
    Route::get('/buyer-unapproved-product-list/ajax','ProductController@buyerUnapprovedProductListAjax')->name('buyer-unapproved-product-list.ajax');
    //Employee
    Route::get('/employee-list/ajax','EmployeeController@employeeListAjax')->name('employee-list.ajax');
    Route::get('/employee-due-list','ExportExcelController@exportEmployeeDueReport')->name('employee-due-list');
    Route::resource('employee','EmployeeController');
    Route::post('employee/verification','EmployeeController@verification')->name('employee.verification');
    Route::get('employee/edit-password/{id}','EmployeeController@editPassword')->name('employee.edit-password');
    Route::post('employee/password-update/{id}','EmployeeController@updatePassword')->name('employee.password-update');
    Route::post('/employee-modal/details','EmployeeController@detailsModal')->name('employee-modal.details');
    Route::get('/un-approve-employee-list','EmployeeController@unApproveEmployeeList')->name('un-approve-employee-list');
     Route::get('/un-approve-employee-list/ajax','EmployeeController@unApproveEmployeeListAjax')->name('un-approve-employee-list.ajax');

    //Education
    Route::resource('education-levels','EducationLevelController');
    Route::resource('education-degrees','EducationDegreeController');
    Route::resource('city-corporations','CityCorporationController');
    Route::resource('salary-range','SalaryRangeController');


    //Employer..
    Route::resource('employer','EmployerController');
    Route::get('/employer-list/ajax','EmployerController@employerListAjax')->name('employer-list.ajax');
    Route::get('employer/edit-password/{id}','EmployerController@editPassword')->name('employer.edit-password');
    Route::post('employer/password-update/{id}','EmployerController@updatePassword')->name('employer.password-update');
    Route::post('/employer-modal/details','EmployerController@detailsModal')->name('employer-modal.details');
    Route::get('/employer.un-approve-employer-list','EmployerController@unApproveEmployerList')->name('employer.un-approve-employer-list');
    Route::get('/un-approve-employer-list/ajax','EmployerController@unApproveEmployerListAjax')->name('un-approve-employer-list.ajax');

    //Review

    //Sliders
    Route::resource('sliders','SliderController');
    Route::get('/reviews','ReviewController@index')->name('reviews.index');
    Route::post('review/status/update', 'ReviewController@updateStatus')->name('review-status.update');
    Route::get('review/show/{id}','ReviewController@show')->name('review.view');
    Route::post('review/update/{id}','ReviewController@reviewUpdate')->name('review.update');
    //Blogs
    Route::resource('blogs','BlogController');
    Route::post('blog/status', 'BlogController@updateStatus')->name('blog.status');
    Route::post('blogs/slug-change','BlogController@slugChange')->name('blogs.slug-change');

    //PopUps
    Route::resource('pop-ups','PopUpController');


    //Message Charge
    Route::resource('message-charge','MessageChargeController');

    Route::resource('advertisement','AdvertisementController');
    Route::resource('profile','ProfileController');
    Route::put('password/update/{id}','ProfileController@updatePassword')->name('password.update');

    //Report
    Route::get('/total-sales','ReportController@totalSale')->name('total-sales');
    Route::get('/total-revenue','ReportController@totalRevenue')->name('total-revenue');
    Route::get('/total-vat','ReportController@totalVat')->name('total-vat');
    Route::get('/total-package-sell','ReportController@totalPackageSell')->name('total-package-sell');
    Route::get('/total-transaction','ReportController@totalTransaction')->name('total-transaction');
    Route::get('/total-bid-accepted','ReportController@totalBidAccepted')->name('total-bid-accepted');
    Route::get('/total-bid-rejected','ReportController@totalBidReject')->name('total-bid-rejected');
    Route::get('/total-products','ReportController@totalProducts')->name('total-products');
    Route::get('/total-buy-requested-products','ReportController@totalBuyRequestedProducts')->name('total-buy-requested-products');
    Route::get('/total-advertisements','ReportController@totalAdvertisements')->name('total-advertisements');
    Route::get('/total-manufacturer-posts','ReportController@totalManufacturerPosts')->name('total-manufacturer-posts');
    Route::get('/total-job-seekers','ReportController@totalJobSeekers')->name('total-job-seekers');
    Route::get('/total-job-provider','ReportController@totalJobProvider')->name('total-job-provider');
    Route::get('/total-work-order-received','ReportController@totalWorkOrderReceived')->name('total-work-order-received');
    Route::get('/total-work-order-provided','ReportController@totalWorkOrderProvided')->name('total-work-order-provided');
    Route::get('/total-sms-history','ReportController@totalSmsHistory')->name('total-sms-history');
    Route::get('/referral-code-report','ReportController@refferalCodeReport')->name('referral-code-report');

   //invoice
    Route::get('sale-invoice/{id}/{sale_type}','InvoiceController@sale_invoice')->name('sale_invoice');



    Route::get('/sales-report','ReportController@salesReport')->name('sales-report');
    Route::post('/sale-report-details','ReportController@salesReportDetails')->name('sale-report.details');
    Route::get('/monthly-earning-report','ReportController@monthlyEarningReport')->name('monthly-earning-report');
    Route::post('/monthly-earning-report/show','ReportController@monthlyReportValue')->name('monthly_report.value');
    Route::get('/top-sellers','ReportController@topSellers')->name('top-sellers');
    Route::get('/seller-commission-due-list/{id}','SellerController@seller_commission_due_list')->name('seller-commission-due-list');
    Route::get('/commission-report','ReportController@commissionReport')->name('commission-report');
    Route::post('/commission-payment/store/{id}','ReportController@commissionPaymentStore')->name('commission-payment.store');
    Route::post('/commission-report-modal','ReportController@commissionReportModal')->name('commission-report-modal');
    Route::get('/sms-report','ReportController@smsReport')->name('sms-report');
    Route::post('/sms-report/show','ReportController@smsReportValue')->name('sms-report.value');
    Route::get('/transaction-report','ReportController@transactionReport')->name('transaction-report');
    Route::get('/seller-payment','SellerController@sellerPayment')->name('seller.payment');
    Route::post('/transaction-report/show','ReportController@transactionReportValue')->name('transaction-report.value');
    Route::get('/sale-record/print/{id}','ReportController@saleRecordPrint')->name('sale-record.print');

    Route::get('/notification','NotificationController@index')->name('notification');
    Route::get('/notification-list/ajax','NotificationController@notificationAjax')->name('notification-list.ajax');
    Route::get('/notification-detail/{id}','NotificationController@details')->name('notification.detail');

    //Admin Excel Export
    Route::get('/sale-report-export','ExportExcelController@exportSaleReport')->name('sale-report-export');
    Route::get('/monthly-earning-report-export/{from_date}/{to_date}','ExportExcelController@exportMonthlyEarningReport')->name('monthly-earning-report-export');
    Route::get('/sms-report-export/{from_date}/{to_date}','ExportExcelController@exportSmsReport')->name('sms-report-export');
    Route::get('/top-seller-export','ExportExcelController@exportTopSeller')->name('top-seller-export');
    Route::get('/commission-report-export','ExportExcelController@exportCommissionReport')->name('commission-report-export');
    Route::get('/transaction-report-export/{from_date}/{to_date}','ExportExcelController@exportTransactionReport')->name('transaction-report-export');

    Route::get('/total-buyer-export','ExportExcelController@exportTotalBuyerReport')->name('total-buyer-export');
    Route::get('/total-seller-export','ExportExcelController@exportTotalSellerReport')->name('total-seller-export');
    Route::get('/total-employee-export','ExportExcelController@exportTotalEmployeeReport')->name('total-employee-export');
    Route::get('/total-employer-export','ExportExcelController@exportTotalEmployerReport')->name('total-employer-export');
    Route::get('/total-sale-export/{start_date}/{end_date}/{sale_type}','ExportExcelController@exportTotalSaleReport');
    Route::get('/total-revenue-export/{start_date}/{end_date}/{sale_type}','ExportExcelController@exportTotalRevenueReport');
    Route::get('/total-vat-export/{start_date}/{end_date}','ExportExcelController@exportTotalVatReport');
    Route::get('/total-package-sell-export/{start_date}/{end_date}/{package_type}','ExportExcelController@exportTotalPackageSellReport');
    Route::get('/total-transactions-export/{start_date}/{end_date}','ExportExcelController@exportTotalTransactionsReport');
    Route::get('/total-bid-accepted-export/{start_date}/{end_date}','ExportExcelController@exportTotalBidAcceptedReport');
    Route::get('/total-products-export/{start_date}/{end_date}','ExportExcelController@exportTotalProductsReport');
    Route::get('/total-buy-requested-products-export/{start_date}/{end_date}','ExportExcelController@exportTotalBuyRequestedProductsReport');
    Route::get('/total-advertisements-export/{start_date}/{end_date}/{type}','ExportExcelController@exportTotalAdvertisementsReport');
    Route::get('/total-manufacturer-posts-export/{start_date}/{end_date}','ExportExcelController@exportTotalManufacturerPostsReport');
    Route::get('/total-employees-export/{start_date}/{end_date}','ExportExcelController@exportTotalEmployeesReport');
    Route::get('/total-employers-export/{start_date}/{end_date}','ExportExcelController@exportTotalEmployersReport');
    Route::get('/total-work-order-provided-export/{start_date}/{end_date}','ExportExcelController@exportTotalWOProvidedReport');
    Route::get('/total-work-order-received-export/{start_date}/{end_date}','ExportExcelController@exportTotalWOReceivedReport');
    Route::get('/total-sms-history-export/{start_date}/{end_date}','ExportExcelController@exportTotalSmsHistoryReport');




    //PDF
    Route::get('/total-buyer-pdf','PdfController@exportTotalBuyerPDF')->name('total-buyer-pdf');
    Route::get('/total-seller-pdf','PdfController@exportTotalSellerPDF')->name('total-seller-pdf');
    Route::get('/total-employee-pdf','PdfController@exportTotalEmployeePDF')->name('total-employee-pdf');
    Route::get('/total-employer-pdf','PdfController@exportTotalEmployerPDF')->name('total-employer-pdf');

    Route::get('/total-sale-pdf/{start_date}/{end_date}/{sale_type}','PdfController@exportTotalSalePDF');
    Route::get('/total-revenue-pdf/{start_date}/{end_date}/{sale_type}','PdfController@exportTotalRevenuePDF');
    Route::get('/total-vat-pdf/{start_date}/{end_date}','PdfController@exportTotalVatReport');
    Route::get('/total-package-sell-pdf/{start_date}/{end_date}/{package_type}','PdfController@exportTotalPackagePDF');
    Route::get('/total-transactions-pdf/{start_date}/{end_date}','PdfController@exportTotalTransactionsPDF');
    Route::get('/total-bid-accepted-pdf/{start_date}/{end_date}','PdfController@exportTotalBidAcceptedPDF');
    Route::get('/total-products-pdf/{start_date}/{end_date}','PdfController@exportTotalProductsPDF');
    Route::get('/total-buy-requested-products-pdf/{start_date}/{end_date}','PdfController@exportTotalBuyRequestedProductsPDF');
    Route::get('/total-advertisements-pdf/{start_date}/{end_date}/{type}','PdfController@exportTotalAdvertisementsPDF');
    Route::get('/total-manufacturer-posts-pdf/{start_date}/{end_date}','PdfController@exportTotalManufacturerPostsPDF');
    Route::get('/total-employees-pdf/{start_date}/{end_date}','PdfController@exportTotalEmployeesPDF');
    Route::get('/total-employers-pdf/{start_date}/{end_date}','PdfController@exportTotalEmployersPDF');
    Route::get('/total-work-order-provided-pdf/{start_date}/{end_date}','PdfController@exportTotalWOProvidedPDF');
    Route::get('/total-work-order-received-pdf/{start_date}/{end_date}','PdfController@exportTotalWOReceivedPDF');
    Route::get('/total-sms-history-pdf/{start_date}/{end_date}','PdfController@exportTotalSmsHistoryPDF');

    Route::get('/sale-report-pdf','PdfController@exportSaleReportPDF')->name('sale-report-pdf');
    Route::get('/monthly-earning-report-pdf/{from_date}/{to_date}','PdfController@exportMonthlyEarningReportPDF')->name('monthly-earning-report-pdf');
    Route::get('/sms-report-pdf/{from_date}/{to_date}','PdfController@exportSmsReportPDF')->name('sms-report-pdf');
    Route::get('/top-seller-pdf','PdfController@exportTopSellerPDF')->name('top-seller-pdf');
    Route::get('/commission-report-pdf','PdfController@exportCommissionPDF')->name('commission-report-pdf');
    Route::get('/transaction-report-pdf/{from_date}/{to_date}','PdfController@exportTransactionReportPDF')->name('transaction-report-pdf');




    // job
    Route::resource('industry-categories','IndustryCategoryController');
    Route::resource('industry-sub-categories','IndustrySubCategoryController');
    Route::resource('industry-employee-types','IndustryEmployeeTypeController');

    //Work Order

    Route::get('/seller-work-order-list','WorkOrderController@sellerWorkOrderList')->name('seller-work-order.list');
    Route::get('/manufacturer-work-order/edit/{id}','WorkOrderController@sellerWorkOrderEdit')->name('seller-work-order.edit');
    Route::post('/manufacturer-work-order/update/{id}','WorkOrderController@sellerWorkOrderUpdate')->name('seller-work-order.update');
    Route::post('/work-order-product/status','WorkOrderController@verificationStatusUpdate')->name('work-order-product.status');
    Route::post('/featured-work-order/status','WorkOrderController@featuredStatusUpdate')->name('featured-work-order.status');
    Route::get('/seller-work-order-individual/{seller_id}/{wo_id}','WorkOrderController@sellerWOIndividual');
    Route::get('/buyer-work-order-individual/{buyer_id}/{wo_id}','WorkOrderController@buyerWOIndividual');

    Route::get('/un-approve-seller-work-order-list','WorkOrderController@unApproveSellerWorkOrderList')->name('un-approve-seller-work-order-list');

    //performance
    Route::get('/config-cache', 'SystemOptimize@ConfigCache')->name('config.cache');
    Route::get('/clear-cache', 'SystemOptimize@CacheClear')->name('cache.clear');
    Route::get('/view-cache', 'SystemOptimize@ViewCache')->name('view.cache');
    Route::get('/view-clear', 'SystemOptimize@ViewClear')->name('view.clear');
    Route::get('/route-cache', 'SystemOptimize@RouteCache')->name('route.cache');
    Route::get('/route-clear', 'SystemOptimize@RouteClear')->name('route.clear');
    Route::get('/site-optimize', 'SystemOptimize@Settings')->name('site.optimize');
    Route::get('/optimize-clear', 'SystemOptimize@optimizeClear');

//zahidul working
Route::get('registration-user-report','ReportController@registerUserReport')->name('registration-user-report');
Route::get('monthly-registration-user-report','ReportController@monthlyRegisterUserReport')->name('monthly-registration-user-report');
Route::get('bidder-list-report','ReportController@BidderListReport')->name('bidder-list-report');

//CKEditor
Route::post('ckeditor/upload', 'CkeditorController@upload')->name('ckeditor.upload');


});
