<?php

use Illuminate\Support\Facades\Route;

/**
 * Web Routes
 * 
 * Phase 0: UI Shell test routes
 * Phase 1: Authentication routes
 */

// Welcome page (Laravel default - can be removed later)
Route::get('/', function () {
    return view('welcome');
});

// UI Shell Smoke Test (Phase 0B)
Route::get('/_shell', function () {
    return view('shell');
})->name('shell');

// Phase 1 Test Summary
Route::get('/_test-phase1', function () {
    return view('test-phase1');
})->name('test.phase1');

// Phase 2 Test Summary
Route::middleware('auth')->group(function () {
    Route::get('/_test-phase2', function () {
        return view('test-phase2');
    })->name('test.phase2');

    // Permission test routes
    Route::get('/_test-permission/{permission}', function (string $permission) {
        return response()->json([
            'success' => true,
            'message' => "✅ Access granted! You have the '{$permission}' permission.",
            'user' => auth()->user()->name,
            'permission' => $permission,
        ]);
    })->middleware('permission:{permission}')->name('test.permission');
});

// Dashboard placeholder (Phase 6)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect('/_shell');
    })->name('dashboard');
});

// Auth routes (Phase 1)
require __DIR__.'/auth.php';
