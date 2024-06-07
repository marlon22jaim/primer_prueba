<?php

use App\Http\Controllers\SupplierController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    Route::prefix('v1')->namespace('App\Http\Controllers')->group(function () {
        Route::apiResource('suppliers', SupplierController::class);
        Route::apiResource('orders', OrderController::class);
        Route::post('orders/bulk', ['uses' => 'OrderController@bulkStore']);
    });
});

