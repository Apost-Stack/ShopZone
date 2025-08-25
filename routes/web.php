<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('/Administration')->group(function () {
    Route::resource('/statuses', \App\Http\Controllers\Base\StatusController::class);
    //Sel
    Route::prefix('/Sel')->group(function () {
        Route::prefix('/products')->group(function () {
            Route::resource('/categories', \App\Http\Controllers\Sel\Product\CategoryController::class);
        });
    });
});