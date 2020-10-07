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
        });

        // Commission Set
        Route::group(['namespace' => 'Commission'], function () {
            Route::get('/commission', 'CommissionsController@index')->name('admin.commission');
            Route::post('store/commission', 'CommissionsController@store')->name('admin.add_commission');
        });
    });
});