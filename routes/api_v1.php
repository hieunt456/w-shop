<?php

use Illuminate\Support\Facades\Route;
use WolfShop\Http\Controllers\Api\V1\ItemController;
use WolfShop\Http\Controllers\Api\V1\ItemImageUploadController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('items', [ItemController::class, 'index'])->name('items.index');
    Route::put('items/{item}/image', ItemImageUploadController::class)->name('items.image.upload');
});
