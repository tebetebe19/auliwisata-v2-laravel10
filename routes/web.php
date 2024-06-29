<?php

use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/'], function () {
    Route::get('/', [ProductsController::class, 'test']);
    Route::get('{slug?}', [ProductsController::class, 'test']);
    // Route::get('/test', [ProductsController::class, 'test']);
});
