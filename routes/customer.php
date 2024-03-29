<?php

use App\Http\Controllers\Api\V1\Customer\AuthController;
use App\Http\Controllers\Api\V1\Customer\BookingController;
use App\Http\Controllers\Api\V1\Customer\HomeController;
use App\Http\Controllers\Api\V1\Customer\WishListController;
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

Route::group(['prefix' => '/v1'], function () {

    Route::post('/reset', [AuthController::class, 'resetPassword']);
    Route::post('/check-code', [AuthController::class, 'checkCode']);
    Route::post('/confirm-reset', [AuthController::class, 'confirmReset']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('search', [HomeController::class, 'search']);

});

Route::group(['prefix' => '/v1','middleware' => ['auth:api']], function () {

    Route::get('bookings/pay/{id}', [BookingController::class, 'pay']);
    Route::get('bookings/cancel/{id}', [BookingController::class, 'cancel']);

    Route::get('bookings', [BookingController::class, 'index']);
    Route::post('bookings', [BookingController::class, 'store']);
    Route::get('bookings/{booking}', [BookingController::class, 'show']);
    Route::put('bookings/{booking}', [BookingController::class, 'update']);
    Route::delete('bookings/{booking}', [BookingController::class, 'delete']);

    Route::get('wish_lists', [WishListController::class, 'index']);
    Route::post('wish_lists', [WishListController::class, 'store']);
    Route::get('wish_lists/{wish_list}', [WishListController::class, 'show']);
    Route::put('wish_lists/{wish_list}', [WishListController::class, 'update']);
    Route::delete('wish_lists/{wish_list}', [WishListController::class, 'delete']);

    Route::post('/update-profile', [AuthController::class, 'updateProfile']);
    Route::post('/send-code', [AuthController::class, 'sendCode']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::post('/update-email', [AuthController::class, 'updateEmail']);
    Route::post('/update-phone', [AuthController::class, 'updatePhone']);
    Route::get('/profile', [AuthController::class, 'profile']);

    Route::post('/logout', [AuthController::class, 'logout']);

});
