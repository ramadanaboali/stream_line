<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\General\CountryController;
use App\Http\Controllers\Api\V1\General\RegionController;
use App\Http\Controllers\Api\V1\General\CityController;
use App\Http\Controllers\Api\V1\General\CategoryController;
use App\Http\Controllers\Api\V1\General\ServiceCategoryController;
use App\Http\Controllers\Api\V1\General\ClientCancellationReasonController;

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
    Route::get('countries', [CountryController::class, 'index']);
    Route::get('regions', [RegionController::class, 'index']);
    Route::get('cities', [CityController::class, 'index']);
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('service_categories', [ServiceCategoryController::class, 'index']);
    Route::get('client_cancellation_reasons', [ClientCancellationReasonController::class, 'index']);

});

Route::group(['prefix' => '/v1','middleware' => ['auth:api']], function() {


        Route::post('countries', [CountryController::class, 'store'])->middleware('adminPermission:countries.create');
        Route::get('countries/{country}', [CountryController::class, 'show'])->middleware('adminPermission:countries.view');
        Route::put('countries/{country}', [CountryController::class, 'update'])->middleware('adminPermission:countries.edit');
        Route::delete('countries/{country}', [CountryController::class, 'delete'])->middleware('adminPermission:countries.delete');

        Route::post('regions', [RegionController::class, 'store'])->middleware('adminPermission:regions.create');
        Route::get('regions/{region}', [RegionController::class, 'show'])->middleware('adminPermission:regions.view');
        Route::put('regions/{region}', [RegionController::class, 'update'])->middleware('adminPermission:regions.edit');
        Route::delete('regions/{region}', [RegionController::class, 'delete'])->middleware('adminPermission:regions.delete');

        Route::post('cities', [CityController::class, 'store'])->middleware('adminPermission:cities.create');
        Route::get('cities/{city}', [CityController::class, 'show'])->middleware('adminPermission:cities.view');
        Route::put('cities/{city}', [CityController::class, 'update'])->middleware('adminPermission:cities.edit');
        Route::delete('cities/{city}', [CityController::class, 'delete'])->middleware('adminPermission:cities.delete');

        Route::post('categories', [CategoryController::class, 'store'])->middleware('adminPermission:categories.create');
        Route::get('categories/{category}', [CategoryController::class, 'show'])->middleware('adminPermission:categories.view');
        Route::put('categories/{category}', [CategoryController::class, 'update'])->middleware('adminPermission:categories.edit');
        Route::delete('categories/{category}', [CategoryController::class, 'delete'])->middleware('adminPermission:categories.delete');

        Route::post('service_categories', [ServiceCategoryController::class, 'store'])->middleware('adminPermission:service_categories.create');
        Route::get('service_categories/{service_category}', [ServiceCategoryController::class, 'show'])->middleware('adminPermission:service_categories.view');
        Route::put('service_categories/{service_category}', [ServiceCategoryController::class, 'update'])->middleware('adminPermission:service_categories.edit');
        Route::delete('service_categories/{service_category}', [ServiceCategoryController::class, 'delete'])->middleware('adminPermission:service_categories.delete');

        Route::post('client_cancellation_reasons', [ClientCancellationReasonController::class, 'store'])->middleware('adminPermission:client_cancellation_reasons.create');
        Route::get('client_cancellation_reasons/{client_cancellation_reason}', [ClientCancellationReasonController::class, 'show'])->middleware('adminPermission:client_cancellation_reasons.view');
        Route::put('client_cancellation_reasons/{client_cancellation_reason}', [ClientCancellationReasonController::class, 'update'])->middleware('adminPermission:client_cancellation_reasons.edit');
        Route::delete('client_cancellation_reasons/{client_cancellation_reason}', [ClientCancellationReasonController::class, 'delete'])->middleware('adminPermission:client_cancellation_reasons.delete');
});
