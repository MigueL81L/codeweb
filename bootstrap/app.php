<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        // Añadir las rutas definidas en instructor.php y admin.php
        then: function () {
            // Incluir rutas de instructor.php con prefijo 'instructor' y nombre 'instructor'
            Route::prefix('instructor')->name('instructor.')->middleware(['auth', 'web'])->group(function () {
                require base_path('routes/instructor.php');
            });

            // Incluir rutas de admin.php con prefijo 'admin' y nombre 'admin'
            Route::prefix('admin')->name('admin.')->middleware(['auth', 'web'])->group(function () {
                require base_path('routes/admin.php');
            });
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();





