<?php

namespace BonsaiCms\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePublishing();
        $this->configureRoutes();
    }

    /**
     * Configure the publishable resources offered by the package.
     *
     * @return void
     */
    protected function configurePublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../../config' => config_path(''),
            ], 'bonsai-config');

            $this->publishes([
                __DIR__.'/../../../database/migrations' => database_path('migrations'),
            ], 'bonsai-migrations');

            $this->publishes([
                __DIR__.'/../../App/Actions' => app_path('Actions'),
            ], 'bonsai-actions');

            $this->publishes([
                __DIR__.'/../../App/Http/Responses' => app_path('Http/Responses'),
            ], 'bonsai-http-responses');

            $this->publishes([
                __DIR__.'/../../App/Providers' => app_path('Providers'),
            ], 'bonsai-providers');
        }
    }

    /**
     * Configure the routes offered by the application.
     *
     * @return void
     */
    protected function configureRoutes()
    {
        RateLimiter::for('passwordForgot', function (Request $request) {
            return Limit::perMinute(1)->by($request->ip());
        });

        Route::group([
            'middleware' => config('fortify.middleware', ['web']),
            'namespace' => 'Laravel\Fortify\Http\Controllers',
            'domain' => config('fortify.domain', null),
            'prefix' => config('fortify.path'),
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../../../routes/auth.php');
        });
    }
}
