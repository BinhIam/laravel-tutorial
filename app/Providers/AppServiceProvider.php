<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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
        $this->app->bind('UserService', \App\Services\UserService::class);
        $this->app->bind('AuthService', \App\Services\AuthService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('cache', function ($expression) {
            return "<?php if (! App\Services\CachingService::setUp($expression)) { ?>";
        });

        Blade::directive('endcache', function () {
            return "<?php } echo App\Services\CachingService::down() ?>";
        });
    }
}
