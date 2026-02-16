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

// Phase 3 Test Summary
Route::middleware('auth')->group(function () {
    Route::get('/_test-phase3', function () {
        return view('test-phase3');
    })->name('test.phase3');
});

// Phase 4 Test Summary
Route::middleware('auth')->group(function () {
    Route::get('/_test-phase4', function () {
        return view('test-phase4');
    })->name('test.phase4');
});

// Phase 5 Test Summary (requires tenant.selected middleware)
Route::middleware(['auth', 'tenant.selected'])->group(function () {
    Route::get('/_test-phase5', function () {
        return view('test-phase5');
    })->name('test.phase5');
});

// Phase 6 Test Summary (requires tenant.selected middleware)
Route::middleware(['auth', 'tenant.selected'])->group(function () {
    Route::get('/_test-phase6', function () {
        return view('test-phase6');
    })->name('test.phase6');
});

// Phase 7 Test Summary (requires tenant.selected middleware)
Route::middleware(['auth', 'tenant.selected'])->group(function () {
    Route::get('/_test-phase7', function () {
        return view('test-phase7');
    })->name('test.phase7');
});

// Phase 8 Test Summary (requires tenant.selected middleware)
Route::middleware(['auth', 'tenant.selected'])->group(function () {
    Route::get('/_test-phase8', function () {
        return view('test-phase8');
    })->name('test.phase8');
});

// Dashboard (Phase 6)
// Protected by: auth + tenant.selected middleware
Route::middleware(['auth', 'tenant.selected'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
        ->name('dashboard');
});

// Auth routes (Phase 1)
require __DIR__.'/auth.php';

// Users CRUD (Phase 3)
// Phase 5: Now includes tenant.selected middleware
Route::middleware(['auth', 'tenant.selected'])->prefix('users')->name('users.')->group(function () {
    // Index: requires users.view permission
    Route::get('/', [App\Http\Controllers\UserController::class, 'index'])
        ->middleware('permission:users.view')
        ->name('index');

    // Create: requires users.create permission
    Route::get('/create', [App\Http\Controllers\UserController::class, 'create'])
        ->middleware('permission:users.create')
        ->name('create');

    // Store: requires users.create permission
    Route::post('/', [App\Http\Controllers\UserController::class, 'store'])
        ->middleware('permission:users.create')
        ->name('store');

    // Edit: requires users.update permission
    Route::get('/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])
        ->middleware('permission:users.update')
        ->name('edit');

    // Update: requires users.update permission
    Route::put('/{user}', [App\Http\Controllers\UserController::class, 'update'])
        ->middleware('permission:users.update')
        ->name('update');

    // Delete: requires users.delete permission
    Route::delete('/{user}', [App\Http\Controllers\UserController::class, 'destroy'])
        ->middleware('permission:users.delete')
        ->name('destroy');
});
