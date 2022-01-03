<?php

// Homepage
Route::get('/', 'HomeController@index');

// Files
Route::get('files/{file}', 'MainController@getFile');

// Articles
Route::get('article', 'ArticleController@indexArticle')->name('pages-article');
Route::get('article/{url}', 'ArticleController@contentArticle');

// Share
Route::get('share', 'ShareController@index');
Route::get('share/{url}', 'ShareController@contentShare');

// My List
Route::get('basket', 'MyListController@index');
// Compare
Route::get('compare', 'CompareController@index');

// Pages
Route::get('contact', 'Contacts@index')->name('pages-contact');
Route::get('gotovye-proekty', 'ControllerReadyMadeProject@index')->name('pages-gotovyeproekty');
Route::get('clients', 'ClientsController@index')->name('pages-clients');
Route::get('o-kompanii', 'AboutCompanyController@index')->name('pages-okompanii');
Route::get('raschjot-komplektacii', 'RaschetKitController@index')->name('pages-raschjot');
Route::get('service', 'ServiceController@index')->name('pages-service');
Route::get('servisnoe-garant', 'ServiceGarantController@index')->name('pages-servisnoe');
Route::get('payment-delivery', 'MainController@payment_delivery_page')->name('pages-payment');
Route::get('vozvrat-tovara', 'MainController@vozvrat_tovara_page')->name('pages-vozvrat');
//Route::get('zapchasti', 'ZapchastiController@index');
Route::get('realizovannye-proekty', 'CompletedProjectController@index')->name('pages-realizovannyeproekty');
Route::get('privacy-policy', 'MainController@privacy_policy_page')->name('pages-privacy');

// Search
Route::match(['get', 'post'], 'search', 'SearchController@index');

// Product page
Route::get('product', function () {
    return view('pages/product', ['title' => 'Страница']);
});

// Catalogue
Route::get('catalog', 'CatalogController@switch_content_city')->name('pages-catalog');
Route::get('catalog/{city?}/{category?}/{type1?}/{type2?}/{type3?}/{type4?}/{type5?}/{type6?}/{type7?}/{type8?}','CatalogController@switch_content_city')->name('catalog');

Route::get('zapchasti', 'CatalogPartsController@switch_content_city')->name('pages-catalog-parts');
Route::get('zapchasti/{city?}/{category_parts?}/{type1?}/{type2?}/{type3?}/{type4?}/{type5?}/{type6?}/{type7?}/{type8?}','CatalogPartsController@switch_content_city')->name('catalog-parts');



Route::get('logout', function () {
    return view('auth/logout', ['title' => 'Выход из админ панели']);
});

// YML Export
Route::get('/export-yml', 'ExportCatalog@yml');
Route::get('/export-yml-categories-several', 'ExportCatalog@ymlForCategoriesSeveral');
Route::get('/export-turbo-yml', 'ExportCatalog@turboYml');

Route::get('/import-cities', 'ExportCatalog@importCities');
Route::get('/import-contacts', 'ExportCatalog@importContacts');
// Google Merchant
Route::get('/google-merchant/saved_file.xml', 'ExportCatalog@google_merchant');

Auth::routes();

Route::get('/sitemap', 'SitemapsController@page')->name('pages-sitemap');
Route::get('/sitemap.xml', 'SitemapsController@index');
Route::get('/sitemap_pages.xml', 'SitemapsController@generateFromPages')->name('sitemap_pages');
Route::get('/sitemap_filters.xml', 'SitemapsController@getFilterPages')->name('sitemap_filters');
Route::get('/sitemap{code}.xml', 'SitemapsController@generateFromCity');

// Email
Route::post('sendEmailPrice', 'MailController@sendEmailPrice');
Route::post('sendEmailCallback', 'MailController@sendEmailCallback');
Route::post('sendEmailRequestCardProduct', 'MailController@sendEmailRequestCardProduct');
Route::post('sendEmailRequestCardPart', 'MailController@sendEmailRequestCardPart');
Route::post('sendEmailReadyMadeProject', 'MailController@sendEmailReadyMadeProject');
Route::post('sendEmailServiceGuarantee', 'MailController@sendEmailServiceGuarantee');
Route::post('sendEmailzapchasti', 'MailController@sendEmailzapchasti');
Route::post('sendEmailShare', 'MailController@sendEmailShare');
Route::post('sendEmailBasket', 'MailController@sendEmailBasket');
Route::post('sendEmailProductConsultation', 'MailController@sendEmailProductConsultation');
Route::post('sendEmailRaschjotKomplektacii', 'MailController@sendEmailRaschjotKomplektacii');

// Фильтр типов категорий
Route::post('category-type-filter', 'CatalogController@set_filter')->defaults('before', 'csrf-ajax')->name('category-type-filter');

Route::post('/ajax/catalog', 'CatalogController@renderAjaxCatalog')->name('ajax-catalog');

// Middleware
Route::group(['middleware' => 'auth'], function () {
    Route::get('/emails', 'PageEmails@index');
    Route::get('/export/all', 'PageEmails@export');

    Route::get('/clear', function() {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        return "Кэш очищен.";
    });
});
