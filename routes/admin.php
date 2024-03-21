<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Admin\AuthController;
use App\Http\Controllers\Api\V1\Admin\RoleController;
use App\Http\Controllers\Api\V1\Admin\PackageController;
use App\Http\Controllers\Api\V1\Admin\PaymentSettingController;
use App\Http\Controllers\Api\V1\Admin\ServiceSettingController;
use App\Http\Controllers\Api\V1\Admin\TaxSettingController;

Route::group(['prefix' => '/v1'], function () {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/reset', [AuthController::class, 'resetPassword']);
    Route::post('/check-code', [AuthController::class, 'checkCode']);
    Route::post('/confirm-reset', [AuthController::class, 'confirmReset']);

    Route::get('packages', [PackageController::class, 'index']);

});

Route::group(['prefix' => '/v1','middleware' => ['auth:api']], function () {

    Route::get('roles', [RoleController::class, 'index'])->middleware('adminPermission:roles.view');
    Route::post('roles', [RoleController::class, 'store'])->middleware('adminPermission:roles.create');
    Route::get('roles/{role}', [RoleController::class, 'show'])->middleware('adminPermission:roles.view');
    Route::put('roles/{role}', [RoleController::class, 'update'])->middleware('adminPermission:roles.edit');
    Route::delete('roles/{role}', [RoleController::class, 'delete'])->middleware('adminPermission:roles.delete');

    Route::post('/update-profile', [AuthController::class, 'updateProfile']);
    Route::post('/send-code', [AuthController::class, 'sendCode']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::post('/update-email', [AuthController::class, 'updateEmail']);
    Route::post('/update-phone', [AuthController::class, 'updatePhone']);
    Route::get('/profile', [AuthController::class, 'profile']);

    Route::post('packages', [PackageController::class, 'store'])->middleware('adminPermission:packages.create');
    Route::get('packages/{package}', [PackageController::class, 'show'])->middleware('adminPermission:packages.view');
    Route::put('packages/{package}', [PackageController::class, 'update'])->middleware('adminPermission:packages.edit');
    Route::delete('packages/{package}', [PackageController::class, 'delete'])->middleware('adminPermission:packages.delete');

    Route::get('payment_settings', [PaymentSettingController::class, 'getSetting'])->middleware('adminPermission:payment_settings.view');
    Route::post('payment_settings', [PaymentSettingController::class, 'updateSetting'])->middleware('adminPermission:payment_settings.edit');

    Route::get('service_settings', [ServiceSettingController::class, 'getSetting'])->middleware('adminPermission:service_settings.view');
    Route::post('service_settings', [ServiceSettingController::class, 'updateSetting'])->middleware('adminPermission:service_settings.edit');

    Route::get('tax_settings', [TaxSettingController::class, 'getSetting'])->middleware('adminPermission:tax_settings.view');
    Route::post('tax_settings', [TaxSettingController::class, 'updateSetting'])->middleware('adminPermission:tax_settings.edit');

    Route::post('/logout', [AuthController::class, 'logout']);

});
