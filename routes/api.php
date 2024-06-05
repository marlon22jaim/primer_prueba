<?php

use App\Http\Controllers\SupplierController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers','middleware'=>'auth:sanctum'], function () {
    Route::apiResource('suppliers', SupplierController::class);
    Route::apiResource('orders', OrderController::class);
    Route::post('orders/bulk',['uses' => 'OrderController@bulkStore']);
});
