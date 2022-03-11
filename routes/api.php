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
    Route::get('/member-foreign/{table}', [MemberController::class, 'showForeignKey']);
    Route::get('/member-edit/{id}/{company_id?}', [MemberController::class, 'edit']);
    Route::post('/member/{id}', [MemberController::class, 'update']);
    Route::get('/member-search/{name}', [MemberController::class, 'search']);
    
    // List route project
    Route::resource('/project', ProjectController::class);
    Route::get('/project-edit/{id}/{company_id?}/{work_room_id?}', [ProjectController::class, 'edit']);
    Route::post('/project/{id}', [ProjectController::class, 'update']);
    Route::get('/project-search/{name}', [ProjectController::class, 'search']);
    Route::get('/project-foreign/{table}', [ProjectController::class, 'showForeignKey']);
    
    // List route member project
    Route::resource('/member-project', MemberProjectController::class);
    Route::get('/member-project-edit/{id1}/{id2}', [MemberProjectController::class, 'edit']);
    Route::post('/member-project-update/{id1}/{id2}', [MemberProjectController::class, 'update']);
    Route::get('/member-project-search/{name}', [MemberProjectController::class, 'search']);
    Route::get('/member-project-foreign/{table}', [MemberProjectController::class, 'showForeignKey']);
    
    // List route training
    Route::resource('/training', TrainingController::class);
    Route::get('/training-edit/{id}/{trainer_id?}/{project_id?}', [TrainingController::class, 'edit']);
    Route::post('/training/{id}', [TrainingController::class, 'update']);
    Route::get('/training-search/{name}', [TrainingController::class, 'search']);
    Route::get('/training-foreign/{table}', [TrainingController::class, 'showForeignKey']);

    // List route training room
    Route::resource('/training-room', TrainingRoomController::class);
    Route::get('/training-room-edit/{id1}/{id2}', [TrainingRoomController::class, 'edit']);
    Route::post('/training-room-update/{id1}/{id2}', [TrainingRoomController::class, 'update']);
    Route::get('/training-room-search/{name}', [TrainingRoomController::class, 'search']);
    Route::get('/training-room-foreign/{table}', [TrainingRoomController::class, 'showForeignKey']);
    Route::get('/training-room-sub-query', [TrainingRoomController::class, 'showForeignKeySubQuery']);

    // List route device
    Route::resource('/device', DeviceController::class);
    Route::get('/device-edit/{id}/{member_id?}', [DeviceController::class, 'edit']);
    Route::post('/device/{id}', [DeviceController::class, 'update']);
    Route::get('/device-foreign/{table}', [DeviceController::class, 'showForeignKey']);
    Route::get('/device-search/{name}', [DeviceController::class, 'search'])->where('name', '(.*)');

    // List route carbinet
    Route::resource('/carbinet', CarbinetController::class);
    Route::get('/carbinet-edit/{id}/{work_room_id?}/{member_id?}', [CarbinetController::class, 'edit']);
    Route::post('/carbinet/{id}', [CarbinetController::class, 'update']);
    Route::get('/carbinet-foreign/{table}', [CarbinetController::class, 'showForeignKey']);
    Route::get('/carbinet-search/{name}', [CarbinetController::class, 'search']);
});


Route::prefix('view')->group(function () {
    // Show lists content
    Route::get('/home/{id?}', [ShowListController::class, 'home']);

    // Show lists content table company and work room
    Route::get('/company-workroom/{name}/{id}', [ShowListController::class, 'companyAndWorkRoom']);

    // Show lists content member detail
    Route::get('/member/{id}', [ShowListController::class, 'member']);

    // Search name company get list content
    Route::get('/search/{name}', [ShowListController::class, 'search']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
