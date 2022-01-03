<?php


Route::get('/', 'HomeController@index');

Route::get('article/{url}', 'ArticleController@contentArticle');

Route::get('share/{url}', 'ShareController@contentShare');

Route::get('contact', 'Contacts@index');

Route::get('gotovye-proekty', 'ControllerReadyMadeProject@index');

Route::get('clients', 'ClientsController@index');

Route::get('basket', 'MyListController@index');

Route::get('o-kompanii', 'AboutCompanyController@index');

Route::get('raschjot-komplektacii', 'RaschetKitController@index');

Route::get('service', 'ServiceController@index');

Route::get('servisnoe-garant', 'ServiceGarantController@index');

Route::get('zapchasti', 'ZapchastiController@index');

Route::get('realizovannye-proekty', 'CompletedProjectController@index');

Route::match(['get', 'post'], 'search', 'SearchController@index');

Route::get('product', function () {
    return view('pages/product', ['title' => 'Страница']);
});

Route::get('catalog/{category?}/{type1?}/{type2?}/{type3?}/{type4?}/{type5?}/{type6?}/{type7?}/{type8?}', 'CatalogController@type_action');

Route::get('logout', function () {
    return view('auth/logout', ['title' => 'Выход из админ панели']);
});

Auth::routes();
// Email Rout

Route::post('sendEmailPrice', 'MailController@sendEmailPrice');

Route::post('sendEmailCallback', 'MailController@sendEmailCallback');

Route::post('sendEmailRequestCardProduct', 'MailController@sendEmailRequestCardProduct');

Route::post('sendEmailReadyMadeProject', 'MailController@sendEmailReadyMadeProject');

Route::post('sendEmailServiceGuarantee', 'MailController@sendEmailServiceGuarantee');

Route::post('sendEmailzapchasti', 'MailController@sendEmailzapchasti');

Route::post('sendEmailShare', 'MailController@sendEmailShare');

Route::post('sendEmailBasket', 'MailController@sendEmailBasket');



