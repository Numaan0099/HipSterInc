<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

use App\Http\Controllers\Admin\AuthController as AdminAuth;
use App\Http\Controllers\Admin\ProductImportController;
use App\Http\Controllers\Admin\ProductController;


use App\Http\Controllers\Customer\AuthController as CustomerAuth;


Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/register', [AdminAuth::class, 'showRegister'])->name('register');
        Route::post('/register', [AdminAuth::class, 'register']);

        Route::get('/login', [AdminAuth::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuth::class, 'login']);
        Route::post('/logout', [AdminAuth::class, 'logout'])->name('logout');

        Route::middleware('auth:admin')->group(function () {

            Route::resource('products', ProductController::class);

            Route::get('/dashboard', function () {
                return Inertia::render('Admin/Dashboard');
            })->name('dashboard');

            Route::get('/products/import', function () {
                return Inertia::render('Admin/ProductImport');
            })->name('products.import.page');

            Route::post('/products/import', [ProductImportController::class, 'import'])
                ->name('products.import');
        });
    });


Route::prefix('customer')->group(function () {
    Route::get('/register', [CustomerAuth::class, 'showRegister'])->name('customer.register');
    Route::post('/register', [CustomerAuth::class, 'register']);


    Route::get('/login', [CustomerAuth::class, 'showLogin'])->name('customer.login');
    Route::post('/login', [CustomerAuth::class, 'login']);
    Route::post('/logout', [CustomerAuth::class, 'logout'])->name('customer.logout');

    Route::middleware('auth:customer')->group(function () {
        Route::get('/dashboard', function () {
            return Inertia::render('Customer/Dashboard');
        })->name('customer.dashboard');
    });
});




require __DIR__ . '/settings.php';
