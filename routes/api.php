<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\PassportAuthController;
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
   
    // Create, delete or find accounts enpoints 
    Route::resource('account', AccountController::class);
});