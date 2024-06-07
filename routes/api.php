<?php

use App\Http\Controllers\SupplierController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
});

// Agrupa las rutas bajo un middleware y un prefijo de versión
Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    Route::prefix('v1')->namespace('App\Http\Controllers')->group(function () {
        // Rutas de recursos para proveedores y órdenes
        // Rutas CRUD para proveedores y órdenes
        Route::apiResource('suppliers', SupplierController::class);
        Route::apiResource('orders', OrderController::class);
         // Ruta personalizada para almacenamiento masivo de órdenes
        Route::post('orders/bulk', ['uses' => 'OrderController@bulkStore']);
    });
});

