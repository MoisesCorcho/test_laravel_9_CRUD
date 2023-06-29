<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Organization\OrganizationController;
use App\Http\Controllers\Member\MemberController;
use App\Http\Controllers\Visit\VisitController;
use App\Http\Controllers\MemberPosition\MemberPositionController;
use App\Http\Controllers\ImportExport\ImportExportController;
use App\Http\Controllers\Survey\SurveyController;

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

Route::group(['middleware' => ['api'], 'prefix' => 'auth'], function () {
    Route::post('Register', [AuthController::class, 'register']);
    Route::post('Login',    [AuthController::class, 'login']);
    Route::post('Logout',   [AuthController::class, 'logout']);
    Route::post('Refresh',  [AuthController::class, 'refresh']);
    Route::post('Me',       [AuthController::class, 'me']);
});

Route::group(['middleware' => ['api', 'jwt.verify', 'role:Admin|SuperAdmin|Seller'], 'prefix' => 'usuarios'], function () {
    Route::get('Index',                 [UserController::class, 'index']);
    Route::get('Show/{id}',             [UserController::class, 'show']);
    Route::post('Store',                [UserController::class, 'store']);
    Route::put('Update/{id}',           [UserController::class, 'update']);
    Route::delete('Destroy/{id}',       [UserController::class, 'destroy']);
    Route::get('SellerList',            [UserController::class, 'sellersList']);
    Route::get('GetRoles',              [UserController::class, 'getRoles']);
    Route::get('GetSellersWithClients', [UserController::class, 'getSellersWithClients']);
    Route::get('AvailableClients',      [UserController::class, 'availableClients']);
    Route::put(
        'AssignClientToSeller/organization/{idOrganizacion}/user/{idUsuario}',
        [UserController::class, 'assignClientToSeller']
    );
    Route::put(
        'RemoveClientToSeller/organization/{idOrganizacion}/user/{idUsuario}',
        [UserController::class, 'removeClientToSeller']
    );
    Route::get('PendingTasks', [UserController::class, 'pendingTasks']);
    Route::post('DisableTask/{id}', [UserController::class, 'disableTask']);
});

Route::group(['middleware' => ['api', 'jwt.verify', 'role:Admin|SuperAdmin'], 'prefix' => 'organizaciones'], function () {
    Route::get('Index',                 [OrganizationController::class, 'index']);
    Route::get('Show/{id}',             [OrganizationController::class, 'show']);
    Route::post('Store',                [OrganizationController::class, 'store']);
    Route::put('Update/{id}',           [OrganizationController::class, 'update']);
    Route::delete('Destroy/{id}',       [OrganizationController::class, 'destroy']);
});

Route::group(['middleware' => ['api', 'jwt.verify'], 'prefix' => 'miembros'], function () {
    Route::get('Index',           [MemberController::class, 'index']);
    Route::get('Show/{id}',       [MemberController::class, 'show']);
    Route::post('Store',          [MemberController::class, 'store']);
    Route::put('Update/{id}',     [MemberController::class, 'update']);
    Route::delete('Destroy/{id}', [MemberController::class, 'destroy']);
});

Route::group(['middleware' => ['api', 'jwt.verify'], 'prefix' => 'visitas'], function () {
    Route::get('Index',              [VisitController::class, 'index']);
    Route::get('Show/{id}',          [VisitController::class, 'show']);
    Route::post('Store',             [VisitController::class, 'store']);
    Route::put('Update/{id}',        [VisitController::class, 'update'] );
    Route::delete('Destroy/{id}',    [VisitController::class, 'destroy'] );
    Route::get('VisitsSeller',       [VisitController::class, 'visitsSeller'] );
    Route::put('DisableVisit/{id}',  [VisitController::class, 'disableVisit'] );
    Route::put('CompleteVisit/{id}', [VisitController::class, 'completeVisit'] );
    Route::get('ReasonsForNotVisit', [VisitController::class, 'reasonsForNotVisit'] );
    Route::put('RescheduleVisit/{id}',    [VisitController::class, 'rescheduleVisit'] );
});

Route::group(['middleware' => ['api', 'jwt.verify'], 'prefix' => 'posicionesIntegrantes'], function () {
    Route::get('GetMemberPositions', [MemberPositionController::class, 'getMemberPositions']);
});

Route::group(['middleware' => ['api'], 'prefix' => 'reportes'], function () {
    Route::post('ImportOrganizations', [ImportExportController::class, 'importOrganizations']);
    Route::get('ExportClientsXlsx',    [ImportExportController::class, 'exportClientsXlsx']);
    Route::get('ExportClientsCsv',     [ImportExportController::class, 'exportClientsCsv']);
    Route::get('ExportClientsTsv',     [ImportExportController::class, 'exportClientsTsv']);
    Route::get('ExportForms',          [ImportExportController::class, 'exportForms']);
    Route::get('ExportMembersXlsx',    [ImportExportController::class, 'exportMembersXlsx']);

    Route::get('PowerbiExport',        [ImportExportController::class, 'powerbiExport']);
    Route::get('PowerbiJson2',         [ImportExportController::class, 'powerbiJson']);
    Route::get('PowerbiJson3',         [ImportExportController::class, 'powerbiJson2']);
});

Route::group(['middleware' => ['api', 'jwt.verify'], 'prefix' => 'formularios'], function () {
    Route::get('Index',             [SurveyController::class, 'index']);
    Route::post('Store',            [SurveyController::class, 'store']);
    Route::get('Show/{id}',         [SurveyController::class, 'show']);
    Route::put('Update/{id}',       [SurveyController::class, 'update']);
    Route::delete('Destroy/{id}',   [SurveyController::class, 'destroy']);
    Route::post('StoreAnswer/{id}', [SurveyController::class, 'storeAnswer']);
    Route::get('SellerOrganizations/{id}', [SurveyController::class, 'sellerOrganizations']);
    Route::get('SellerOrganizationsMembers/{id}', [SurveyController::class, 'sellerOrganizationsMembers']);
    Route::get('ClientPositions', [SurveyController::class, 'clientPositions']);
    Route::get('SellerSurveys/{id}', [SurveyController::class, 'sellerSurveys']);
    Route::put(
        'AssignSurveyToSeller/survey/{idSurvey}/seller/{idSeller}',
        [SurveyController::class, 'assignSurveyToSeller']
    );
    Route::put(
        'UnassignSurveyToSeller/survey/{idSurvey}/seller/{idSeller}',
        [SurveyController::class, 'unassignSurveyToSeller']
    );
    Route::get('SellersAssignedToSurvey/{idSurvey}', [SurveyController::class, 'sellersAssignedToSurvey']);
    Route::get('SellersWithoutSurvey', [SurveyController::class, 'sellersWithoutSurvey']);
});


