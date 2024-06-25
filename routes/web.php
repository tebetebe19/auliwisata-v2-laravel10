<?php

use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/'], function () {
    // Route::get('/', [ProductsController::class, 'index']);
    Route::get('/', [ProductsController::class, 'urgent']);
    Route::get('{slug?}', [ProductsController::class, 'index']);
});
