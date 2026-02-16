<?php

use Illuminate\Support\Facades\Route;

/**
 * Example Module Routes
 * 
 * Phase 0A: Example routes to test module loading
 */

Route::prefix('example')->name('example.')->group(function () {
    Route::get('/', function () {
        return view('example::index');
    })->name('index');
});
