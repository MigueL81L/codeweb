<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {

    // Rutas del footer
    Route::view('/who-we-are', 'externos.about')->name('who-we-are');
    Route::view('/contact', 'externos.contact')->name('contact'); // Corregido para apuntar a la vista correcta
    Route::view('/privacy-policy', 'externos.privacy-policy')->name('privacy-policy');
    Route::view('/terms-and-conditions', 'externos.terms-and-conditions')->name('terms-and-conditions');
    Route::view('/accessibility-statement', 'externos.accessibility-statement')->name('accessibility-statement');
});