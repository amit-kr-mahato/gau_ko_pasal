<?php

namespace App\Providers;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RoleMiddleware;


use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
 
public function boot()
{
    // Register middleware aliases
    Route::aliasMiddleware('auth', Authenticate::class);
    Route::aliasMiddleware('role', RoleMiddleware::class);
}

}
