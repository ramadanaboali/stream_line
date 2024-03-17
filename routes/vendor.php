<?php

use App\Http\Controllers\Api\V1\Vendor\UserController;
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

Route::group(['prefix' => '/v1'], function() {

    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);

    Route::post('/reset', [UserController::class, 'resetPassword']);
    Route::post('/check-code', [UserController::class, 'checkCode']);
    Route::post('/confirm-reset', [UserController::class, 'confirmReset']);

});

Route::group(['prefix' => '/v1','middleware' => ['auth:api']], function() {


    Route::post('/logout',[UserController::class, 'logout']);

    Route::post('/update-profile', [AuthController::class, 'updateProfile'])->middleware('vendorPermission:profile.updateProfile');

});
