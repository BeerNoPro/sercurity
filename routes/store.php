<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewBlade\CabinetController;
use App\Http\Controllers\ViewBlade\CompanyController;
use App\Http\Controllers\ViewBlade\DeviceController;
use App\Http\Controllers\ViewBlade\MemberController;
use App\Http\Controllers\ViewBlade\MemberProjectController;
use App\Http\Controllers\ViewBlade\ProjectController;
use App\Http\Controllers\ViewBlade\TrainingController;
use App\Http\Controllers\ViewBlade\TrainingRoomController;
use App\Http\Controllers\ViewBlade\WorkRoomController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/security', function () {
    return view('index');
});

Route::controller(CompanyController::class)->group(function() {
    Route::get('/company', 'index');
});

Route::controller(WorkRoomController::class)->group(function() {
    Route::get('/work-room', 'index');
});

Route::controller(MemberController::class)->group(function() {
    Route::get('/member', 'index');
});

Route::controller(ProjectController::class)->group(function() {
    Route::get('/project', 'index');
});

Route::controller(MemberProjectController::class)->group(function() {
    Route::get('/member-project', 'index');
});

Route::controller(TrainingController::class)->group(function() {
    Route::get('/training', 'index');
});

Route::controller(TrainingRoomController::class)->group(function() {
    Route::get('/training-room', 'index');
});

Route::controller(DeviceController::class)->group(function() {
    Route::get('/device', 'index');
});

Route::controller(CabinetController::class)->group(function() {
    Route::get('/cabinet', 'index');
});



Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/login', [LoginController::class, 'index'])->name('login');
