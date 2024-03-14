<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GatewayController;
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

    Route::post('/login', [UserController::class, 'login']);
});

Route::group(['prefix' => '/v1','middleware' => ['auth:api']], function() {

    Route::group(['prefix' => '/organization'], function() {
        Route::get('/get_related_data/{model}/{id}/{relation}', [GatewayController::class, 'handleRequest']);
        Route::get('/lookup/{model}', [GatewayController::class,'handleRequest']); // model must be like gender-type or country

        Route::get('organizations', [GatewayController::class, 'handleRequest']);
        Route::post('organizations', [GatewayController::class, 'handleRequest']);
        Route::get('organizations/{organization}', [GatewayController::class, 'handleRequest']);
        Route::put('organizations/{organization}', [GatewayController::class, 'handleRequest']);
        Route::delete('organizations/{organization}', [GatewayController::class, 'handleRequest']);

        Route::get('countries', [GatewayController::class, 'handleRequest']);
        Route::post('countries', [GatewayController::class, 'handleRequest']);
        Route::get('countries/{country}', [GatewayController::class, 'handleRequest']);
        Route::put('countries/{country}', [GatewayController::class, 'handleRequest']);
        Route::delete('countries/{country}', [GatewayController::class, 'handleRequest']);

        Route::get('currencies', [GatewayController::class, 'handleRequest']);
        Route::post('currencies', [GatewayController::class, 'handleRequest']);
        Route::get('currencies/{currency}', [GatewayController::class, 'handleRequest']);
        Route::put('currencies/{currency}', [GatewayController::class, 'handleRequest']);
        Route::delete('currencies/{currency}', [GatewayController::class, 'handleRequest']);

        Route::get('school-hubs', [GatewayController::class, 'handleRequest']);
        Route::post('school-hubs', [GatewayController::class, 'handleRequest']);
        Route::get('school-hubs/{schoolHub}', [GatewayController::class, 'handleRequest']);
        Route::put('school-hubs/{schoolHub}', [GatewayController::class, 'handleRequest']);
        Route::delete('school-hubs/{schoolHub}', [GatewayController::class, 'handleRequest']);

        Route::get('schools', [GatewayController::class, 'handleRequest']);
        Route::post('schools', [GatewayController::class, 'handleRequest']);
        Route::get('schools/{school}', [GatewayController::class, 'handleRequest']);
        Route::put('schools/{school}', [GatewayController::class, 'handleRequest']);
        Route::delete('schools/{school}', [GatewayController::class, 'handleRequest']);

        Route::get('genders', [GatewayController::class, 'handleRequest']);
        Route::post('genders', [GatewayController::class, 'handleRequest']);
        Route::get('genders/{gender}', [GatewayController::class, 'handleRequest']);
        Route::put('genders/{gender}', [GatewayController::class, 'handleRequest']);
        Route::delete('genders/{gender}', [GatewayController::class, 'handleRequest']);

        Route::get('branches', [GatewayController::class, 'handleRequest']);
        Route::post('branches', [GatewayController::class, 'handleRequest']);
        Route::get('branches/{branch}', [GatewayController::class, 'handleRequest']);
        Route::put('branches/{branch}', [GatewayController::class, 'handleRequest']);
        Route::delete('branches/{branch}', [GatewayController::class, 'handleRequest']);

        Route::get('phones', [GatewayController::class, 'handleRequest']);
        Route::post('phones', [GatewayController::class, 'handleRequest']);
        Route::get('phones/{phone}', [GatewayController::class, 'handleRequest']);
        Route::put('phones/{phone}', [GatewayController::class, 'handleRequest']);
        Route::delete('phones/{phone}', [GatewayController::class, 'handleRequest']);


        Route::get('group-degrees', [GatewayController::class, 'handleRequest']);
        Route::post('group-degrees', [GatewayController::class, 'handleRequest']);
        Route::get('group-degrees/{groupDegree}', [GatewayController::class, 'handleRequest']);
        Route::put('group-degrees/{groupDegree}', [GatewayController::class, 'handleRequest']);

        Route::get('degrees', [GatewayController::class, 'handleRequest']);
        Route::post('degrees', [GatewayController::class, 'handleRequest']);
        Route::get('degrees/{degree}', [GatewayController::class, 'handleRequest']);
        Route::put('degrees/{degree}', [GatewayController::class, 'handleRequest']);




    });
    Route::group(['prefix' => '/hr'], function() {
        Route::get('/get_related_data/{model}/{id}/{relation}', [GatewayController::class, 'handleRequest']);
        Route::get('universities', [GatewayController::class, 'handleRequest']);
        Route::post('universities', [GatewayController::class, 'handleRequest']);
        Route::get('universities/{university}', [GatewayController::class, 'handleRequest']);
        Route::put('universities/{university}', [GatewayController::class, 'handleRequest']);

        Route::get('departments', [GatewayController::class, 'handleRequest']);
        Route::post('departments', [GatewayController::class, 'handleRequest']);
        Route::get('departments/{department}', [GatewayController::class, 'handleRequest']);
        Route::put('departments/{department}', [GatewayController::class, 'handleRequest']);

        Route::get('jobs', [GatewayController::class, 'handleRequest']);
        Route::post('jobs', [GatewayController::class, 'handleRequest']);
        Route::get('jobs/{job}', [GatewayController::class, 'handleRequest']);
        Route::put('jobs/{job}', [GatewayController::class, 'handleRequest']);

        Route::get('staff', [GatewayController::class, 'handleRequest']);
        Route::post('staff', [GatewayController::class, 'handleRequest']);
        Route::get('staff/{staff}', [GatewayController::class, 'handleRequest']);
        Route::put('staff/{staff}', [GatewayController::class, 'handleRequest']);

        Route::get('staff_degrees', [GatewayController::class, 'handleRequest']);
        Route::post('staff_degrees', [GatewayController::class, 'handleRequest']);
        Route::get('staff_degrees/{staff_degree}', [GatewayController::class, 'handleRequest']);
        Route::put('staff_degrees/{staff_degree}', [GatewayController::class, 'handleRequest']);

        Route::get('department_staff', [GatewayController::class, 'handleRequest']);
        Route::post('department_staff', [GatewayController::class, 'handleRequest']);
        Route::get('department_staff/{department_staff}', [GatewayController::class, 'handleRequest']);
        Route::put('department_staff/{department_staff}', [GatewayController::class, 'handleRequest']);

        Route::get('staff_histories', [GatewayController::class, 'handleRequest']);
        Route::post('staff_histories', [GatewayController::class, 'handleRequest']);
        Route::get('staff_histories/{staff_history}', [GatewayController::class, 'handleRequest']);
        Route::put('staff_histories/{staff_history}', [GatewayController::class, 'handleRequest']);

        Route::get('specialties', [GatewayController::class, 'handleRequest']);
        Route::post('specialties', [GatewayController::class, 'handleRequest']);
        Route::get('specialties/{specialty}', [GatewayController::class, 'handleRequest']);
        Route::put('specialties/{specialty}', [GatewayController::class, 'handleRequest']);

        Route::get('nationalities', [GatewayController::class, 'handleRequest']);
        Route::post('nationalities', [GatewayController::class, 'handleRequest']);
        Route::get('nationalities/{nationality}', [GatewayController::class, 'handleRequest']);
        Route::put('nationalities/{nationality}', [GatewayController::class, 'handleRequest']);

        Route::get('relationships', [GatewayController::class, 'handleRequest']);
        Route::post('relationships', [GatewayController::class, 'handleRequest']);
        Route::get('relationships/{relationship}', [GatewayController::class, 'handleRequest']);
        Route::put('relationships/{relationship}', [GatewayController::class, 'handleRequest']);

        Route::get('discount-periods', [GatewayController::class, 'handleRequest']);
        Route::post('discount-periods', [GatewayController::class, 'handleRequest']);
        Route::get('discount-periods/{discountPeriod}', [GatewayController::class, 'handleRequest']);
        Route::put('discount-periods/{discountPeriod}', [GatewayController::class, 'handleRequest']);

        Route::get('/lookup/{model}', [GatewayController::class,'handleRequest']); // model must be like gender-type or country
    });
    Route::group(['prefix' => '/users'], function() {
        Route::get('/get_related_data/{model}/{id}/{relation}', [GatewayController::class, 'handleRequest']);
        Route::get('roles', [GatewayController::class, 'handleRequest']);
        Route::post('roles', [GatewayController::class, 'handleRequest']);
        Route::get('roles/{role}', [GatewayController::class, 'handleRequest']);
        Route::put('roles/{role}', [GatewayController::class, 'handleRequest']);

        Route::get('permissions', [GatewayController::class, 'handleRequest']);

        Route::post('have_permission_to', [GatewayController::class, 'handleRequest']);
        Route::post('sync_roles', [GatewayController::class, 'handleRequest']);

        Route::get('users', [GatewayController::class, 'handleRequest']);
        Route::post('users', [GatewayController::class, 'handleRequest']);
        Route::get('users/{user}', [GatewayController::class, 'handleRequest']);
        Route::put('users/{user}', [GatewayController::class, 'handleRequest']);
    });


    Route::group(['prefix' => '/building'], function() {
        //general APIs
        Route::get('/get_related_data/{model}/{id}/{relation}', [GatewayController::class,'handleRequest']);
        Route::get('/lookup/{model}', [GatewayController::class,'handleRequest']); // model must be like gender-type or country

        Route::get('buildings', [GatewayController::class, 'handleRequest']);
        Route::post('buildings', [GatewayController::class, 'handleRequest']);
        Route::get('buildings/{building}', [GatewayController::class, 'handleRequest']);
        Route::put('buildings/{building}', [GatewayController::class, 'handleRequest']);

        Route::get('floors', [GatewayController::class, 'handleRequest']);
        Route::post('floors', [GatewayController::class, 'handleRequest']);
        Route::get('floors/{floor}', [GatewayController::class, 'handleRequest']);
        Route::put('floors/{floor}', [GatewayController::class, 'handleRequest']);

        Route::get('wards', [GatewayController::class, 'handleRequest']);
        Route::post('wards', [GatewayController::class, 'handleRequest']);
        Route::get('wards/{ward}', [GatewayController::class, 'handleRequest']);
        Route::put('wards/{ward}', [GatewayController::class, 'handleRequest']);

        Route::get('room-types', [GatewayController::class, 'handleRequest']);
        Route::post('room-types', [GatewayController::class, 'handleRequest']);
        Route::get('room-types/{room_type}', [GatewayController::class, 'handleRequest']);
        Route::put('room-types/{room_type}', [GatewayController::class, 'handleRequest']);

        Route::get('rooms', [GatewayController::class, 'handleRequest']);
        Route::post('rooms', [GatewayController::class, 'handleRequest']);
        Route::get('rooms/{room}', [GatewayController::class, 'handleRequest']);
        Route::put('rooms/{room}', [GatewayController::class, 'handleRequest']);


    });

    Route::group(['prefix' => '/storage'], function() {
        Route::post('/handleRequest', [GatewayController::class, 'handleRequest']);
        Route::get('/get', [GatewayController::class, 'handleRequest']);
        Route::delete('/delete', [GatewayController::class, 'handleRequest']);
    });

    Route::group(['prefix' => '/notification'], function() {
        Route::get('/get_related_data/{model}/{id}/{relation}', [GatewayController::class, 'handleRequest']);

        Route::get('notification_texts', [GatewayController::class, 'handleRequest']);
        Route::post('notification_texts', [GatewayController::class, 'handleRequest']);
        Route::get('notification_texts/{notification_text}', [GatewayController::class, 'handleRequest']);
        Route::put('notification_texts/{notification_text}', [GatewayController::class, 'handleRequest']);

        Route::get('notification_text_channels', [GatewayController::class, 'handleRequest']);
        Route::get('notification_text_events', [GatewayController::class, 'handleRequest']);
        Route::get('notification_text_event_texts', [GatewayController::class, 'handleRequest']);
        Route::get('notification_user_types', [GatewayController::class, 'handleRequest']);


        Route::get('notifications', [GatewayController::class, 'handleRequest']);
        Route::post('notifications', [GatewayController::class, 'handleRequest']);
        Route::get('notifications/{notification}', [GatewayController::class, 'handleRequest']);
        Route::post('mark_as_read', [GatewayController::class, 'handleRequest']);
        Route::get('unread_count', [GatewayController::class, 'handleRequest']);

        Route::post('send_socket', [GatewayController::class, 'handleRequest']);

    });

    Route::group(['prefix' => '/academic_year'], function() {
        Route::get('/get_related_data/{model}/{id}/{relation}', [GatewayController::class, 'handleRequest']);
        Route::get('/lookup/{model}', [GatewayController::class,'handleRequest']); // model must be like gender-type or country


        Route::get('academic-years/current', [GatewayController::class, 'handleRequest']);
        Route::get('academic-years/open-for-admission', [GatewayController::class, 'handleRequest']);

        Route::get('academic-years', [GatewayController::class, 'handleRequest']);
        Route::post('academic-years', [GatewayController::class, 'handleRequest']);
        Route::get('academic-years/{academic_year}', [GatewayController::class, 'handleRequest']);
        Route::put('academic-years/{academic_year}', [GatewayController::class, 'handleRequest']);

        Route::get('academic-genders', [GatewayController::class, 'handleRequest']);
        Route::post('academic-genders', [GatewayController::class, 'handleRequest']);
        Route::get('academic-genders/{academic_gender}', [GatewayController::class, 'handleRequest']);
        Route::put('academic-genders/{academic_gender}', [GatewayController::class, 'handleRequest']);

        Route::get('academic-branches', [GatewayController::class, 'handleRequest']);
        Route::post('academic-branches', [GatewayController::class, 'handleRequest']);
        Route::get('academic-branches/{academic_branch}', [GatewayController::class, 'handleRequest']);
        Route::put('academic-branches/{academic_branch}', [GatewayController::class, 'handleRequest']);

        Route::get('academic-degrees/{academic_degree}/have-available-class', [GatewayController::class, 'handleRequest']);
        Route::get('academic-degrees', [GatewayController::class, 'handleRequest']);
        Route::post('academic-degrees', [GatewayController::class, 'handleRequest']);
        Route::get('academic-degrees/{academic_degree}', [GatewayController::class, 'handleRequest']);
        Route::put('academic-degrees/{academic_degree}', [GatewayController::class, 'handleRequest']);

        Route::get('academic-semesters', [GatewayController::class, 'handleRequest']);
        Route::post('academic-semesters', [GatewayController::class, 'handleRequest']);
        Route::get('academic-semesters/{academic_semester}', [GatewayController::class, 'handleRequest']);
        Route::put('academic-semesters/{academic_semester}', [GatewayController::class, 'handleRequest']);

        Route::get('academic-terms', [GatewayController::class, 'handleRequest']);
        Route::post('academic-terms', [GatewayController::class, 'handleRequest']);
        Route::get('academic-terms/{academic_term}', [GatewayController::class, 'handleRequest']);
        Route::put('academic-terms/{academic_term}', [GatewayController::class, 'handleRequest']);

        Route::post('academic-classes/add-student-to-academic-class', [GatewayController::class, 'handleRequest']);
        Route::get('academic-classes', [GatewayController::class, 'handleRequest']);
        Route::post('academic-classes', [GatewayController::class, 'handleRequest']);
        Route::get('academic-classes/{academic_class}', [GatewayController::class, 'handleRequest']);
        Route::put('academic-classes/{academic_class}', [GatewayController::class, 'handleRequest']);
    });


    Route::group(['prefix' => '/pricing'], function() {
        Route::get('/get_related_data/{model}/{id}/{relation}', [GatewayController::class, 'handleRequest']);
        Route::get('/lookup/{model}', [GatewayController::class,'handleRequest']); // model must be like gender-type or country


        Route::get('packages/academic-year/{academic_year}/academic-degree/{academic_degree}', [GatewayController::class, 'handleRequest']);
        Route::get('packages', [GatewayController::class, 'handleRequest']);
        Route::post('packages', [GatewayController::class, 'handleRequest']);
        Route::get('packages/{package}', [GatewayController::class, 'handleRequest']);
        Route::put('packages/{package}', [GatewayController::class, 'handleRequest']);
        Route::get('packages/{id}/items', [GatewayController::class, 'handleRequest']);
        Route::get('packages/item/all', [GatewayController::class, 'GatewayController']);

        Route::get('package-items', [GatewayController::class, 'handleRequest']);
        Route::post('package-items', [GatewayController::class, 'handleRequest']);
        Route::get('package-items/{package_item}', [GatewayController::class, 'handleRequest']);
        Route::put('package-items/{package_item}', [GatewayController::class, 'handleRequest']);

        Route::get('items', [GatewayController::class, 'handleRequest']);
        Route::post('items', [GatewayController::class, 'handleRequest']);
        Route::post('items/bulk', [GatewayController::class, 'handleRequest']);
        Route::get('items/{item}', [GatewayController::class, 'handleRequest']);
        Route::put('items/{item}', [GatewayController::class, 'handleRequest']);

        Route::get('main-services/academic-year/{year_id}/{degree_id}', [GatewayController::class, 'handleRequest']);
        Route::get('main-services', [GatewayController::class, 'handleRequest']);
        Route::post('main-services', [GatewayController::class, 'handleRequest']);
        Route::get('main-services/{main_service}', [GatewayController::class, 'handleRequest']);
        Route::put('main-services/{main_service}', [GatewayController::class, 'handleRequest']);

        Route::get('sub-services', [GatewayController::class, 'handleRequest']);
        Route::post('sub-services', [GatewayController::class, 'handleRequest']);
        Route::get('sub-services/{sub_service}', [GatewayController::class, 'handleRequest']);
        Route::put('sub-services/{sub_service}', [GatewayController::class, 'handleRequest']);
    });

    Route::group(['prefix' => '/admission'], function() {
        Route::get('/get_related_data/{model}/{id}/{relation}', [GatewayController::class, 'handleRequest']);
        Route::get('/lookup/{model}', [GatewayController::class,'handleRequest']); // model must be like gender-type or country

        Route::put('/admission-request-required-documents/{admissionRequestRequiredDocument}', [AdmissionRequestRequiredDocumentController::class, 'update']);


        Route::get('admission-request/{admission_request}/required-documents', [GatewayController::class, 'handleRequest']);
        Route::post('admission-requests/pay-bill/update-full-admission', [GatewayController::class, 'handleRequest']);
        Route::get('admission-requests', [GatewayController::class, 'handleRequest']);
        Route::post('admission-requests', [GatewayController::class, 'handleRequest']);
        Route::get('admission-requests/{admission_request}', [GatewayController::class, 'handleRequest']);
        Route::put('admission-requests/{admission_request}', [GatewayController::class, 'handleRequest']);

        Route::get('required-documents', [GatewayController::class, 'handleRequest']);
        Route::post('required-documents', [GatewayController::class, 'handleRequest']);
        Route::get('required-documents/{required_document}', [GatewayController::class, 'handleRequest']);
        Route::put('required-documents/{required_document}', [GatewayController::class, 'handleRequest']);

        Route::post('book-appointment', [GatewayController::class, 'handleRequest']);
        Route::post('approval-appointment-callback', [GatewayController::class, 'handleRequest']);
        Route::get('financial-plan-requests', [GatewayController::class, 'handleRequest']);
        Route::post('financial-plan-requests', [GatewayController::class, 'handleRequest']);
        Route::get('financial-plan-requests/{financial_plan_request}', [GatewayController::class, 'handleRequest']);
        Route::put('financial-plan-requests/{financial_plan_request}', [GatewayController::class, 'handleRequest']);
    });
    Route::group(['prefix' => '/transportation'], function() {
        Route::get('/get_related_data/{model}/{id}/{relation}', [GatewayController::class, 'handleRequest']);
        Route::get('/lookup/{model}', [GatewayController::class,'handleRequest']); // model must be like gender-type or country

        Route::get('vehicles', [GatewayController::class, 'handleRequest']);
        Route::post('vehicles', [GatewayController::class, 'handleRequest']);
        Route::get('vehicles/{vehicle}', [GatewayController::class, 'handleRequest']);
        Route::put('vehicles/{vehicle}', [GatewayController::class, 'handleRequest']);

        Route::post('drivers/assign-vehicle', [GatewayController::class,'handleRequest']);
        Route::post('drivers/unassign-vehicle', [GatewayController::class,'handleRequest']);
        Route::get('drivers', [GatewayController::class, 'handleRequest']);
        Route::post('drivers', [GatewayController::class, 'handleRequest']);
        Route::post('drivers/{driver}', [GatewayController::class, 'handleRequest']);
        Route::put('drivers/{driver}', [GatewayController::class, 'handleRequest']);
    });
    Route::group(['prefix' => '/nafith'], function() {
        Route::get('/get_related_data/{model}/{id}/{relation}', [GatewayController::class, 'handleRequest']);
        Route::get('/lookup/{model}', [GatewayController::class,'handleRequest']); // model must be like gender-type or country


        Route::post('callback', [GatewayController::class,'handleRequest']);

        Route::get('nafith_setting', [GatewayController::class, 'handleRequest']);
        Route::post('nafith_setting', [GatewayController::class, 'handleRequest']);

        Route::get('documents', [GatewayController::class, 'handleRequest']);
        Route::post('documents', [GatewayController::class, 'handleRequest']);
        Route::get('documents/{document}', [GatewayController::class, 'handleRequest']);
//        Route::put('documents/{document}', [GatewayController::class, 'handleRequest']);
    });

    Route::group(['prefix' => '/payfort'], function() {
        Route::get('/get_related_data/{model}/{id}/{relation}', [GatewayController::class, 'handleRequest']);
        Route::get('/lookup/{model}', [GatewayController::class,'handleRequest']); // model must be like gender-type or country

        Route::post('pay', [GatewayController::class, 'handleRequest']);
        Route::post('callback', [GatewayController::class,'handleRequest']);
    });

    Route::group(['prefix' => '/anb'], function() {
        Route::get('/get_related_data/{model}/{id}/{relation}', [GatewayController::class, 'handleRequest']);
        Route::get('/lookup/{model}', [GatewayController::class,'handleRequest']); // model must be like gender-type or country

        Route::get('anb_setting', [GatewayController::class, 'handleRequest']);
        Route::post('anb_setting', [GatewayController::class, 'handleRequest']);
        Route::get('create_viban', [GatewayController::class,'handleRequest']);
        Route::get('auth_anb', [GatewayController::class,'handleRequest']);
        Route::post('get_statement', [GatewayController::class,'handleRequest']);

        Route::get('wallets', [GatewayController::class, 'handleRequest']);
//    Route::post('wallets', [WalletController::class, 'store']);
        Route::get('wallets/{wallet}', [GatewayController::class, 'handleRequest']);
//    Route::put('wallets/{wallet}', [WalletController::class, 'update']);
    });

    Route::group(['prefix' => '/exams'], function() {
        //general APIs
        Route::get('/get_related_data/{model}/{id}/{relation}', [GatewayController::class,'handleRequest']);
        Route::get('/lookup/{model}', [GatewayController::class,'handleRequest']); // model must be like gender-type or country

        Route::get('exams', [GatewayController::class, 'handleRequest']);
        Route::post('exams', [GatewayController::class, 'handleRequest']);
        Route::get('exams/{exam}', [GatewayController::class, 'handleRequest']);
        Route::put('exams/{exam}', [GatewayController::class, 'handleRequest']);

        Route::get('questions', [GatewayController::class, 'handleRequest']);
        Route::post('questions', [GatewayController::class, 'handleRequest']);
        Route::get('questions/{question}', [GatewayController::class, 'handleRequest']);
        Route::put('questions/{question}', [GatewayController::class, 'handleRequest']);

        Route::get('options', [GatewayController::class, 'handleRequest']);
        Route::post('options', [GatewayController::class, 'handleRequest']);
        Route::get('options/{option}', [GatewayController::class, 'handleRequest']);
        Route::put('options/{option}', [GatewayController::class, 'handleRequest']);

        Route::get('submissions', [GatewayController::class, 'handleRequest']);
        Route::post('submissions', [GatewayController::class, 'handleRequest']);
        Route::post('submissions/answers', [GatewayController::class, 'submissionAnswers']);
        Route::get('submissions/{submission}', [GatewayController::class, 'handleRequest']);
        Route::put('submissions/{submission}', [GatewayController::class, 'handleRequest']);

    });

    Route::group(['prefix' => '/supply_chain'], function() {
        Route::get('/get_related_data/{model}/{id}/{relation}', [GatewayController::class, 'handleRequest']);
        Route::get('/lookup/{model}', [GatewayController::class,'handleRequest']); // model must be like gender-type or country

        Route::get('units', [GatewayController::class, 'handleRequest']);
        Route::post('units', [GatewayController::class, 'handleRequest']);
        Route::get('units/{unit}', [GatewayController::class, 'handleRequest']);
        Route::put('units/{unit}', [GatewayController::class, 'handleRequest']);

        Route::get('item_groups', [GatewayController::class, 'handleRequest']);
        Route::post('item_groups', [GatewayController::class, 'handleRequest']);
        Route::get('item_groups/{item_group}', [GatewayController::class, 'handleRequest']);
        Route::put('item_groups/{item_group}', [GatewayController::class, 'handleRequest']);

        Route::get('item_files', [GatewayController::class, 'handleRequest']);
        Route::post('item_files', [GatewayController::class, 'handleRequest']);
        Route::get('item_files/{item_file}', [GatewayController::class, 'handleRequest']);
        Route::put('item_files/{item_file}', [GatewayController::class, 'handleRequest']);

        Route::get('store_types', [GatewayController::class, 'handleRequest']);
        Route::post('store_types', [GatewayController::class, 'handleRequest']);
        Route::get('store_types/{store_type}', [GatewayController::class, 'handleRequest']);
        Route::put('store_types/{store_type}', [GatewayController::class, 'handleRequest']);

        Route::get('stores', [GatewayController::class, 'handleRequest']);
        Route::post('stores', [GatewayController::class, 'handleRequest']);
        Route::get('stores/{store}', [GatewayController::class, 'handleRequest']);
        Route::put('stores/{store}', [GatewayController::class, 'handleRequest']);

        Route::get('store_items', [GatewayController::class, 'handleRequest']);
        Route::post('store_items', [GatewayController::class, 'handleRequest']);
        Route::get('store_items/{store_item}', [GatewayController::class, 'handleRequest']);
        Route::put('store_items/{store_item}', [GatewayController::class, 'handleRequest']);


        Route::get('transaction_types', [GatewayController::class, 'handleRequest']);
        Route::post('transaction_types', [GatewayController::class, 'handleRequest']);
        Route::get('transaction_types/{transaction_type}', [GatewayController::class, 'handleRequest']);
        Route::put('transaction_types/{transaction_type}', [GatewayController::class, 'handleRequest']);

        Route::get('transaction_statuses', [GatewayController::class, 'handleRequest']);
        Route::post('transaction_statuses', [GatewayController::class, 'handleRequest']);
        Route::get('transaction_statuses/{transaction_status}', [GatewayController::class, 'handleRequest']);
        Route::put('transaction_statuses/{transaction_status}', [GatewayController::class, 'handleRequest']);

        Route::get('transaction_heads', [GatewayController::class, 'handleRequest']);
        Route::post('transaction_heads', [GatewayController::class, 'handleRequest']);
        Route::get('transaction_heads/{transaction_head}', [GatewayController::class, 'handleRequest']);
        Route::put('transaction_heads/{transaction_head}', [GatewayController::class, 'handleRequest']);

        Route::get('transaction_details', [GatewayController::class, 'handleRequest']);
        Route::post('transaction_details', [GatewayController::class, 'handleRequest']);
        Route::get('transaction_details/{transaction_detail}', [GatewayController::class, 'handleRequest']);
        Route::put('transaction_details/{transaction_detail}', [GatewayController::class, 'handleRequest']);

        Route::get('vendor_categories', [GatewayController::class, 'handleRequest']);
        Route::post('vendor_categories', [GatewayController::class, 'handleRequest']);
        Route::get('vendor_categories/{vendor_category}', [GatewayController::class, 'handleRequest']);
        Route::put('vendor_categories/{vendor_category}', [GatewayController::class, 'handleRequest']);

        Route::get('vendor_officers', [GatewayController::class, 'handleRequest']);
        Route::post('vendor_officers', [GatewayController::class, 'handleRequest']);
        Route::get('vendor_officers/{vendor_officer}', [GatewayController::class, 'handleRequest']);
        Route::put('vendor_officers/{vendor_officer}', [GatewayController::class, 'handleRequest']);

        Route::get('vendors', [GatewayController::class, 'handleRequest']);
        Route::post('vendors', [GatewayController::class, 'handleRequest']);
        Route::get('vendors/{vendor}', [GatewayController::class, 'handleRequest']);
        Route::put('vendors/{vendor}', [GatewayController::class, 'handleRequest']);

        Route::get('vendor_phones', [GatewayController::class, 'handleRequest']);
        Route::post('vendor_phones', [GatewayController::class, 'handleRequest']);
        Route::get('vendor_phones/{vendor_phone}', [GatewayController::class, 'handleRequest']);
        Route::put('vendor_phones/{vendor_phone}', [GatewayController::class, 'handleRequest']);

        Route::get('asset_groups', [GatewayController::class, 'handleRequest']);
        Route::post('asset_groups', [GatewayController::class, 'handleRequest']);
        Route::get('asset_groups/{asset_group}', [GatewayController::class, 'handleRequest']);
        Route::put('asset_groups/{asset_group}', [GatewayController::class, 'handleRequest']);

        Route::get('assets', [GatewayController::class, 'handleRequest']);
        Route::post('assets', [GatewayController::class, 'handleRequest']);
        Route::get('assets/{asset}', [GatewayController::class, 'handleRequest']);
        Route::put('assets/{asset}', [GatewayController::class, 'handleRequest']);
    });

    Route::group(['prefix' => '/appointment'], function() {
        //general APIs
        Route::get('/get_related_data/{model}/{id}/{relation}', [GatewayController::class,'handleRequest']);
        Route::get('/lookup/{model}', [GatewayController::class,'handleRequest']); // model must be like gender-type or country

        Route::get('appointment-sections', [GatewayController::class, 'handleRequest']);
        Route::post('appointment-sections', [GatewayController::class, 'handleRequest']);
        Route::get('appointment-sections/{appointment_section}', [GatewayController::class, 'handleRequest']);
        Route::put('appointment-sections/{appointment_section}', [GatewayController::class, 'handleRequest']);

        Route::get('appointment-offices', [GatewayController::class, 'handleRequest']);
        Route::post('appointment-offices', [GatewayController::class, 'handleRequest']);
        Route::get('appointment-offices/{appointment_office}', [GatewayController::class, 'handleRequest']);
        Route::put('appointment-offices/{appointment_office}', [GatewayController::class, 'handleRequest']);

        Route::get('appointment-questions', [GatewayController::class, 'handleRequest']);
        Route::post('appointment-questions', [GatewayController::class, 'handleRequest']);
        Route::get('appointment-questions/{appointment_question}', [GatewayController::class, 'handleRequest']);
        Route::put('appointment-questions/{appointment_question}', [GatewayController::class, 'handleRequest']);

        Route::get('subjects', [GatewayController::class, 'handleRequest']);
        Route::post('subjects', [GatewayController::class, 'handleRequest']);
        Route::get('subjects/{subject}', [GatewayController::class, 'handleRequest']);
        Route::put('subjects/{subject}', [GatewayController::class, 'handleRequest']);

        Route::post('reserved-appointments/book-appointment', [GatewayController::class, 'handleRequest']);
        Route::post('reserved-appointments/update-approval-status', [GatewayController::class, 'handleRequest']);
        Route::post('reserved-appointments/get-available-slots', [GatewayController::class, 'handleRequest']);
        Route::get('reserved-appointments', [GatewayController::class, 'handleRequest']);
        Route::post('reserved-appointments', [GatewayController::class, 'handleRequest']);
        Route::get('reserved-appointments/{reserved_appointment}', [GatewayController::class, 'handleRequest']);
        Route::put('reserved-appointments/{reserved_appointment}', [GatewayController::class, 'handleRequest']);

        Route::get('office-schedules', [GatewayController::class, 'handleRequest']);
        Route::post('office-schedules', [GatewayController::class, 'handleRequest']);
        Route::get('office-schedules/{office_schedule}', [GatewayController::class, 'handleRequest']);
        Route::put('office-schedules/{office_schedule}', [GatewayController::class, 'handleRequest']);

    });

    Route::group(['prefix' => '/billing'], function() {
        //general APIs
        Route::get('/get_related_data/{model}/{id}/{relation}', [GatewayController::class,'handleRequest']);
        Route::get('/lookup/{model}', [GatewayController::class,'handleRequest']); // model must be like gender-type or country

        Route::get('admission-bills/filter', [GatewayController::class, 'handleRequest']);
        Route::get('admission-bills/pending-bills/{payment_way_key}', [GatewayController::class, 'handleRequest']);
        Route::post('admission-bills/pay/bank', [GatewayController::class, 'handleRequest']);
        Route::post('admission-bills/pay-bank/accept', [GatewayController::class, 'handleRequest']);
        Route::post('admission-bills/pay-bank/reject', [GatewayController::class, 'handleRequest']);
        Route::get('admission-bills/guardian/{guardian_id}', [GatewayController::class, 'handleRequest']);
        Route::get('admission-bills/admission-request/{admission_id}', [GatewayController::class, 'handleRequest']);

        Route::get('admission-bills', [GatewayController::class, 'handleRequest']);
        Route::get('admission-bills/pending', [GatewayController::class, 'handleRequest']);
        Route::post('admission-bills', [GatewayController::class, 'handleRequest']);
        Route::get('admission-bills/{admission_bill}', [GatewayController::class, 'handleRequest']);
        Route::put('admission-bills/{admission_bill}', [GatewayController::class, 'handleRequest']);

        Route::post('admission-bills/payfort/callback', [GatewayController::class, 'handleRequest'])->name('admission-bills.payfort.callback');

    });

    Route::group(['prefix' => '/students'], function() {
        //general APIs
        Route::get('/get_related_data/{model}/{id}/{relation}', [GatewayController::class,'handleRequest']);
        Route::get('/lookup/{model}', [GatewayController::class,'handleRequest']); // model must be like gender-type or country

        Route::get('students', [GatewayController::class, 'handleRequest']);
        Route::post('students', [GatewayController::class, 'handleRequest']);
        Route::get('students/{student}', [GatewayController::class, 'handleRequest']);
        Route::put('students/{student}', [GatewayController::class, 'handleRequest']);

    });


    Route::group(['prefix' => '/withdrawal'], function() {
        Route::get('/get_related_data/{model}/{id}/{relation}', [GatewayController::class, 'handleRequest']);
        Route::get('/lookup/{model}', [GatewayController::class,'handleRequest']); // model must be like gender-type or country

        Route::get('withdrawal-periods', [GatewayController::class, 'handleRequest']);
        Route::post('withdrawal-periods', [GatewayController::class, 'handleRequest']);
        Route::get('withdrawal-periods/{withdrawalPeriod}', [GatewayController::class, 'handleRequest']);
        Route::put('withdrawal-periods/{withdrawalPeriod}', [GatewayController::class, 'handleRequest']);

        Route::get('withdrawal-requests', [GatewayController::class, 'handleRequest']);
        Route::post('withdrawal-requests', [GatewayController::class, 'handleRequest']);
        Route::get('withdrawal-requests/{withdrawalRequest}', [GatewayController::class, 'handleRequest']);
        Route::put('withdrawal-requests/{withdrawalRequest}', [GatewayController::class, 'handleRequest']);

        Route::get('settlements', [GatewayController::class, 'handleRequest']);
        Route::post('settlements', [GatewayController::class, 'handleRequest']);
        Route::get('settlements/{settlement}', [GatewayController::class, 'handleRequest']);
        Route::put('settlements/{settlement}', [GatewayController::class, 'handleRequest']);

    });

    Route::post('/logout',[UserController::class, 'logout']);


});
