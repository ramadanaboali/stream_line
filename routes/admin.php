<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Admin\AuthController;
use App\Http\Controllers\Api\V1\Admin\UnitController;

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

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/reset', [AuthController::class, 'resetPassword']);
    Route::post('/check-code', [AuthController::class, 'checkCode']);
    Route::post('/confirm-reset', [AuthController::class, 'confirmReset']);
});

Route::group(['prefix' => '/v1','middleware' => ['auth:api']], function () {

    Route::post('/update-profile', [AuthController::class, 'updateProfile']);
    Route::post('/send-code', [AuthController::class, 'sendCode']);
    Route::post('/update-email', [AuthController::class, 'updateEmail']);
    Route::post('/update-phone', [AuthController::class, 'updatePhone']);
    Route::get('/profile', [AuthController::class, 'profile']);

    Route::post('/logout', [AuthController::class, 'logout']);


});
