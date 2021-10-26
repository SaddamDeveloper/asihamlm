<?php

// =========== index ============= 

use Illuminate\Support\Facades\Route;
Route::group(['namespace' => 'Web'], function () {
    Route::get('/', 'WebsiteController@index')->name('web.index');
    Route::get('/about', 'WebsiteController@about')->name('web.about');
    Route::get('/plan', 'WebsiteController@plan')->name('web.plan');
    Route::get('/reward', 'WebsiteController@reward')->name('web.reward');
    Route::get('/product', 'WebsiteController@product')->name('web.product');
    Route::get('/rank/achiever', 'WebsiteController@rankAchiever')->name('web.rank_achiever');
    Route::get('/reward/achiever', 'WebsiteController@rewardAchiever')->name('web.reward_achiever');
    Route::get('/contact', 'WebsiteController@contact')->name('web.contact');
    Route::get('/thanks/{token}', 'WebsiteController@thanks')->name('web.thanks');
    Route::get('/product/data', 'WebsiteController@productData')->name('web.product.data');
    Route::get('/category/filter/{id}', 'WebsiteController@categoryFilter')->name('web.category_filter');
    Route::get('/legal/docs', 'WebsiteController@legalDocs')->name('web.legal');
    Route::get('/video/plan', 'WebsiteController@videoPlan')->name('web.video_plan');
    Route::get('/videos', 'WebsiteController@video')->name('web.gallery.video');
    // =========== join-us ============= 
    Route::get('/Document', 'WebsiteController@document')->name('web.document');
    Route::get('/product/data', 'WebsiteController@productData')->name('web.product.data');
});

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
