<?php

use App\Http\Controllers\Api\V1\Vendor\AuthController;
use App\Http\Controllers\Api\V1\Vendor\HomeController;
use App\Http\Controllers\Api\V1\Vendor\UserController;
use App\Http\Controllers\Api\V1\Vendor\BranchController;
use App\Http\Controllers\Api\V1\Vendor\SectionController;
use App\Http\Controllers\Api\V1\Vendor\SubscriptionController;
use App\Http\Controllers\Api\V1\Vendor\EmployeeController;
use App\Http\Controllers\Api\V1\Vendor\BookingController;
use App\Http\Controllers\Api\V1\Vendor\OfferController;
use App\Http\Controllers\Api\V1\Vendor\ServiceController;
use App\Http\Controllers\Api\V1\Vendor\TaxInvoiceController;
use App\Http\Controllers\Api\V1\Vendor\VendorSettingController;
use App\Http\Controllers\Api\V1\Vendor\RoleController;
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

    Route::post('errorSubscribe', [HomeController::class, 'errorSubscribe'])->name('errorSubscribe');
    Route::post('successSubscribe', [HomeController::class, 'successSubscribe'])->name('successSubscribe');

});

Route::group(['prefix' => '/v1','middleware' => ['auth:api']], function () {


        Route::get('permissions', [RoleController::class, 'permissions']);
        Route::get('roles', [RoleController::class, 'index'])->middleware('vendorPermission:roles.view');
        Route::post('roles', [RoleController::class, 'store'])->middleware('vendorPermission:roles.create');
        Route::get('roles/{role}', [RoleController::class, 'show'])->middleware('vendorPermission:roles.view');
        Route::put('roles/{role}', [RoleController::class, 'update'])->middleware('vendorPermission:roles.edit');
        Route::delete('roles/{role}', [RoleController::class, 'delete'])->middleware('vendorPermission:roles.delete');


    Route::get('users', [UserController::class, 'index'])->middleware('vendorPermission:users.view');
    Route::post('users', [UserController::class, 'store'])->middleware('vendorPermission:users.create');
    Route::get('users/{user}', [UserController::class, 'show'])->middleware('vendorPermission:users.view');
    Route::put('users/{user}', [UserController::class, 'update'])->middleware('vendorPermission:users.edit');
    Route::delete('users/{user}', [UserController::class, 'delete'])->middleware('vendorPermission:users.delete');

    Route::get('branches', [BranchController::class, 'index'])->middleware('vendorPermission:branches.view');
    Route::post('branches', [BranchController::class, 'store'])->middleware(['vendorPermission:branches.create','checkSubscription:branches']);
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
    Route::post('booking_customer_invoice', [BookingController::class, 'booking_customer_invoice'])->middleware('vendorPermission:vendor_booking_report.view');
    Route::post('booking_vendor_invoice', [BookingController::class, 'booking_vendor_invoice'])->middleware('vendorPermission:vendor_booking_report.view');
//    Route::post('bookings/pay', [BookingController::class, 'pay']);
    Route::get('bookings/cancel/{id}', [BookingController::class, 'cancel']);

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
    Route::post('employees', [EmployeeController::class, 'store'])->middleware(['vendorPermission:employees.create','checkSubscription:employees']);
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
    Route::post('subscriptions/check_is_paid', [SubscriptionController::class, 'check_is_paid'])->middleware('vendorPermission:subscriptions.pay');

    Route::get('tax_invoices', [TaxInvoiceController::class, 'index'])->middleware('vendorPermission:tax_invoices.view');
    Route::post('tax_invoices', [TaxInvoiceController::class, 'store'])->middleware('vendorPermission:tax_invoices.create');
    Route::get('tax_invoices/{tax_invoice}', [TaxInvoiceController::class, 'show'])->middleware('vendorPermission:tax_invoices.view');
    Route::put('tax_invoices/{tax_invoice}', [TaxInvoiceController::class, 'update'])->middleware('vendorPermission:tax_invoices.edit');
    Route::delete('tax_invoices/{tax_invoice}', [TaxInvoiceController::class, 'delete'])->middleware('vendorPermission:tax_invoices.delete');

    Route::get('vendor_settings', [VendorSettingController::class, 'getSetting'])->middleware('vendorPermission:vendor_settings.view');
    Route::post('vendor_settings', [VendorSettingController::class, 'updateSetting'])->middleware('vendorPermission:vendor_settings.edit');


    Route::get('customer_report_list', [HomeController::class, 'customer_report_list'])->middleware('vendorPermission:vendor_customer_report.view');
    Route::get('customer_report_show/{customer}', [HomeController::class, 'customer_report_show'])->middleware('vendorPermission:vendor_customer_report.view');

    Route::get('service_report_list', [HomeController::class, 'service_report_list'])->middleware('vendorPermission:vendor_service_report.view');
    Route::get('service_report_show/{service}', [HomeController::class, 'service_report_show'])->middleware('vendorPermission:vendor_service_report.view');

    Route::get('offer_report_list', [HomeController::class, 'offer_report_list'])->middleware('vendorPermission:vendor_offer_report.view');
    Route::get('offer_report_show/{offer}', [HomeController::class, 'offer_report_show'])->middleware('vendorPermission:vendor_offer_report.view');

    Route::get('booking_report_list', [HomeController::class, 'booking_report_list'])->middleware('vendorPermission:vendor_booking_report.view');
    Route::get('booking_report_show/{booking}', [HomeController::class, 'booking_report_show'])->middleware('vendorPermission:vendor_booking_report.view');
    Route::post('booking_customer_invoice', [HomeController::class, 'booking_customer_invoice'])->middleware('vendorPermission:vendor_booking_report.view');
    Route::post('booking_vendor_invoice', [HomeController::class, 'booking_vendor_invoice'])->middleware('vendorPermission:vendor_booking_report.view');

    Route::get('home_totals', [HomeController::class, 'home_totals'])->middleware('vendorPermission:vendor_home.view');
    Route::get('booking_count_chart', [HomeController::class, 'booking_count_chart'])->middleware('vendorPermission:vendor_home.view');
    Route::get('booking_total_chart', [HomeController::class, 'booking_total_chart'])->middleware('vendorPermission:vendor_home.view');
    Route::get('pos_totals', [HomeController::class, 'pos_totals'])->middleware('vendorPermission:vendor_home.view');

    Route::get('booking_count_with_month_chart', [HomeController::class, 'booking_count_with_month_chart'])->middleware('vendorPermission:vendor_statistics.view');
    Route::get('register_count_with_month_chart', [HomeController::class, 'register_count_with_month_chart'])->middleware('vendorPermission:vendor_statistics.view');
    Route::get('booking_count_last_week_chart', [HomeController::class, 'booking_count_last_week_chart'])->middleware('vendorPermission:vendor_statistics.view');
    Route::get('last_bookings', [HomeController::class, 'last_bookings'])->middleware('vendorPermission:vendor_statistics.view');
    Route::get('last_customers', [HomeController::class, 'last_customers'])->middleware('vendorPermission:vendor_statistics.view');


});
