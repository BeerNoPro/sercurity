<?php

use App\Http\Controllers\Sercurity\CarbinetController;
use App\Http\Controllers\Sercurity\CompanyController;
use App\Http\Controllers\Sercurity\DeviceController;
use App\Http\Controllers\Sercurity\MemberController;
use App\Http\Controllers\Sercurity\MemberProjectController;
use App\Http\Controllers\Sercurity\ProjectController;
use App\Http\Controllers\Sercurity\TrainingController;
use App\Http\Controllers\Sercurity\TrainingRoomController;
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
    Route::get('/company/search/{name}', [CompanyController::class, 'search']);
    Route::post('/company/restore/{id}', [CompanyController::class, 'restore']);

    // List route work room
    Route::resource('/work-room', WorkRoomController::class);
    Route::get('/work-room/search/{name}', [WorkRoomController::class, 'search']);
    Route::post('/work-room/restore/{id}', [WorkRoomController::class, 'restore']);
    
    // List route member
    Route::resource('/member', MemberController::class);
    Route::get('/member/search/{name}', [MemberController::class, 'search']);
    Route::post('/member/restore/{id}', [MemberController::class, 'restore']);
    
    // List route project
    Route::resource('/project', ProjectController::class);
    Route::get('/project/search/{name}', [ProjectController::class, 'search']);
    Route::post('/project/restore/{id}', [ProjectController::class, 'restore']);
    
    // List route member project
    Route::resource('/member-project', MemberProjectController::class);
    Route::put('/member-project-update', [MemberProjectController::class, 'save']);
    Route::delete('/member-project-delete', [MemberProjectController::class, 'delete']);
    Route::post('/member-project-restore', [MemberProjectController::class, 'restore']);
    
    // List route training
    Route::resource('/training', TrainingController::class);
    Route::get('/training/search/{content}', [TrainingController::class, 'search']);
    Route::post('/training/restore/{id}', [TrainingController::class, 'restore']);

    // List route training room
    Route::resource('/training-room', TrainingRoomController::class);
    Route::put('/training-room-update', [TrainingRoomController::class, 'save']);
    Route::delete('/training-room-delete', [TrainingRoomController::class, 'delete']);
    Route::post('/training-room-restore', [TrainingRoomController::class, 'restore']);

    // List route Device
    Route::resource('/device', DeviceController::class);
    Route::get('/device/search/{user_login}', [DeviceController::class, 'search']);
    Route::post('/device/restore/{id}', [DeviceController::class, 'restore']);

    // List route carbinet
    Route::resource('/carbinet', CarbinetController::class);
    Route::get('/carbinet/search/{name}', [CarbinetController::class, 'search']);
    Route::post('/carbinet/restore/{id}', [CarbinetController::class, 'restore']);
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
