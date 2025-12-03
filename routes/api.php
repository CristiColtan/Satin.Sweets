<?php

use App\Http\Controllers\AddonController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ResetPasswController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

//Route::get('/debug-dom', function () {
//    return [
//        'class_exists' => class_exists(DOMDocument::class),
//        'php_version' => PHP_VERSION,
//        'extensions' => get_loaded_extensions(),
//    ];
//});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('products', ProductController::class)->except(['show', 'index']);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/parents', [CategoryController::class, 'getParentCategories']);

    Route::apiResource('addons', AddonController::class);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password', [ResetPasswController::class, 'sendResetLinkEmail']);
Route::post('/reset-password', [ResetPasswController::class, 'resetPassword']);

Route::get('/product/{slug}', [ProductController::class, 'showSlug']);
Route::get('/glitter-addons', [AddonController::class, 'index']);

Route::apiResource('products', ProductController::class)->only(['index', 'show']);

Route::get('/products/{product}/reviews', [ReviewController::class, 'index']);
Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])
    ->middleware('auth:sanctum');
//sterge daca te razgandesti si utilizatorii pot lasa review uri daca nu sunt autentificati

Route::get('/categories/children/{parentId}', [CategoryController::class, 'getChildCategories']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites/{product}', [FavoriteController::class, 'store']);
    Route::delete('/favorites/{product}', [FavoriteController::class, 'destroy']);
});
{/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/
}
