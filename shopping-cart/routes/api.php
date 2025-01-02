<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::prefix('cart')->group(function () {
    Route::post('add', [CartController::class, 'addItem']);
    Route::post('remove', [CartController::class, 'removeItem']);
    Route::get('/', [CartController::class, 'viewCart']);
    Route::delete('clear', [CartController::class, 'clearCart']);
});
