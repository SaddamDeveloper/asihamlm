<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Admin'],function(){
    Route::get('/admin/login','LoginController@showLoginForm')->name('admin.login');    
    Route::post('login', 'LoginController@adminLogin');
    Route::post('logout', 'LoginController@logout')->name('admin.logout');

    Route::group(['middleware'=>'auth:admin','prefix'=>'admin'],function(){
        Route::get('/dashboard', 'DashboardController@dashboardView')->name('admin.deshboard');
        Route::get('/change/password/form', 'LoginController@changePasswordForm')->name('admin.change_password_form');
        Route::post('/change/password', 'LoginController@changePassword')->name('admin.change_password');
        
        // Users
        Route::group(['namespace' => 'Member'], function () {
            Route::get('/members', 'MemberController@index')->name('admin.members');
            Route::get('/member/list', 'MemberController@memberList')->name('admin.ajax.member_list');
            Route::get('/view/member/{id}', 'MemberController@memberView')->name('admin.member_view');
            Route::get('/edit/member/{id}', 'MemberController@memberEdit')->name('admin.member_edit');
            Route::post('/edit/member/', 'MemberController@memberUpdate')->name('admin.update_member');
            Route::get('/downline/member/{id}', 'MemberController@memberDownline')->name('admin.member_downline');
            Route::get('/member/tree/{rank?}/{user_id?}', 'MemberController@memberTree')->name('admin.member.tree');
            Route::get('/downline/member/list/{id}', 'MemberController@memberDownlineList')->name('admin.ajax.downline_list');
            Route::get('/change/member/password/{id}', 'MemberController@changeMemberPassword')->name('admin.member.change_password');
            Route::post('/update/member/password', 'MemberController@updateMemberPassword')->name('admin.update_member_password');
            Route::get('/status/member/{id}/{status}', 'MemberController@memberStatus')->name('admin.member_status');
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
            Route::get('/edit/product/{id}', 'ProductController@edit')->name('admin.edit.product');
            Route::post('/update/product/', 'ProductController@update')->name('admin.update_product');
            Route::get('/delete/product/{id}','ProductController@destroy')->name('admin.delete.product');
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

        // WithDraw
        Route::group(['namespace' => 'Withdraw'], function(){
            Route::get('/withdraw/request', 'WithDrawController@index')->name('admin.withdraw');
            Route::get('/withdraw/list', 'WithDrawController@list')->name('admin.ajax.withdraw');
            Route::get('/withdraw/status/{id}/{status}', 'WithDrawController@status')->name('admin.withdraw_status');
        });

        // WebPage Manage
        Route::group(['namespace' => 'Website'], function () {
            //  Slider
            Route::get('/shopping/slider', 'ShoppingProductController@shoppingSlider')->name('admin.shopping_slider');
            Route::get('/shopping/slider/add', 'ShoppingProductController@addShoppingSlider')->name('admin.add_slider');
            Route::get('/shopping/slider/list', 'ShoppingProductController@ShoppingSliderList')->name('admin.shopping_slider_list');
            Route::post('/shopping/slider/store', 'ShoppingProductController@storeShoppingSlider')->name('admin.store_shopping_slider');
            Route::get('/shopping/slider/status/{sId}/{status}', 'ShoppingProductController@ShoppingSliderStatus')->name('admin.shopping_slider_status');
            Route::get('/shopping/slider/edit/{id}', 'ShoppingProductController@ShoppingSliderEdit')->name('admin.shopping_slider_edit');
            Route::post('/shopping/slider/update', 'ShoppingProductController@ShoppingSliderUpdate')->name('admin.update_shopping_slider');

            //Shopping Product
            Route::get('/shopping/product', 'ShoppingProductController@shoppingProduct')->name('admin.shopping_product');
            Route::get('/shopping/product/add', 'ShoppingProductController@addShoppingProduct')->name('admin.add_shopping_product');
            Route::post('/shopping/product/store', 'ShoppingProductController@storeShoppingProduct')->name('admin.store_shopping_product');
            Route::get('/shopping/product/list', 'ShoppingProductController@ShoppingProductList')->name('admin.shopping_product_list');
            Route::get('/shopping/product/status/{pId}/{status}', 'ShoppingProductController@ShoppingProductStatus')->name('admin.shopping_product_status');
            Route::get('/shopping/product/edit/{id}', 'ShoppingProductController@ShoppingProductEdit')->name('admin.shopping_product_edit');
            Route::post('/shopping/product/update/', 'ShoppingProductController@ShoppingProductUpdate')->name('admin.update_shopping_product');

            //Shopping Category
            Route::get('/shopping/category', 'ShoppingProductController@shoppingCategory')->name('admin.shopping_category');
            Route::get('/shopping/category/add', 'ShoppingProductController@addShoppingCategory')->name('admin.add_shopping_category');
            Route::post('/shopping/category/store', 'ShoppingProductController@storeShoppingCategory')->name('admin.store_shopping_category');
            Route::get('/shopping/category/list', 'ShoppingProductController@ShoppingCategoryList')->name('admin.shoppingCategoryList');
            Route::get('/shopping/category/status/{pId}/{status}', 'ShoppingProductController@ShoppingCategoryStatus')->name('admin.shopping_category_status');
            Route::get('/shopping/category/edit/{id}', 'ShoppingProductController@ShoppingCategoryEdit')->name('admin.shopping_category_edit');
            Route::post('/shopping/category/update/{id}', 'ShoppingProductController@ShoppingCategoryUpdate')->name('admin.update_shopping_category');
            
            // Gallery Add
            Route::get('gallery/', 'GalleryController@gallery')->name('admin.gallery');
            Route::post('/store/gallery/', 'GalleryController@storeGallery')->name('admin.store_gallery');
            Route::get('/gallery/list/', 'GalleryController@galleryList')->name('admin.ajax.get_gallery_list');
            Route::get('/gallery/action/{id}/{status}', 'GalleryController@galleryStatus')->name('admin.gallery_status');
            Route::get('/gallery/delete/{id}', 'GalleryController@galleryDelete')->name('admin.gallery_delete');

            //Video Gallery Add
            Route::get('/video/gallery/', 'VideoGalleryController@videoGallery')->name('admin.video_gallery');
            Route::post('/store/video/gallery/', 'VideoGalleryController@storeVideoGallery')->name('admin.store_video_gallery');
            Route::get('/video/gallery/list/', 'VideoGalleryController@videoGalleryList')->name('admin.ajax.get_video_gallery_list');
            Route::get('/video/gallery/status/{id}/{status}', 'VideoGalleryController@videoGalleryStatus')->name('admin.video_gallery_status');
            Route::get('/video/gallery/delete/{id}', 'VideoGalleryController@videoGalleryDelete')->name('admin.video_gallery_delete');

            // Legal Add
            Route::get('/legal/docs', 'LegalController@legal')->name('admin.legal');
            Route::post('/store/legal/', 'LegalController@storeLegal')->name('admin.store_legal');
            Route::get('/legal/list/', 'LegalController@legalList')->name('admin.ajax.get_legal_list');
            Route::get('/legal/action/{id}/{status}', 'LegalController@legalAction')->name('admin.legal_action');
            Route::get('/legal/delete/{id}', 'LegalController@legalDelete')->name('admin.legal_delete');
            
            // Forented
            Route::get('info/', 'FrontendController@info')->name('admin.info');
            Route::post('/store/info/', 'FrontendController@storeInfo')->name('admin.store_frontend');
        });
    });
});