<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('customers')->group(function () {

    Route::get('/', [\App\Http\Controllers\CustomerController::class, 'me']);
    Route::put('/', [\App\Http\Controllers\CustomerController::class, 'update']);
    Route::post('/', [\App\Http\Controllers\CustomerController::class, 'store']);

    Route::get('/{customer_id}', [\App\Http\Controllers\CustomerController::class, 'show']);

    Route::post('/{customer_id}/vehicles', [\App\Http\Controllers\VehicleController::class, 'store']);
    Route::get('/{customer_id}/vehicles', [\App\Http\Controllers\VehicleController::class, 'index']);
    Route::get('/{customer_id}/vehicles/{vehicle_id}', [\App\Http\Controllers\VehicleController::class, 'show']);
    Route::put('/{customer_id}/vehicles/{vehicle_id}', [\App\Http\Controllers\VehicleController::class, 'update']);
    Route::delete('/{customer_id}/vehicles/{vehicle_id}', [\App\Http\Controllers\VehicleController::class, 'destroy']);
});
