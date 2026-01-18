<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\SecurityController;

// Public routes
Route::get('/', [FrontendController::class, 'index'])->name('frontend.index');

// Authenticated routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard route for Mubs Script Marking & Tracing System
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // User Management routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('faculties', FacultyController::class);
        
        // Security Routes
        Route::prefix('security')->name('security.')->group(function () {
            Route::get('/', [SecurityController::class, 'index'])->name('index');
            Route::get('/{securityLog}', [SecurityController::class, 'show'])->name('show');
            Route::post('/block-ip/{ipAddress}', [SecurityController::class, 'blockIp'])->name('block-ip');
            Route::put('/unblock-ip/{ipAddress}', [SecurityController::class, 'unblockIp'])->name('unblock-ip');
            Route::get('/export', [SecurityController::class, 'export'])->name('export');
        });
    });
});
