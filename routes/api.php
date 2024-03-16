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


Route::group(['prefix' => '/v1','middleware' => ['auth:api']], function() {


        Route::get('countries', [CountryController::class, 'index']);
        Route::post('countries', [CountryController::class, 'store']);
        Route::get('countries/{country}', [CountryController::class, 'show']);
        Route::put('countries/{country}', [CountryController::class, 'update']);
        Route::delete('countries/{country}', [CountryController::class, 'delete']);

        Route::get('regions', [RegionController::class, 'index']);
        Route::post('regions', [RegionController::class, 'store']);
        Route::get('regions/{region}', [RegionController::class, 'show']);
        Route::put('regions/{region}', [RegionController::class, 'update']);
        Route::delete('regions/{region}', [RegionController::class, 'delete']);

        Route::get('cities', [CityController::class, 'index']);
        Route::post('cities', [CityController::class, 'store']);
        Route::get('cities/{city}', [CityController::class, 'show']);
        Route::put('cities/{city}', [CityController::class, 'update']);
        Route::delete('cities/{city}', [CityController::class, 'delete']);

        Route::get('categories', [CategoryController::class, 'index']);
        Route::post('categories', [CategoryController::class, 'store']);
        Route::get('categories/{category}', [CategoryController::class, 'show']);
        Route::put('categories/{category}', [CategoryController::class, 'update']);
        Route::delete('categories/{category}', [CategoryController::class, 'delete']);

        Route::get('service_categories', [ServiceCategoryController::class, 'index']);
        Route::post('service_categories', [ServiceCategoryController::class, 'store']);
        Route::get('service_categories/{service_category}', [ServiceCategoryController::class, 'show']);
        Route::put('service_categories/{service_category}', [ServiceCategoryController::class, 'update']);
        Route::delete('service_categories/{service_category}', [ServiceCategoryController::class, 'delete']);

        Route::get('client_cancellation_reasons', [ClientCancellationReasonController::class, 'index']);
        Route::post('client_cancellation_reasons', [ClientCancellationReasonController::class, 'store']);
        Route::get('client_cancellation_reasons/{client_cancellation_reason}', [ClientCancellationReasonController::class, 'show']);
        Route::put('client_cancellation_reasons/{client_cancellation_reason}', [ClientCancellationReasonController::class, 'update']);
        Route::delete('client_cancellation_reasons/{client_cancellation_reason}', [ClientCancellationReasonController::class, 'delete']);
});
