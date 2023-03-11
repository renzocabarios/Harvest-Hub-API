<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionLineController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartLineController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('/product', ProductController::class);
    Route::apiResource('/user', UserController::class, ['except' => ['store']]);
    Route::apiResource('/transaction', TransactionController::class);
    Route::apiResource('/transaction-line', TransactionLineController::class);
    Route::apiResource('/cart', CartController::class);
    Route::apiResource('/cart-line', CartLineController::class);
    Route::apiResource('/admin', AdminController::class);
    Route::apiResource('/farmer', FarmerController::class, ['except' => ['store']]);
    Route::apiResource('/customer', CustomerController::class, ['except' => ['store']]);
    Route::post('/transaction/checkout', [TransactionController::class, 'checkout']);
    Route::get('/transaction/customer/{id}', [TransactionController::class, 'getByCustomer']);
});
Route::post('/farmer', [FarmerController::class, "store"]);
Route::post('/customer', [CustomerController::class, "store"]);
Route::post('/user', [UserController::class, "store"]);
Route::post('/auth', [AuthController::class, "login"]);