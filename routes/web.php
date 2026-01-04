<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

use App\Http\Controllers\Admin\AuthController as AdminAuth;
use App\Http\Controllers\Customer\AuthController as CustomerAuth;

Route::prefix('admin')->group(function () {

    Route::get('/login', [AdminAuth::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuth::class, 'login']);
    Route::post('/logout', [AdminAuth::class, 'logout'])->name('admin.logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', function () {
            return Inertia::render('Admin/Dashboard');
        })->name('admin.dashboard');
    });
});


Route::prefix('customer')->group(function () {

    Route::get('/login', [CustomerAuth::class, 'showLogin'])->name('customer.login');
    Route::post('/login', [CustomerAuth::class, 'login']);
    Route::post('/logout', [CustomerAuth::class, 'logout'])->name('customer.logout');

    Route::middleware('auth:customer')->group(function () {
        Route::get('/dashboard', function () {
            return Inertia::render('Customer/Dashboard');
        })->name('customer.dashboard');
    });
});




require __DIR__.'/settings.php';   
   