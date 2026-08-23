<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_ENV') === 'production' || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) || request()->header('x-forwarded-proto') === 'https') {
            URL::forceScheme('https');
        }
    }
}
