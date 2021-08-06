<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Login and register endpoints
Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);


Route::middleware('auth:api')->group(function(){

    // Create, update, delete or find users enpoints 
    Route::resource('users', UserController::class);
    Route::get('users/profile', [UserController::class, 'show']);
    Route::put('users/update/password', [UserController::class, 'updatePassword']);

    // Create, delete or find accounts enpoints 
    Route::resource('account', AccountController::class);
    Route::get('account/user', [AccountController::class, 'show']);

    // Create, delete or find loans enpoints 
    Route::resource('loan', LoanController::class);
    Route::get('loan/user', [LoanController::class, 'show']);

     // Create, delete or find payments enpoints 
     Route::resource('payment', PaymentController::class);
     Route::get('payment/user', [PaymentController::class, 'show']);
});