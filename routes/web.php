<?php

use App\Http\Controllers\Admin\Users\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->name('public.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Public\PublicController::class, 'home'])->name('home');
    Route::get('/about', [\App\Http\Controllers\Public\PublicController::class, 'about'])->name('about');
    Route::get('/contact', [\App\Http\Controllers\Public\PublicController::class, 'contact'])->name('contact');
});

Route::prefix('/Authentication')->name('Auth.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Auth\AuthentificateController::class, 'loginView'])->name('loginView');
    Route::post('/login', [\App\Http\Controllers\Auth\AuthentificateController::class, 'login'])->name('login');
    Route::get('/register-customer', [\App\Http\Controllers\Auth\AuthentificateController::class,'registerCustomerView'])->name('registerCustomerView');
    Route::post('/register-customer', [UserController::class,'storeCustomer'])->name('register');

    Route::post('/logout', [\App\Http\Controllers\Auth\AuthentificateController::class, 'logout'])->name('logout');
});

Route::prefix('/Administration')->group(function () {
    Route::resource('/statuses', \App\Http\Controllers\Admin\Base\StatusController::class);
    //Sel
    Route::prefix('/Sel')->group(function () {
        Route::prefix('/products')->group(function () {
            Route::resource('/categories', \App\Http\Controllers\Admin\Sel\Product\CategoryController::class);
        });
    });
});