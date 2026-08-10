<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        
        // Force HTTPS scheme when accessed through Nginx Reverse Proxy over SSL
        if (!app()->runningInConsole()) {
            if (request()->server('HTTP_X_FORWARDED_PROTO') === 'https' || request()->header('X-Forwarded-Proto') === 'https') {
                \Illuminate\Support\Facades\URL::forceScheme('https');
            }
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        

    }
}