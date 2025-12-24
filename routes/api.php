<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FirebaseAuthController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\ManageCategoryController;
use App\Http\Controllers\ManageDashboardController;
use App\Http\Controllers\ManageOrderController;
use App\Http\Controllers\ManageProductController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'signup']);

Route::group(['prefix' => 'auth'], function () {
    Route::get('/google/redirect', [GoogleAuthController::class, 'redirect']);
    Route::get('/google/callback', [GoogleAuthController::class, 'callback']);
    Route::get('/google/get-token', [GoogleAuthController::class, 'getToken']);
    Route::prefix('firebase')->group(function () {
        Route::post('/signin', [FirebaseAuthController::class, 'signin']);
    });
});

Route::middleware(['auth:sanctum'])->group(function () {
    // can dang nhap moi duoc su dung
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('user-infor', [ManageUserController::class, 'userInfor']);

    Route::post('update-or-create-cate', [ManageCategoryController::class, 'updateOrCreateCate']);
    Route::get('delete-cate', [ManageCategoryController::class, 'deleteCate']);
    Route::post('update-or-create-product', [ManageProductController::class, 'updateOrCreateProduct']);
    Route::get('delete-product', [ManageProductController::class, 'deleteProduct']);

    Route::post('create-bill', [PaymentController::class, 'createBill']);
    Route::get('check-payment-status', [PaymentController::class, 'checkPaymentStatus']);
    Route::get('order-history', [ManageUserController::class, 'orderHistory']);
    Route::post('update-profile', [ManageUserController::class, 'updateProfile']);
    Route::post('/send-feedback', [ManageOrderController::class, 'sendFeedback']);

});

Route::get('/list-category', [ManageCategoryController::class, 'listCategory']);
Route::get('/list-product', [ManageProductController::class, 'listProduct']);
Route::get('/best-products', [ManageProductController::class, 'bestProducts']);
Route::get('/product-detail', [ManageProductController::class, 'productDetail']);
Route::get('/similar-products', [ManageProductController::class, 'similarProduct']);

Route::get('/list-orders', [ManageOrderController::class, 'listOrder']);
Route::post('/update-order-status', [ManageOrderController::class, 'updateOrderStatus']);

Route::get('/get-statistics', [ManageDashboardController::class, 'getStatistics']);
Route::get('/get-revenue-by-year', [ManageDashboardController::class, 'getRevenueByYear']);
Route::get('/get-monthly-revenue', [ManageDashboardController::class, 'getMonthlyRevenue']);