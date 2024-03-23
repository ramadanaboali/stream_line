<?php

use App\Http\Controllers\Api\V1\Vendor\AuthController;
use App\Http\Controllers\Api\V1\Vendor\UserController;
use App\Http\Controllers\Api\V1\Vendor\BranchController;
use App\Http\Controllers\Api\V1\Vendor\SectionController;
use App\Http\Controllers\Api\V1\Vendor\EmployeeController;
use App\Http\Controllers\Api\V1\Vendor\ServiceController;
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
    Route::get('sections/{section}', [SectionController::class, 'show'])->middleware('vendorPermission:sections.view');
    Route::put('sections/{section}', [SectionController::class, 'update'])->middleware('vendorPermission:sections.edit');
    Route::delete('sections/{section}', [SectionController::class, 'delete'])->middleware('vendorPermission:sections.delete');

    Route::get('services', [ServiceController::class, 'index'])->middleware('vendorPermission:services.view');
    Route::post('services', [ServiceController::class, 'store'])->middleware('vendorPermission:services.create');
    Route::get('services/{service}', [ServiceController::class, 'show'])->middleware('vendorPermission:services.view');
    Route::put('services/{service}', [ServiceController::class, 'update'])->middleware('vendorPermission:services.edit');
    Route::delete('services/{service}', [ServiceController::class, 'delete'])->middleware('vendorPermission:services.delete');

    Route::get('employees', [EmployeeController::class, 'index'])->middleware('vendorPermission:employees.view');
    Route::post('employees', [EmployeeController::class, 'store'])->middleware('vendorPermission:employees.create');
    Route::get('employees/{employee}', [EmployeeController::class, 'show'])->middleware('vendorPermission:employees.view');
    Route::put('employees/{employee}', [EmployeeController::class, 'update'])->middleware('vendorPermission:employees.edit');
    Route::delete('employees/{employee}', [EmployeeController::class, 'delete'])->middleware('vendorPermission:employees.delete');

    Route::post('/update-profile', [AuthController::class, 'updateProfile']);
    Route::post('/send-code', [AuthController::class, 'sendCode']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::post('/update-email', [AuthController::class, 'updateEmail']);
    Route::post('/update-phone', [AuthController::class, 'updatePhone']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

});
