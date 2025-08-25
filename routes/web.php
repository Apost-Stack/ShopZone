<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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