<?php

use App\Http\Controllers\OrderController;

use Illuminate\Support\Facades\Route;

Route::prefix('orders')->group(function () {
    Route::post('/', [OrderController::class, 'createOrder']);
    Route::get('/{id}', [OrderController::class, 'viewOrder']);
    Route::get('/', [OrderController::class, 'listOrders']);
});
