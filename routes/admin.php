<?php

Route::group(['namespace' => 'Admin'],function(){
    Route::get('/admin/login','LoginController@showLoginForm')->name('admin.login');    
    Route::post('login', 'LoginController@adminLogin');
    Route::post('logout', 'LoginController@logout')->name('admin.logout');

    Route::group(['middleware'=>'auth:admin','prefix'=>'admin'],function(){
        Route::get('/dashboard', 'DashboardController@dashboardView')->name('admin.deshboard');
        Route::get('/change/password/form', 'LoginController@changePasswordForm')->name('admin.change_password_form');
        Route::post('/change/password', 'LoginController@changePassword')->name('admin.change_password');
        
        // Users
        Route::group(['namespace' => 'User'], function () {
            Route::get('/users', 'UsersController@index')->name('admin.users');
        });

        // Orders
        Route::group(['namespace' => 'Order'], function () {
            Route::get('/orders', 'OrdersController@index')->name('admin.orders');
            Route::get('/orders/list', 'OrdersController@list')->name('admin.ajax.orders');
        });

        // Product List
        Route::group(['namespace' => 'Product'], function (){
            Route::get('/product', 'ProductController@index')->name('admin.product');
            Route::get('/add/product', 'ProductController@add')->name('admin.add.product');
            Route::post('/store/product', 'ProductController@store')->name('admin.store_product');
            Route::get('/list/product', 'ProductController@show')->name('admin.ajax.product_list');
        });

        // Commission Set
        Route::group(['namespace' => 'Commission'], function () {
            Route::get('/commission', 'CommissionsController@index')->name('admin.commission');
            Route::post('store/commission', 'CommissionsController@store')->name('admin.add_commission');
        });

        // Fund
        Route::group(['namespace' => 'Fund'], function(){
            Route::get('/fund', 'FundsController@index')->name('admin.fund');
            Route::get('/fund/page', 'FundsController@fund')->name('admin.allocate_fund');
            Route::post('/allocate/fund', 'FundsController@allocateFund')->name('admin.allot_fund');
            Route::get('/search/sponsor/id', 'FundsController@searchMemberID')->name('admin.search_sponsor');
            Route::get('/fund/list', 'FundsController@show')->name('admin.ajax.funds_list');
            Route::group(['namespace' => 'FundHistory'], function () {
                Route::get('/fund/history/{id}', 'FundsHistoryController@fundHistory')->name('admin.fund_history');
                Route::get('/fund/history/list/{user_id}', 'FundsHistoryController@fundHistoryList')->name('admin.ajax.funds_history_list');
            });
        });

        // Pair Timing
        Route::group(['namespace' => 'PairTiming'], function (){
            Route::get('/pair/timing', 'PairTimingController@index')->name('admin.pair_timing');
            Route::post('/add/pair/timing', 'PairTimingController@store')->name('admin.add_pair_timing');
        });


    });
});