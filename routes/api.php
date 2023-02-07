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

Route::apiResource('/product', ProductController::class);
Route::apiResource('/user', UserController::class);
Route::apiResource('/transaction', TransactionController::class);
Route::apiResource('/transaction-line', TransactionLineController::class);
Route::apiResource('/customer', CustomerController::class);
Route::apiResource('/cart', CartController::class);
Route::apiResource('/cart-line', CartLineController::class);
Route::apiResource('/admin', AdminController::class);
Route::apiResource('/farmer', FarmerController::class);
