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
use App\Http\Controllers\Api\V1\General\UserNotificationSettingController;
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


        Route::post('countries', [CountryController::class, 'store'])->middleware('generalPermission:countries.create');
        Route::get('countries/{country}', [CountryController::class, 'show'])->middleware('generalPermission:countries.view');
        Route::put('countries/{country}', [CountryController::class, 'update'])->middleware('generalPermission:countries.edit');
        Route::delete('countries/{country}', [CountryController::class, 'delete'])->middleware('generalPermission:countries.delete');

        Route::post('regions', [RegionController::class, 'store'])->middleware('generalPermission:regions.create');
        Route::get('regions/{region}', [RegionController::class, 'show'])->middleware('generalPermission:regions.view');
        Route::put('regions/{region}', [RegionController::class, 'update'])->middleware('generalPermission:regions.edit');
        Route::delete('regions/{region}', [RegionController::class, 'delete'])->middleware('generalPermission:regions.delete');

        Route::post('cities', [CityController::class, 'store'])->middleware('generalPermission:cities.create');
        Route::get('cities/{city}', [CityController::class, 'show'])->middleware('generalPermission:cities.view');
        Route::put('cities/{city}', [CityController::class, 'update'])->middleware('generalPermission:cities.edit');
        Route::delete('cities/{city}', [CityController::class, 'delete'])->middleware('generalPermission:cities.delete');

        Route::post('categories', [CategoryController::class, 'store'])->middleware('generalPermission:categories.create');
        Route::get('categories/{category}', [CategoryController::class, 'show'])->middleware('generalPermission:categories.view');
        Route::put('categories/{category}', [CategoryController::class, 'update'])->middleware('generalPermission:categories.edit');
        Route::delete('categories/{category}', [CategoryController::class, 'delete'])->middleware('generalPermission:categories.delete');

        Route::post('service_categories', [ServiceCategoryController::class, 'store'])->middleware('generalPermission:service_categories.create');
        Route::get('service_categories/{service_category}', [ServiceCategoryController::class, 'show'])->middleware('generalPermission:service_categories.view');
        Route::put('service_categories/{service_category}', [ServiceCategoryController::class, 'update'])->middleware('generalPermission:service_categories.edit');
        Route::delete('service_categories/{service_category}', [ServiceCategoryController::class, 'delete'])->middleware('generalPermission:service_categories.delete');

        Route::post('client_cancellation_reasons', [ClientCancellationReasonController::class, 'store'])->middleware('generalPermission:client_cancellation_reasons.create');
        Route::get('client_cancellation_reasons/{client_cancellation_reason}', [ClientCancellationReasonController::class, 'show'])->middleware('generalPermission:client_cancellation_reasons.view');
        Route::put('client_cancellation_reasons/{client_cancellation_reason}', [ClientCancellationReasonController::class, 'update'])->middleware('generalPermission:client_cancellation_reasons.edit');
        Route::delete('client_cancellation_reasons/{client_cancellation_reason}', [ClientCancellationReasonController::class, 'delete'])->middleware('generalPermission:client_cancellation_reasons.delete');

        Route::post('cancellation_reasons', [CancellationReasonController::class, 'store'])->middleware('generalPermission:cancellation_reasons.create');
        Route::get('cancellation_reasons/{cancellation_reason}', [CancellationReasonController::class, 'show'])->middleware('generalPermission:cancellation_reasons.view');
        Route::put('cancellation_reasons/{cancellation_reason}', [CancellationReasonController::class, 'update'])->middleware('generalPermission:cancellation_reasons.edit');
        Route::delete('cancellation_reasons/{cancellation_reason}', [CancellationReasonController::class, 'delete'])->middleware('generalPermission:cancellation_reasons.delete');

        Route::get('wallets', [WalletController::class, 'index'])->middleware('generalPermission:wallets.view');
        Route::post('wallets', [WalletController::class, 'store'])->middleware('generalPermission:wallets.create');
        Route::get('wallets/{wallet}', [WalletController::class, 'show'])->middleware('generalPermission:wallets.view');
        Route::put('wallets/{wallet}', [WalletController::class, 'update'])->middleware('generalPermission:wallets.edit');
        Route::delete('wallets/{wallet}', [WalletController::class, 'delete'])->middleware('generalPermission:wallets.delete');

        Route::get('wallet_transactions', [WalletTransactionController::class, 'index'])->middleware('generalPermission:wallet_transactions.view');
        Route::post('wallet_transactions', [WalletTransactionController::class, 'store'])->middleware('generalPermission:wallet_transactions.create');
        Route::get('wallet_transactions/{wallet_transaction}', [WalletTransactionController::class, 'show'])->middleware('generalPermission:wallet_transactions.view');
        Route::put('wallet_transactions/{wallet_transaction}', [WalletTransactionController::class, 'update'])->middleware('generalPermission:wallet_transactions.edit');
        Route::delete('wallet_transactions/{wallet_transaction}', [WalletTransactionController::class, 'delete'])->middleware('generalPermission:wallet_transactions.delete');

        Route::get('promo_codes', [PromoCodeController::class, 'index'])->middleware('generalPermission:promo_codes.view');
        Route::post('promo_codes', [PromoCodeController::class, 'store'])->middleware('generalPermission:promo_codes.create');
        Route::get('promo_codes/{promo_code}', [PromoCodeController::class, 'show'])->middleware('generalPermission:promo_codes.view');
        Route::put('promo_codes/{promo_code}', [PromoCodeController::class, 'update'])->middleware('generalPermission:promo_codes.edit');
        Route::delete('promo_codes/{promo_code}', [PromoCodeController::class, 'delete'])->middleware('generalPermission:promo_codes.delete');

        Route::post('reviews', [ReviewController::class, 'store'])->middleware('generalPermission:reviews.create');
        Route::get('reviews/{review}', [ReviewController::class, 'show'])->middleware('generalPermission:reviews.view');
        Route::put('reviews/{review}', [ReviewController::class, 'update'])->middleware('generalPermission:reviews.edit');
        Route::delete('reviews/{review}', [ReviewController::class, 'delete'])->middleware('generalPermission:reviews.delete');

        Route::get('review_reports', [ReviewReportController::class, 'index'])->middleware('generalPermission:review_reports.view');
        Route::post('review_reports', [ReviewReportController::class, 'store'])->middleware('generalPermission:review_reports.create');
        Route::get('review_reports/{review_report}', [ReviewReportController::class, 'show'])->middleware('generalPermission:review_reports.view');
        Route::put('review_reports/{review_report}', [ReviewReportController::class, 'update'])->middleware('generalPermission:review_reports.edit');
        Route::delete('review_reports/{review_report}', [ReviewReportController::class, 'delete'])->middleware('generalPermission:review_reports.delete');


    Route::get('language_settings', [LanguageSettingController::class, 'getSetting'])->middleware('generalPermission:language_settings.view');
    Route::post('language_settings', [LanguageSettingController::class, 'updateSetting'])->middleware('generalPermission:language_settings.edit');

    Route::get('privacy_policies', [PrivacyPolicyController::class, 'getSetting'])->middleware('generalPermission:privacy_policies.view');
    Route::post('privacy_policies', [PrivacyPolicyController::class, 'updateSetting'])->middleware('generalPermission:privacy_policies.edit');

    Route::get('term_conditions', [TermConditionController::class, 'getSetting'])->middleware('generalPermission:term_conditions.view');
    Route::post('term_conditions', [TermConditionController::class, 'updateSetting'])->middleware('generalPermission:term_conditions.edit');

    Route::get('user_notification_settings', [UserNotificationSettingController::class, 'getSetting']);
    Route::post('user_notification_settings', [UserNotificationSettingController::class, 'updateSetting']);
});
