<?php

use App\Http\Controllers\AddonController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('products', ProductController::class)->except(['show', 'index']);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/parents', [CategoryController::class, 'getParentCategories']);

    Route::apiResource('addons', AddonController::class);
});

Route::post('/login', [AuthController::class, 'login']);
Route::get('/product/{slug}', [ProductController::class, 'showSlug']);
Route::get('/glitter-addons', [AddonController::class, 'index']);

Route::apiResource('products', ProductController::class)->only(['index', 'show']);

Route::get('/products/{product}/reviews', [ReviewController::class, 'index']);
Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])
    ->middleware('auth:sanctum'); // delete if users cand review if not authenticated

{/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/
}
