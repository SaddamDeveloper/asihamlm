<?php

Route::group(['namespace' => 'Member', 'prefix' => 'member'],function(){
    Route::get('login','LoginController@showLoginForm')->name('member.login');    
    Route::post('login', 'LoginController@memberLogin');
    Route::post('logout', 'LoginController@logout')->name('member.logout');

    Route::group(['middleware'=>'auth:member'],function(){
        Route::get('/dashboard', 'DashboardController@dashboardView')->name('member.dashboard');
        Route::get('/change/password/form', 'LoginController@changePasswordForm')->name('member.change_password_form');
        Route::post('/change/password', 'LoginController@changePassword')->name('member.change_password');

        // Registration
        Route::group(['namespace' => 'Registration'], function (){
            Route::get('/register', 'RegistrationController@index')->name('member.register');
        });

        // Downline
        Route::group(['namespace' => 'Downline'], function () {
            Route::get('/downline', 'DownlineController@index')->name('member.downline');
            Route::get('/tree', 'DownlineController@tree')->name('member.tree');
        });
    });
});