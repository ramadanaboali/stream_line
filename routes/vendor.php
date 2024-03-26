<?php

use App\Http\Controllers\Api\V1\Vendor\AuthController;
use App\Http\Controllers\Api\V1\Vendor\UserController;
use App\Http\Controllers\Api\V1\Vendor\BranchController;
use App\Http\Controllers\Api\V1\Vendor\SectionController;
use App\Http\Controllers\Api\V1\Vendor\SubscriptionController;
use App\Http\Controllers\Api\V1\Vendor\EmployeeController;
use App\Http\Controllers\Api\V1\Vendor\BookingController;
use App\Http\Controllers\Api\V1\Vendor\OfferController;
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

    Route::get('bookings', [BookingController::class, 'index'])->middleware('vendorPermission:bookings.view');
    Route::post('bookings', [BookingController::class, 'store'])->middleware('vendorPermission:bookings.create');
    Route::get('bookings/{booking}', [BookingController::class, 'show'])->middleware('vendorPermission:bookings.view');
    Route::put('bookings/{booking}', [BookingController::class, 'update'])->middleware('vendorPermission:bookings.edit');
    Route::delete('bookings/{booking}', [BookingController::class, 'delete'])->middleware('vendorPermission:bookings.delete');

    Route::get('offers', [OfferController::class, 'index'])->middleware('vendorPermission:offers.view');
    Route::post('offers', [OfferController::class, 'store'])->middleware('vendorPermission:offers.create');
    Route::get('offers/{offer}', [OfferController::class, 'show'])->middleware('vendorPermission:offers.view');
    Route::put('offers/{offer}', [OfferController::class, 'update'])->middleware('vendorPermission:offers.edit');
    Route::delete('offers/{offer}', [OfferController::class, 'delete'])->middleware('vendorPermission:offers.delete');

    Route::get('services', [ServiceController::class, 'index'])->middleware('vendorPermission:services.view');
    Route::post('services', [ServiceController::class, 'store'])->middleware('vendorPermission:services.create');
    Route::get('services/{service}', [ServiceController::class, 'show'])->middleware('vendorPermission:services.view');
    Route::put('services/{service}', [ServiceController::class, 'update'])->middleware('vendorPermission:services.edit');
    Route::delete('services/{service}', [ServiceController::class, 'delete'])->middleware('vendorPermission:services.delete');

    Route::get('employees', [EmployeeController::class, 'index'])->middleware('vendorPermission:employees.view');
    Route::post('employees', [EmployeeController::class, 'store'])->middleware('vendorPermission:employees.create');
    Route::post('employees/employee-service', [EmployeeController::class, 'employeeService'])->middleware('vendorPermission:employees.create');
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


    Route::get('subscriptions', [SubscriptionController::class, 'index'])->middleware('vendorPermission:subscriptions.view');
    Route::post('subscriptions', [SubscriptionController::class, 'store'])->middleware('vendorPermission:subscriptions.create');
    Route::get('subscriptions/{subscription}', [SubscriptionController::class, 'show'])->middleware('vendorPermission:subscriptions.view');
    Route::put('subscriptions/{subscription}', [SubscriptionController::class, 'update'])->middleware('vendorPermission:subscriptions.edit');
    Route::post('subscriptions/pay', [SubscriptionController::class, 'pay'])->middleware('vendorPermission:subscriptions.pay');


});
