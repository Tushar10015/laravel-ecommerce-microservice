<?php

use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;


Route::prefix('inventory')->group(function () {
    Route::post('/', [InventoryController::class, 'addProduct']);
    Route::get('/', [InventoryController::class, 'listProducts']);
    Route::put('/{id}', [InventoryController::class, 'updateStock']);
    Route::get('/{id}', [InventoryController::class, 'viewProduct']);
});
