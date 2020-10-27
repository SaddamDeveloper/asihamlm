<?php

// =========== index ============= 

use Illuminate\Support\Facades\Route;

Route::get('/', 'Web\WebsiteController@index')->name('web.index');
Route::get('/about', 'Web\WebsiteController@about')->name('web.about');
Route::get('/plan', 'Web\WebsiteController@plan')->name('web.plan');
Route::get('/reward', 'Web\WebsiteController@reward')->name('web.reward');
Route::get('/product', 'Web\WebsiteController@product')->name('web.product');
Route::get('/rank/achiever', 'Web\WebsiteController@rankAchiever')->name('web.rank_achiever');
Route::get('/reward/achiever', 'Web\WebsiteController@rewardAchiever')->name('web.reward_achiever');
Route::get('/contact', 'Web\WebsiteController@contact')->name('web.contact');
Route::get('/thanks/{token}', 'Web\WebsiteController@thanks')->name('web.thanks');
Route::get('/product/data', 'Web\WebsiteController@productData')->name('web.product.data');
Route::get('/category/filter/{id}', 'Web\WebsiteController@categoryFilter')->name('web.category_filter');
Route::get('/legal/docs', 'Web\WebsiteController@legalDocs')->name('web.legal');
Route::get('/video/plan', 'Web\WebsiteController@videoPlan')->name('web.video_plan');
Route::get('/videos', 'Web\WebsiteController@video')->name('web.gallery.video');
// =========== join-us ============= 
Route::get('/Document', function () {
    return view('web.document');
})->name('web.document');

// =========== join-us ============= 
Route::get('/club', function () {
    return view('web.club');
})->name('web.club');

// =========== login ============= 
Route::get('/login', function () {
    return view('web.login');
})->name('web.login');

// =========== product-list ============= 
Route::get('/product-list', 'Web\WebsiteController@productList')->name('web.product.product-list');

// =========== product-detail ============= 
Route::get('/product-detail/{id}', 'Web\WebsiteController@productDetail')->name('web.product.product-detail');

// =========== Image ============= 
Route::get('/image', 'Web\WebsiteController@image')->name('web.gallery.image');

// =========== Video ============= 
