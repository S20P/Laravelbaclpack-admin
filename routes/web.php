<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|*/
    Auth::routes();
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/account', function () {
        return view('FrontEnd.pages.Account');
    })->name('Account');
    Route::get('/article-blog-Page/{slug}','HomeController@getBlogDetails')->name('ArticleBlogPage');
    Route::any('/faq','HomeController@getFaqs')->name('Faq');
    Route::any('/help','HomeController@getHelps')->name('Help');
    Route::any('/help-ajex','HomeController@getHelpsAjex')->name('HelpsAjex');
    Route::get('/our-story', function () {
        return view('FrontEnd.pages.OurStory');
    })->name('OurStory');
    Route::get('/contacts','HomeController@contactUS')->name('Contacts');
    Route::any('/blog','HomeController@blogListng')->name('Blog');
    Route::get('/supplier-details', function () {
        return view('FrontEnd.pages.SupplierDetails');
    })->name('SupplierDetails');
    Route::get('/404', function () {
        return view('404page');
    })->name('404page');
    Route::get('/supplier-details/{slug}','HomeController@getSupplierDetails')->name('SupplierDetailsPage');
    Route::post('/check_email_exists', 'HomeController@check_email_exists');
    Route::post('/check_subscribe_exists', 'HomeController@check_subscribe_exists');
    Route::any('/contact_us', 'HomeController@contactUsSend')->name('contactUsSendAction');
    Route::any('/our-suppliers','HomeController@displayFilterSupplier')->name('OurSuppliers');
    Route::get('/our-suppliers/{slug}','HomeController@displayOurSupplier')->name('OurSuppliersCat');
    Route::get('/browse-suppliers','HomeController@displayAllCategory')->name('BrowseSuppliers');
    Route::get('/browse-suppliers/{slug}','HomeController@displayAllCategory')->name('BrowseSuppliersCat');
    Route::get('/become-supplier','HomeController@becomeSupplierSignupform')->name('BecomeSupplier');
    Route::any('/become-supplier_signup','HomeController@becomeSupplierSignup')->name('BecomeSupplierSignup');
    Route::post('/customer_subscribe','HomeController@putSubscribe')->name('CustomerSubscribe');
    Route::get('/customer-feed','HomeController@getFeed')->name('InstaFeed');
    Route::get('/supplier-terms-and-conditions', 'HomeController@supplierTakeAndCare')->name('SupplierTackandCare');
    Route::post('/supplier_price_tires','HomeController@selectPriceRange')->name('Price_Tires');

    //login
    Route::post('/login', 'Auth\LoginController@ProfileLogin')->name('profile.login');
    Route::post('/customer_login', 'Auth\LoginController@ProfileLoginCustomer')->name('profile.logincusstomer');
    Route::post('/register', 'Auth\RegisterController@register')->name('profile.register');
    
    Route::any('/social_login', 'Auth\SocialAccountController@registerandLogin')->name('sociallogins');

    Route::get('{role}/password/reset/','Auth\CustomResetPasswordController@getResetPasswordForm')->name('password.reset');
    Route::post('password/email','Auth\CustomResetPasswordController@postResetPasswordEmail')->name('password.email');
    Route::get('resetPassword/{email}/{role}/{verificationLink}','Auth\CustomResetPasswordController@resetPassword');
    Route::post('resetPassword','Auth\CustomResetPasswordController@newPassword')->name('password.update');

    // Bookings Mangement api
    Route::get('/booking', 'BookingController@booking_get')->name('booking_get');
    Route::post('/booking/add', 'BookingController@booking_add_manual')->name('booking_add');
    Route::get('/booking/edit/{booking_id}', 'BookingController@booking_edit')->name('booking_edit');
    Route::post('/booking/update', 'BookingController@booking_update')->name('booking_update');
    Route::post('/booking/remove/{booking_id}', 'BookingController@booking_remove')->name('booking_remove');
    Route::get('/booking-by-customer', 'BookingController@getCustomerBooking')->name('get_booking_by_customer');
    Route::get('/get-wishlist-account', 'Customer\customerController@getCustomerWish')->name('WishlistCustomerAccount');


    //Supplier Assigned Services crud
    Route::get('/supplier-services/{supplier_id?}', 'SupplierServiceController@getSupplierServices')->name('supplier_services');
    Route::get('/supplier-services/edit/{id}', 'SupplierServiceController@EditSupplierServices')->name('supplier_services_edit');
    Route::post('/supplier_services/update', 'SupplierServiceController@UpdateSupplierServices')->name('supplier_services_update');
    Route::post('/supplier_services/remove/{id}', 'SupplierServiceController@RemoveSupplierServices')->name('supplier_services_remove');
    Route::get('/service-slider/edit/{id}', 'SupplierServiceController@EditServiceSlider')->name('services_slider_edit');
    Route::post('/service_slider/update', 'SupplierServiceController@UpdateServiceSlider')->name('services_slider_update');
    Route::post('/service_slider/delete/{id}', 'SupplierServiceController@DeleteServiceSlider')->name('services_slider_delete');

   //Analytics Mangement
    Route::get('/analytics', 'AnalyticsController@get_analytics')->name('analytics.all');
    Route::post('/analytics/add', 'AnalyticsController@create_analytics')->name('analytics.add');
    Route::post('/analytics/search_add', 'AnalyticsController@createSearchAnalytics')->name('analytics.searchAdd');

    // supplier------  
    Route::group(['prefix' => 'supplier',  'middleware' => ['auth.supplier']], function()
    { 
        Route::get('/register', 'Auth\RegisterController@showSupplierRegisterForm');
        Route::post('/register', 'Auth\RegisterController@createSupplier');
        Route::get('/', 'Supplier\supplierController@dashboard')->name('supplier.dashboard');
        Route::get('/dashboard', 'Supplier\supplierController@dashboard')->name('supplier.dashboard');
        Route::get('/account', 'Supplier\supplierController@account')->name('supplier.account');
        Route::post('/account', 'Supplier\supplierController@account_edit')->name('supplier.account');
        Route::get('/profile', 'Supplier\supplierController@profile')->name('supplier.profile');
        Route::post('/profile', 'Supplier\supplierController@profile_edit')->name('supplier.profile');
        Route::post('/Sendinvoice', 'Supplier\supplierController@SendInvoice')->name('supplier.sendinvoice');
        Route::post('/supplier_addreply','Supplier\supplierController@addToreply')->name('supplier.addreply');
        Route::post('/check_customer_exists', 'Supplier\supplierController@check_customer_exists');
        Route::post('/payment_transfer_info', 'Supplier\supplierController@payment_transfer_info_update')->name('supplier.payment_transfer_info');
        Route::post('/supplier_services/add', 'Supplier\supplierController@AddSupplierServices')->name('supplier_services_add');

    });

    // customer------
    Route::group(['prefix' => 'customer',  'middleware' => ['auth.customer']], function()
    {
        Route::get('/register', 'Auth\RegisterController@showCustomerRegisterForm');
        Route::post('/register', 'Auth\RegisterController@createCustomer');
        Route::get('/', 'Customer\customerController@dashboard')->name('customer.dashboard');
        Route::get('/dashboard', 'Customer\customerController@dashboard')->name('customer.dashboard');
        Route::get('/account', 'Customer\customerController@account')->name('customer.account');
        Route::post('/account', 'Customer\customerController@account_edit')->name('customer.account');
        Route::get('/profile', 'Customer\customerController@profile')->name('customer.profile');
        Route::post('/profile', 'Customer\customerController@profile_edit')->name('customer.profile');
        Route::post('/customer_inquiry','Customer\customerController@sendInquiry')->name('customer.inquiry');
        Route::post('/supplier_review','Customer\customerController@putSupplierReviews')->name('customer.review');
        Route::post('/customer_wishlist','Customer\customerController@addToWishlist')->name('customer.wishlist');
        Route::post('/customer_wishlist_remove','Customer\customerController@removeToWishlist')->name('customer.wishlistRemove');
        Route::get('/customer-wishlist','Customer\customerController@wishlist')->name('customer.wishlist');
        Route::post('/customer_addreply','Customer\customerController@addToreply')->name('customer.addreply');
        Route::any('/payment','Customer\customerController@payment')->name('customer.payment');
        Route::post('/wishlist_remove/{wish_id}', 'Customer\customerController@wish_remove')->name('customer.wish_remove');
        
    });

    Route::any('/invoice/{booking_id?}','HomeController@invoice')->name('invoice');
    Route::any('/invoice-download/{booking_id?}','HomeController@invoice_download')->name('invoice_download');
    Route::get('/thankyou','HomeController@thankyou')->name('thankyou');
    Route::get('/Subscribed', function () {
        return view('thankyou_subscription');
    })->name('Subscribed');
    Route::get('/payment-error', function () {
        return view('payerror');
    })->name('payerror');
    Route::get('/mails', function () {
        return view('emails.mailformat');
    })->name('mails');
    Route::get('/mails-format', function () {
        return view('emails.mailformatheaderfooter');
    })->name('mails');
    Route::get('/supplier-login', 'HomeController@supplierLogin')->name('SupplierLogin');
    View::composer('*', function($view){
        $pages_class = str_replace(".","_",$view->getName());
        View::share('view_name', $pages_class);
    }); 
    Route::get('addmoney/stripe', 'MoneySetupController@PaymentStripe');
    Route::post('payform/stripe','MoneySetupController@postPaymentStripe');
    Route::any('cancel_subscription', 'MoneySetupController@cancelSubscription');
    Route::get('our-story', 'HomeController@our_Story')->name('OurStory');
    Route::post('/read_messages','HomeController@readMessages')->name('ReadMessages');
    Route::get('events-by-supplier-service/{supplier_services_id}', 'HomeController@getEventsBysupplierService')->name('getEventsBysupplierService');
    Route::any('/send_report', 'Admin\MailJobsController@reportSend')->name('SendReport');
    Route::post('/send_template', 'Admin\MailJobsController@sendReportTemplate')->name('SendTemplate');
    Route::any('/generate_report', 'Admin\IndustryStatsReportController@generate_report')->name('GenerateReport');
    Route::get('/booking-payment-info/{booking_id}', 'BookingController@booking_payment_info')->name('booking_payment_info');
    Route::any('/locations', 'HomeController@locations')->name('locations');
    Route::any('/test', 'HomeController@test')->name('test');
    Route::get('/customer_email_list', 'HomeController@customer_email_list')->name('customer_email_list');
    Route::get('/export-all-supplier-csv', 'HomeController@ExportAllSupplierCSV')->name('csv_upload_bulk');
    Route::get('/booking-confirmation-email/{booking_id}', 'BookingController@SendBookingConfirmationEmail')->name('booking-confirmation-email');
    Route::get('/profile/verificationLink/{customer_id}','HomeController@ProfileVerificationByEmailLink')->name('customer-verificationLink');