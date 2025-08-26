<?php

use App\Http\Controllers\Admin\Users\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::prefix('/Authentication')->name('Auth.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Auth\AuthentificateController::class, 'loginView'])->name('loginView');
    Route::post('/login', [\App\Http\Controllers\Auth\AuthentificateController::class, 'login'])->name('login');
    Route::get('/register-customer', [\App\Http\Controllers\Auth\AuthentificateController::class,'registerCustomerView'])->name('registerCustomerView');
    Route::post('/register-customer', [UserController::class,'storeCustomer'])->name('register');
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