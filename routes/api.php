<?php

use Illuminate\Support\Facades\Route;
use WolfShop\Http\Controllers\Api\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    require __DIR__ . '/api_v1.php';
});
