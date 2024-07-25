<?php

use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/'], function () {
    Route::get('/gallery', [GalleryController::class, 'gallery']);
    Route::get('/', [ProductsController::class, 'test']);
    Route::get('{slug?}', [ProductsController::class, 'test']);
    // Route::get('/test', [ProductsController::class, 'test']);
});
