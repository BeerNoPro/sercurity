<?php

use App\Http\Controllers\Sercurity\CarbinetController;
use App\Http\Controllers\Sercurity\CompanyController;
use App\Http\Controllers\Sercurity\DeviceController;
use App\Http\Controllers\Sercurity\MemberController;
use App\Http\Controllers\Sercurity\MemberProjectController;
use App\Http\Controllers\Sercurity\ProjectController;
use App\Http\Controllers\Sercurity\TrainingController;
use App\Http\Controllers\Sercurity\TrainingRoomController;
use App\Http\Controllers\Sercurity\View\ShowListController;
use App\Http\Controllers\Sercurity\WorkRoomController;
use Illuminate\Http\Request;
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

Route::prefix('admin')->group(function () {
    // List route company
    Route::resource('/company', CompanyController::class);
    Route::post('/company/{id}', [CompanyController::class, 'update']);
    Route::get('/company-search/{name}', [CompanyController::class, 'search']);

    // List route work room
    Route::resource('/work-room', WorkRoomController::class);
    Route::post('/work-room/{id}', [WorkRoomController::class, 'update']);
    Route::get('/work-room-search/{name}', [WorkRoomController::class, 'search']);
    
    // List route member
    Route::resource('/member', MemberController::class);
    Route::get('/member-foreign', [MemberController::class, 'showForeignKey']);
    Route::post('/member/{id}', [MemberController::class, 'update']);
    Route::get('/member-search/{name}', [MemberController::class, 'search']);
    
    // List route project
    Route::resource('/project', ProjectController::class);
    Route::post('/project/{id}', [ProjectController::class, 'update']);
    Route::get('/project-search/{name}', [ProjectController::class, 'search']);
    Route::get('/project-foreign/{name}', [ProjectController::class, 'showForeignKey']);
    
    // List route member project
    Route::resource('/member-project', MemberProjectController::class);
    Route::post('/member-project-edit', [MemberProjectController::class, 'edit']);
    Route::post('/member-project-update/{id1}/{id2}', [MemberProjectController::class, 'save']);
    Route::get('/member-project-search/{name}', [MemberProjectController::class, 'search']);
    Route::get('/member-project-foreign/{name}', [MemberProjectController::class, 'showForeignKey']);
    
    // List route training
    Route::resource('/training', TrainingController::class);
    Route::post('/training/{id}', [TrainingController::class, 'update']);
    Route::get('/training-search/{name}', [TrainingController::class, 'search']);
    Route::get('/training-foreign/{name}', [TrainingController::class, 'showForeignKey']);

    // List route training room
    Route::resource('/training-room', TrainingRoomController::class);
    Route::post('/training-room-edit', [TrainingRoomController::class, 'edit']);
    Route::post('/training-room-update/{id1}/{id2}', [TrainingRoomController::class, 'save']);
    Route::get('/training-room-search/{name}', [TrainingRoomController::class, 'search']);
    Route::get('/training-room-foreign/{name}', [TrainingRoomController::class, 'showForeignKey']);
    Route::get('/training-room-sub-query', [TrainingRoomController::class, 'showForeignKeySubQuery']);

    // List route Device
    Route::resource('/device', DeviceController::class);
    Route::post('/device/{id}', [DeviceController::class, 'update']);
    Route::get('/device-foreign', [DeviceController::class, 'showForeignKey']);
    Route::get('/device-search/{user_login}', [DeviceController::class, 'search']);

    // List route carbinet
    Route::resource('/carbinet', CarbinetController::class);
    Route::post('/carbinet/{id}', [CarbinetController::class, 'update']);
    Route::get('/carbinet-foreign/{name}', [CarbinetController::class, 'showForeignKey']);
    Route::get('/carbinet-search/{name}', [CarbinetController::class, 'search']);
});


Route::prefix('view')->group(function () {
    // Show lists content
    Route::get('/', [ShowListController::class, 'showListProject']);

    // Show lists content company detail
    Route::get('/company/{id}', [ShowListController::class, 'companyDetail']);

    // Show lists content work-room detail
    Route::get('/work-room/{id}', [ShowListController::class, 'workRoomDetail']);

    // Show lists content member detail
    Route::get('/member/{id}', [ShowListController::class, 'memberDetail']);
    
    // Show lists content project detail
    Route::get('/project/{id}', [ShowListController::class, 'projectDetail']);

    // Show lists content member project detail
    Route::get('/member-project/{member_id}/{project_id}', [ShowListController::class, 'memberProjectDetail']);

    // Show lists content training detail
    Route::get('/training/{id}', [ShowListController::class, 'trainingDetail']);

    // Show lists content training room detail
    Route::get('/training-room/{training_id}/{member_id}', [ShowListController::class, 'trainingRoomDetail']);

    // Show lists content device detail
    Route::get('/device/{id}', [ShowListController::class, 'deviceDetail']);

    // Show lists content carbinet detail
    Route::get('/carbinet/{id}', [ShowListController::class, 'carbinetDetail']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
