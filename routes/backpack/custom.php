<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::get('api/article', 'App\Http\Controllers\Api\ArticleController@index');
Route::get('api/article-search', 'App\Http\Controllers\Api\ArticleController@search');
Route::get('api/article/{id}', 'App\Http\Controllers\Api\ArticleController@show');


Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    // CRUD resources and other admin routes
   
     // ---------------------------
    // Backpack DEMO Custom Routes
    // Prevent people from doing nasty stuff in the online demo
    // ---------------------------
    if (app('env') == 'production') {
        // disable delete and bulk delete for all CRUDs
        $cruds = ['article', 'category', 'tag', 'monster', 'icon', 'product', 'page', 'menu-item', 'user', 'role', 'permission'];
        foreach ($cruds as $name) {
            Route::delete($name.'/{id}', function () {
                return false;
            });
            Route::post($name.'/bulk-delete', function () {
                return false;
            });
        }
    }
    Route::crud('supplier', 'SupplierCrudController');
    Route::crud('customer', 'CustomerCrudController');
 
    Route::crud('pages', 'PagesCrudController');
    Route::crud('articles', 'ArticlesCrudController');
  
    Route::crud('slidermodule', 'SliderModuleCrudController');
    Route::crud('socialmediamodule', 'SocialMediaModuleCrudController');
    Route::crud('howitwork', 'HowItWorkCrudController');
    Route::crud('testimonial', 'TestimonialCrudController');
    Route::crud('location', 'LocationCrudController');
   
    Route::crud('articlecategory', 'ArticleCategoryCrudController');
    Route::crud('faqs', 'FaqsCrudController');
    Route::crud('gallerymodule', 'GalleryModuleCrudController');
    Route::crud('supplierreviews', 'SupplierReviewsCrudController');
    Route::crud('help', 'HelpCrudController');
    Route::crud('supplierdetailsslider', 'SupplierDetailsSliderCrudController');
    Route::crud('our_story', 'Our_storyCrudController');
    Route::crud('sitedetails', 'SiteDetailsCrudController');
    Route::crud('analytics', 'AnalyticsCrudController');
    Route::crud('services', 'ServicesCrudController');
    Route::crud('events', 'EventsCrudController');
    Route::crud('supplier_services', 'Supplier_servicesCrudController');
    Route::crud('supplier_assign_events', 'Supplier_assign_eventsCrudController');
    Route::crud('bookings', 'BookingsCrudController');
    Route::crud('payments', 'PaymentsCrudController');
    // Route::get('payments/supplier_payment_report/{id}', 'PaymentsCrudController@supplierPaymentReport');

    //Reports.................
    Route::crud('reports/supplier', 'PaymentReportController');
    Route::get('reports/supplier_payment_details/{id}', 'PaymentReportController@PaymentDetailsBySupplier');

Route::get('reports/supplier_payment_details/ajex/{supplier_id}', 'PaymentReportController@PaymentDetailsBySupplierAjex');

Route::get('reports/update_payment_status', 'PaymentReportController@UpdatePaymentStatus');


    Route::get('reports/analytics', 'AnalyticsReportController@dashbord');

 Route::any('reports/supplier_analytics_details/{supplier_id?}', 'AnalyticsReportController@AnalyticsDetailsBySupplierAjex')->name('AnalyticsDetailsBySupplier');

    Route::get('reports/industry_stats_report', 'IndustryStatsReportController@dashbord');

    Route::crud('reports/industry_stats_report_QabyPrice', 'IndustryStatsReportQaPriceController');
    Route::crud('reports/industry_stats_report_QabyLocation', 'IndustryStatsReportQaLocationController');

    Route::crud('reports/industry_stats_report_QbbyPrice', 'IndustryStatsReportQbPriceController');
    Route::crud('reports/industry_stats_report_QbbyLocation', 'IndustryStatsReportQbLocationController');

    Route::crud('reports/industry_stats_report_QcbyPrice', 'IndustryStatsReportQcPriceController');
    Route::crud('reports/industry_stats_report_QcbyLocation', 'IndustryStatsReportQcLocationController');

    Route::crud('reports/industry_stats_report_QdbyPrice', 'IndustryStatsReportQdPriceController');
    Route::crud('reports/industry_stats_report_QdbyLocation', 'IndustryStatsReportQdLocationController');

    Route::crud('supplierbankingdetails', 'SupplierBankingDetailsCrudController');
    Route::crud('messanger', 'MessangerCrudController');
    Route::get('email_template', 'Analytic_emailCrudController@show');     

    Route::crud('emailtemplatesdynamic', 'EmailTemplatesDynamicCrudController');
    Route::crud('supplier_assign_services', 'Supplier_assign_servicesCrudController');
}); // this should be the absolute last line of this file