<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Admin\AuthController;
use App\Http\Controllers\Api\V1\Admin\RoleController;
use App\Http\Controllers\Api\V1\Admin\PackageController;
use App\Http\Controllers\Api\V1\Admin\PaymentSettingController;
use App\Http\Controllers\Api\V1\Admin\ServiceSettingController;
use App\Http\Controllers\Api\V1\Admin\TaxSettingController;
use App\Http\Controllers\Api\V1\Admin\NotificationSettingController;
use App\Http\Controllers\Api\V1\Admin\SystemNotificationController;
use App\Http\Controllers\Api\V1\Admin\HelpCenterController;
use App\Http\Controllers\Api\V1\Admin\FAQController;
use App\Http\Controllers\Api\V1\Admin\ContactMessageController;
use App\Http\Controllers\Api\V1\Admin\BannerController;
use App\Http\Controllers\Api\V1\Admin\UserController;
use App\Http\Controllers\Api\V1\Admin\VendorController;
use App\Http\Controllers\Api\V1\Admin\HomeController;
Route::group(['prefix' => '/v1'], function () {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/reset', [AuthController::class, 'resetPassword']);
    Route::post('/check-code', [AuthController::class, 'checkCode']);
    Route::post('/confirm-reset', [AuthController::class, 'confirmReset']);

    Route::get('packages', [PackageController::class, 'index']);
    Route::get('help_centers', [HelpCenterController::class, 'index']);
    Route::get('f_a_q_s', [FAQController::class, 'index']);
    Route::get('banners', [BannerController::class, 'index']);

    Route::post('contact_messages', [ContactMessageController::class, 'store']);
    Route::get('vendors', [VendorController::class, 'index']);

});

Route::group(['prefix' => '/v1','middleware' => ['auth:api']], function () {

    Route::get('permissions', [RoleController::class, 'permissions']);
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


    Route::get('users', [UserController::class, 'index'])->middleware('adminPermission:users.view');
    Route::post('users', [UserController::class, 'store'])->middleware('adminPermission:users.create');
    Route::get('users/{user}', [UserController::class, 'show'])->middleware('adminPermission:users.view');
    Route::put('users/{user}', [UserController::class, 'update'])->middleware('adminPermission:users.edit');
    Route::delete('users/{user}', [UserController::class, 'delete'])->middleware('adminPermission:users.delete');

    Route::post('vendors', [VendorController::class, 'store'])->middleware('adminPermission:vendors.create');
    Route::get('vendors/{vendor}', [VendorController::class, 'show'])->middleware('adminPermission:vendors.view');
    Route::put('vendors/{vendor}', [VendorController::class, 'update'])->middleware('adminPermission:vendors.edit');
    Route::delete('vendors/{vendor}', [VendorController::class, 'delete'])->middleware('adminPermission:vendors.delete');



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

    Route::get('notification_settings', [NotificationSettingController::class, 'getSetting'])->middleware('adminPermission:notification_settings.view');
    Route::post('notification_settings', [NotificationSettingController::class, 'updateSetting'])->middleware('adminPermission:notification_settings.edit');

    Route::get('system_notifications', [SystemNotificationController::class, 'index'])->middleware('adminPermission:system_notifications.view');
    Route::post('system_notifications', [SystemNotificationController::class, 'store'])->middleware('adminPermission:system_notifications.create');
    Route::get('system_notifications/{system_notification}', [SystemNotificationController::class, 'show'])->middleware('adminPermission:system_notifications.view');
    Route::put('system_notifications/{system_notification}', [SystemNotificationController::class, 'update'])->middleware('adminPermission:system_notifications.edit');
    Route::delete('system_notifications/{system_notification}', [SystemNotificationController::class, 'delete'])->middleware('adminPermission:system_notifications.delete');

    Route::post('help_centers', [HelpCenterController::class, 'store'])->middleware('adminPermission:help_centers.create');
    Route::get('help_centers/{help_center}', [HelpCenterController::class, 'show'])->middleware('adminPermission:help_centers.view');
    Route::put('help_centers/{help_center}', [HelpCenterController::class, 'update'])->middleware('adminPermission:help_centers.edit');
    Route::delete('help_centers/{help_center}', [HelpCenterController::class, 'delete'])->middleware('adminPermission:help_centers.delete');

    Route::post('f_a_q_s', [FAQController::class, 'store'])->middleware('adminPermission:f_a_q_s.create');
    Route::get('f_a_q_s/{f_a_q}', [FAQController::class, 'show'])->middleware('adminPermission:f_a_q_s.view');
    Route::put('f_a_q_s/{f_a_q}', [FAQController::class, 'update'])->middleware('adminPermission:f_a_q_s.edit');
    Route::delete('f_a_q_s/{f_a_q}', [FAQController::class, 'delete'])->middleware('adminPermission:f_a_q_s.delete');


    Route::get('contact_messages', [ContactMessageController::class, 'index']);
    Route::get('contact_messages/{contact_message}', [ContactMessageController::class, 'show'])->middleware('adminPermission:contact_messages.view');
    Route::put('contact_messages/{contact_message}', [ContactMessageController::class, 'update'])->middleware('adminPermission:contact_messages.edit');
    Route::delete('contact_messages/{contact_message}', [ContactMessageController::class, 'delete'])->middleware('adminPermission:contact_messages.delete');

    Route::post('banners', [BannerController::class, 'store'])->middleware('adminPermission:banners.create');
    Route::get('banners/{banner}', [BannerController::class, 'show'])->middleware('adminPermission:banners.view');
    Route::put('banners/{banner}', [BannerController::class, 'update'])->middleware('adminPermission:banners.edit');
    Route::delete('banners/{banner}', [BannerController::class, 'delete'])->middleware('adminPermission:banners.delete');


    Route::get('vendor_report_list', [VendorController::class, 'vendor_report_list'])->middleware('adminPermission:vendor_report.view');
    Route::get('vendor_report_show/{vendor}', [VendorController::class, 'vendor_report_show'])->middleware('adminPermission:vendor_report.view');

    Route::get('customer_report_list', [VendorController::class, 'customer_report_list'])->middleware('adminPermission:customer_report.view');
    Route::get('customer_report_show/{customer}', [VendorController::class, 'customer_report_show'])->middleware('adminPermission:customer_report.view');

    Route::get('subscription_report_list', [VendorController::class, 'subscription_report_list'])->middleware('adminPermission:subscription_report.view');
    Route::get('subscription_report_show/{subscription}', [VendorController::class, 'subscription_report_show'])->middleware('adminPermission:subscription_report.view');

    Route::get('service_report_list', [VendorController::class, 'service_report_list'])->middleware('adminPermission:service_report.view');
    Route::get('service_report_show/{service}', [VendorController::class, 'service_report_show'])->middleware('adminPermission:service_report.view');

    Route::get('offer_report_list', [VendorController::class, 'offer_report_list'])->middleware('adminPermission:offer_report.view');
    Route::get('offer_report_show/{offer}', [VendorController::class, 'offer_report_show'])->middleware('adminPermission:offer_report.view');

    Route::get('booking_report_list', [VendorController::class, 'booking_report_list'])->middleware('adminPermission:booking_report.view');
    Route::get('booking_report_show/{booking}', [VendorController::class, 'booking_report_show'])->middleware('adminPermission:booking_report.view');
    Route::post('booking_customer_invoice', [VendorController::class, 'booking_customer_invoice'])->middleware('adminPermission:booking_report.view');
    Route::post('booking_vendor_invoice', [VendorController::class, 'booking_vendor_invoice'])->middleware('adminPermission:booking_report.view');

    Route::get('home_totals', [HomeController::class, 'home_totals'])->middleware('adminPermission:home.view');
    Route::get('booking_count_chart', [HomeController::class, 'booking_count_chart'])->middleware('adminPermission:home.view');
    Route::get('booking_total_chart', [HomeController::class, 'booking_total_chart'])->middleware('adminPermission:home.view');

    Route::get('booking_count_with_month_chart', [HomeController::class, 'booking_count_with_month_chart'])->middleware('adminPermission:statistics.view');
    Route::get('register_count_with_month_chart', [HomeController::class, 'register_count_with_month_chart'])->middleware('adminPermission:statistics.view');
    Route::get('booking_count_last_week_chart', [HomeController::class, 'booking_count_last_week_chart'])->middleware('adminPermission:statistics.view');
    Route::get('last_bookings', [HomeController::class, 'last_bookings'])->middleware('adminPermission:statistics.view');
    Route::get('last_customers', [HomeController::class, 'last_customers'])->middleware('adminPermission:statistics.view');

    Route::post('/logout', [AuthController::class, 'logout']);

});
