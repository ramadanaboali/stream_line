<?php

use App\Http\Controllers\Api\V1\Vendor\AuthController;
use App\Http\Controllers\Api\V1\Vendor\UserController;
use App\Http\Controllers\Api\V1\Vendor\BranchController;
use App\Http\Controllers\Api\V1\Vendor\SectionController;
use App\Http\Controllers\Api\V1\Vendor\SubscriptionController;
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

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::post('/reset', [AuthController::class, 'resetPassword']);
    Route::post('/check-code', [AuthController::class, 'checkCode']);
    Route::post('/confirm-reset', [AuthController::class, 'confirmReset']);

});

Route::group(['prefix' => '/v1','middleware' => ['auth:api']], function () {

    Route::get('users', [UserController::class, 'index'])->middleware('vendorPermission:users.view');
    Route::post('users', [UserController::class, 'store'])->middleware('vendorPermission:users.create');
    Route::get('users/{user}', [UserController::class, 'show'])->middleware('vendorPermission:users.view');
    Route::put('users/{user}', [UserController::class, 'update'])->middleware('vendorPermission:users.edit');
    Route::delete('users/{user}', [UserController::class, 'delete'])->middleware('vendorPermission:users.delete');

    Route::get('branches', [BranchController::class, 'index'])->middleware('vendorPermission:branches.view');
    Route::post('branches', [BranchController::class, 'store'])->middleware('vendorPermission:branches.create');
    Route::get('branches/{branch}', [BranchController::class, 'show'])->middleware('vendorPermission:branches.view');
    Route::put('branches/{branch}', [BranchController::class, 'update'])->middleware('vendorPermission:branches.edit');
    Route::delete('branches/{branch}', [BranchController::class, 'delete'])->middleware('vendorPermission:branches.delete');


    Route::get('sections', [SectionController::class, 'index'])->middleware('vendorPermission:sections.view');
    Route::post('sections', [SectionController::class, 'store'])->middleware('vendorPermission:sections.create');
    Route::get('sections/{branch}', [SectionController::class, 'show'])->middleware('vendorPermission:sections.view');
    Route::put('sections/{branch}', [SectionController::class, 'update'])->middleware('vendorPermission:sections.edit');
    Route::delete('sections/{branch}', [SectionController::class, 'delete'])->middleware('vendorPermission:sections.delete');

    Route::post('/update-profile', [AuthController::class, 'updateProfile']);
    Route::post('/send-code', [AuthController::class, 'sendCode']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::post('/update-email', [AuthController::class, 'updateEmail']);
    Route::post('/update-phone', [AuthController::class, 'updatePhone']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);


    Route::get('subscriptions', [SubscriptionController::class, 'index'])->middleware('vendorPermission:subscriptions.view');
    Route::post('subscriptions', [SubscriptionController::class, 'store'])->middleware('vendorPermission:subscriptions.create');
    Route::get('subscriptions/{subscription}', [SubscriptionController::class, 'show'])->middleware('vendorPermission:subscriptions.view');
    Route::put('subscriptions/{subscription}', [SubscriptionController::class, 'update'])->middleware('vendorPermission:subscriptions.edit');
    Route::delete('subscriptions/{subscription}', [SubscriptionController::class, 'delete'])->middleware('vendorPermission:subscriptions.delete');


});
