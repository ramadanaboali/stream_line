<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\General\CountryController;
use App\Http\Controllers\Api\V1\General\RegionController;
use App\Http\Controllers\Api\V1\General\CityController;
use App\Http\Controllers\Api\V1\General\CategoryController;
use App\Http\Controllers\Api\V1\General\ServiceCategoryController;
use App\Http\Controllers\Api\V1\General\ClientCancellationReasonController;
use App\Http\Controllers\Api\V1\General\CancellationReasonController;
use App\Http\Controllers\Api\V1\General\WalletController;
use App\Http\Controllers\Api\V1\General\WalletTransactionController;
use App\Http\Controllers\Api\V1\General\PromoCodeController;
use App\Http\Controllers\Api\V1\General\ReviewController;
use App\Http\Controllers\Api\V1\General\ReviewReportController;
use App\Http\Controllers\Api\V1\Admin\LanguageSettingController;
use App\Http\Controllers\Api\V1\Admin\PrivacyPolicyController;
use App\Http\Controllers\Api\V1\Admin\TermConditionController;

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
    Route::get('cancellation_reasons', [CancellationReasonController::class, 'index']);
    Route::get('reviews', [ReviewController::class, 'index']);

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

        Route::post('cancellation_reasons', [CancellationReasonController::class, 'store'])->middleware('adminPermission:cancellation_reasons.create');
        Route::get('cancellation_reasons/{cancellation_reason}', [CancellationReasonController::class, 'show'])->middleware('adminPermission:cancellation_reasons.view');
        Route::put('cancellation_reasons/{cancellation_reason}', [CancellationReasonController::class, 'update'])->middleware('adminPermission:cancellation_reasons.edit');
        Route::delete('cancellation_reasons/{cancellation_reason}', [CancellationReasonController::class, 'delete'])->middleware('adminPermission:cancellation_reasons.delete');

        Route::get('wallets', [WalletController::class, 'index'])->middleware('adminPermission:wallets.view');
        Route::post('wallets', [WalletController::class, 'store'])->middleware('adminPermission:wallets.create');
        Route::get('wallets/{wallet}', [WalletController::class, 'show'])->middleware('adminPermission:wallets.view');
        Route::put('wallets/{wallet}', [WalletController::class, 'update'])->middleware('adminPermission:wallets.edit');
        Route::delete('wallets/{wallet}', [WalletController::class, 'delete'])->middleware('adminPermission:wallets.delete');

        Route::get('wallet_transactions', [WalletTransactionController::class, 'index'])->middleware('adminPermission:wallet_transactions.view');
        Route::post('wallet_transactions', [WalletTransactionController::class, 'store'])->middleware('adminPermission:wallet_transactions.create');
        Route::get('wallet_transactions/{wallet_transaction}', [WalletTransactionController::class, 'show'])->middleware('adminPermission:wallet_transactions.view');
        Route::put('wallet_transactions/{wallet_transaction}', [WalletTransactionController::class, 'update'])->middleware('adminPermission:wallet_transactions.edit');
        Route::delete('wallet_transactions/{wallet_transaction}', [WalletTransactionController::class, 'delete'])->middleware('adminPermission:wallet_transactions.delete');

        Route::get('promo_codes', [PromoCodeController::class, 'index'])->middleware('adminPermission:promo_codes.view');
        Route::post('promo_codes', [PromoCodeController::class, 'store'])->middleware('adminPermission:promo_codes.create');
        Route::get('promo_codes/{promo_code}', [PromoCodeController::class, 'show'])->middleware('adminPermission:promo_codes.view');
        Route::put('promo_codes/{promo_code}', [PromoCodeController::class, 'update'])->middleware('adminPermission:promo_codes.edit');
        Route::delete('promo_codes/{promo_code}', [PromoCodeController::class, 'delete'])->middleware('adminPermission:promo_codes.delete');

        Route::post('reviews', [ReviewController::class, 'store'])->middleware('adminPermission:reviews.create');
        Route::get('reviews/{review}', [ReviewController::class, 'show'])->middleware('adminPermission:reviews.view');
        Route::put('reviews/{review}', [ReviewController::class, 'update'])->middleware('adminPermission:reviews.edit');
        Route::delete('reviews/{review}', [ReviewController::class, 'delete'])->middleware('adminPermission:reviews.delete');

        Route::get('review_reports', [ReviewReportController::class, 'index'])->middleware('adminPermission:review_reports.view');
        Route::post('review_reports', [ReviewReportController::class, 'store'])->middleware('adminPermission:review_reports.create');
        Route::get('review_reports/{review_report}', [ReviewReportController::class, 'show'])->middleware('adminPermission:review_reports.view');
        Route::put('review_reports/{review_report}', [ReviewReportController::class, 'update'])->middleware('adminPermission:review_reports.edit');
        Route::delete('review_reports/{review_report}', [ReviewReportController::class, 'delete'])->middleware('adminPermission:review_reports.delete');


    Route::get('language_settings', [LanguageSettingController::class, 'getSetting'])->middleware('adminPermission:language_settings.view');
    Route::post('language_settings', [LanguageSettingController::class, 'updateSetting'])->middleware('adminPermission:language_settings.edit');

    Route::get('privacy_policies', [PrivacyPolicyController::class, 'getSetting'])->middleware('adminPermission:privacy_policies.view');
    Route::post('privacy_policies', [PrivacyPolicyController::class, 'updateSetting'])->middleware('adminPermission:privacy_policies.edit');

    Route::get('term_conditions', [TermConditionController::class, 'getSetting'])->middleware('adminPermission:term_conditions.view');
    Route::post('term_conditions', [TermConditionController::class, 'updateSetting'])->middleware('adminPermission:term_conditions.edit');

});
