<?php

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BkashController;
use Illuminate\Support\Facades\Artisan;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    //return view('welcome');
//    return redirect()->route('login');
//});
Route::get('/test', function () {
    $products = \App\Model\SaleRecord::where('payment_status','Paid')->sum('commission');
    dd(number_format($products));
});

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    Toastr::success('Cache Clear Successfully Done!');
    return redirect()->route('index');
});
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    Toastr::success('Config Cache Successfully Done!');
    return redirect()->route('index');
});
Route::get('/view-cache', function() {
    $exitCode = Artisan::call('view:cache');
    Toastr::success('View Cache Successfully Done!');
    return redirect()->route('index');
});
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    Toastr::success('View Clear Successfully Done!');
    return redirect()->route('index');
});


// SSLCOMMERZ Start
// buy package
Route::get('/ssl/pay', 'PublicSslCommerzPaymentController@index')->name('ssl.pay');
Route::POST('/success', 'PublicSslCommerzPaymentController@success');
Route::POST('/fail', 'PublicSslCommerzPaymentController@fail');
Route::POST('/cancel', 'PublicSslCommerzPaymentController@cancel');
Route::POST('/ipn', 'PublicSslCommerzPaymentController@ipn');
//SSLCOMMERZ END

Route::get('/ssl/redirect/{trans_id}','PublicSslCommerzPaymentController@status');


//bkash area start
//Route::post('token', 'PaymentController@token')->name('token');
//Route::get('createpayment', 'PaymentController@createpayment')->name('createpayment');
//Route::get('executepayment', 'PaymentController@executepayment')->name('executepayment');
// bkash area end



//Stipe Start
// buy package
Route::get('stripe', 'StripePaymentController@stripe');
Route::post('stripe', 'StripePaymentController@stripePost')->name('stripe.post');
//Stripe END

Route::post('/change_language', 'Frontend\WebSettingController@changeLanguage');

Auth::routes();

Route::post('/registration/store','Frontend\FrontendController@register')->name('user.register');
Route::post('/get_seller_form','Frontend\FrontendController@getSellerForm')->name('get_seller_form');
Route::post('/get_employee_form','Frontend\FrontendController@getEmployeeForm')->name('get_employee_form');
Route::post('/get_district_by_division','Frontend\FrontendController@getDistrict')->name('get_district_by_division');
Route::post('/get_upazila_by_district','Frontend\FrontendController@getUpazila')->name('get_upazila_by_district');
Route::post('/get_union_by_upazila','Frontend\FrontendController@getUnion')->name('get_union_by_upazila');
Route::post('/get_industry_sub_category_by_industry_category','Frontend\FrontendController@getIndustrySubCategory')->name('get_industry_sub_category_by_industry_category');
Route::post('/get_industry_employee_type_by_industry_sub_category','Frontend\FrontendController@getIndustryEmployeeType')->name('get_industry_employee_type_by_industry_sub_category');


Route::post('/get_education_degree','Frontend\FrontendController@getEducationDegree')->name('get_education_degree');

Route::post('/check_user_phone','Frontend\FrontendController@checkUserPhone')->name('check_user_phone');


Route::get('/', 'Frontend\FrontendController@index')->name('index');
Route::get('/about-us', 'Frontend\AboutController@about')->name('about-us');
Route::get('/contact', 'Frontend\AboutController@contact')->name('contact-us');
Route::post('/contact-store', 'Frontend\AboutController@store' )->name('contact.store');
Route::get('/faqs', 'Frontend\AboutController@faqs')->name('faqs');
Route::get('/our-policy', 'Frontend\AboutController@policy')->name('policy');
Route::get('/terms-and-conditions', 'Frontend\AboutController@terms')->name('terms-condition');
Route::get('/shipping', 'Frontend\AboutController@shipping')->name('shipping');
Route::get('/order-returns', 'Frontend\AboutController@returns')->name('returns');

//product route here............
Route::get('/product/{slug}/detail', 'Frontend\ProductController@frontendProductDetails')->name('frontend-product-details');
Route::get('/product/{slug}', 'Frontend\ProductController@productDetails')->name('product-details');
Route::post('/product-bid/store', 'Frontend\ProductController@productBidStore')->name('product-bid.store');
//Route::group(['middleware' => ['auth', 'buyer']], function () {
//    Route::post('/product-bid/store', 'Frontend\ProductController@productBidStore')->name('product-bid.store');
//});

Route::post('products/get-subcategories-by-category','Frontend\CategoryController@ajaxSubCat')->name('products.get_subcategories_by_category');
Route::post('products/get-subsubcategories-by-subcategory','Frontend\CategoryController@ajaxSubSubCat')->name('products.get_subsubcategories_by_subcategory');
Route::post('products/get-subsub-childcategories-by-subsubcategory','Frontend\CategoryController@ajaxSubSubChildCat')->name('products.get_subsubchildcategories_by_subsubcategory');
Route::post('products/get-subsub-childchildcategories-by-subsubchildcategory','Frontend\CategoryController@ajaxSubSubChldChildCat')->name('products.get_subsubchildchildcategories_by_subsubchildcategory');
Route::post('products/get_category_six','Frontend\CategoryController@ajaxCategorySix')->name('products.get_category_six');
Route::post('products/get_category_seven','Frontend\CategoryController@ajaxCategorySeven')->name('products.get_category_seven');
Route::post('products/get_category_eight','Frontend\CategoryController@ajaxCategoryEight')->name('products.get_category_eight');
Route::post('products/get_category_nine','Frontend\CategoryController@ajaxCategoryNine')->name('products.get_category_nine');
Route::post('products/get_category_ten','Frontend\CategoryController@ajaxCategoryTen')->name('products.get_category_ten');


Route::post('products/get_dying_subcategories','Frontend\CategoryController@getDyingSubcategories')->name('products.get_dying_subcategories');


Route::get('/our-products', 'Frontend\ProductController@ourProducts')->name('our-products');
Route::get('/category/{slug}', 'Frontend\ProductController@ourProductByCategory')->name('our-products-by-category');
Route::get('/our-products/{slug}', 'Frontend\ProductController@ourProductDetails')->name('our-product-details');
Route::get('/seller-product-show', 'Frontend\ProductController@sellerProductShow')->name('seller.product.show');
Route::get('/buyer-product-show', 'Frontend\ProductController@buyerProductShow')->name('buyer.product.show');
Route::get('/frontend-all-featured-products', 'Frontend\ProductController@allFeaturedProduct')->name('frontend-all-featured-products');
Route::get('/frontend-all-recent-products', 'Frontend\ProductController@allRecentProduct')->name('frontend-all-recent-products');
Route::get('/frontend-all-recent-products', 'Frontend\ProductController@allRecentProduct')->name('frontend-all-recent-products');
Route::get('/job/registration', 'Frontend\FrontendController@jobRegistration')->name('job.registration');
Route::get('/job/registration/employee', 'Frontend\FrontendController@jobRegistrationEmployee')->name('job.registration.employee');
Route::get('/job/registration/employer', 'Frontend\FrontendController@jobRegistrationEmployer')->name('job.registration.employer');

Route::get('/work-order/registration', 'Frontend\FrontendController@workOrderRegistration')->name('work-order.registration');
Route::get('/work-order/registration/buyer', 'Frontend\FrontendController@workOrderRegistrationBuyer')->name('work-order.registration.buyer');
Route::get('/work-order/registration/seller', 'Frontend\FrontendController@workOrderRegistrationSeller')->name('work-order.registration.seller');

//search route here.............
Route::get('/search', 'Frontend\SearchController@search')->name('category.search');
Route::get('/search?q={search}', 'Frontend\SearchController@search')->name('suggestion.search');
Route::post('/ajax-search', 'Frontend\SearchController@ajax_search')->name('search.ajax');

//Route::get('/product/{slug}', 'Frontend\SearchController@product')->name('product');
Route::get('/products', 'Frontend\SearchController@listing')->name('products');
Route::get('/search?category={category_slug}', 'Frontend\SearchController@search')->name('products.category');
Route::get('/search?subcategory={subcategory_slug}', 'Frontend\SearchController@search')->name('products.subcategory');
Route::get('/search?subsubcategory={subsubcategory_slug}', 'Frontend\SearchController@search')->name('products.subsubcategory');
Route::get('/search?subsubchildcategory={subsubchildcategory_slug}', 'Frontend\SearchController@search')->name('products.subsubchildcategory');
Route::get('/search?subsubchildchildcategory={subsubchildchildcategory_slug}', 'Frontend\SearchController@search')->name('products.subsubchildchildcategory');
Route::get('/search?categorysix={categorysix_slug}', 'Frontend\SearchController@search')->name('products.categorysix');
Route::get('/search?categoryseven={categoryseven_slug}', 'Frontend\SearchController@search')->name('products.categoryseven');
Route::get('/search?categoryeight={categoryeight_slug}', 'Frontend\SearchController@search')->name('products.categoryeight');
Route::get('/search?categorynine={categorynine_slug}', 'Frontend\SearchController@search')->name('products.categorynine');
Route::get('/search?categoryten={categoryten_slug}', 'Frontend\SearchController@search')->name('products.categoryten');
Route::get('/search?brand={brand_slug}', 'Frontend\SearchController@search')->name('products.brand');

Route::post('/currency', 'Frontend\CurrencyController@changeCurrency')->name('currency.change');
Route::post('/bid-price-convert', 'Frontend\ProductController@bidPriceConvert')->name('bid.price.convert');

//Blog
Route::get('/blogs', 'Frontend\BlogController@index')->name('blog');
Route::get('/blog-details/{slug}', 'Frontend\BlogController@details')->name('blog-details');


//Job...
Route::get('/job', 'Frontend\JobController@index')->name('job');
Route::get('/become-an-employee', 'Frontend\JobController@becomeEmployee')->name('become-an-employee');

//Forget Password
Route::get('/reset-password','Frontend\FrontendController@getPhoneNumber')->name('reset.password');
Route::post('/otp-store','Frontend\FrontendController@checkPhoneNumber')->name('phone.check');
Route::post('/change-password','Frontend\FrontendController@otpStore')->name('otp.store');
Route::post('/new-password/update/{id}','Frontend\FrontendController@passwordUpdate')->name('reset.password.update');

// shop pages
Route::get('privacy-and-policy', 'Frontend\DynamicPageController@privacy_and_policy')->name('privacy-and-policy');
Route::get('cookies-policy', 'Frontend\DynamicPageController@cookies_policy')->name('cookies-policy');
Route::get('terms-and-conditions', 'Frontend\DynamicPageController@terms_and_conditions')->name('terms-conditions');
Route::get('return-refund-policy', 'Frontend\DynamicPageController@return_refund_policy')->name('return-refund-policy');
Route::get('faq', 'Frontend\DynamicPageController@faq')->name('faq');
Route::get('stay-safe', 'Frontend\DynamicPageController@staySafe')->name('stay-safe');

Route::get('/get-verification-code/{id}', 'Frontend\VerificationController@getVerificationCode')->name('get-verification-code');
Route::post('/get-verification-code-store', 'Frontend\VerificationController@verification')->name('get-verification-code.store');
Route::get('/check-verification-code', 'Frontend\VerificationController@CheckVerificationCode')->name('check-verification-code');

//Seller and Buyer
Route::post('verification-code', 'Frontend\FrontendController@checkPhoneNumber')->name('password-update.otp-send');



Route::get('/pay', [BkashController::class, 'pay'])->name('pay');
Route::post('/bkash/create', [BkashController::class, 'create'])->name('create');
Route::post('/bkash/execute', [BkashController::class, 'execute'])->name('execute');
//
//Route::get('/success', [BkashController::class, 'success'])->name('success');
//Route::get('/fail', [BkashController::class, 'fail'])->name('fail');

// Checkout IFrame User
//Route::get('/pay', [BkashController::class, 'pay'])->name('pay');
//Route::post('/bkash/create', [BkashController::class, 'create'])->name('create');
//Route::post('/bkash/execute', [BkashController::class, 'execute'])->name('execute');
//
Route::get('/bkash/success', [BkashController::class, 'success'])->name('success');
Route::get('/bkash/fail', [BkashController::class, 'fail'])->name('fail');
//
//// Checkout IFrame Admin
Route::get('/bkash/query', [BkashController::class, 'query'])->name('query');
Route::get('/bkash/query-payment', [BkashController::class, 'queryPayment'])->name('query-payment');
//
Route::get('/bkash/search', [BkashController::class, 'search'])->name('search');
Route::get('/bkash/search-transaction', [BkashController::class, 'searchTransaction'])->name('search-transaction');
//
Route::get('/bkash/refund', [BkashController::class, 'getRefund'])->name('get-refund');
Route::post('/bkash/refund', [BkashController::class, 'refund'])->name('refund');
//
Route::get('/bkash/refund-status', [BkashController::class, 'getRefundStatus'])->name('get-refund-status');
Route::post('/bkash/refund-status', [BkashController::class, 'refundStatus'])->name('refund-status');
