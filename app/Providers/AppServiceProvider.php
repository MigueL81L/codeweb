<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Providers\EventServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Registro el EventServiceProvider aquí
        $this->app->register(EventServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register a route or override a redirection logic at start
        Route::get('/', function () {
            return redirect('/register');
    });
    }
}
