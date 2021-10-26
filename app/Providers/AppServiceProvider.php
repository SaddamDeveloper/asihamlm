<?php

namespace App\Providers;

use App\Models\Frontend;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        View::composer('web.include.header', function($view){
            $frontend = Frontend::first();
            $view->with('frontend', $frontend);
        });
        View::composer('web.include.footer', function($view){
            $frontend = Frontend::first();
            $view->with('frontend', $frontend);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
