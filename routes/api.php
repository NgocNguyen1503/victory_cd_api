<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\ManageCategoryController;
use App\Http\Controllers\ManageProductController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'signup']);

Route::group(['prefix' => 'auth'], function () {
    Route::get('/google/redirect', [GoogleAuthController::class, 'redirect']);
    Route::get('/google/callback', [GoogleAuthController::class, 'callback']);
    Route::get('/google/get-token', [GoogleAuthController::class, 'getToken']);
});


Route::middleware(['auth:sanctum'])->group(function () {
    //
});

Route::get('/list-category', [ManageCategoryController::class, 'listCategory']);
Route::get('/list-product', [ManageProductController::class, 'listProduct']);
// Route::get('/best-products', [ManageProductController::class, 'bestProducts']);
