<?php

use App\Http\Controllers\AddonController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('products', ProductController::class);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/parents', [CategoryController::class, 'getParentCategories']);

    Route::apiResource('addons', AddonController::class);
});

Route::post('/login', [AuthController::class, 'login']);
Route::get('/product/{slug}', [ProductController::class, 'showSlug']);
Route::get('/glitter-addons', [AddonController::class, 'index']);

{/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/
}
