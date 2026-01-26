<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SecurityController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductModelController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\POSController;
use App\Http\Controllers\Admin\TaxSettingsController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\CartController;

// Public routes
Route::get('/', [FrontendController::class, 'index'])->name('frontend.index');
Route::get('/products/{id}', [FrontendController::class, 'showProduct'])->name('frontend.products.show');

// Cart routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{productId}', [CartController::class, 'add'])->name('add');
    Route::put('/update/{productId}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{productId}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    Route::get('/count', [CartController::class, 'count'])->name('count');
});

// Authenticated routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard route for Apex Platform
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('brands', BrandController::class);
        Route::resource('product-models', ProductModelController::class);
        Route::resource('products', ProductController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('purchases', PurchaseController::class);
        Route::resource('customers', CustomerController::class);
        Route::get('sales', [SaleController::class, 'index'])->name('sales.index');
        Route::get('sales/{sale}', [SaleController::class, 'show'])->name('sales.show');
        Route::get('sales/{sale}/receipt', [SaleController::class, 'receipt'])->name('sales.receipt');
        Route::get('sales/{sale}/receipt/download', [SaleController::class, 'downloadReceipt'])->name('sales.receipt.download');
        Route::post('sales/{sale}/return', [SaleController::class, 'processReturn'])->name('sales.return');
        
        // POS Routes
        Route::prefix('pos')->name('pos.')->group(function () {
            Route::get('/', [POSController::class, 'index'])->name('index');
            Route::post('/', [POSController::class, 'store'])->name('store');
            Route::get('/search-product', [POSController::class, 'searchProduct'])->name('search-product');
        });
        
        // Settings Routes
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::prefix('tax')->name('tax.')->group(function () {
                Route::get('/edit', [TaxSettingsController::class, 'edit'])->name('edit');
                Route::put('/update', [TaxSettingsController::class, 'update'])->name('update');
            });
        });
        
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
