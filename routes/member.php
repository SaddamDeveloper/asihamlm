<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Member', 'prefix' => 'member'],function(){
    Route::get('login','LoginController@showLoginForm')->name('member.login');    
    Route::post('login', 'LoginController@memberLogin');
    Route::post('logout', 'LoginController@logout')->name('member.logout');

    Route::group(['middleware'=>'auth:member'],function(){
        Route::get('/change/password/form', 'LoginController@changePasswordForm')->name('member.change_password_form');
        Route::post('/change/password', 'LoginController@changePassword')->name('member.change_password');
        
        Route::get('/dashboard', 'DashboardController@dashboardView')->name('member.dashboard');
        Route::group(['namespace' => 'Profile'], function () {
            Route::get('/profile', 'ProfileController@index')->name('member.profile');
            Route::get('/account/update', 'ProfileController@accountUpdate')->name('member.account_update');
            Route::post('/member/update', 'ProfileController@memberUpdate')->name('member.update_member');
        });
        
        // Registration
        Route::group(['namespace' => 'Registration'], function (){
            Route::get('/register', 'RegistrationController@index')->name('member.register');
            Route::post('/add/member', 'RegistrationController@store')->name('member.add_new_member');
            Route::get('/search/sponsorID', 'RegistrationController@searchSponsorID')->name('member.search_sponsor_id');
            Route::get('/check/loginID', 'RegistrationController@loginIDCheck')->name('member.login_id_check');
            Route::get('/product/{id}', 'RegistrationController@productPage')->name('member.product_page');
            Route::post('/purchase', 'RegistrationController@purchasePage')->name('member.purchase');
            Route::get('/finsih', 'RegistrationController@finishPage')->name('member.finish');
        });

        // Downline
        Route::group(['namespace' => 'Downline'], function () {
            Route::get('/downline', 'DownlineController@index')->name('member.downline');
            Route::get('/my/downline', 'DownlineController@downline')->name('member.ajax.downline_list');
        });

        // Tree
        Route::group(['namespace' => 'Tree'], function () {
            // Route::get('/tree', 'TreeController@index')->name('member.tree');
            Route::get('/my/tree/{rank?}/{user_id?}', 'TreeController@memberTree')->name('member.tree');
        });

        // Wallet
        Route::group(['namespace' => 'Wallet'], function () {
            Route::get('/wallet', 'WalletsController@index')->name('member.wallet');
            Route::get('/wallet/data', 'WalletsController@walletList')->name('member.ajax.wallet');
            Route::get('/wallet/balance', 'WalletsController@walletBalance')->name('member.wallet_balance');
            Route::get('/withdraw', 'WalletsController@withdraw')->name('member.withdraw');
            Route::post('/withdraw/amount', 'WalletsController@withdrawAmount')->name('member.withdraw.amount');
            Route::get('/withdraw/list', 'WalletsController@withdrawList')->name('member.ajax.withdraw');
        });

        // Commission
        Route::group(['namespace' => 'Commission'], function () {
            Route::get('/commission', 'CommissionsController@index')->name('member.commission');
            Route::get('/commission/list', 'CommissionsController@commission')->name('member.ajax.commission');
        });

        // Order
        Route::group(['namespace' => 'Order'], function () {
            Route::get('/order', 'OrderController@index')->name('member.orders');
            Route::get('/order/list', 'OrderController@ordersList')->name('member.ajax.orders');
        });
    });
});