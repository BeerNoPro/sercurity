<?php

use App\Http\Controllers\Sercurity\CompanyController;
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
    // Handle company
    Route::resource('/company', CompanyController::class);
    Route::get('/company/search/{name}', [CompanyController::class, 'search']);
    // Handle work room
    Route::resource('/work-room', WorkRoomController::class);
    Route::get('/work-room/search/{name}', [WorkRoomController::class, 'search']);
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
